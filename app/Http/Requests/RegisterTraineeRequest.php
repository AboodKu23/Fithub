<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterTraineeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'temp_token' => 'required|uuid|exists:temp_users,temp_token',
            'height' => 'required|numeric|between:50,250',
            'weight' => 'required|numeric',
            'activity_level' => 'required|string|in:Beginner,Intermediate,Advanced',
        ];
    }
}
