<?php

namespace App\Http\Requests\API\Lk\Products;

use Illuminate\Foundation\Http\FormRequest;

class CatalogUpdateRequest extends FormRequest
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
            'id' => ['integer'],
            'visible' => ['boolean'],
            'name' => ['string'],
        ];
    }
}
