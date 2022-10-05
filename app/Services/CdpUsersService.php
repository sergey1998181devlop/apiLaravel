<?php

namespace App\Services;

use App\Enums\BonusTypeEnum;
use App\Enums\EmailSendTypeEnum;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Http\Requests\API\Auth\UserConfirmRequest;
use App\Http\Requests\API\Auth\UserRegisterRequest;
use App\Http\Requests\API\Auth\UserLoginRequest;
use App\Http\Requests\API\Lk\User\UpdatePhoneRequest;
use App\Http\Requests\API\Lk\User\UserUpdateRequest;
use App\Models\CdpEmailNotes;
use App\Http\Resources\UserProfileResource;
use App\Models\CdpLoyalBonusLogs;
use App\Models\CdpMalls;
use App\Models\CdpUserBonusBalance;
use App\Models\CdpUserOrdersCount;
use App\Models\CdpUsers;
use App\Http\Controllers\API\ApiController as ApiController;
use App\Models\CdpUsersVerificationCodes;
use App\Models\CdpUsersVerificationHashes;
use App\Models\MallsCredentials;
use App\Services\Contracts\CdpSmsSenderServiceInterface;
use App\Services\Contracts\CdpUsersServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class CdpUsersService implements CdpUsersServiceInterface
{

    public function index($token)
    {
        return CdpUsers::index($token);
    }

    public function update(UserUpdateRequest $request)
    {
        $user = $this->index($request->bearerToken());
        $user->update($request->all());

        return ApiController::sendResponse(new UserProfileResource($user), 'Данные о пользователе успешно изменены!', true);
    }

    public function register(UserRegisterRequest $request)
    {
        $user = CdpUsers::where(['phone' => $request->phone, 'mall_id' => $request->mall_id])->first();
        if (!$user) {
            $input = $request->all();
            $user = CdpUsers::create($input);
            CdpUsersVerificationHashes::create($user->id);

            return ApiController::sendResponse(new UserProfileResource($user), 'Вы успешно зарегистрированы', true);
        }

        return ApiController::sendError('Пользователь уже существует', ['status_code' => '409'], 409);
    }

    public function sendVerificationCode(UserLoginRequest $request)
    {
        $data = CdpUsersVerificationCodes::where('phone', $request->phone)->first();
        if (!$data || $data->created_at->lt(Carbon::now()->subSeconds(29))) {
            $credentials = MallsCredentials::where('mall_id', $request->mall_id)->first();
            $code = CdpUsersVerificationCodes::create($request);
            CdpSmsSenderService::send($request->phone, $code, $credentials);

            return ApiController::sendResponse([], 'Введите отправленный Вам верификационный код', true);
        }
        $time = (Carbon::parse($data->created_at)->diffInSeconds(Carbon::now())) - 60;

        return ApiController::sendError('Вы сможете запросить новый смс-код через' . ' ' . $time . ' ' . 'секунд', ['status_code' => '501'], 501);
    }

    public function sendCode(UpdatePhoneRequest $request)
    {
        $user = CdpUsers::where(['phone' => $request->phone, 'mall_id' => $request->mall_id])->first();
        if (!$user) {
            $data = CdpUsersVerificationCodes::where('phone', $request->phone)->first();
            if (!$data || $data->created_at->lt(Carbon::now()->subMinutes(3))) {
                $credentials = MallsCredentials::where('mall_id', $request->mall_id)->first();
                $code = CdpUsersVerificationCodes::create($request);
                CdpSmsSenderService::send($request->phone, $code, $credentials);

                return ApiController::sendResponse([], 'Введите отправленный Вам верификационный код', true);
            }
            $time = (Carbon::parse($data->created_at)->diffInSeconds(Carbon::now())) - 60;

            return ApiController::sendError('Вы сможете запросить новый смс-код через' . ' ' . $time . ' ' . 'секунд', ['status_code' => '501'], 501);
        }

        return ApiController::sendError('Пользователь не существует', ['status_code' => '404'], 404);
    }

    public function confirmPhone(UserConfirmRequest $request)
    {
        $data = CdpUsersVerificationCodes::findCode($request->phone, $request->code);
        if (!$data) {
            return ApiController::sendError('Неверный смс-код.', ['status_code' => '504'], 504);
        }
        if (!$data->created_at->lt(Carbon::now()->subMinutes(1))) {
            $userParent = CdpUsers::where(['phone' => $request->phone, 'mall_id' => $request->mall_id])->first();
            if ($userParent->password) {
                $success['token'] = $userParent->createToken('cdpApiSecretToken', ['user'])->plainTextToken;
                $success['name'] = $userParent->name;
                $userParent->update(['token' => $success['token'], 'last_login' => Carbon::now()]);
                CdpUsersVerificationCodes::destroy($data->id);

                return ApiController::sendResponse($success, 'Вы успешно вошли в аккаунт.', true);
            } else {
                $userParent->update(['is_activated' => 1, 'activated_at' => Carbon::now(), 'password' => sha1(uniqid())]);
                CdpUserBonusBalance::create([
                    'user_id' => $userParent->id,
                    'balance' => 500,
                ]);
                CdpUserOrdersCount::create([
                    'user_id' => $userParent->id,
                    'count_unactivated' => 0,
                    'count_activated' => 0,
                ]);
                CdpLoyalBonusLogs::create([
                    'bonus_transaction' => 500,
                    'bonus_date' => Carbon::now(),
                    'check_id' => NULL,
                    'bonus_type' => BonusTypeEnum::BONUS_TYPE_REGISTER,
                    'user_id' => $userParent->id,
                    'bonus_description' => BonusTypeEnum::BONUS_TYPE_REGISTER_DESCRIPTION,
                    'payment_status' => BonusTypeEnum::BONUS_TYPE_INCREASE_STATUS,
                ]);
                $success['token'] = $userParent->createToken('cdpApiSecretToken', ['user'])->plainTextToken;
                $success['name'] = $userParent->name;
                $userParent->update(['token' => $success['token'], 'last_login' => Carbon::now()]);
                if ($messageId = CdpEmailNotes::where(['mall_id' => $userParent->mall_id, 'send_type' => EmailSendTypeEnum::EMAIL_WELCOME_AFTER_REGISTER])->pluck('message_id')->first()) {
                    CdpEmailSenderService::send($messageId, $userParent->email);
                }
                $appUrl = CdpMalls::where('mall_id', $userParent->mall_id)->pluck('uri')->first();
                $hash = CdpUsersVerificationHashes::where('user_id', $userParent->id)->pluck('hash')->first();
                if ($messageId = CdpEmailNotes::where(['mall_id' => $userParent->mall_id, 'send_type' => EmailSendTypeEnum::EMAIL_REGISTER])->pluck('message_id')->first()) {
                    CdpEmailSenderService::send($messageId, $userParent->email, 'link:' . Config::get('app.url') . '/api/verifyEmail/' . $hash);
                }
                CdpUsersVerificationCodes::destroy($data->id);

                return ApiController::sendResponse($success, 'Вы успешно подтвердили учетную запись и вошли в аккаунт.', true);
            }
        }

        return ApiController::sendError('Срок действия смс-кода прошел', ['status_code' => '501']);
    }

    public function confirmUpdatingPhone(UserConfirmRequest $request)
    {
        $data = CdpUsersVerificationCodes::findCode($request->phone, $request->code);

        if (!$data) {
            return ApiController::sendError('Неверный смс-код.', ['status_code' => '504'], 504);
        }
        if (!$data->created_at->lt(Carbon::now()->subMinutes(1))) {
            $user = CdpUsers::where('token', $request->bearerToken())->update(['phone' => $request->phone]);

            return ApiController::sendResponse(new UserProfileResource($user), 'Смена номера телефона прошла успешно', true);
        }

        return ApiController::sendError('Срок действия смс-кода прошел', ['status_code' => '501']);
    }

    public function confirmEmail($hash)
    {
        $user = CdpUsersVerificationHashes::getUser($hash);
        $appUrl = CdpMalls::where('mall_id' , $user->mall_id)->pluck('uri')->first();
        if ($user) {
            if ($user->email_confirmed) {
                $success['message'] = 'Ваш email уже подтвержден.';
                $success['status'] = false;
                $success['redirect'] = $appUrl . 'lk-login';

                return $success;
            }
            CdpUserBonusBalance::increase($user->id, 50);
            CdpLoyalBonusLogs::create([
                'bonus_transaction' => 50,
                'bonus_date' => Carbon::now(),
                'check_id' => NULL,
                'bonus_type' => BonusTypeEnum::BONUS_TYPE_EMAIL_CONFIRM,
                'user_id' => $user->id,
                'bonus_description' => BonusTypeEnum::BONUS_TYPE_EMAIL_CONFIRM_DESCRIPTION,
                'payment_status'    =>  BonusTypeEnum::BONUS_TYPE_INCREASE_STATUS,
            ]);
            $user->update(['email_confirmed' => 1]);
            if ($messageId = CdpEmailNotes::where(['mall_id' => $user->mall_id, 'send_type' => EmailSendTypeEnum::EMAIL_AFTER_REGISTER])->pluck('message_id')->first()) {
                CdpEmailSenderService::send($messageId, $user->email);
            }
            $success['message'] = 'Ваш email успешно подтвержден.';
            $success['status'] = true;
            $success['redirect'] = $appUrl . 'lk-login';

            return $success;
        }

        $success['message'] = 'Ошибка подтверждения email.';
        $success['status'] = false;
        $success['redirect'] = $appUrl . 'lk-login';

        return $success;
    }
}
