<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'customer_first_name'=>'required',
            'customer_last_name' => 'required',
            'customer_contact_no' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pin_code' => 'required',
        ];
    }
    public function messages()
    {
        return
            [
                'customer_first_name.required' => 'The first name field is required.',
                'customer_last_name.required' => 'The last name  field  is required.',
                'customer_contact_no.required' => 'The contect no field  is required.',
                'email.email' => 'Please enter a valid email address.',
                'address.required'=>'The address field is required',
                'city.required'=>'The city field is required',
                'pin_code.required|max:6' => 'The pin code is required',
            ];
    }
}