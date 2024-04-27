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
    public function __construct(private UserService $userService) {}

    public function index(Request $request): View
    {
        $title = 'Пользователи';

        $perPage = 10;
        $users = $this->userService->getAllAdminsWithPagination($request, $perPage);

        return view('admin.users.index', [
            'title' => $title,
            'paginator' => $users,
        ]);
    }

    public function create(): View
    {
        $title = 'Добавить';

        return view('admin.users.create', [
            'title' => $title,
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $result = $this->userService->create($request);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка сохранения.']);
        }

        return redirect()->route('users.index')->with('success', 'Успешно сохранено.');
    }

    public function show(User $user): View
    {
        abort(404);
    }

    public function edit(User $user): View
    {
        $title = 'Редактировать: ' . $user->name;

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
            return back()->withErrors(['error' => 'Ошибка сохранения.']);
        }

        return redirect()->route('users.index')->with('success', 'Успешно сохранено.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $result = $this->userService->destroy($user);

        if (!$result) {
            return back()->withErrors(['error' => 'Ошибка удаления.']);
        }

        return redirect()->route('users.index')->with('success', 'Успешно удалено.');
    }

}
