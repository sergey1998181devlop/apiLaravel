<?php

namespace App\Services\Contracts;

use App\Http\Requests\API\Lk\Loyal\OrderCreateRequest;
use Illuminate\Http\Request;

interface CdpOrderServiceInterface
{
    public function makeUserOrder(OrderCreateRequest $request);

    public function  index(Request $request);
}
