<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCompanyFundRequest extends FormRequest
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
            'company_id' => [
                'required',   // The field is required
                'uuid',       // The field must be a valid UUID
            ],
            'fund_id' => [
                'required',   // The field is required
                'uuid',       // The field must be a valid UUID
            ],
        ];
    }

    public function messages()
    {
        return [
            'company_id.required' => 'The company ID is required.',
            'company_id.uuid' => 'The company ID must be a valid UUID.',

            'fund_id.required' => 'The fund ID is required.',
            'fund_id.uuid' => 'The fund ID must be a valid UUID.',
        ];
    }
}
