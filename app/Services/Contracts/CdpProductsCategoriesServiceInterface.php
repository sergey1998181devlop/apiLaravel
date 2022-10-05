<?php

namespace App\Services\Contracts;


use App\Http\Requests\API\Lk\Products\CategoryCreateRequest;
use App\Http\Requests\API\Lk\Products\CategoryIndexRequest;
use App\Http\Requests\API\Lk\Products\CategoryUpdateRequest;
use App\Http\Requests\API\Lk\Products\CategoryDeleteRequest;
use Illuminate\Http\Request;

interface CdpProductsCategoriesServiceInterface
{
    public function create(CategoryCreateRequest $request);

    public function show(CategoryIndexRequest $request);

    public function getRandomByToken(Request $request);

    public function update(CategoryUpdateRequest $request);

    public function delete(CategoryDeleteRequest $request);
}
