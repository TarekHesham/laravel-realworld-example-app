<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user.username' => 'nullable|string|max:50|unique:users,username,' . auth()->user()->id,
            'user.email' => 'nullable|email|max:255|unique:users,email,' . auth()->user()->id,
            'user.password' => 'nullable',
            'user.image' => 'nullable|url',
            'user.bio' => 'nullable|string|max:2048'
        ];
    }
}
