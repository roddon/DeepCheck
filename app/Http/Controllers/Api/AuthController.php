<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Api\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Request to login with app
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // $this->validate($request, [
        //     'email' => 'required|email',
        //     'password' => 'required'
        // ], [
        //     'email.required' => 'The email address field is required.',
        //     'email.email' => 'The email must be a valid format.'
        // ]);

        return $this->auth->login($request);
    }


    /**
     * Request to logout from app
     * @return Illuminate\Http\Response
     */
    public function logout()
    {
        return $this->auth->logout();
    }
}
