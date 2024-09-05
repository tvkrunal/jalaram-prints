<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
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
            'customer_id	'=>'required',
            'type_of_job	' => 'required',
            'delivery_date' => 'required',
            'designing_details' => 'required',
            'price_masters_id' => 'required',
            'user_id' => 'required',
            'job_description' => 'required',
            'process' => 'required',
            'cost_calculation' => 'required',
        ];
    }
    public function messages()
    {
        return
            [
                'customer_id.required' => 'The customer field is required.',
                'type_of_job.required' => ' The type of job  field  is required.',
                'delivery_date.required' => 'The delivery date field is required',
                'designing_details.required' => ' The designing details  field  is required.',
                'price_masters_id.required'=>'The price masters field is required',
                'user_id.required'=>'The user field is required',
                'job_description.required' => 'The job description field is required.',
                'process.required'=>'The process field is required',
                'cost_calculation.required' => 'The cost calculation field is required.', 
            ];
    }
}
