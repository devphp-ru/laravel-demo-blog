<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $id = $this->tag?->id;

        return [
            'name' => 'bail|required|string|min:1|max:255|regex:#^[А-ЯЁёа-яA-Za-z0-9- ]+$#u|unique:tags,name,' . $id,
            'content' => 'bail|nullable|string|min:1|max:65000',
            'is_active' => 'bail|gte:0',
        ];
    }

}
