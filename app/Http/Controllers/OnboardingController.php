<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepository;
use App\Http\Requests\CheckInviteCustomerRequest;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    protected $repository;

    public function __construct(CustomerRepository $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->customer->dataTables($request);
        }

        return view('manage.onboarding.index');
    }


    public function customerDetail($id)
    {
        return $this->customer->detail($id);
    }


    /**
     * @param CheckInviteCustomerRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendMail(CheckInviteCustomerRequest $request)
    {
        return $this->customer->inviteCustomer($request);
    }

    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadDocument(Request $request)
    {
        return $this->customer->uploadDocument($request);
    }


    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function kycVerification(Request $request)
    {
        return $this->customer->accountVerification($request);
    }


    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function tinkCallback(Request $request)
    {
        return $this->customer->tinkCallback($request->code);
    }


    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function customerVerification(Request $request)
    {
        return $this->customer->customerVerification($request->verification_code);
    }


    public function verifyPhoneOtp(Request $request)
    {
        return $this->customer->verifyPhoneOtp($request);
    }

    public function updateCustomerSanctionList($id)
    {
        return $this->customer->updateCustomerSanctionList($id);
    }

    public function checkCustomerVerification(Request $request)
    {
        return $this->customer->checkCustomerVerification($request);
    }
}
