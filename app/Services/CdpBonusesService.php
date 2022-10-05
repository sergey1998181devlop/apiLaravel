<?php

namespace App\Services;

use App\Models\CdpLoyalBonusLogs;
use App\Models\CdpUsers;
use App\Services\Contracts\CdpBonusesServiceInterface;

class CdpBonusesService implements CdpBonusesServiceInterface
{
    /**
     *
     */
    public function index($token)
    {
        $user = CdpUsers::index($token);
        $history = CdpLoyalBonusLogs::userHistory($user->id);
        return $history;
    }



}
