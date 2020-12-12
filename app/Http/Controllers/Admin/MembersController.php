<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\MembersRepository;
use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;

class MembersController extends Controller
{

    public function __construct(MembersRepository $membersRepository)
    {
        $this->repository = $membersRepository;
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
