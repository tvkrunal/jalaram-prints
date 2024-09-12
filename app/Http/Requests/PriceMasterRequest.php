<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceMasterRequest extends FormRequest
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
            'item_type' => 'required',
            'media' => 'required',
            'gsm' => 'required',
            'qty' => 'required',
            'min_cost' => 'required',
            'max_cost' => 'required',
        ];
    }
    public function messages()
    {
        return
            [
                'item_type.required' => 'The item type field is required.',
                'media.required' => ' The media field  is required.',
                'gsm.required' => 'The gsm field  is required.',
                'qty.required' => 'The qty field  is required.',
                'min_cost.required'=>'The min cost field is required',
                'max_cost.required'=>'The max cost field is required',
            ];
    }
}