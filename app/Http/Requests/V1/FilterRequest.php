<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            "query" => ['nullable', 'string', 'max:100'],
            'sort_by' => ['nullable'],
            'sort_order' => ['nullable', 'in:asc,desc'],
            'with_trashed' => ['nullable', 'boolean']
        ];
    }

    public function prepareForValidation(): void {
        $this->merge([
            "sort_by" => $this->input("sort_by", "id"),
            "sort_order" => $this->input("sort_order", "asc"),
            "with_trashed" => $this->input("with_trashed", 0),
        ]);
    }
}
