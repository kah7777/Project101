<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
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
        return [
                "name"=>"required|string",
                "email"=>"required|email|",
                "password"=>"required|max:20",
                'user_type'=> ['required', Rule::in(['doctor', 'guardian'])]
        ];
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
