<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $id = $this->category?->id;

        return [
            'parent_id' => 'regex:#^[0-9]$#u',
            'name' => 'required|string|min:2|max:255|regex:#^[А-ЯЁёа-яA-Za-z0-9- ]+$#u|unique:categories,name,' . $id,
            'content' => 'nullable|string|min:2|max:65000',
            'is_active' => 'regex:#^[0-9]$#u',
        ];
    }

}
