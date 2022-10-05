<?php

namespace App\Services;

use App\Http\Controllers\API\ApiController as ApiController;
use App\Http\Requests\API\Auth\AdminLoginRequest;
use App\Models\CdpAdmins;
use App\Models\CdpUsers;
use App\Services\Contracts\CdpAdminServiceInterface;

class CdpAdminService implements CdpAdminServiceInterface
{
    public function login(AdminLoginRequest $request)
    {
        $admin = CdpAdmins::where('login' , $request->login)->where('password' , $request->password)->first();
        if ($admin) {
            $userParent = CdpUsers::where('id', $admin->user_id)->first();
            if ($userParent) {
                $success['token'] = $userParent->createToken('cdpApiSecretToken' , ['superadmin'])->plainTextToken;
                $userParent->update(['token' => $success['token']]);

                return ApiController::sendResponse($success, 'Вы успешно вошли.', true);
            }

            return ApiController::sendError('Пользователя нет в системе', ['status_code' => '404'], 404);
        }

        return ApiController::sendError('Ошибка авторизации', ['status_code' => '403'], 403);
    }
}
