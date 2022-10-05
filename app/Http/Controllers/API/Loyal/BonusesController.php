<?php

namespace App\Http\Controllers\API\Loyal;

use App\Http\Controllers\API\ApiController as ApiController;
use App\Http\Controllers\API\Lk\LkController;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Resources\BonusesResource;
use App\Models\CdpUserBonusBalance;
use App\Models\CdpUsers;
use App\Services\Contracts\CdpBonusesServiceInterface;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class BonusesController extends ApiController
{
    public function __construct(CdpBonusesServiceInterface $cdpBonusesService)
    {
       $this->CdpBonusesService = $cdpBonusesService;
    }

    /**
     * @OA\Get(
     *       path="api/lk/bonuses/history",
     *      operationId="bonusesUserHistory",
     *      tags={"bonuses"},
     *      summary="Получение бонусных транзакций пользователя",
     *      description="Защищено bearer-токеном",
     *         @OA\Parameter(
     *          name="bearer",
     *          description="bearer-токен пользователя",
     *          example="3|rePJ34DDFgds",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *   @OA\Response(response="200",
     *      description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *             @OA\Items(
     *                type="object",
     *                 @OA\Property(
     *                     property="id",
     *                      example="3",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="bonus_transaction",
     *                      example="+30",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="bonus_date",
     *                      example="30.05.2001",
     *                     type="date"
     *                ),
     *                 @OA\Property(
     *                     property="bonus_id",
     *                      example="3",
     *                     type="integer"
     *                ),
     *                 @OA\Property(
     *                     property="bonus_type",
     *                      example="3",
     *                     type="integer"
     *                ),
     *                 @OA\Property(
     *                     property="user_id",
     *                      example="3",
     *                     type="integer"
     *                ),
     *            ),
     *
     *             )
     *         ),
     *   )
     * )
     */

    public function userHistory(Request $request)
    {
        $checks = $this->CdpBonusesService->index($request->bearerToken());
        return $this->sendResponse($checks, 'Данные о пользователе успешно получены' , 200);
    }

    /**
     * @OA\Get(
     *       path="api/lk/bonuses/balance",
     *      operationId="bonusesUserBalance",
     *      tags={"bonuses"},
     *      summary="Получение баланса пользователя",
     *      description="Защищено bearer-токеном",
     *         @OA\Parameter(
     *          name="bearer",
     *          description="bearer-токен пользователя",
     *          example="3|rePJ34DDFgds",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *   @OA\Response(response="200",
     *      description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *             @OA\Items(
     *                type="object",
     *                 @OA\Property(
     *                     property="id",
     *                      example="3",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                      example="30",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="balance",
     *                      example="3000",
     *                     type="integer"
     *                ),
     *            ),
     *
     *             )
     *         ),
     *   )
     * )
     */

    public function userBalance(Request $request)
    {
        $user_id = CdpUsers::index($request->bearerToken());
        $balance = CdpUserBonusBalance::index($user_id->id);
        return $this->sendResponse($balance, 'Данные о балансе пользователя успешно получены' , 200);
    }
}
