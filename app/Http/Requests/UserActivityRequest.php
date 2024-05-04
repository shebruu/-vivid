<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'activity_id' => ['required', 'exists:activities,id'],
            'created_by' => ['required', 'exists:users,id'],
            'place_id' => ['required', 'exists:places,id'],
            'duration' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:proposed,revised,validated,rejected'],
            'start_time' => ['nullable', 'date'],



        ];
    }
}
