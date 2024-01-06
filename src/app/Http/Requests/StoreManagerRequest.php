<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManagerRequest extends FormRequest
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
                'required',
                'string',
                'max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The manager name is required.',
            'name.string' => 'The manager name must be a string.',
            'name.max' => 'The manager name cannot exceed 255 characters.',
        ];
    }
}
