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
            // 'slug' => ['required', 'string', 'max:255', 'unique:trips,slug'],
            'title' => ['nullable', 'string', 'max:255'],
            'departure' => ['nullable', 'date'],
            'arrival' => ['nullable', 'date', 'after_or_equal:departure'],
            'totalestimation' => ['nullable', 'integer'],


        ];

        if ($this->isMethod('put')) {
            $rules['title'][] = 'required';
            $rules['departure'][] = 'required';
            $rules['arrival'][] = 'required';
            $rules['note'] = ['nullable', 'string'];
        }
    }

    public function messages(): array
    {
        return [
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'departure.date' => 'La date de départ doit être une date valide.',
            'arrival.date' => 'La date d\'arrivée doit être une date valide.',
            'arrival.after_or_equal' => 'La date d\'arrivée doit être après ou égale à la date de départ.',
            'totalestimation.integer' => 'L\'estimation totale doit être un nombre entier.',
            'totalestimation.min' => 'L\'estimation totale doit être supérieure ou égale à 0.',
            'note.string' => 'La note doit être une chaîne de caractères.'
        ];
    }
}
