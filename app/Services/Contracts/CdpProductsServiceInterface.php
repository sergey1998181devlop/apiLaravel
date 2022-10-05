<?php

namespace App\Services\Contracts;

use App\Http\Requests\API\Lk\Products\ProductCreateRequest;
use App\Http\Requests\API\Lk\Products\ProductDeleteRequest;
use App\Http\Requests\API\Lk\Products\ProductIndexRequest;
use App\Http\Requests\API\Lk\Products\ProductUpdateRequest;
use Illuminate\Http\Request;

interface CdpProductsServiceInterface
{
    public function index(Request $request);

    public function update(ProductUpdateRequest $request);

    public function create(ProductCreateRequest $request);

    public function random(Request $request);

    public function getRandomByToken(Request $request);

    public function delete(ProductDeleteRequest $request);

    public function show(int $id);
}
