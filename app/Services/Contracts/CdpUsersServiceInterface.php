<?php

namespace App\Services\Contracts;

use App\Http\Requests\API\Auth\UserConfirmRequest;
use App\Http\Requests\API\Auth\UserRegisterRequest;
use App\Http\Requests\API\Auth\UserLoginRequest;
use App\Http\Requests\API\Lk\User\UpdatePhoneRequest;
use App\Http\Requests\API\Lk\User\UserUpdateRequest;
use Illuminate\Http\Request;

interface CdpUsersServiceInterface
{
    public function register(UserRegisterRequest $request);

    public function index($token);

    public function update(UserUpdateRequest $request);

    public function confirmPhone(UserConfirmRequest $request);

    public function sendVerificationCode(UserLoginRequest $request);

    public function sendCode(UpdatePhoneRequest $request);

    public function confirmUpdatingPhone(UserConfirmRequest $request);

    public function confirmEmail($hash);
}
