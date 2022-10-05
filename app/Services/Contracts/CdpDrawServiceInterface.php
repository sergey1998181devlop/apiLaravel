<?php

namespace App\Services\Contracts;
use App\Http\Requests\API\Lk\Loyal\DrawCreateRequest;
use App\Http\Requests\API\Lk\Loyal\DrawDeleteRequest;
use App\Http\Requests\API\Lk\Loyal\DrawUpdateRequest;
use Illuminate\Http\Request;

interface CdpDrawServiceInterface
{
    public function get($user);

    public function create(DrawCreateRequest $request);

    public function update(DrawUpdateRequest $request);

    public function delete(DrawDeleteRequest $request);

    public function join($user , $id);

    public function getDrawMembers($user , $id);

    public function getAllDraws($user);
}
