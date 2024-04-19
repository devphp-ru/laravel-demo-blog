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

    public function edit(int $id): View
    {
        $adminUser = AdminUser::find($id);

        $title = 'Редактировать: ' . $adminUser->username;

        return view('admin.admin_users.edit', [
            'title' => $title,
            'item' => $adminUser,
        ]);
    }

    public function update(
        Request $request,
        int $id,
    ): RedirectResponse
    {
        $adminUser = AdminUser::find($id);

        $request->validate([
            'username' => 'required|string|min:2|max:255|regex:/^[А-ЯЁёа-яA-Za-z ]+$/u',
            'email' => 'required|string|max:1000|email|unique:admin_users,email,' . $adminUser->id,
            'password' => 'nullable|string|min:5|max:255|confirmed|regex:/^[A-Za-z0-9]+$/u',
        ]);

        $request->merge(['is_banned' => $request->input('is_banned', 0)]);
        $request->merge(['password' => $request->input('password') ?? $adminUser->password]);

        $result = $adminUser->update($request->only($adminUser->getFillable()));

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка сохранения.'])->onlyInput('username', 'email');
        }

        return redirect()->route('admin-users.index')->with('success', 'Успешно сохранено.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $result = AdminUser::find($id)->delete();

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка удаления.']);
        }

        return redirect()->route('admin-users.index')->with('success', 'Успешно удалено.');
    }

}
