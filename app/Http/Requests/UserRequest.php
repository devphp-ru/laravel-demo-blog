<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $id = $this->user?->id;

        return [
            'name' => 'bail|required|string|min:2|max:255|regex:/^[А-ЯЁёа-яA-Za-z ]+$/u',
            'email' => 'bail|required|string|max:1000|email|unique:users,email,' . $id,
            'password' => ($id ? 'bail|nullable' : 'bail|required') . '|string|min:5|max:255|confirmed|regex:/^[A-Za-z0-9]+$/u',
        ];
    }

}
