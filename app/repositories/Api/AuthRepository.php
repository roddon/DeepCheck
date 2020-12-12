<?php

namespace App\Repositories\Api;

use App\Http\Resources\UserResource;
use App\Repositories\BaseRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Auth;

class AuthRepository extends BaseRepository
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function login(Request $request)
    {
        $email = $request->username ?: '';
        $password = $request->password;
        $user = $this->userService->login($email, $password);
        if ($user) {
            Auth::login($user);
            $user->userLoginLogs()->create([
                'ip' => $request->header('x-vapor-source-ip', $request->ip())
            ]);
            $response = response()->json(["user" => new UserResource($user), 'type' => 'Bearer', 'token' => $user->createToken(env('CREATE_TOKEN'))->accessToken]);
        } else {
            $response = response()->json(['error' => 'Unauthorized'], 401);
        }

        return $response;
    }


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $request->user()->token()->delete();

        $json = [
            'msg' => true,
            'statusCode' => 200,
            'trace' => 'You are Logged out.',
        ];
        return response()->json($json, '200');
    }
}
