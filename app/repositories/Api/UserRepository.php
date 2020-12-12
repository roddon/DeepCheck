<?php

namespace App\Repositories\Api;

use App\Http\Resources\UserResource;
use App\Repositories\BaseRepository;
use App\Services\UserService;

class UserRepository extends BaseRepository
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update($request)
    {
        $user = $request->user();
        if ($user) {
            $user->sftp_token = $request->sftp_token;
            $user->sftp_un = $request->sftp_un;
            $user->sftp_pw = $request->sftp_pw;
            $user->sftp_server_ip = $request->sftp_server_ip;
            $user->save();
            return response()->json(['message' => 'User information has beeen updated'], 200);
        } else {

            return response()->json(['message' => 'Invalid user'], 422);
        }
    }

    public function userDetailBySftpToken($request)
    {
        $data = $this->userService->userDetailBySftpToken($request);
        return new UserResource($data);
    }
}
