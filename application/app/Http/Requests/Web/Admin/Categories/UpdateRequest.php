<?php

namespace App\Http\Requests\Web\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category');
        $categoryId = is_object($category) ? $category->id : $category;

        return [
            'parent_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'alias' => ['required', 'string', 'max:255', Rule::unique('categories', 'alias')->ignore($categoryId)],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
