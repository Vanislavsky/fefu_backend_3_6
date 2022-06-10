<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CatalogApiFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_slug' => ['nullable'],
            'search_query' => ['nullable'],
            'sort_mode' => ['nullable', Rule::in(['price_asc', 'price_desc'])],
            'filters' => ['nullable', 'array'],
            'filters.*' => ['required', 'array']
        ];
    }
}
