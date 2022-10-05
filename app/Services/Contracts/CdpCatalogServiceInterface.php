<?php

namespace App\Services\Contracts;

use App\Http\Requests\API\Lk\Products\CatalogIndexRequest;
use App\Http\Requests\API\Lk\Products\CatalogCreateRequest;
use App\Http\Requests\API\Lk\Products\CatalogUpdateRequest;
use App\Http\Requests\API\Lk\Products\CatalogDeleteRequest;

interface CdpCatalogServiceInterface
{
    public function create(CatalogCreateRequest $request);

    public function index(CatalogIndexRequest $request);

    public function update(CatalogUpdateRequest $request);

    public function delete(CatalogDeleteRequest $request);
}

