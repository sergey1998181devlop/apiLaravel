<?php

namespace App\Services\Contracts;


interface CdpFileServiceInterface
{
    public static function store($file, $path , $hashDir);
}
