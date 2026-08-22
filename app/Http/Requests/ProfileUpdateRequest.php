<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'email' => [
            'required',
            'string',
            'lowercase',
            'email',
            'max:255',
            Rule::unique(User::class)->ignore($this->user()->id),
        ],

        'age' => [
            'nullable',
            'integer',
            'min:13',
            'max:100',
        ],

        'job_title' => [
            'nullable',
            'string',
            'max:255',
        ],

        'profile_description' => [
            'nullable',
            'string',
            'max:2000',
        ],

        'phone' => [
            'nullable',
            'string',
            'max:20',
        ],

        'skills' => [
            'nullable',
            'string',
            'max:1000',
        ],

       'profile_image' => 'nullable',
'resume' => 'nullable',
    ];
}
}
