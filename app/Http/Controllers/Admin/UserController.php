<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends BaseController
{
    public function __construct(private readonly UserService $userService) {}

    public function index(Request $request): View
    {
        $title = __('Пользователи');

        $perPage = 10;
        $users = $this->userService->getAllAdminsWithPagination($request, $perPage);

        return view('admin.users.index', [
            'title' => $title,
            'paginator' => $users,
        ]);
    }

    public function create(): View
    {
        $title = __('Добавить');

        return view('admin.users.create', [
            'title' => $title,
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $result = $this->userService->create($request);

        if (!$result) {
            return back()->withErrors(['error' => __('Ошибка сохранения.')]);
        }

        return redirect()->route('users.index')->with('success', __('Успешно сохранено.'));
    }

    public function show(User $user): View
    {
        $title = __('Профиль пользователя');

        $user->load(['articles', 'articleComments']);

        return view('admin.users.show', [
            'title' => $title,
           'user' => $user,
        ]);
    }

    public function edit(User $user): View
    {
        $title = __('Редактировать: ' . $user->name);

        return view('admin.users.edit', [
            'title' => $title,
            'item' => $user,
        ]);
    }

    public function update(
        UserRequest $request,
        User $user,
    ): RedirectResponse
    {
        $result = $this->userService->update($request, $user);

        if (!$result) {
            return back()->withErrors(['error' => __('Ошибка сохранения.')]);
        }

        return redirect()->route('users.index')->with('success', __('Успешно сохранено.'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $result = $this->userService->destroy($user);

        if (!$result) {
            return back()->withErrors(['error' => __('Ошибка удаления.')]);
        }

        return redirect()->route('users.index')->with('success', __('Успешно удалено.'));
    }

}
