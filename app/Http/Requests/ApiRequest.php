<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Dotenv\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Exceptions\HttpResponseException as ExceptionsHttpResponseException;
use Illuminate\Http\Response;

abstract class ApiRequest extends FormRequest
{
    use ApiResponse;
    /**
     * Determine if the user is authorized to make this request.
     */
    abstract public function rules();

    protected function failedValidation(ValidationValidator $validator)
    {
        throw new ExceptionsHttpResponseException($this->apiError(
            $validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY,
        ));
    }

    protected function failedAuthorization()
    {
        throw new ExceptionsHttpResponseException($this->apiError(
            null,
            Response::HTTP_UNAUTHORIZED
        ));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
}
