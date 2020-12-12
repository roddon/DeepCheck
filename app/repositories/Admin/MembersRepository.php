<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use App\Services\UserService;
use Illuminate\Http\Request;

class MembersRepository extends BaseRepository
{

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function dataTable(Request $request)
    {

        if ($request->ajax()) {
            return $this->userService->allMembers();
        }

        return view('manage.admin.members.index');
    }


    public function create()
    {
        return view('manage.admin.members.create');
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

            $user = $this->userService->memberUserCreate($userData);
            if ($user) {
                return redirect()->route('admin.members.index')->with('message', 'New Member created successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Email already exists');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Something went wrong');
        }
    }
}
