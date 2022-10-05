<?php

namespace App\Http\Controllers\API\Admin;

use App\Enums\BonusTypeEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\API\Lk\Loyal\ConfirmCheckRequest;
use App\Models\CdpLoyalBonusLogs;
use App\Models\CdpLoyalChecks;
use App\Models\CdpUserBonusBalance;
use App\Models\CdpUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChecksModerationController extends ApiController
{

    /**
     * @OA\Get(
     *     path="api/admin/checks/getChecks",
     *     operationId="getChecks",
     *     tags={"admin"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение чеков для модерации",
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
     *                             property="user_id",
     *                             example="22",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             example="test",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="surname",
     *                             example="test",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="email",
     *                             example="test@test.com",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="phone",
     *                             example="9991231234",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="mall_id",
     *                             example="32",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="status",
     *                             example="pending",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="file_link",
     *                             example="https://test.com/img.png",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="date"
     *                         ),
     *                     ),
     *                 ),
     *             )
     *        ),
     *    )
     * )
     */

    public function get(Request $request)
    {
        $data = DB::table('cdp_loyal_checks')->where('status', 'neutral')
            ->join('cdp_users', 'cdp_users.id', '=', 'cdp_loyal_checks.user_id')
            ->select('cdp_loyal_checks.user_id', 'cdp_loyal_checks.status', 'cdp_loyal_checks.file_link', 'cdp_loyal_checks.id', 'cdp_loyal_checks.created_at', 'cdp_users.name', 'cdp_users.surname', 'cdp_users.email', 'cdp_users.phone', 'cdp_users.mall_id')->get();

        return $this->sendResponse($data, 'Данные о чеках успешно получены.', 200);
    }


    /**
     * @OA\Post(
     *     path="api/admin/checks/getFilteredChecks",
     *     operationId="getFilteredChecks",
     *     tags={"admin"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение чеков для модерации по статусу",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="status",
     *         description="Статус чека",
     *         example="test",
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
     *                         @OA\Property(
     *                             property="id",
     *                             example="3",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="user_id",
     *                             example="22",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             example="test",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="surname",
     *                             example="test",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="email",
     *                             example="test@test.com",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="phone",
     *                             example="9991231234",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="mall_id",
     *                             example="32",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="status",
     *                             example="pending",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="file_link",
     *                             example="https://test.com/img.png",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="date"
     *                         ),
     *                     ),
     *                 ),
     *             )
     *         )
     *     )
     * )
     */
    public function getFilteredChecks(Request $request)
    {
        $data = DB::table('cdp_loyal_checks')->where('status', $request->status)
            ->join('cdp_users', 'cdp_users.id', '=', 'cdp_loyal_checks.user_id')
            ->select('cdp_loyal_checks.user_id', 'cdp_loyal_checks.status', 'cdp_loyal_checks.file_link', 'cdp_loyal_checks.id', 'cdp_loyal_checks.created_at', 'cdp_users.name', 'cdp_users.surname', 'cdp_users.email', 'cdp_users.phone', 'cdp_users.mall_id')->get();
        return $this->sendResponse($data, 'Данные о чеках успешно получены.', 200);
    }

    /**
     * @OA\Post(
     *     path="api/admin/checks/confirmCheck",
     *     operationId="confirmCheck",
     *     tags={"admin"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Подтверждение чека",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="check_id",
     *         description="Идентификатор чека",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         description="Статус чека",
     *         example="confirmed/declined",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="check_sum",
     *         description="Количество начисляемых бонусов",
     *         example="300",
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
     *                         property="id",
     *                         example="3",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         example="22",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         example="test",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="surname",
     *                         example="test",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         example="test@test.com",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="phone",
     *                         example="9991231234",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="mall_id",
     *                         example="32",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="status",
     *                         example="pending",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="file_link",
     *                         example="https://test.com/img.png",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="date"
     *                     ),
     *                 ),
     *             )
     *         )
     *     )
     * )
     */

    public function confirm(ConfirmCheckRequest $request)
    {
        $data = CdpLoyalChecks::where('id', $request->check_id)->first();
        CdpUserBonusBalance::where('user_id', $data->user_id)->increment('balance', $data->bonus_sum);
        CdpLoyalBonusLogs::create([
            'bonus_transaction' => $data->bonus_sum,
            'bonus_date' => Carbon::now(),
            'check_id' => $data->id,
            'bonus_type' => BonusTypeEnum::BONUS_TYPE_ADMIN,
            'user_id' => $data->user_id,
            'bonus_description' => BonusTypeEnum::BONUS_TYPE_ADMIN_DESCRIPTION,
        ]);
        CdpLoyalChecks::where('id', $request->check_id)->update([
            'status' => $request->status,
            'check_sum' => $request->check_sum,
            'bonus_sum' => $request->bonus_sum,
        ]);

        return $this->sendResponse($data, 'Данные о чеке успешно изменены.', 200);
    }
}
