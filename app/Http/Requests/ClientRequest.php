<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:190',
            'email' => 'required_without:phone|nullable|email:strict,dns,filter',
            'phone' => [
                'required_without:email',
                'nullable',
                'regex:/^[0-9+\s]*$/',
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'name.max' => 'The name must not exceed 190 characters.',
            'email.email' => 'Please enter a valid email address.',
            'email.required_without' => 'An email or phone number is required.',
            'phone.regex' => 'The phone number must only contain digits, spaces, or a plus sign.',
            'phone.required_without' => 'An email or phone number is required.',
        ];
    }
}
