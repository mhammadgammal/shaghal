<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',

            //owner 
            'ownerName' => 'required|string|max:255',
            'ownerEmail' => 'required|email|max:255',
            'ownerPassword' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.unique' => 'The company name has already been taken.',
            'address.required' => 'The address field is required.',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address may not be greater than 255 characters.',
            'industry.required' => 'The industry field is required.',
            'industry.string' => 'The industry must be a string.',
            'industry.max' => 'The industry may not be greater than 255 characters.',
            'website.string' => 'The website must be a string.',
            'website.url' => 'The website format is invalid.',
            'website.max' => 'The website may not be greater than 255 characters.',

            //owner 
            'ownerName.required' => 'The owner name field is required.',
            'ownerName.string' => 'The owner name must be a string.',
            'ownerName.max' => 'The owner name may not be greater than 255 characters.',
            'ownerEmail.required' => 'The owner email field is required.',
            'ownerEmail.email' => 'The owner email must be a valid email address.',
            'ownerEmail.max' => 'The owner email may not be greater than 255 characters.',
            'ownerPassword.required' => 'The owner password field is required.',
            'ownerPassword.string' => 'The owner password must be a string.',
            'ownerPassword.min' => 'The owner password must be at least 8 characters.',
        ];
    }
}
