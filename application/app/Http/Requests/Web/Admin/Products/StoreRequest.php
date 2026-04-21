<?php

namespace App\Http\Requests\Web\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
