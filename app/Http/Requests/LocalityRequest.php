<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocalityRequest extends FormRequest
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
            'postal_code' => ['required', 'integer'],
            'city' => ['required', 'string', 'max:60'],
            'province' => ['required', 'string'],
            'country' => ['nullable', 'string', 'max:60'],
            'adress' => ['nullable', 'string'],
            'population' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string'],
            'language' => ['required', 'string'],
            'googleplace_id' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }
}
