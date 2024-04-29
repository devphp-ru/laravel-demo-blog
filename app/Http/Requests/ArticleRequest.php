<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $id = $this->article?->id;

        return [
            'category_id' => 'bail|gte:0|exists:categories,id',
            'title' => 'bail|required|string|min:2|max:255|unique:articles,title,' . $id,
            'content' => 'bail|required|string|min:2|max:65000',
            'image' => 'bail|nullable|image|mimes:png,jpeg,jpg,webp',
            'views' => 'bail|gte:0',
            'is_active' => 'bail|gte:0',
        ];
    }

}
