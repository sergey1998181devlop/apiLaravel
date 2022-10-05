<?php

namespace App\Http\Requests\API\Auth;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserVerifyRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {

        return [
            'phone' => ['required','max:25'],
            'mall_id' => ['required' , 'exists:cdp_malls,mall_id']
        ];
    }

    public function validationData()
    {
        try {
            $this->merge([
                'phone' => str_replace(array('(', ')', ' ', '-', '+'), '', $this->phone)]);
            if (iconv_strlen($this->phone) === 10 and $this->phone[0] === 9) {
                return parent::validationData();
            }
            if (iconv_strlen($this->phone) < 10) {
                throw new Exception("Неверный формат номера" , 401);
            } else {
                $this->merge([
                    'phone' => substr($this->phone, iconv_strlen($this->phone) - 10)]);
                return parent::validationData();
            }
        }catch (\Exception $exception) {
            throw new Exception("Ошибка валидации номера" , 401);
        }
    }
}
