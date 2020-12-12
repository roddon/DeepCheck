<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthenticateController extends AppController
{

    public function __construct(AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Login page view
     * @return Illuminate\Http\Response
     */
    public function create()
    {
        return $this->auth->create();
    }

    /**
     * Request to login with app
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'The email address field is required.',
            'email.email' => 'The email must be a valid format.'
        ]);

        return $this->auth->login($request);
    }

    /**
     * Request to login with app
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'The email address field is required.',
            'email.email' => 'The email must be a valid format.'
        ]);

        return $this->auth->adminLogin($request);
    }

    /**
     * Request to logout from app
     * @return Illuminate\Http\Response
     */
    public function logout()
    {
        return $this->auth->logout();
    }

    /**
     * New user sign up view
     * @return Illuminate\Http\Response
     */
    public function signUpCreate()
    {
        return $this->auth->signUpCreate();
    }

    /**
     * Forgot password view
     * @return Illuminate\Http\Response
     */
    public function forgotPasswordCreate()
    {
        return $this->auth->forgotPasswordCreate();
    }

    /**
     * Request to new password by email verification
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ], [
            'email.required' => 'The email address field is required.',
            'email.email' => 'The email must be a valid format.'
        ]);

        return $this->auth->forgotPassword($request->email);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Illuminate\Http\SignupRequest  $request
     * @return Illuminate\Http\Response
     */
    public function store(SignupRequest $request)
    {
        return $this->auth->store($request);
    }


    public function startUserVerification(Request $request)
    {
        return $this->auth->startUserVerification($request);
    }


    public function verifyPhoneOtp(Request $request)
    {
        return $this->auth->verifyPhoneOtp($request);
    }
}
