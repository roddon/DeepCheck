<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Crypt;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');



Artisan::command('encrypt {string*}', function ($string) {
    $string = implode(' ', $string);
    $this->info(Crypt::encryptString($string));
});


Artisan::command('decrypt {string}', function ($string) {
    $this->info(Crypt::decryptString($string));
});
