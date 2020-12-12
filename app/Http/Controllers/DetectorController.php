<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DetectorRepository;

class DetectorController extends Controller
{
    protected $repository;

    public function __construct(DetectorRepository $detectorRepository)
    {
        $this->repository = $detectorRepository;
    }

    public function accountingCheck()
    {
        $accountData = $this->repository->accountingCheck();
        return view('manage.detector.account-check', compact('accountData'));
    }

    public function accountingSync(Request $request)
    {
        return $this->repository->accountingSync($request);
    }


    public function connectorCallback(Request $request)
    {
        dd($request);
    }

    public function checkAccountingForMautic(Request $request)
    {
        return $this->repository->checkAccountingForMautic($request);
    }
}
