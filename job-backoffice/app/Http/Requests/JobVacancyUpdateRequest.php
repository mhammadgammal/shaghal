<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:225',
            'description' => 'required|string',
            'location' => 'required|string|max:225',
            'salary' => 'required|numeric|min:0',
            'type' => 'required|in:full-time,hybrid,contract,remote',
            'category_id' => 'required|exists:job_categories,id',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 225 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'location.required' => 'The location field is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than 225 characters.',
            'salary.required' => 'The salary field is required.',
            'salary.numeric' => 'The salary must be a number.',
            'salary.min' => 'The salary must be at least 0.',
            'type.required' => 'The type field is required.',
            'type.in' => 'The selected type is invalid. Allowed types are: full-time, hybrid, contract, remote.',
        ];
    }
}
