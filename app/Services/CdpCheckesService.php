<?php

namespace App\Services;


use App\Http\Requests\API\Lk\Loyal\LoyalCheckUploadRequest;
use App\Models\CdpLoyalChecks;
use App\Models\CdpUsers;
use App\Services\Contracts\CdpCheckesServiceInterface;

class CdpCheckesService implements CdpCheckesServiceInterface
{
    /**
     *
     */
    public function index($token)
    {
        $user = CdpUsers::index($token);
        return CdpLoyalChecks::index($user->id , $user->mall_id);
    }

    public function upload(LoyalCheckUploadRequest $request , $token)
    {
        $hash = sha1(uniqid());
        $filename = sha1(uniqid());
        $user = CdpUsers::index($token);
        $file = CdpFileService::storeIfNoneFileType($request->file , '' ,$hash  , $filename);
        return CdpLoyalChecks::create($user , $file , $hash , $filename);
    }

}
