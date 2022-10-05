<?php

namespace App\Http\Requests\API\Lk\Products;

use Illuminate\Foundation\Http\FormRequest;

class CatalogCreateRequest extends FormRequest
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
            'id'=> ['integer', 'required', 'unique:cdp_products_catalogs,id'],
            'visible' => ['boolean', 'required'],
            'name' => ['string', 'required'],
            'mall_id' => ['integer' , 'required', 'exists:cdp_malls,mall_id']
        ];
    }
}
