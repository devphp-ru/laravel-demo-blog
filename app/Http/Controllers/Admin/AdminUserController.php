<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends BaseController
{
    public function index(): View
    {
        $title = 'Администраторы';

        $users = AdminUser::orderByDesc('id')->paginate(10);

        return view('admin.admin_users.index', [
            'title' => $title,
            'paginator' => $users,
        ]);
    }

    public function create(): View
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(AdminUser $adminUser)
    {
        //
    }

    public function update(Request $request, AdminUser $adminUser)
    {
        //
    }

    public function destroy(AdminUser $adminUser)
    {
        //
    }

}
