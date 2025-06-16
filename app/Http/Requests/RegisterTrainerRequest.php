<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterTrainerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'temp_token' => 'required|uuid|exists:temp_users,temp_token',
            'experience_years' => 'required|integer|min:0',
        ];
    }
}
