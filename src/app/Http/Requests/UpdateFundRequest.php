<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFundRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' =>
                'string',
                'max:255',
            'start_year' =>
                'year',
                'max:4',
            'manager_id' =>
                'year',
                'exists:manager, id',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name cannot exceed 255 characters.',

            'start_year.numeric' => 'The start year must be a number.',
            'start_year.max' => 'The start year cannot exceed 4 characters.',

            'manager_id.exists' => 'The selected manager is invalid.',
        ];
    }
}
