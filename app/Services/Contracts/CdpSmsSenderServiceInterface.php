<?php

namespace App\Services\Contracts;

use App\Http\Requests\API\Lk\Loyal\LoyalCheckUploadRequest;

interface CdpSmsSenderServiceInterface
{
    public static function send($phone, $code, $credentials);
}

