<?php

namespace App\Http\Requests\API\Lk\Loyal;

use Illuminate\Foundation\Http\FormRequest;

class DrawDeleteRequest extends FormRequest
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
            'october_id' => ['required' , 'integer' , 'exists:cdp_draws,october_id'],
        ];
    }
}
