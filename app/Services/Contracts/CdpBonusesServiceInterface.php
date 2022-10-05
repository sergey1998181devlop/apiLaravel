<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface CdpBonusesServiceInterface
{
    public function index($token);
}
