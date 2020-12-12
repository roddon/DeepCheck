<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Mautic as MauticHelper;

class Mautic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $mautic = new MauticHelper();
        $authenticate = $mautic->authenticateToken();

        $this->setMauticSession($authenticate);

        return $next($request);
    }

    public function setMauticSession($authenticate)
    {
        $acceessToken = $authenticate->access_token;
        $refreshToken = $authenticate->refresh_token;
        $expSecond = $authenticate->expires_in;
        $afterExp = time() + $expSecond;

        request()->session()->put('mauticAccessToekn', $acceessToken);
        request()->session()->put('mauticRefressToken', $refreshToken);
        request()->session()->put('mauticExpSecond', $expSecond);
        request()->session()->put('mauticTokenExtTime', $afterExp);
    }
}
