<?php

namespace App\Enums;


class EmailSendTypeEnum
{
    const EMAIL_REGISTER = 1; //Отправка при подтверждении почты

    const EMAIL_WELCOME_AFTER_REGISTER = 2; //Отправка приветственного письма после регистрации

    const EMAIL_AFTER_REGISTER = 3; //Отправка после подтверждения
}
