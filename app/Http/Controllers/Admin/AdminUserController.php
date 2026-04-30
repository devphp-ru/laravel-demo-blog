<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminUserRequest;
use App\Models\AdminUser;
use App\Services\AdminUsers\AdminUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends BaseController
{
    public function __construct(private readonly AdminUserService $adminUserService) {}

    public function index(Request $request): View
    {
        $title = __('Администраторы');

        $perPage = 10;
        $users = $this->adminUserService->getAllAdminsWithPagination($request, $perPage);

        return view('admin.admin_users.index', [
            'title' => $title,
            'paginator' => $users,
        ]);
    }

    public function create(): View
    {
        $title = __('Добавить');

        return view('admin.admin_users.create', [
            'title' => $title,
        ]);
    }

    public function store(AdminUserRequest $request): RedirectResponse
    {
        $result = $this->adminUserService->create($request);

        if (!$result) {
            return back()->withErrors(['error' => __('Ошибка сохранения.')])->onlyInput('username', 'email');
        }

        return redirect()->route('admin-users.index')->with('success', __('Успешно сохранено.'));
    }

    public function show(AdminUser $adminUser): View
    {
        $title = __('Профиль администратора');

        $adminUser->load([
            'articles',
            'articleComments',
        ]);

        return view('admin.admin_users.show', [
            'title' => $title,
            'user' => $adminUser,
        ]);
    }

    public function edit(AdminUser $adminUser): View
    {
        $title = __('Редактировать: ' . $adminUser->username);

        return view('admin.admin_users.edit', [
            'title' => $title,
            'item' => $adminUser,
        ]);
    }

    public function update(
        AdminUserRequest $request,
        AdminUser $adminUser,
    ): RedirectResponse
    {
        $result = $this->adminUserService->update($request, $adminUser);

        if (!$result) {
            return back()->withErrors(['error' => __('Ошибка сохранения.')])->onlyInput('username', 'email');
        }

        return redirect()->route('admin-users.index')->with('success', __('Успешно сохранено.'));
    }

    public function destroy(AdminUser $adminUser): RedirectResponse
    {
        $result = $this->adminUserService->destroy($adminUser);

        if (!$result) {
            return back()->withErrors(['error' => __('Ошибка удаления.')]);
        }

        return redirect()->route('admin-users.index')->with('success', __('Успешно удалено.'));
    }

}
