<?php

namespace App\Enums;


class BonusTypeEnum
{

    const BONUS_TYPE_REGISTER = 1; //Начисление бонусов за регистрацию

    const BONUS_TYPE_REGISTER_DESCRIPTION = 'Начисление бонусов за регистрацию'; //Описание операции

    const BONUS_TYPE_CHECK = 2;

    const BONUS_TYPE_CHECK_DESCRIPTION = 'Начисление бонусов за активацию чека'; //Описание операции

    const BONUS_TYPE_ADMIN = 3;

    const BONUS_TYPE_ADMIN_DESCRIPTION = 'Начисление бонусов администратором'; //Описание операции

    const BONUS_TYPE_DECREASE_BURNED = 4;

    const BONUS_TYPE_DECREASE_BURNED_DESCRIPTION = 'Сгорание бонусов'; //Описание операции

    const BONUS_TYPE_DECREASE_PRODUCT = 5;

    const BONUS_TYPE_DECREASE_PRODUCT_DESCRIPTION = 'Списание бонусов за покупку подарка'; //Описание операции
    const BONUS_TYPE_DECREASE_PRODUCT_DESCRIPTION_JOKES = 'Списание бонусов за участие в розыгрыше'; //Описание операции

    const BONUS_TYPE_EMAIL_CONFIRM = 6; //Начисление бонусов за регистрацию

    const BONUS_TYPE_EMAIL_CONFIRM_DESCRIPTION = 'Начисление за подтверждение email-адреса'; //Описание операции

    const CHECK_STATUS_NOT_ACCEPTED = 0;
    const CHECK_STATUS_NEUTRAL = 1;
    const CHECK_STATUS_CONFIRMED = 2;
    const BONUS_TYPE_DECREASE_STATUS = 'write_off'; //Статус операции (списание , начисление)
    const BONUS_TYPE_INCREASE_STATUS = 'enrollment'; //Статус операции (списание , начисление)

}
