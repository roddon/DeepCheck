<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Services\UserService;
use Illuminate\Http\Request;

class UsersRepository extends BaseRepository
{

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function dataTable(Request $request)
    {

        if ($request->ajax()) {
            return $this->userService->allAdminUsers();
        }

        return view('manage.admin.users.index');
    }


    public function create()
    {
        return view('manage.admin.users.create');
    }


    public function store(Request $request)
    {
        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'password' => $request->password
            ];

            $user = $this->userService->createAdminUser($userData);
            if ($user) {
                return redirect()->route('admin.users.index')->with('message', 'New user created successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Email already exists');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Something went wrong');
        }
    }
}
