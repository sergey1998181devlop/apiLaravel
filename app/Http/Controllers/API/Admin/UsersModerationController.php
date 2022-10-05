<?php

namespace App\Http\Controllers\API\Admin;

use App\Enums\BonusTypeEnum;
use App\Http\Controllers\API\ApiController as ApiController;
use App\Models\CdpLoyalBonusLogs;
use App\Models\CdpMalls;
use App\Models\CdpUserBonusBalance;
use App\Models\CdpUsers;
use App\Models\CdpUsersOrders;
use App\Services\Contracts\CdpUserModerationServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersModerationController extends ApiController
{
    public function __construct(CdpUserModerationServiceInterface $cdpUserModerationService)
    {
        $this->cdpUserModerationService = $cdpUserModerationService;
    }

    /**
     * @OA\Post(
     *     path="api/admin/users/getMalls",
     *     operationId="AdminGetMalls",
     *     tags={"admin"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение списка ТРЦ",
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
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="mall_id",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="uri",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="timestamp"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="timestamp"
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */
    public function getMalls()
    {
        $data = CdpMalls::query()->get();

        return $this->sendResponse($data, 'Список успешно получен', true);
    }


    /**
     * @OA\Post(
     *     path="api/admin/users/getUsersByMall",
     *     operationId="AdminUsersByMall",
     *     tags={"admin"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение пользователей по ТРЦ с фильтрами",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="mall_id",
     *         description="id ТРЦ",
     *         example="1",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="filter",
     *         description="Фильтр для поиска информации",
     *         example="new_users/old_users/login_new/login_old/all",
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
     *                             property="name",
     *                             example="Maxim",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="surname",
     *                             example="Sukachev",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="phone",
     *                             example="89853429512",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="email",
     *                             example="solvintech@mail.ru",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="sex",
     *                             example="male,female",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="mall_id",
     *                             example="3",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="date"
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="date"
     *                         ),
     *                     )
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function getUsersByMall(Request $request)
    {
        $user = CdpUsers::index($request->bearerToken());
        $data = $this->cdpUserModerationService->filterUsersByMall($request->filter,$request->mall_id , $user);
        return $this->sendResponse($data, 'Данные о пользователях.' , 200);
    }

    /**
     * @OA\Post(
     *     path="api/admin/users/getUsers",
     *     operationId="moderateUser",
     *     tags={"admin"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Получение cписка пользователей по фильтрам",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="filter",
     *         description="Фильтр для поиска информации",
     *         example="new_users/old_users/login_new/login_old/all",
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
     *                             property="name",
     *                             example="Maxim",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="surname",
     *                             example="Sukachev",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="phone",
     *                             example="89853429512",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="email",
     *                             example="solvintech@mail.ru",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="sex",
     *                             example="male,female",
     *                             type="string"
     *                         ),
     *                         @OA\Property(
     *                             property="mall_id",
     *                             example="3",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="date"
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="date"
     *                         ),
     *                     )
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function getUsers(Request $request)
    {
        $user = CdpUsers::index($request->bearerToken());
        $data = $this->cdpUserModerationService->filterUsers($request->filter , $user);
        return $this->sendResponse($data, 'Данные о пользователях.' , 200);
    }

    /**
     * @OA\Post(
     *     path="api/admin/users/addBonuses",
     *     operationId="AdminAddBonusesUser",
     *     tags={"admin"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Начисление бонусов администратором",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="user_id",
     *         description="id пользователя",
     *         example="3",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="bonuses",
     *         description="Количество начисляемых бонусов",
     *         example="1000",
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
     *                             example="3",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="user_id",
     *                             example="1",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="balance",
     *                             example="55",
     *                             type="integer"
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="date"
     *                         ),
     *                         @OA\Property(
     *                             property="updated_at",
     *                             type="date"
     *                         ),
     *                     )
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function addBonuses(Request $request)
    {
        $data = CdpUserBonusBalance::increase($request->user_id , $request->bonuses);
        CdpLoyalBonusLogs::create([
            'bonus_transaction' => $request->bonuses,
            'bonus_date' => Carbon::now(),
            'check_id' => NULL,
            'bonus_type' => BonusTypeEnum::BONUS_TYPE_ADMIN,
            'user_id' => $request->user_id,
            'bonus_description' => $request->comment ?? BonusTypeEnum::BONUS_TYPE_ADMIN_DESCRIPTION,
        ]);
        return $this->sendResponse($data, 'Баланс пользователя'.' '.$request->id , 200);
    }

    /**
     * @OA\Post(
     *     path="api/admin/users/updateUser",
     *     operationId="AdminUpdateUser",
     *     tags={"admin"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Обновление информации о пользователе",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="id",
     *         description="id пользователя",
     *         example="3",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         description="Номер телефона пользователя",
     *         example="9853429732",
     *         required=false,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         description="Имя пользователя",
     *         example="Maxim",
     *         required=false,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="surname",
     *         description="Фамилия пользователя",
     *         example="Naberezhniy",
     *         required=false,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sex",
     *         description="Пол пользователя",
     *         example="male,female",
     *         required=false,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         description="email пользователя",
     *         example="solvintech@mail.ru",
     *         required=false,
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
     *                         property="updated",
     *                         type="bool"
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function updateUser(Request $request)
    {
        $admin = $request->user();
        $user = CdpUsers::where('mall_id' , $admin['mall_id'])->where('id' , $request->id)->update($request->all());
        return $this->sendResponse(['updated' => $user], 'Данные о пользователе обновлены.' , 200);
    }


    /**
     * @OA\Post(
     *     path="api/admin/users/getUserHistory",
     *     operationId="getUserHistory",
     *     tags={"admin"},
     *     security={
     *          {"Bearer": {}}
     *     },
     *     summary="Обновление информации о пользователе",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="user_id",
     *         description="id пользователя",
     *         example="3",
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
     *                             property="product_title",
     *                             example="201",
     *                             type="string"
     *                         ),
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function getUserHistory(Request $request)
    {
        $data = CdpUsersOrders::where('user_id', $request->user_id)->get();

        return ApiController::sendResponse($data, 'Товары успешно получены' , 200);
    }
}
