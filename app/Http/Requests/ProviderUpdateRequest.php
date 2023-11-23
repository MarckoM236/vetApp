<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderUpdateRequest extends FormRequest
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
            'nit'=>['required', 'numeric', 'min:7'],
            'name'=>['required', 'string', 'max:255'],
            'contact'=>['required', 'string', 'max:255'],
            'email'=>['required', 'string', 'email', 'max:255'],
            'phone'=>['required', 'numeric', 'min:7']
        ];
    }
}
