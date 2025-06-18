<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExercisesPageRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'required|integer|min:1',
        ];
    }
}
