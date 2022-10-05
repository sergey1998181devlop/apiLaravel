<?php

namespace App\Http\Requests\API\Lk\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'visible' => ['boolean'],
            'name' => ['required' , 'string' , 'min:3' , 'max:70'],
            'description' => ['required' , 'string' , 'min:3' , 'max:450'],
            'price' => ['required' , 'integer'],
            'october_id' => ['required'],

            'category_id' => ['required' , 'integer' , 'exists:cdp_products_categories,october_id'],
            'product_count' => ['required' , 'integer'],
        ];
    }
}
