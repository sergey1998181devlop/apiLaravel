<?php

namespace App\Http\Requests\API\Lk\Loyal;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmCheckRequest extends FormRequest
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
            'check_id' => ['required' , 'exists:cdp_loyal_checks,id'],
            'check_sum' => ['required'],
            'bonus_sum' => ['required'],
            'status' => ['required' , 'string'],
        ];
    }
}
