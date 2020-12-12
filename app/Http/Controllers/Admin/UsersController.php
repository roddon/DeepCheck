<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Repositories\Admin\UsersRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct(UsersRepository $usersRepository)
    {
        $this->repository = $usersRepository;
    }

    public function index(Request $request)
    {
        return $this->repository->dataTable($request);
    }


    public function create()
    {
        return $this->repository->create();
    }

    public function store(SignupRequest $request)
    {
        return $this->repository->store($request);
    }
}
