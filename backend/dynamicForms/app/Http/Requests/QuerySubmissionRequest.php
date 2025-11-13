<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuerySubmissionRequest extends FormRequest
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
            'field_id' => 'nullable|exists:form_fields,id',
            'value' => 'nullable|string',
            'filters' => 'nullable|array',
            'filters.*.field_id' => 'required|exists:form_fields,id',
            'filters.*.value' => 'required',
            'filters.*.operator' => 'nullable|in:=,LIKE,>,<,>=,<=',
        ];
    }
}
