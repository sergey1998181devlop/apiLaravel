<?php

namespace App\Services;

use App\Enums\BonusTypeEnum;
use App\Http\Requests\API\Lk\Loyal\DrawCreateRequest;
use App\Http\Requests\API\Lk\Loyal\DrawDeleteRequest;
use App\Http\Requests\API\Lk\Loyal\DrawUpdateRequest;
use App\Models\CdpDraw;
use App\Models\CdpDrawMembers;
use App\Models\CdpLoyalBonusLogs;
use App\Models\CdpUserBonusBalance;
use App\Models\CdpUsersOrders;
use App\Services\Contracts\CdpDrawServiceInterface;
use Carbon\Carbon;
use App\Http\Controllers\API\ApiController;
use Illuminate\Support\Facades\DB;


class CdpDrawService implements CdpDrawServiceInterface
{
    public function get($user)
    {
        return CdpDraw::where('mall_id', $user->mall_id)->first();
    }

    public function create(DrawCreateRequest $request)
    {
        //TODO - проверить на работоспособность, возможно, стоит использовать $request->file('big_image')....
        $user = $request->user();
        $hash = sha1(uniqid());
        $filename = sha1(uniqid());
        $bigFile = CdpFileService::storeForCategories($request->big_image, '' ,$hash  , $filename);
        $smallFile = CdpFileService::storeForCategories($request->small_image, '' ,$hash  , $filename);
        $draw = CdpDraw::query()->create(array_merge($request->all(), ['mall_id' => $user->mall_id], ['big_image_link' => 'storage/'.$bigFile->file_name], ['small_image_link' => 'storage/'.$smallFile->file_name]));

        return ApiController::sendResponse($draw, 'Розыгрыш создан', true);
    }

    public function update(DrawUpdateRequest $request)
    {

        try {
            DB::beginTransaction();
            if ($request->big_image) {
                $hash = sha1(uniqid());
                $filename = sha1(uniqid());
                $bigFile = CdpFileService::storeForCategories($request->big_image, '' ,$hash  , $filename);
                $bigImg = 'storage/'.$bigFile->file_name;
            }

            if ($request->small_image) {
                $hash = sha1(uniqid());
                $filename = sha1(uniqid());
                $smallFile = CdpFileService::storeForCategories($request->small_image, '' ,$hash  , $filename);
                $smallImg = 'storage/'.$smallFile->file_name;
            }

            $data = CdpDraw::where('october_id', $request->october_id)->update(array_filter([
                'title' => $request->title ?? null,
                'description' => $request->description ?? null,
                'bonus_price' => $request->bonus_price ?? null,
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
                'big_image_link' => $bigImg ?? null,
                'small_image_link' => $smallImg ?? null,
            ]));
            DB::commit();

            return ApiController::sendResponse(['updated' => $data], 'Данные о розыгрыше обновлены', true);
        } catch (\Exception $exception) {
            DB::rollBack();

            return ApiController::sendError('Ошибка обновления категории', ['status_code' => '501'], 501);
        }
    }

    public function delete(DrawDeleteRequest $request)
    {
        if (CdpDraw::where('october_id', $request->october_id)->delete()) {
            return ApiController::sendResponse(['deleted' => true], 'Розыгрыш удален', true);
        }

        return ApiController::sendError('Ошибка удаления розыгрыша', ['status_code' => '501', 'deleted' => false], 501);
    }


    public function getAllDraws($user)
    {
        return CdpDraw::where('mall_id', $user->mall_id)->where('date_end', '>', Carbon::now())->get();
    }

    public function join($user, $id)
    {
        $balance = CdpUserBonusBalance::where('user_id', $user->id)->first();
        $draw = CdpDraw::find($id);
        if ($draw->date_start < Carbon::now() && $draw->date_end > Carbon::now()) {
            if ($balance->balance > $draw->bonus_price) {
                CdpUserBonusBalance::decrease($user->id, $draw->bonus_price);
                CdpUsersOrders::query()->create([
                    'product_id' => $id,
                    'product_price' => $draw->bonus_price,
                    'user_id' => $user->id,
                    'product_title' => $draw->title,
                    'product_type' => 'draw',
                    'file_link' => $draw->small_image_link,
                    'data_purchase' => Carbon::now()->format('d/m/Y'),
                    'product_coupon' => $draw->title
                ]);
                CdpLoyalBonusLogs::create([
                    'bonus_transaction' => $draw->bonus_price,
                    'bonus_date' => Carbon::now(),
                    'check_id' => NULL,
                    'bonus_type' => BonusTypeEnum::BONUS_TYPE_DECREASE_PRODUCT,
                    'user_id' => $user->id,
                    'bonus_description' => BonusTypeEnum::BONUS_TYPE_DECREASE_PRODUCT_DESCRIPTION,
                ]);
                CdpDrawMembers::create([
                    'user_id' => $user->id,
                    'draw_id' => $draw->id,
                    'mall_id' => $draw->mall_id
                ]);

                return ApiController::sendResponse(['added' => true], 'Регистрация успешна.', true);
            }

            return ApiController::sendError('Недостаточно баллов.', ['status_code' => 401, 'added' => false], 401);
        }

        return ApiController::sendError('Ошибка при регистраци в розыгрыше', ['status_code' => 501, 'added' => false], 501);
    }

    public function getDrawMembers($user, $id)
    {
        return CdpDrawMembers::where('draw_id', $id)->where('mall_id', $user->mall_id)->get();
    }
}
