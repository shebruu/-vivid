<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', 'unique:trips,slug'],
            'title' => ['nullable', 'string', 'max:255'],
            'departure' => ['nullable', 'date'],
            'arrival' => ['nullable', 'date', 'after_or_equal:departure'],
            'totalestimation' => ['nullable', 'integer'],
            'note' => ['nullable', 'string'],
            'created_by' => ['required', 'exists:users,id'],
        ];
    }
}
