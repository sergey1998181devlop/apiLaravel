<?php

namespace App\Http\Controllers\API\Products;

use App\Http\Controllers\API\ApiController as ApiController;
use App\Http\Requests\API\Lk\Products\CategoryIndexRequest;
use App\Http\Requests\API\Lk\Products\CategoryCreateRequest;
use App\Http\Requests\API\Lk\Products\CategoryUpdateRequest;
use App\Http\Requests\API\Lk\Products\CategoryDeleteRequest;
use App\Services\Contracts\CdpProductsCategoriesServiceInterface;
use Illuminate\Http\Request;

class ProductsCategoriesController extends ApiController
{
    public function __construct(CdpProductsCategoriesServiceInterface $cdpProductsCategoriesService)
    {
        $this->cdpProductsCategoriesService = $cdpProductsCategoriesService;
    }

    /**
     * @OA\Get(
     *     path="api/lk/categories/index",
     *     operationId="indexCategories",
     *     tags={"categories"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение категорий продуктов",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="catalog_id",
     *         description="id каталога продуктов",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
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
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="catalog_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="sort_categories",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="october_id",
     *                             type="integer"
     *                         ),
     *                     )
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function index(CategoryIndexRequest $request)
    {
        $data = $this->cdpProductsCategoriesService->show($request);

        return $this->sendResponse($data, 'Каталог товаров успешно найден', 200);
    }

    /**
     * @OA\Get(
     *     path="api/getRandomCategories",
     *     operationId="randomCategoriesByToken",
     *     tags={"categories"},
     *     summary="Получение рандомных категорий по статичному токену",
     *     description="Защищено статичным токеном",
     *     @OA\Parameter(
     *         name="token",
     *         description="token",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="catalog_id",
     *         description="Id каталога",
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
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="catalog_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="sort_categories",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="october_id",
     *                             type="integer"
     *                         ),
     *                     )
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function getRandomByToken(Request $request)
    {
        return $this->cdpProductsCategoriesService->getRandomByToken($request);
    }



    /**
     * @OA\Post(
     *     path="api/admin/categories/create",
     *     operationId="createCategory",
     *     tags={"categories"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Создание категорий продуктов",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="name",
     *         description="Название категории",
     *         example="Помады",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="catalog_id",
     *         description="id каталога продуктов",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="october_id",
     *         description="id каталога из october CMS",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="фотография - png/jpg/jpeg",
     *                     property="image",
     *                     type="file",
     *                 ),
     *                 required={"image"}
     *             )
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
     *                         property="id",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="catalog_id",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="sort_categories",
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

    public function create(CategoryCreateRequest $request)
    {
        return $this->cdpProductsCategoriesService->create($request);
    }


    /**
     * @OA\Post(
     *     path="api/admin/categories/update",
     *     operationId="updateCategory",
     *     tags={"categories"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Обновление категории продуктов",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="name",
     *         description="Название категории",
     *         example="test",
     *         required=false,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sort_categories",
     *         description="Сортировка категории",
     *         example="test",
     *         required=false,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="catalog_id",
     *         description="id каталога продуктов",
     *         example="1",
     *         required=false,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="october_id",
     *         description="id каталога из october CMS",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="фотография - png/jpg/jpeg",
     *                     property="image",
     *                     type="file",
     *                 ),
     *                 required={}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="message",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(
     *                                 property="updated",
     *                                 type="bool"
     *                             )
     *                         )
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */
    public function update(CategoryUpdateRequest $request)
    {
        return $this->cdpProductsCategoriesService->update($request);
    }


    /**
     * @OA\Delete(
     *     path="api/admin/categories/delete",
     *     operationId="deleteCategory",
     *     tags={"categories"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Удаление категории продуктов",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="category_id",
     *         description="id категории продукта",
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
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="message",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="status",
     *                         type="bool"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(
     *                                 property="deleted",
     *                                 type="bool"
     *                             )
     *                         )
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */
    public function delete(CategoryDeleteRequest $request)
    {
        return $this->cdpProductsCategoriesService->delete($request);
    }
}
