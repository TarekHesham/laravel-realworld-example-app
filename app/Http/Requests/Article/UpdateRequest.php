<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('article')->user->id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'article.title' => 'nullable|string|max:255',
            'article.description' => 'nullable|string|max:255',
            'article.body' => 'nullable|string|max:2048',
            'article.tagList' => 'nullable|array',
            'article.tagList.*' => 'nullable|string|max:255'
        ];
    }
}
