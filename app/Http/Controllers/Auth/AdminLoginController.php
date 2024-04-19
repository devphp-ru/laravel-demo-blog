<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.admin_login_form');
    }

    public function login(AdminLoginRequest $request): RedirectResponse
    {
        if (!auth('admin')->attempt($request->validated())) {
            return back()->withErrors(['error' => 'Неверный логин или пароль.'])->onlyInput('email');
        }

        if (auth('admin')->user()->is_banned) {
            auth('admin')->logout();

            return back()->withErrors(['error' => 'Доступ запрещен.']);
        }

        return redirect()->route('admin.dashboard.index')->with('success', 'Вы вошил в систему.');
    }

    public function logout(): RedirectResponse
    {
        auth('admin')->logout();

        return redirect()->route('admin.login.form')->with('success', 'Вы вышил из системы.');
    }

}
