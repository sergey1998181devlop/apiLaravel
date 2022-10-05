<?php

namespace App\Http\Requests\API\Auth;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends FormRequest
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
            'name' => ['required','string','min:3','max:30'],
            'phone' => ['required'],
            'email' => ['required','email','string','max:55'],
            'surname' => ['string','min:3','max:30'],
            'birthdate' => ['required','date_format:d/m/Y'],
            'sex' => ['string'],
            'mall_id' => ['required', 'exists:cdp_malls,mall_id']
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

    public function messages()
    {
        return [
            'agreement_personal.accepted' => 'Вы должны принять правила обработки персональных данных',
            'agreement_loyalty.accepted' => 'Вы должны принять правила программы лояльности',
            'birthdate.before' => 'Вы должны быть старше 16 лет',
            'givenName.required' => 'Поле имя обязательно для заполнения',
            'phone.required' => 'Поле телефон обязательно для заполнения',
            'birthdate.required' => 'Поле дата рождения обязательно для заполнения',
        ];
    }
}
