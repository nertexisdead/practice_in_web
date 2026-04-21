<?php

namespace App\Http\Requests\Web\Admin\Categories;

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
            'parent_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'alias' => ['required', 'string', 'max:255', Rule::unique('categories', 'alias')],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
