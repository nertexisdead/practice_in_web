<?php

namespace App\Http\Requests\Api\V1\Products;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'category_id' => ['sometimes', 'integer', Rule::exists('categories', 'id')],
            'in_stock' => ['sometimes', 'boolean'],
            'rating' => ['sometimes', 'nullable', 'numeric', 'between:0,5'],
        ];
    }
}
