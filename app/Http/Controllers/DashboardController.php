<?php

namespace App\Http\Controllers;

use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends AppController
{
    public function __construct(DashboardRepository $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return $this->dashboard->dashboard();
    }
}
