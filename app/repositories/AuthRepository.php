<?php

namespace App\Repositories;

use App\Helpers\Firebase;
use App\Http\Requests\SignupRequest;
use App\Notifications\ForgotPassword;
use App\Notifications\UserVerification;
use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Notification;

class AuthRepository extends BaseRepository
{
    public function __construct(UserService $userService, CompanyService $companyService)
    {
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

    /**
     * Login page view
     * @return Illuminate\Http\Response
     */
    public function create()
    {
        return $this->authCheck('manage.auth.login');
    }

    /**
     * New user sign up view
     * @return Illuminate\Http\Response
     */
    public function signUpCreate()
    {
        return $this->authCheck('manage.auth.signup');
    }

    /**
     * Authenticate Users.
     *
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
        try {
            $user = $this->userService->login($request->email, $request->password);
            $loginNo = 0;
            if ($user) {
                if(in_array($request->email,['admin@deepcheck.one'])){
                    $loginNo = 1;
                    Auth::login($user);
                }else{
                    $loginNo = $user->login_no;
                    if ($user->status==0 && !in_array($request->email,['admin@deepcheck.one'])) {
                        return response()->json(['errors' => ['email' => 'Your account is not verified yet.']], 422);
                    }
                    $user->login_no += 1;
                    $user->save();
                    
                    Auth::login($user);
                    $user->userLoginLogs()->create([
                        'ip' => $request->header('x-vapor-source-ip', $request->ip())
                    ]);
                    $request->session()->put('login', 1);
                    
                    $stageId = config('config.mautic.stages.login');
                    $segmentId = config('config.mautic.segment.login');
                    $contactParam['firstname'] = $user->name;
                    $contactParam['email'] = $user->email;
                    $contactParam['ipAddress'] = $request->ip();
                    $contactParam['lastActive'] = date('Y-m-d H:m:i');
                    $contactParam['overwriteWithBlank'] = true;

                    $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);    
                }
                return response()->json(['message' => 'Login Successfull','redirect'=>$loginNo], 200);
            }

            return response()->json(['errors' => ['email' => 'Invalid email and password']], 422);
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }

    /**
     * Authenticate Users.
     *
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function adminLogin(Request $request)
    {
        try {
            $user = $this->userService->adminLogin($request->email, $request->password);

            if ($user) {
                Auth::login($user);
                return redirect()->route('dashboard.create');
            }
            return redirect()->back()->withErrors(['email' => 'Invalid Email Address or Password']);
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }

    /**
     * Destroy user session.
     * @return Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }


    /**
     * Store a newly created user .
     *
     * @param  Illuminate\Http\SignupRequest  $request
     * @return Illuminate\Http\Response
     */
    public function store(SignupRequest $request)
    {
        try {			
            $user = $request->all();            
            $user = $this->userService->memberUserCreate($user);
            
            if ($user) {
                $company = $this->companyService->newCompanyCreate($user->id);
                Notification::route('mail', $user->email)->notify(new UserVerification($user));
                /*Auth::login($user);
                $user->userLoginLogs()->create([
                    'ip' => $request->header('x-vapor-source-ip', $request->ip())
                ]);*/

                // $stageId = config('config.mautic.stages.signup');

                $segmentId = config('config.mautic.segment.signup');

                $contactParam['firstname'] = $user->name;
                $contactParam['email'] = $user->email;
                $contactParam['ipAddress'] = $request->ip();
                $contactParam['lastActive'] = date('Y-m-d H:m:i');
                $contactParam['overwriteWithBlank'] = true;

                $this->userService->mauticAPI($stageId=null, $segmentId, $contactParam);
                $user->assignDefaultSubscription($user);
                return response()->json(['message' => 'Signup Successfully'], 200);
                // return redirect()->route('settings.edit')->with('status', 'Thank you for registration, an email has sent to your email account, please verify your account');
            }
            return response()->json(['errors' => ['name' => 'Something went wrong']], 422);
        } catch (Throwable $e) {

            return $this->logExceptionAndRespond($e);
        }
    }

    /**
     * Forgot password view
     * @return \Illuminate\Http\Response
     */
    public function forgotPasswordCreate()
    {
        return view('manage.auth.forgot-password');
    }

    /**
     * Forget password
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(string $email)
    {
        try {
            $user =  $this->userService->findByEmail($email);

            if ($user) {
                $password = Str::random(8);
                \Log::info($password);
                $user->password = $password;
                $user->save();

                Notification::route('mail', $user->email)->notify(new ForgotPassword($user, $password));
                return response()->json(['message' => 'Your new password has been sent on your email'], 200);
            }
            return response()->json(['errors' => ['email' => 'Email not found, Please check your email']], 422);
        } catch (Throwable $e) {
            return $this->logExceptionAndRespond($e);
        }
    }


    public function startUserVerification(Request $request)
    {
        if ($request->verification_code) {
            $user = $this->userService->findBy([
                'verification_token' => $request->verification_code
            ]);
            if ($user) {

                $this->userService->updateById($user->id, [
                    'email_verified_at' => Carbon::now()
                ]);
                return view('manage.verification.user.start-verification', compact('user'));
            } else {
                return view('manage.customer.invalid-link', compact('user'));
            }
        }
    }

    public function verifyPhoneOtp(Request $request)
    {
        try {
            $firebase = new Firebase();
            $response = $firebase->verifyOtp($request->code, $request->verificationId);
            
            $user = $this->userService->find($request->user_id);
            if ($response->phoneNumber) {
                $this->userService->updateById($user->id, [
                    'verification_token' => null,
                    'contact_number' => $request->contact_number,
                    'status' => true
                ]);
                $user->assignDefaultSubscription($user);
                return response()->json(['message' => 'Phone number verify successfully'], 200);
            } else {
                return response()->json(['message' => 'Phone number verification failed'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Phone number verification failed',"error"=>$e->getMessage()], 422);
        }
    }
}
