<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
                'identificacion' => ['required', 'numeric', 'min:7','unique:customers'],
                'name' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'address' => ['nullable', 'string', 'max:255'],
                'phone' => ['nullable', 'numeric', 'min:7'],
                'city' => ['nullable', 'string', 'max:255'],
                'neighborhood' => ['nullable','string', 'max:255']
        ];
    }
}
