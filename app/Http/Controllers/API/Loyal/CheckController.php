<?php

namespace App\Http\Controllers\API\Loyal;

use App\Http\Controllers\API\ApiController as ApiController;
use App\Http\Requests\API\Lk\Loyal\LoyalCheckUploadRequest;
use App\Http\Resources\CheckesResource;
use App\Services\Contracts\CdpCheckesServiceInterface;
use Illuminate\Http\Request;

class CheckController extends ApiController
{
    public function __construct(CdpCheckesServiceInterface $CdpCheckesService)
    {
        $this->CdpCheckesService = $CdpCheckesService;
    }

     /**
     * @OA\Get(
     *       path="api/lk/checks/show",
     *      operationId="index",
     *      tags={"checks"},
     *      summary="Получение списка чеков пользователя",
      *     @OA\Parameter(
      *          name="bearer",
      *          description="bearer-токен пользователя",
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
      *                     example="3",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
      *                     example="3",
     *                     type="integer"
     *                 ),
      *                @OA\Property(
      *                     property="mall_id",
      *                     example="3",
      *                     type="integer"
      *                 ),
      *               @OA\Property(
      *                     property="bonus_id",
      *                     example="3",
      *                     type="integer"
      *                ),
      *               @OA\Property(
      *                     property="created_at",
      *                     type="date"
      *                 ),
      *               @OA\Property(
      *                     property="updated_at",
      *                     type="date"
      *                 ),
     *            ),
     *
     *             )
     *         ),
     *   )
     * )
     */

    public function index(Request $request) {
        $checks = $this->CdpCheckesService->index($request->bearerToken());
        return $this->sendResponse($checks , 'Данные примененных чеков пользователя' , 200);
    }

    /**
     * @OA\Post(
     *       path="api/lk/checks/upload",
     *      operationId="upload",
     *      tags={"checks"},
     *      summary="Загрузка чека",
     *        @OA\Parameter(
     *          name="bearer",
     *          description="bearer-токен пользователя",
     *          example="3|KFDL34df3wg",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *          @OA\Parameter(
     *          name="file",
     *          description="Фотография чека",
     *          example="jpg/jpeg/png",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="image"
     *          )
     *      ),
     *   @OA\Response(response="200",
     *      description="OK",
     *   )
     * )
     */

    public function upload(LoyalCheckUploadRequest $request)
    {
        $checks = $this->CdpCheckesService->upload($request , $request->bearerToken());
        return $this->sendResponse($checks, 'Чек успешно загружен' , 200);
    }
}
