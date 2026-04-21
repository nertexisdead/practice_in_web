<?php

namespace App\Http\Requests\Api\V1\Categories;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends ApiFormRequest
{
    public function rules(): array
    {
        $category = $this->route('category');
        $categoryId = is_object($category) ? $category->id : $category;

        return [
            'parent_id' => ['sometimes', 'nullable', 'integer', Rule::exists('categories', 'id')],
            'alias' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('categories', 'alias')->ignore($categoryId),
            ],
            'name' => ['sometimes', 'string', 'max:255'],
        ];
    }
}
