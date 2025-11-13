<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFieldRequest extends FormRequest
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
            'form_id' => 'required|exists:forms,id',
            'label' => 'required|string|max:255',
            'field_type_id' => 'required|exists:field_types,id',
            'validation_rules' => 'nullable|array',
            'order' => 'nullable|integer',
            'is_required' => 'nullable|boolean',
            'options' => 'nullable|array',
            'options.*.value' => 'required|string',
            'options.*.label' => 'required|string',
            'options.*.order' => 'nullable|integer',
        ];
    }
}
