<?php

namespace App\Http\Controllers\API\Products;

use App\Http\Controllers\API\ApiController as ApiController;
use App\Http\Requests\API\Lk\Products\CatalogIndexRequest;
use App\Http\Requests\API\Lk\Products\CatalogCreateRequest;
use App\Http\Requests\API\Lk\Products\CatalogUpdateRequest;
use App\Http\Requests\API\Lk\Products\CatalogDeleteRequest;
use App\Services\Contracts\CdpCatalogServiceInterface;


class ProductsCatalogController extends ApiController
{
    public function __construct(CdpCatalogServiceInterface $CdpProductsCatalogService)
    {
        $this->CdpProductsCatalogService = $CdpProductsCatalogService;
    }

    /**
     * @OA\Post(
     *     path="api/lk/catalog/index",
     *     operationId="indexCatalog",
     *     tags={"catalog"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение каталогов категорий продуктов",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="mall_id",
     *         description="Id ТРЦ",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="success",
     *                     type="bool",
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             property="name",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="visible",
     *                             type="bool"
     *                         ),
     *                         @OA\Property(
     *                             property="mall_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="october_id",
     *                             type="integer"
     *                         ),
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function index(CatalogIndexRequest $request)
    {
        $data = $this->CdpProductsCatalogService->index($request);

        return $this->sendResponse($data, 'Каталог успешно найден' , true);
    }

    /**
     * @OA\Post(
     *     path="api/admin/catalog/create",
     *     operationId="createCatalog",
     *     tags={"catalog"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Создание каталога категорий продуктов",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="id",
     *         description="id записи",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="mall_id",
     *         description="Id ТРЦ",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         description="Название каталога",
     *         example="Продукты для дома",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="visible",
     *         description="Видимость категории",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="bool"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="success",
     *                     type="bool",
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="name",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="visible",
     *                         type="bool"
     *                     ),
     *                     @OA\Property(
     *                         property="mall_id",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="october_id",
     *                         type="integer"
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function create(CatalogCreateRequest $request) {
        $data = $this->CdpProductsCatalogService->create($request);

        return $this->sendResponse($data, 'Каталог успешно создан' , true);
    }


    /**
     * @OA\Post(
     *     path="api/admin/catalog/update",
     *     operationId="updateCatalog",
     *     tags={"catalog"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Обновление названия и видимости каталога категорий продуктов",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="name",
     *         description="Название каталога",
     *         example="Продукты для дома",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="visible",
     *         description="Видимость категории",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="bool"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="success",
     *                     type="bool",
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="updated",
     *                         type="bool"
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function update(CatalogUpdateRequest $request)
    {
        return $this->CdpProductsCatalogService->update($request);
    }

    /**
     * @OA\Delete(
     *     path="api/admin/catalog/delete",
     *     operationId="deleteCatalog",
     *     tags={"catalog"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Удаление каталога категорий продуктов",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="mall_id",
     *         description="Id ТРЦ",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="success",
     *                     type="bool",
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="deleted",
     *                         type="bool"
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function delete(CatalogDeleteRequest $request)
    {
        return $this->CdpProductsCatalogService->delete($request);
    }
}
