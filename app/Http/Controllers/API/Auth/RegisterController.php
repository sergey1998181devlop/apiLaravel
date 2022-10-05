<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\ApiController as ApiController;
use App\Http\Requests\API\Auth\UserLoginRequest;
use App\Http\Requests\API\Auth\UserRegisterRequest;
use App\Models\CdpUsers;
use App\Services\Contracts\CdpUsersServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends ApiController
{

    public function __construct(CdpUsersServiceInterface $CdpUsersService)
    {
        $this->CdpUsersService = $CdpUsersService;
    }


    /**
     * @OA\Post(
     *     path="api/register",
     *     operationId="registerUser",
     *     tags={"auth"},
     *     summary="Регистрация пользователя",
     *     @OA\Parameter(
     *         name="mall_id",
     *         description="id ТРЦ",
     *         required=true,
     *         example="3",
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         description="Номер телефона пользователя",
     *         required=true,
     *         example="89853429241",
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         description="Имя пользователя",
     *         required=true,
     *         example="Вячеслав",
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="surname",
     *         description="Фамилия пользователя",
     *         example="Погольша",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="sex",
     *         description="Пол пользователя",
     *         example="male,female",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="birthdate",
     *         description="День рождения пользователя",
     *         example="04/05/2002",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         description="Email пользователя",
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

    public function register(UserRegisterRequest $request)
    {
        return $this->CdpUsersService->register($request);
    }

    /**
     * @OA\Post(
     *     path="api/login",
     *     operationId="loginUser",
     *     tags={"auth"},
     *     summary="Авторизация пользователя",
     *     @OA\Parameter(
     *         name="mall_id",
     *         description="id ТРЦ",
     *         example="3",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         example="89853429321",
     *         description="Номер телефона пользователя",
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
     *                         property="success",
     *                         type="bool"
     *                     ),
     *                     @OA\Property(
     *                         property="bearerToken",
     *                         type="string"
     *                     ),
     *                 ),
     *             )
     *         ),
     *     )
     * )
     */

    public function login(UserLoginRequest $request)
    {
        if (!CdpUsers::where('phone', $request->phone)->where('mall_id', $request->mall_id)->exists()) {
            return $this->sendError('Пользователь не найден.', ['status_code' => '404']);
        }
        try {
            return $this->CdpUsersService->sendVerificationCode($request);
        } catch (\Exception $exception) {
            return $this->sendError('Ошибка сервиса авторизации.', ['status_code' => '404']);
        }
    }

    /**
     * @OA\Post(
     *     path="api/verify",
     *     operationId="registerVerifyPhone",
     *     tags={"auth"},
     *     summary="Отправка смс-кода для подтверждения телефона",
     *     description="Отправка смс-кода",
     *     @OA\Parameter(
     *         name="phone",
     *         description="Номер телефона пользователя",
     *         example="89853429213",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="mall_id",
     *         description="id ТРЦ пользователя",
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

    public function verify(UserLoginRequest $request)
    {
        if (!CdpUsers::where('phone', $request->phone)->where('mall_id', $request->mall_id)->exists()) {
            return ApiController::sendError('Пользователь не найден.', ['status_code' => '404'], 404);
        }
        try {
            return $this->CdpUsersService->sendVerificationCode($request);
        } catch (\Exception $exception) {
            return $this->sendError('Ошибка сервиса авторизации.', ['status_code' => '404']);
        }
    }
}
