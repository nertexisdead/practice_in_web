<?php

namespace App\Http\Requests\Api\V1\Categories;

use App\Http\Requests\ApiFormRequest;

class IndexRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
