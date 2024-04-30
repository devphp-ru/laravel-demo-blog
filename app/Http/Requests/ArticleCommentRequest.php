<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'parent_id' => 'bail|gte:0',
            'article_id' => 'bail|gte:0|exists:articles,id',
            'username' => 'bail|required|string|min:2|max:255|regex:#^[А-ЯЁёа-яA-Za-z0-9 ]+$#u',
            'email' => 'bail|required|string|email|max:255',
            'content' => 'bail|required|string|min:1|max:255',
        ];
    }
}
