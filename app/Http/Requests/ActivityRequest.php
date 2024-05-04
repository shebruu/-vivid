<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'activity' => ['required', 'string', 'max:255'],
            'created_by' => ['nullable', 'exists:users,id'], // Should reference an existing user
        ];
    }
}
