<?php

namespace App\Http\Requests\API\Lk\Products;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
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
            'name' => ['required' , 'string' , 'max:50'],
            'catalog_id' => ['required' , 'integer' , 'exists:cdp_products_catalogs,id'],
            'october_id' => ['required', 'integer'],

        ];
    }
}
