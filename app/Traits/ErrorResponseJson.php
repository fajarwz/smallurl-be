<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ErrorResponseJson {
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(errorResponse([], $validator->errors(), 422));
    }
}