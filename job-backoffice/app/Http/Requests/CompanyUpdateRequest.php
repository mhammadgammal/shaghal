<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Company name is required',
            'name.max' => 'Company name must be less than 255 characters',
            'name.unique' => 'Company name already exists',
            'address.required' => 'Company address is required',
            'address.max' => 'Company address must be less than 255 characters',
            'industry.required' => 'Company industry is required',
            'industry.max' => 'Company industry must be less than 255 characters',
            'website.url' => 'Company website must be a valid URL',
            'website.max' => 'Company website must be less than 255 characters',
        ];
    }
}
