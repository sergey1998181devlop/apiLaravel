<?php

namespace App\Services\Contracts;

use App\Http\Requests\API\Auth\AdminLoginRequest;

interface CdpAdminServiceInterface
{
    public function login(AdminLoginRequest $request);
}

