<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMobilityRequest extends FormRequest
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
            'first_name_benefit' => 'required',
            'last_name_benefit' => 'required',
            'date_go' => 'required',
            'status' => 'required',
            'date_return' => 'required',
            'destination' => 'required',
            'laboratory' => 'nullable', 
            'department' => 'nullable',
        ];
    }
}
