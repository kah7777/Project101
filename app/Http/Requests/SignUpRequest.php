<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Services\ApiResponseService;


class SignUpRequest extends FormRequest
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
        $commonRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|same:password', 
            'gender' => 'required|in:male,female',
            'user_type' => 'required|in:doctor,child',
        ];

        if ($this->input('user_type') == 'doctor') {
            $specificRules = [
                'years_of_experience' => 'sometimes|integer|min:0',
                'phone' => 'sometimes|string|max:20',
            ];
        } else {
            $specificRules = [
                'age' => 'required|integer|min:0|max:18',
                'height' => 'sometimes|numeric|min:0|max:300',
                'weight' => 'sometimes|numeric|min:0|max:200',
            ];
        }

        return array_merge($commonRules, $specificRules);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponseService::error(
                'Validation failed',
                422,
                $validator->errors()->toArray()
            )
        );
    }
}
