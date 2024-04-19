<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.admin_login_form');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|max:1000|email',
            'password' => 'required|string|max:1000',
        ]);

        if (!auth('admin')->attempt($request->only('email', 'password'))) {
            return back()->withErrors(['error' => 'Неверный логин или пароль.'])->onlyInput('email');
        }

        if (auth('admin')->user()->is_banned) {
            auth('admin')->logout();

            return back()->withErrors(['error' => 'Доступ запрещен.']);
        }

        return redirect()->route('admin.dashboard.index')->with('success', 'Вы вошил в систему.');
    }

}
