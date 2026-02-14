<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerupdateRequest extends FormRequest
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
            'name' => 'required|string',

            'contact' => [
                'required',
                'digits_between:7,15',
                Rule::unique('customers', 'contact')
                    ->ignore($this->route('customer')), 
            ],

            'email' => [
                'email',
                Rule::unique('customers', 'email')
                    ->ignore($this->route('customer')),
            ],
        ];
    }
}
