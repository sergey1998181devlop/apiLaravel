<?php

namespace App\Http\Requests\API\Lk\Loyal;

use Illuminate\Foundation\Http\FormRequest;

class DrawUpdateRequest extends FormRequest
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
            'october_id' => ['required'],
            'title' => ['sometimes' , 'string' , 'max:120'],
            'description' => ['sometimes' , 'string' , 'max:300'],
            'bonus_price' => ['sometimes' , 'integer'],
            'date_start' => ['sometimes' , 'date_format:Y/m/d'],
            'date_end' => ['sometimes' , 'date_format:Y/m/d'],
            'big_image' => ['sometimes'],
            'small_image' => ['sometimes']
        ];
    }
}
