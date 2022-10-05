<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveNewSettings extends FormRequest
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
            'name'     =>  'required|min:3|max:30',
            'phone'     =>  'required|size:11',
            'email'     =>  'required|email',
            'birthdate' =>  'date|date_format:Y-m-d|before:'.now()->subYears(18)->toDateString(),
            'surname'     =>  'min:3|max:30',
            'sex'     =>  'integer',
        ];
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

