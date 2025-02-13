<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tag' => 'nullable|string',
            'author' => 'nullable|string',
            'favorited' => 'nullable|string',
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer'
        ];
    }
}
