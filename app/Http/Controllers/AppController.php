<?php

namespace App\Http\Controllers;

use App\Helpers\Mautic;
use App\Http\Controllers\Controller;
use App\Models\MauticConsumer;
use Auth;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function home()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.members.index');
            } elseif (Auth::user()->hasRole('member')) {

                return redirect()->route('dashboard.create');
            }
        } else {
            $MauticConsumer = MauticConsumer::count('id');
            if ($MauticConsumer == 0) {
                $mautic = new Mautic;
                $mautic->initiateAuth();
            }
            
            $bodyClass = 'home-page';
            $siteSeo = config('config.seo.home_page');
            return view('manage.frontend.home', compact('bodyClass', 'siteSeo'));
        }
    }


    public function tinkCallback(Request $request)
    {
        $customerId = request()->session()->get('customer_id');
        $supplierId = request()->session()->get('supplier_id');

        if ($supplierId) {
            if ($request->error) {
                return view('manage.verification.supplier.error-verification', compact('supplierId'));
            } else {
                return  redirect()->route('verification.supplier.tink-callback', [
                    'code' => $request->consent,
                    'credentialsId' => $request->credentialsId ?? '0',
                ]);
            }
        } else if ($customerId) {
            if ($request->error) {
                return view('manage.customer.error-verification', compact('customerId'));
            } else {
                return  redirect()->route('verification.customer.tink-callback', [
                    'code' => $request->consent,
                    'credentialsId' => $request->credentialsId ?? '0',
                ]);
            }
        }
    }
}
