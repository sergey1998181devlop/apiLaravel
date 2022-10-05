<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\API\Auth\AdminCreateRequest;
use App\Http\Requests\API\Auth\AdminLoginRequest;
use App\Http\Requests\API\Auth\UserRegisterRequest;
use App\Models\CdpUsers;
use App\Models\CdpLoyalChecks;
use App\Services\Contracts\CdpAdminServiceInterface;
use Illuminate\Http\Request;


class AdminController extends ApiController
{
    public function __construct(CdpAdminServiceInterface $cdpAdminService)
    {
        $this->cdpAdminService = $cdpAdminService;
    }

    /**
     * @OA\Post(
     *     path="/api/dashboard/login",
     *     operationId="loginAdmin",
     *     tags={"admin"},
     *     summary="Авторизация админа",
     *     @OA\Parameter(
     *         name="login",
     *         description="Логин администратора",
     *         example="test",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         example="password",
     *         description="Пароль администратора",
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
     *                     @OA\Property(
     *                         property="bearerToken",
     *                         type="string"
     *                     ),
     *                 ),
     *
     *             )
     *         ),
     *     )
     * )
     */

    public function login(AdminLoginRequest $request)
    {
        return $this->cdpAdminService->login($request);
    }
}
