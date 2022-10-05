<?php

namespace App\Http\Requests\API\Lk\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'visible' => ['sometimes' , 'boolean'],
            'name' => ['sometimes' , 'string' , 'min:3' , 'max:50'],
            'price' => ['sometimes' , 'integer'],
            'october_id' => ['required' , 'integer'],
            'product_image' => ['sometimes', 'mimes:jpeg,png,jpg'],
            'product_count' => ['sometimes' , 'integer'],
        ];
    }
}
