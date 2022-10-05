<?php

namespace App\Http\Requests\API\Lk\Loyal;

use Illuminate\Foundation\Http\FormRequest;

class DrawCreateRequest extends FormRequest
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
            'october_id' => ['required', 'integer'],
            'title' => ['required' , 'string' , 'max:120'],
            'description' => ['required' , 'string' , 'max:300'],
            'bonus_price' => ['required' , 'integer'],
            'date_start' => ['required' , 'date_format:Y/m/d'],
            'date_end' => ['required' , 'date_format:Y/m/d'],
            'big_image' => ['required'],
            'small_image' => ['required'],
        ];
    }
}
