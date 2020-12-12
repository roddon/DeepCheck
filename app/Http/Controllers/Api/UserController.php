<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Api\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $repository;
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function update(Request $request)
    {
        return $this->repository->update($request);
    }

    public function userDetailBySftpToken(Request $request)
    {
        return $this->repository->userDetailBySftpToken($request);
    }
}
