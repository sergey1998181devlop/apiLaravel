<?php

namespace App\Http\Controllers\API\Lk;

use App\Http\Controllers\API\ApiController as ApiController;
use App\Http\Requests\API\Auth\UserConfirmRequest;
use App\Http\Requests\API\Auth\UserLoginRequest;
use App\Http\Requests\API\Lk\User\UpdatePhoneRequest;
use App\Http\Requests\API\Lk\User\UserUpdateRequest;
use App\Http\Resources\UserProfileResource;
use App\Models\CdpUserBonusBalance;
use App\Models\CdpUserOrdersCount;
use App\Models\CdpUsers;
use App\Services\Contracts\CdpUsersServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class LkController extends ApiController
{
    public function __construct(CdpUsersServiceInterface $CdpUsersService)
    {
        $this->CdpUsersService = $CdpUsersService;
    }

    public function migrate(Request $request)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($request->file); // тут наш файл с таблицей Excel
        $worksheet = $spreadsheet->setActiveSheetIndex(0);
        $highestRow = $worksheet->getHighestRow();
        $highestCol = $worksheet->getHighestColumn();
        $infoByTableReviews = $worksheet->rangeToArray("A1:$highestCol$highestRow", null, true, false, false);
        $count = 0;
        try {
            foreach ($infoByTableReviews as $item) {
                $count++;
                if ($count >= 2) {
                    $hash = sha1(uniqid());
                    if (is_integer($item['20'])) {
                        $phone = $item['20'];
                        $phone = substr($phone, 1);
                        $userParent = CdpUsers::query()->create([
                            'name' => $item['51'] ?? ' ',
                            'surname' => $item['50'] ?? ' ',
                            'phone' => $phone,
                            'email' => $item['22'],
                            'sex' => 'none',
                            'mall_id' => 21,
                            'birthdate' => $item['19'],
                            'password' => $hash,
                            'is_activated' => 1,
                            'email_confirmed' => 1,
                        ]);
                        $balance = htmlentities($item['0']);
                        $balance = str_replace("&nbsp;", '', $balance);
                        CdpUserBonusBalance::create([
                            'user_id' => $userParent->id,
                            'balance' => $balance,
                        ]);
                        CdpUserOrdersCount::create([
                            'user_id' => $userParent->id,
                            'count_unactivated' => 0,
                            'count_activated' => 0,
                        ]);
                    }
                }
            }
        }catch (\Exception $exception)
        {
            dd($item);
        }

    }

    public function getImage($hash)
    {

        $path = storage_path('storage/' . $hash);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * @OA\Get(
     *     path="api/lk/user/show",
     *     operationId="indexUser",
     *     tags={"user"},
     *     summary="Получение информации о пользователе",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="bearer",
     *         description="bearer-токен пользователя",
     *         example="26|4234fsDSFLENLRKS23",
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
     *                         property="id",
     *                         example="3",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         example="Maxim",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="surname",
     *                         example="Sukachev",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="phone",
     *                         example="89853429512",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         example="solvintech@mail.ru",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="sex",
     *                         example="male,female",
     *                         type="string"
     *                     ),
     *                     @OA\Property(
     *                         property="mall_id",
     *                         example="3",
     *                         type="integer"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="date"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="date"
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function index(Request $request) {
        $history = $this->CdpUsersService->index($request->bearerToken());
        return $this->sendResponse(new UserProfileResource($history), 'Данные о пользователе успешно получены!' , 200);
    }

    /**
     * @OA\Post(
     *     path="api/lk/user/update",
     *     operationId="updateUser",
     *     tags={"user"},
     *     summary="Обновление информации о пользователе",
     *     description="Защищено bearer-токеном",
     *     @OA\Parameter(
     *         name="bearer",
     *         description="bearer-токен пользователя",
     *         example="3|FDSLK43lknsfd",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         description="Номер телефона пользователя",
     *         example="9853429732",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         description="Имя пользователя",
     *         example="Maxim",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="surname",
     *         description="Фамилия пользователя",
     *         example="Naberezhniy",
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sex",
     *         description="Пол пользователя",
     *         example="male,female",
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         description="email пользователя",
     *         example="solvintech@mail.ru",
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

    public function update(UserUpdateRequest $request)
    {
        return $this->CdpUsersService->update($request);
    }

    public function verify(UserLoginRequest $request) {
        try {
            return $this->CdpUsersService->sendVerificationCode($request);
        } catch (\Exception $exception) {
            return $this->sendError('Некорректный токен.', ['status_code' => '404']);
        }
    }

    /**
     * @OA\Post(
     *     path="api/confirm",
     *     operationId="confirmRegisterPhone",
     *     tags={"auth"},
     *     summary="Верификация смс и подтверждения номера телефона",
     *     description="Отправка смс-кода",
     *     @OA\Parameter(
     *         name="phone",
     *         description="Номер телефона пользователя",
     *         example="89853429353",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="mall_id",
     *         description="id ТРЦ",
     *         example="3",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         description="Смс-код",
     *         example="3231",
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

    public function confirm(UserConfirmRequest $request) {
        return $this->CdpUsersService->confirmPhone($request);
    }

    /**
     * @OA\Post(
     *     path="api/lk/user/verify",
     *     operationId="verifyPhone",
     *     tags={"user"},
     *     summary="Отправка смс-кода на подтверждение нового номера телефона",
     *     description="Отправка смс-кода",
     *     @OA\Parameter(
     *         name="bearer",
     *         description="bearer-токен пользователя",
     *         example="3|423KFDS34dfs3",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         description="Новый телефона пользователя",
     *         example="8934252324",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="mall_id",
     *         description="id ТРЦ",
     *         example="3",
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

    public function send(UpdatePhoneRequest $request) {
        try {
            return $this->CdpUsersService->sendCode($request);
        } catch (\Exception $exception) {
            return $this->sendError('Некорректный токен.', ['status_code' => '404']);
        }
    }

    /**
     * @OA\Post(
     *     path="api/lk/user/confirmPhone",
     *     operationId="confirmPhone",
     *     tags={"user"},
     *     summary="Верификация смс и смена номера телефона",
     *     description="Отправка смс-кода",
     *     @OA\Parameter(
     *         name="bearer",
     *         description="bearer-токен пользователя",
     *         example="3|GFD4F45SG",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         description="Новый номер телефона пользователя",
     *         example="9428343212",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *    ),
     *    @OA\Parameter(
     *        name="mall_id",
     *        description="id ТРЦ",
     *        example="3",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *            type="string"
     *        )
     *    ),
     *    @OA\Parameter(
     *        name="code",
     *        description="Смс-код",
     *        example="3214",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *            type="string"
     *        )
     *    ),
     *    @OA\Response(
     *        response="200",
     *        description="OK",
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                type="array",
     *                @OA\Items(
     *                    type="object",
     *                    @OA\Property(
     *                        property="success",
     *                        type="bool"
     *                    ),
     *                ),
     *            )
     *        ),
     *    )
     * )
     */

    public function confirmUpdating(UserConfirmRequest $request) {
        return $this->CdpUsersService->confirmUpdatingPhone($request);
    }

    public function confirmEmail($hash)
    {
        $success = $this->CdpUsersService->confirmEmail($hash);

        return Redirect::to($success['redirect']);
    }
}
