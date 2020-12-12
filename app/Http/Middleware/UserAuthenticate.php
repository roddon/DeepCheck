<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use View;
use App\Models\EmailLog;
use App\Models\User;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        } else {
            $user = Auth::user();
            if ($user->hasRole('member')) {
                $status = $this->userPermission();
                if ($status) {
                    $this->userData($user);
                    View::share('userLogin', $request->session()->get('login'));
                    $request->session()->put('login', null);
                    return $next($request);
                } else {
                    return redirect()->route('settings.edit');
                }
            } else {
                return redirect()->route('home');
            }
        }
    }


    private function userPermission()
    {
        $status = true;
        if (request()->routeIs('invoice*')) {
            $status = true;
        } else if ((!Auth::user()->status && Route::currentRouteName() != 'settings.edit')  && !request()->ajax()) {
            $status = false;
        }
        return $status;
    }


    private function userData(User $user)
    {
        View::share('company', $user->company);
        $unreadEmail = EmailLog::where('is_read', 0)->where('user_id', $user->id)->count();
        $unreadNotification = ActivityLog::where('model_type', 'App\Models\Customer')->where('is_read', 0)->where('user_id', $user->id)->count();
        view()->share('unreadEmail', $unreadEmail);
        view()->share('unreadNotification', $unreadNotification);


        $checkUserSubscription = $user->subscriptionPlanCheck;

        $plan = optional(optional($checkUserSubscription)->subscription)->subscriptionPlan;

        $subscriptionOnboarding = 0;
        $subscriptionSupplierVerification = 0;
        $subscriptionSafaPay = 0;
        $subscriptionDetector = 0;
        $subscriptionNoOfCheckInvoices = 0;
        $userSubscriptionStatus = false;
        if ($checkUserSubscription) {

            if ($checkUserSubscription->no_of_check_invoice) {
                $subscriptionNoOfCheckInvoices = $checkUserSubscription->no_of_check_invoice;
                $userSubscriptionStatus = true;
            }

            if ($checkUserSubscription->no_of_onboarding) {
                $subscriptionOnboarding = $checkUserSubscription->no_of_onboarding;
                $userSubscriptionStatus = true;
            }

            if ($checkUserSubscription->no_of_supplier_check) {
                $subscriptionSupplierVerification = $checkUserSubscription->no_of_supplier_check;
                $userSubscriptionStatus = true;
            }

            if ($checkUserSubscription->no_of_safe_payout) {
                $subscriptionSafaPay = $checkUserSubscription->no_of_safe_payout;
                $userSubscriptionStatus = true;
            }

            if ($checkUserSubscription->no_of_detector_records) {
                $subscriptionDetector = $checkUserSubscription->no_of_detector_records;
                $userSubscriptionStatus = true;
            }
        }
        // $userSubscriptionStatus = false;
        View::share('subscriptionOnboarding', $subscriptionOnboarding);
        View::share('subscriptionSupplierVerification', $subscriptionSupplierVerification);
        View::share('subscriptionSafaPay', $subscriptionSafaPay);
        View::share('subscriptionDetector', $subscriptionDetector);
        View::share('userSubscriptionStatus', $userSubscriptionStatus);
        View::share('subscriptionNoOfCheckInvoices', $subscriptionNoOfCheckInvoices);
    }
}
