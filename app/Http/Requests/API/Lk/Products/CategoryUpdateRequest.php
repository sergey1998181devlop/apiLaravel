<?php

namespace App\Http\Requests\API\Lk\Products;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['sometimes', 'string' , 'max:50'],
            'sort_categories' => ['sometimes', 'integer'],
            'catalog_id' => ['integer' , 'exists:cdp_products_catalogs,id'],
            'october_id' => ['integer'],
            'image' => ['sometimes', 'mimes:jpeg,png,jpg'],
        ];
    }
}
