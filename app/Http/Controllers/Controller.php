<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="OpenApi Documentation",
 *      description="Документация для CDP сервиса",
 * ),
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Основной API"
 * )
 * @OA\SecurityScheme(
 *     scheme="Bearer",
 *     securityScheme="Bearer",
 *     name="Authorization",
 *     type="apiKey",
 *     in="header"
 *  )
 *
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
