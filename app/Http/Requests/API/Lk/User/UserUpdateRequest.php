<?php

namespace App\Http\Requests\API\Lk\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name'     =>  'required|min:3|max:30',
            'phone'     =>  'required',
            'email'     =>  'required|email|string|max:55',
            'birthdate' =>  'date|date_format:d/m/Y',
            'surname'     =>  'min:3|max:30',
            'sex'     =>  'string',
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
    
    public function messages(){
        return [
            'name.required' => 'Введите :attribute (:attribute обязателено)',
            'name.min' => 'Минимальная длина :attribute [:min] символов',
            'name.max' => 'Максимальная длина :attribute [:max] символов',

            'email.email' => ':attribute введен не верно',

            'phone.required' => 'Введите :attribute (:attribute обязателен)',
            'phone.size' => 'Длина :attribute должна быть  [:size] символов',

            'surname.min' => 'Минимальная длина :attribute [:min] символов',
            'surname.max' => 'Максимальная длина :attribute [:max] символов',

            'birthdate.date_format' => 'Не верная :attribute',
            'birthdate.before' => 'Вам должно быть больше 18 лет',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'имя',
            'phone' => 'номер телефона',
            'email' => 'email',
            'surname' => 'фамилия',
            'sex' => 'пол',
            'birthdate' => 'дата рождения',
        ];
    }
}
