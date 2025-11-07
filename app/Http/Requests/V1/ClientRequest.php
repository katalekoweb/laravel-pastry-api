<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        $clientId = request()->route("client");

        return [
            "name" => ['required', 'string', 'min:3'],
            "email" => ['nullable', 'email', "unique:clients,email,$clientId"],
            "phone" => ['nullable', 'string'],
            "dob" => ['nullable', 'date'],
            "address" => ['nullable', 'string'],
            "complement" => ['nullable', 'string'],
            "neighbor" => ['nullable', 'string'],
            "neighbor" => ['nullable', 'string'],
            "postal_code" => ['nullable', 'string'],
            "sign_date" => ['nullable', 'string']
        ];
    }
}
