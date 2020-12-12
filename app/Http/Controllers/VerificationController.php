<?php

namespace App\Http\Controllers;


use App\Repositories\VerificationRepository;
use Illuminate\Http\Request;

class VerificationController extends AppController
{

    public function __construct(VerificationRepository $repository)
    {
        $this->repository = $repository;
    }


    public function startSupplierVerification(Request $request)
    {
        return $this->repository->startSupplierVerification($request);
    }


    public function verifyPhoneOtp(Request $request)
    {
        return $this->repository->verifyPhoneOtp($request);
    }

    public function updateSupplier(Request $request)
    {
        return $this->repository->updateSupplier($request);
    }

    /**
     * Display a listing of the customers.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function kycVerification(Request $request)
    {
        return $this->repository->kycVerification($request);
    }

    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function tinkCallback(Request $request)
    {
        return $this->repository->tinkCallback($request);
    }

    public function addSupplierAccount(Request $request)
    {
        return $this->repository->supplierTinkVerification($request);
    }

    public function addCustomerAccount(Request $request)
    {
        return $this->repository->customerTinkVerification($request);
    }

    public function getInstitutions()
    {
        return $this->repository->getInstitutions();
    }

    public function accountAuthRequest(Request $request)
    {
        return $this->repository->accountAuthRequest($request);
    }

    public function addSupplierAddress(Request $request)
    {
        return $this->repository->addSupplierAddress($request);
    }

    public function addCustomerAddress(Request $request)
    {
        return $this->repository->addCustomerAddress($request);
    }
}
