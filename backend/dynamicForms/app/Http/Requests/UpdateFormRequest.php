<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'version' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
            'fields' => 'nullable|array',
            'fields.*.label' => 'required_with:fields|string|max:255',
            'fields.*.field_type_id' => 'required_with:fields|exists:field_types,id',
            'fields.*.validation_rules' => 'nullable|array',
            'fields.*.order' => 'nullable|integer',
            'fields.*.is_required' => 'nullable|boolean',
            'fields.*.options' => 'nullable|array',
            'fields.*.options.*.value' => 'required|string',
            'fields.*.options.*.label' => 'required|string',
            'fields.*.options.*.order' => 'nullable|integer',
        ];
    }
}
