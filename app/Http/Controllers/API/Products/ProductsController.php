<?php

namespace App\Http\Controllers\API\Products;

use App\Http\Controllers\API\ApiController as ApiController;
use App\Http\Requests\API\Lk\Products\ProductCreateRequest;
use App\Http\Requests\API\Lk\Products\ProductDeleteRequest;
use App\Http\Requests\API\Lk\Products\ProductIndexRequest;
use App\Http\Requests\API\Lk\Products\ProductUpdateRequest;
use App\Services\Contracts\CdpProductsServiceInterface;
use Illuminate\Http\Request;

class ProductsController extends ApiController

{
    public function __construct(CdpProductsServiceInterface $productsService)
    {
        $this->productsService = $productsService;
    }

    /**
     * @OA\Get(
     *     path="api/lk/products/index",
     *     operationId="indexProducts",
     *     tags={"products"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="visible_all",
     *         description="Показывать все",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="bool"
     *         )
     *     ),
     *     summary="Получение продуктов по номеру каталога",
     *     description="Защищено bearer-токеном",
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
     *                             property="id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="description",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="visible",
     *                             type="bool"
     *                         ),
     *                         @OA\Property(
     *                             property="price",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="product_image",
     *                             type="bool"
     *                         ),
     *                         @OA\Property(
     *                             property="category_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="sort_product",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="product_count",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="october_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="catalog_id",
     *                             type="integer"
     *                         ),
     *                     ),
     *                 ),
     *             )
     *        ),
     *    )
     * )
     */

    public function index(Request $request)
    {
        return $this->productsService->index($request);
    }

    /**
     * @OA\Post(
     *     path="api/lk/products/show",
     *     operationId="showProduct",
     *     tags={"products"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение продукта по id",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         description="Id продукта",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
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
     *                         property="description",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="visible",
     *                         type="bool"
     *                     ),
     *                     @OA\Property(
     *                         property="price",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="product_image",
     *                         type="bool"
     *                     ),
     *                     @OA\Property(
     *                         property="category_id",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="sort_product",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="product_count",
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

    public function show(Request $request)
    {
        $data = $this->productsService->show($request->id);

        return $this->sendResponse($data, 'Данныео товаре успешно получены' , 200);
    }


    /**
     * @OA\Get(
     *     path="api/lk/products/getRandom",
     *     operationId="randomProducts",
     *     tags={"products"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение рандомных продуктов",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="visible_all",
     *         description="Показывать все",
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
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="description",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="visible",
     *                             type="bool"
     *                         ),
     *                         @OA\Property(
     *                             property="price",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="product_image",
     *                             type="bool"
     *                         ),
     *                         @OA\Property(
     *                             property="category_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="sort_product",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="product_count",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="october_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="catalog_id",
     *                             type="integer"
     *                         ),
     *                     ),
     *                 ),
     *             )
     *        ),
     *    )
     * )
     */
    public function random(Request $request)
    {
        return $this->productsService->random($request);
    }


    /**
     * @OA\Get(
     *     path="api/getRandomProducts",
     *     operationId="randomProductsByToken",
     *     tags={"products"},
     *     summary="Получение рандомных продуктов",
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
     *         name="visible_all",
     *         description="Показывать все",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="bool"
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
     *                             property="id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="description",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="visible",
     *                             type="bool"
     *                         ),
     *                         @OA\Property(
     *                             property="price",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="product_image",
     *                             type="bool"
     *                         ),
     *                         @OA\Property(
     *                             property="category_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="sort_product",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="product_count",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="october_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="catalog_id",
     *                             type="integer"
     *                         ),
     *                     ),
     *                 ),
     *             )
     *        ),
     *    )
     * )
     */

    public function getRandomByToken(Request $request)
    {
        return $this->productsService->getRandomByToken($request);
    }


    /**
     * @OA\Post(
     *     path="api/admin/products/create",
     *     operationId="createProduct",
     *     tags={"products"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Создание продукта",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="category_id",
     *         description="Id категории продукта",
     *         example="3",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         description="Название продукта",
     *         example="Соли",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         description="Описание продукта",
     *         example="Соли для гололедов",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="price",
     *         description="Цена продукта",
     *         example="300",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="product_count",
     *         description="Остаток продукта на текущий момент",
     *         example="22",
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
     *                     property="product_image",
     *                     type="file",
     *                 ),
     *                 required={"product_image"}
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="visible",
     *         description="Видимость товара",
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
     *                         property="id",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="visible",
     *                         type="bool"
     *                     ),
     *                     @OA\Property(
     *                         property="price",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="product_image",
     *                         type="bool"
     *                     ),
     *                     @OA\Property(
     *                         property="category_id",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="sort_product",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="product_count",
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

    public function create(ProductCreateRequest $request)
    {
        return $this->productsService->create($request);
    }


    /**
     * @OA\Post(
     *     path="api/admin/products/update",
     *     operationId="updateProduct",
     *     tags={"products"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Обновление информации о товаре",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="category_id",
     *         description="Id категории продукта",
     *         example="3",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         description="Название продукта",
     *         example="Carmex",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         description="Описание продукта",
     *         example="Автомобильный аккумулятор",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="price",
     *         description="Цена продукта",
     *         example="3000",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="product_count",
     *         description="Остаток продукта на текущий момент",
     *         example="34",
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
     *                     property="product_image",
     *                     type="file",
     *                 ),
     *                 required={}
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="visible",
     *         description="Видимость товара",
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

    public function update(ProductUpdateRequest $request)
    {
        return $this->productsService->update($request);
    }

    /**
     * @OA\Delete(
     *     path="api/admin/products/delete",
     *     operationId="deleteProduct",
     *     tags={"products"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Удаление продукта",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="october_id",
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

    public function delete(ProductDeleteRequest $request)
    {
        return $this->productsService->delete($request);
    }
}
