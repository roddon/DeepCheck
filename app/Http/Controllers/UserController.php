<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use DB;
use Illuminate\Http\Request;

class UserController extends AppController
{

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    // public function changePassword()
    // {
    //     return view('manage.users.change-password');
    // }


    // public function updatePassword()
    // {
    //     return $this->user->updatePassword();
    // }

    /**
     * Update user information
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'email',
            'password' => 'confirmed|min:6|nullable',
        ], [
            'email.email' => 'The email must be a valid format.',
            'password.confirmed' => 'Please confirm your password',
            'password.min' => 'Password minimum 6 character long',
        ]);
        return $this->user->update($request);
    }

    public function paymentPlan(Request $request)
    {
        return $this->user->paymentPlan($request);
    }

    public function checkInvoice(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required',
            'contactNumber' => 'required',
            // 'invoiceFile' => 'max:10240'
        ], [
            'email.required' => 'The email address field is required.',
            'email.email' => 'The email must be a valid format.'
        ]);
        return $this->user->checkInvoice($request);
    }

    public function verifyOtpCode(Request $request)
    {
        return $this->user->verifyOtpCode($request);
    }

    public function subscribePlan()
    {
        return true;
    }

}
