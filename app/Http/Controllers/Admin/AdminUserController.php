<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use Illuminate\Http\RedirectResponse;
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
        $title = 'Добавить';

        return view('admin.admin_users.create', [
            'title' => $title,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string|min:2|max:255|regex:/^[А-ЯЁёа-яA-Za-z ]+$/u',
            'email' => 'required|string|email|max:1000|unique:admin_users,email',
            'password' => 'required|string|min:5|max:255|confirmed|regex:/^[A-Za-z0-9]+$/u',
        ]);

        $request->merge(['is_banned' => $request->input('is_banned', '0')]);

        $result = AdminUser::create($request->only((new AdminUser())->getFillable()));

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка сохранения.'])->onlyInput('username', 'email');
        }

        return redirect()->route('admin-users.index')->with('success', 'Успешно сохранено.');
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
