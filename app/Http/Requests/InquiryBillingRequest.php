<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InquiryBillingRequest extends FormRequest
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
            'bill_type'=>'required',
            'dispatch_type' => 'required',
        ];
    }
    public function messages()
    {
        return
            [
                'bill_type.required' => 'The customer field is required.',
                'dispatch_type.required' => ' The type of job  field  is required.',
            ];
    }
}
