<?php

namespace App\Repositories;

use Sentry;
use Throwable;
use Auth;

class BaseRepository
{

    /**
     * @param Throwable $e
     * @return RedirectResponse
     */
    public function logExceptionAndRespond(Throwable $e)
    {
        Sentry::captureException($e);

        return redirect()->back()->with(['error' => 'Something went wrong, please try again later.']);
    }



    /**
     * Check authenttication access page
     * @param string $viewPage
     */
    protected function authCheck(string $viewPage)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.create');
        }

        return view($viewPage);
    }

    /**
     * Get client IP
     * @return string
     */
    protected function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }
}
