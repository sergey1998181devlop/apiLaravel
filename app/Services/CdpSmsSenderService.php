<?php

namespace App\Services;

use App\Services\Contracts\CdpSmsSenderServiceInterface;

class CdpSmsSenderService implements CdpSmsSenderServiceInterface
{
    public static function send($phone, $code, $credentials)
    {
        $client = new \GuzzleHttp\Client([
            'verify' => false
        ]);
        $response = $client->request('POST', 'https://api3.greensms.ru/sms/send', [
            'form_params' => [
                'user' => $credentials->sms_user,
                'pass' => $credentials->sms_password,
                'to' => '7'.$phone,
                'txt' => 'Код подтверждения:'.' '.$code->code,
                'from' => $credentials->sms_name
            ]
        ]);
    }
}
