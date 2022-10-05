<?php

namespace App\Services;

use App\Services\Contracts\CdpEmailSenderServiceInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;

class CdpEmailSenderService implements CdpEmailSenderServiceInterface
{
    public static function send(int $messageId, string $email, string $snippets = ''): bool
    {
        $client = new \GuzzleHttp\Client();

        $params = [
            'query' => [
                'apiKey' => Config::get('emailsendler.api_key'),
                'messageId' => $messageId,
                'email' => $email,
                'snippets' => $snippets
            ]
        ];

        try {
            $response = $client->request('GET', 'https://api.enkod.ru/v1/mail/', $params);
        } catch (GuzzleException $e) {
            return false;
        }

        return $response->getStatusCode() == 200;
    }
}
