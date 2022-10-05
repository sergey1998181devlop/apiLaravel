<?php

namespace App\Services\Contracts;

use App\Http\Requests\API\Lk\Loyal\LoyalCheckUploadRequest;

interface CdpEmailSenderServiceInterface
{
    public static function send(int $messageId , string $email, string $snippets);
}
