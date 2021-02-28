<?php

namespace App\MyProject\Api\Http\Requests;

interface RequestInterface
{

    /**
     * @return array
     */
    public function rules(): array;

    /**
     * @return array
     */
    public function messages(): array;

}
