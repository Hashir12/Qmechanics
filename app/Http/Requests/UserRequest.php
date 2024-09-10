<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
         // Validation rules for the user form
         return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:1,2',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        // Custom error messages
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.',
            'role.required' => 'Please select a role.',
            'password.required' => 'The password field is required.',
        ];
    }
}
