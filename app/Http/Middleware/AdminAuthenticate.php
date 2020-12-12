<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use View;
use App\Models\EmailLog;


class AdminAuthenticate
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
            if (Auth::user()->hasRole('admin')) {
                return $next($request);
            }
        }
    }
}
