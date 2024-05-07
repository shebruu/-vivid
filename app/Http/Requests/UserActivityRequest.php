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
            //'activity_id' => ['required', 'exists:activities,id'],
            'activity_title' => 'required|string|max:255',
            //'created_by' => ['required', 'exists:users,id'],
            //'place_id' => ['required', 'exists:places,id'],
            'address'        => 'required|string|max:255',
            'postal_code'    => 'required|string|max:10',
            'duration' => ['nullable', 'integer', 'min:0'],
            //'status' => ['required', 'string', 'in:proposed,revised,validated,rejected'],
            'start_time' => ['required', 'date'],

            //price 
            'amount'         => 'required|numeric|min:0',
            'age_range'      => 'required|string',
            'season'         => 'required|string|in:spring,summer,autumn,winter',



        ];
    }
}
