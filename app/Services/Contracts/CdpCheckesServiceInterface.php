<?php

namespace App\Services\Contracts;

use App\Http\Requests\API\Lk\Loyal\LoyalCheckUploadRequest;

interface CdpCheckesServiceInterface
{
    public function index($token);

    public function upload(LoyalCheckUploadRequest $request , $token);
}
