<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $id = $this->admin_user->id ?? null;

        return [
            'username' => 'bail|required|string|min:2|max:255|regex:/^[А-ЯЁёа-яA-Za-z ]+$/u',
            'email' => 'bail|required|string|max:1000|email|unique:admin_users,email,' . $id,
            'password' => ($id ? 'bail|nullable' : 'bail|required') . '|string|min:5|max:255|confirmed|regex:/^[A-Za-z0-9]+$/u',
        ];
    }

}
