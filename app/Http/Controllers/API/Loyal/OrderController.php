<?php

namespace App\Http\Controllers\API\Loyal;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\API\Lk\Loyal\OrderCreateRequest;
use App\Models\CdpUsersOrders;
use App\Services\Contracts\CdpOrderServiceInterface;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    public function __construct(CdpOrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @OA\Get(
     *     path="api/lk/order/index",
     *     operationId="orderUserHistory",
     *     tags={"order"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение информации о купленных купонов пользователя",
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
     *                             property="product_id",
     *                             example="1",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="product_count",
     *                             example="100",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="product_duration",
     *                             example="122",
     *                             type="date"
     *                         ),
     *                         @OA\Property(
     *                             property="product_coupon",
     *                             example="201",
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
        $data = $this->orderService->index($request);
        return $this->sendResponse($data, 'Список оформленных подарков' , 200);
    }

    /**
     * @OA\Post(
     *     path="api/lk/order/create",
     *     operationId="createOrder",
     *     tags={"order"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Создание заказа",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="product_id",
     *         description="id подарка",
     *         example="10",
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
     *                             property="order_id",
     *                             type="integer"
     *                         ),
     *                     ),
     *                 ),
     *             )
     *        ),
     *    )
     * )
     */

    public function makeUserOrder(OrderCreateRequest $request)
    {
       return $this->orderService->makeUserOrder($request);
    }

}
