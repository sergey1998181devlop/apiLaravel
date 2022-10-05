<?php

namespace App\Http\Controllers\API\Loyal;

use App\Http\Controllers\API\ApiController as ApiController;
use App\Http\Requests\API\Lk\Loyal\DrawCreateRequest;
use App\Http\Requests\API\Lk\Loyal\DrawDeleteRequest;
use App\Http\Requests\API\Lk\Loyal\DrawUpdateRequest;
use App\Models\CdpDraw;
use App\Services\CdpFileService;
use App\Services\Contracts\CdpDrawServiceInterface;
use Illuminate\Http\Request;

class DrawController extends ApiController
{
    public function __construct(CdpDrawServiceInterface $cdpDrawService)
    {
        $this->cdpDrawService = $cdpDrawService;
    }

    /**
     * @OA\Post(
     *     path="api/lk/draw/index",
     *     operationId="getDraw",
     *     tags={"draw"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение информации о текущем розыгрыше",
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
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         example="3",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         example="Розыгрыш наушников",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         example="Две пары наушников",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="bonus_price",
     *                         example="3000",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="date_start",
     *                         example="07/02/2002",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="date_end",
     *                         example="07/02/2022",
     *                         type="string"
     *                     ),
     *                 ),
     *             )
     *        ),
     *    )
     * )
     */

    public function get(Request $request)
    {
        $user = $request->user();
        $data = $this->cdpDrawService->get($user);
        return $this->sendResponse($data, 'Данные о текущем розыгрыше получены', true);
    }


    /**
     * @OA\Get(
     *     path="api/lk/draw/listDraws",
     *     operationId="allDraws",
     *     tags={"draw"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение списка розыгрышей",
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
     *                             example="3",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="title",
     *                             example="Розыгрыш наушников",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="description",
     *                             example="Две пары наушников",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="bonus_price",
     *                             example="3000",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="date_start",
     *                             example="07/02/2002",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="date_end",
     *                             example="07/02/2022",
     *                             type="string"
     *                         ),
     *                     ),
     *                 ),
     *             )
     *        ),
     *    )
     * )
     */

    public function getAll(Request $request)
    {
        $user = $request->user();
        $data = $this->cdpDrawService->getAllDraws($user);
        if (!empty($data)) {
            return $this->sendResponse($data, 'Данные о розыгрышах успешно получены', 200);
        }

        return $this->sendResponse($data, 'Розыгрыши отсуствуют', 200);
    }


    /**
     * @OA\Post(
     *     path="api/lk/draw/join",
     *     operationId="joinToDraw",
     *     tags={"draw"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         description="id розыгрыша",
     *         example="103",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     summary="Зарегистрироваться в розыгрыше",
     *     description="Защищено bearer-токеном",
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
     *                                 property="added",
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

    public function joinToDraw(DrawDeleteRequest $request)
    {
        //TODO DrawDeleteRequest - временное решение, можно добавить новый Request
        $user = $request->user();
        $data = $this->cdpDrawService->join($user, $request->id);

        return $this->sendResponse($data, '', 200);
    }

    /**
     * @OA\Post(
     *     path="api/admin/draw/create",
     *     operationId="createDraw",
     *     tags={"draw"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Создание розыгрыша",
     *     description="Защищено bearer-токеном",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Большая фотография - png/jpg/jpeg",
     *                     property="big_image",
     *                     type="file",
     *                 ),
     *                 @OA\Property(
     *                     description="Маленькая фотография - png/jpg/jpeg",
     *                     property="small_image",
     *                     type="file",
     *                 ),
     *                 required={"big_image", "small_image"}
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         description="Заголовок",
     *         example="Розыгрыш пива",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         description="Описание",
     *         example="Розыгрыш азотного пива",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="bonus_price",
     *         description="Количество списываемых бонусов для участия",
     *         example="3000",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="data_start",
     *         description="Дата начала",
     *         example="07/02/2022",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="data_end",
     *         description="Дата окончания",
     *         example="07/02/2022",
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
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="mall_id",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="bonus_price",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="big_image_link",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="small_image_link",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="date_start",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="date_end",
     *                         type="string"
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */


    public function create(DrawCreateRequest $request)
    {
        return $this->cdpDrawService->create($request);
    }

    /**
     * @OA\Post(
     *     path="api/admin/draw/update",
     *     operationId="updateDraw",
     *     tags={"draw"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Обновить условия и описание розыгрыша",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="title",
     *         description="Заголовок",
     *         example="Ежегодный розыгрыш",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         description="Описание",
     *         example="Розыгрыш наушников",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="bonus_price",
     *         description="Количество списываемых бонусов для участия",
     *         example="3000",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="data_start",
     *         description="Дата начала",
     *         example="",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="data_end",
     *         description="Дата окончания",
     *         example="",
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
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="success",
     *                         type="bool"
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function update(DrawUpdateRequest $request)
    {
        return $this->cdpDrawService->update($request);
    }

    /**
     * @OA\Post(
     *     path="api/admin/draw/delete",
     *     operationId="deleteDraw",
     *     tags={"draw"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Удалить розыгрыш",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="id",
     *         description="id розыгрыша",
     *         example="103",
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


    public function delete(DrawDeleteRequest $request)
    {
        return $this->cdpDrawService->delete($request);
    }

    /**
     * @OA\Get(
     *     path="api/admin/draw/finish",
     *     operationId="finishDraw",
     *     tags={"draw"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         description="id розыгрыша",
     *         example="103",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     summary="Получение информации о количестве участников",
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
     *                             property="user_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="draw_id",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="mall_id",
     *                             type="integer"
     *                         ),
     *                     ),
     *                 ),
     *             )
     *        ),
     *    )
     * )
     */

    public function getDrawMembers(DrawDeleteRequest $request)
    {
        //TODO DrawDeleteRequest - временное решение, можно добавить новый Request
        $user = $request->user();
        $data = $this->cdpDrawService->getDrawMembers($user, $request->id);

        return $this->sendResponse($data, 'Данные об участниках успешно получены', true);
    }

}
