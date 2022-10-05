<?php

namespace App\Services\Contracts;

interface CdpUserModerationServiceInterface
{
    public function filterUsers($filter , $user);

    public function filterUsersByMall($filter,$mall , $user);
}
