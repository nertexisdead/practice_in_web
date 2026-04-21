<?php

namespace App\Http\Requests\Api\V1\Categories;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'alias' => ['required', 'string', 'max:255', Rule::unique('categories', 'alias')],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
