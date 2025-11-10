<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterWithBusinessRequest extends FormRequest
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
            // User fields
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            
            // Business fields
            'business_name' => 'required|string|max:255',
            'business_description' => 'nullable|string|max:1000',
            'business_address' => 'nullable|string|max:255',
            'business_phone' => 'nullable|string|max:255',
            'business_email' => 'nullable|email|max:255',
            'business_website' => 'nullable|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'business_name.required' => 'The business name is required.',
            'business_email.email' => 'The business email must be a valid email address.',
            'business_website.url' => 'The business website must be a valid URL.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'password' => 'Password',
            'business_name' => 'Business Name',
            'business_description' => 'Business Description',
            'business_address' => 'Business Address',
            'business_phone' => 'Business Phone',
            'business_email' => 'Business Email',
            'business_website' => 'Business Website',
        ];
    }
}

