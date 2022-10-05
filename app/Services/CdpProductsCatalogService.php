<?php

namespace App\Services;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\API\Lk\Products\CatalogIndexRequest;
use App\Http\Requests\API\Lk\Products\CatalogCreateRequest;
use App\Http\Requests\API\Lk\Products\CatalogUpdateRequest;
use App\Http\Requests\API\Lk\Products\CatalogDeleteRequest;
use App\Models\CdpProductsCatalog;
use App\Models\CdpProductsCategories;
use App\Services\Contracts\CdpCatalogServiceInterface;

class CdpProductsCatalogService implements CdpCatalogServiceInterface
{
    public function create(CatalogCreateRequest $request)
    {
        return CdpProductsCatalog::create(array_merge($request->all(), ['id' => $request->id]));
    }

    public function index(CatalogIndexRequest $request)
    {
        return CdpProductsCatalog::where('mall_id', $request->mall_id)->get();
    }

    public function update(CatalogUpdateRequest $request)
    {
        if ($updated = CdpProductsCatalog::where('id' , $request->id)->update($request->all())) {
            return ApiController::sendResponse(['updated' => $updated], 'Каталог успешно обновлен', true);
        }

        return ApiController::sendError('Ошибка обновления каталога', ['status_code' => '501', 'updated' => $updated], 501);
    }

    public function delete(CatalogDeleteRequest $request)
    {
        if ($deleted = CdpProductsCatalog::where('mall_id', $request->mall_id)->delete()) {
            return ApiController::sendResponse(['deleted' => $deleted], 'Каталог успешно удален', true);
        }

        return ApiController::sendError('Ошибка удаления каталога', ['status_code' => '501', 'deleted' => $deleted], 501);
    }
}
