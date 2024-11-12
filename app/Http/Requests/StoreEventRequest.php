<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
            'date' => 'required',
            'duration' => 'nullable', // Rendre la durée facultative
            'place' => 'required',
            'coordinator' => 'required',
            'laboratory' => 'nullable', // Rendre le laboratoire facultatif
            'department' => 'nullable',
        ];
    }
}
