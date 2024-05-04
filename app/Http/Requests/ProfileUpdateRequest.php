<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:255'], // First name is required
            'lastname' => ['nullable', 'string', 'max:255'], // Last name is optional
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id), // Unique email, ignoring current user
            ],
            'age' => ['nullable', 'integer', 'min:0'],
            'phone' => [
                'nullable',
                'string', // Use string to accommodate non-numeric characters like "+"
                'max:15', // Adjust based on your specific requirements
                'regex:/^\+?[0-9\s\-\(\)]+$/', // Allows numbers, spaces, dashes, parentheses, optional "+" prefix
            ],
            'student' => ['nullable', 'boolean'],
            'login' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'langue' => ['nullable', 'string', 'max:50'], // Optional language field
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'firstname.required' => 'The first name field is required.',
            'login.required' => 'The login field is required.',
            'login.unique' => 'The login has already been taken.',
            // Add more custom error messages as needed
        ];
    }
}
