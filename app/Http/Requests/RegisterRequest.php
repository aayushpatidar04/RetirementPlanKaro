<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name'    => trim((string) $this->input('name')),
            'surname' => trim((string) $this->input('surname')),
            'mobile'  => preg_replace('/\D/', '', (string) $this->input('mobile')),
            'email'   => strtolower(trim((string) $this->input('email'))),
            'city'    => trim((string) $this->input('city')),
            'pan'     => strtoupper(trim((string) $this->input('pan'))) ?: null,
            'ref'     => strtoupper(trim((string) $this->input('ref'))) ?: null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:60'],
            'surname'  => ['required', 'string', 'max:60'],
            'mobile'   => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:users,mobile'],
            'email'    => ['required', 'email:rfc', 'max:190', 'unique:users,email'],
            'city'     => ['required', 'string', 'max:80'],
            'pan'      => ['nullable', 'regex:/^[A-Z]{5}\d{4}[A-Z]$/'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms'    => ['accepted'],
            'risk'     => ['accepted'],
            'share'    => ['nullable', 'boolean'],
            'ref'      => ['nullable', 'string', 'max:12'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Enter your name',
            'surname.required'   => 'Enter your surname',
            'mobile.regex'       => 'Enter a valid 10-digit mobile number',
            'mobile.unique'      => 'This mobile number is already registered. Please login.',
            'email.email'        => 'Enter a valid email',
            'email.unique'       => 'This email is already registered. Please login.',
            'city.required'      => 'Enter your city',
            'pan.regex'          => 'PAN looks wrong (format ABCDE1234F) or leave it blank',
            'password.confirmed' => 'Passwords do not match',
            'terms.accepted'     => 'Please accept the Terms and Privacy Policy',
            'risk.accepted'      => 'Please confirm you have read the Risk Disclosure',
        ];
    }
}