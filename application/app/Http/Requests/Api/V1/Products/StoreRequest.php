<?php

namespace App\Http\Requests\Api\V1\Products;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'in_stock' => ['required', 'boolean'],
            'rating' => ['nullable', 'numeric', 'between:0,5'],
        ];
    }
}
