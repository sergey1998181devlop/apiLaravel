<?php

namespace App\Services;

use App\Enums\BonusTypeEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\API\Lk\Loyal\OrderCreateRequest;
use App\Models\CdpLoyalBonusLogs;
use App\Models\CdpProducts;
use App\Models\CdpUserBonusBalance;
use App\Models\CdpUserOrdersCount;
use App\Models\CdpUsers;
use App\Models\CdpUsersOrders;
use App\Services\Contracts\CdpOrderServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CdpOrderService implements CdpOrderServiceInterface
{
    private function userPay($user , $amount)
    {
        return CdpUserBonusBalance::decrease($user, $amount->price);
    }

    public function makeUserOrder(OrderCreateRequest $request)
    {
        $user = $request->user();
        $amount = CdpProducts::index($request->product_id);
        $balance = $this->userPay($user->id , $amount);
        if ($balance){
            $order  = $this->setOrder($user->id, $amount);
            (new QrCodeService)->generate($order);

            return ApiController::sendResponse(['order_id' => $order], 'Заказ обработан', true);
        }

        return ApiController::sendError('Недостаточно бонусов.', ['status_code' => 401] , 401);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        return CdpUsersOrders::index($user->user_id);
    }

    public function setOrder($user_id, $amount)
    {
        $order = CdpUsersOrders::create($user_id, $amount , 'product');
        CdpUserOrdersCount::where('user_id' , $user_id)->increment('count_unactivated' , 1);

        return $order->id;
    }
}
