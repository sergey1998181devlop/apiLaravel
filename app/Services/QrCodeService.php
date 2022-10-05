<?php

namespace App\Services;

use App\Http\Controllers\API\ApiController;
use App\Models\CdpQrCodes;
use App\Models\CdpUserOrdersCount;
use App\Models\CdpUsers;
use App\Models\CdpUsersOrders;
use App\Services\Contracts\QrCodeServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService implements QrCodeServiceInterface
{
    public function generate($id)
    {
        $hash = $this->makeHash();
        $qr = QrCode::generate(env('QR_URL').$hash);
        $dir = $this->makeHash();
        $fileName = $this->makeHash();
        $link = CdpFileService::storeTest($qr,'qrcode', $dir);
        $this->store($id, $link , $hash);
    }

    private function makeHash()
    {
        return sha1(uniqid());
    }

    private function store($id, $link, $hash)
    {
        CdpQrCodes::query()->create([
            'order_id' => $id,
            'is_activated' => FALSE,
            'link' => 'storage/'.$link.'.svg',
            'hash' => $hash
        ]);
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $id = CdpUsersOrders::where('user_id' , $user['id'])->where('id' , $request->order_id)->first();
        return CdpQrCodes::where('order_id' , $id->id)->first();
    }

    public function activate($hash)
    {
        try {
            DB::beginTransaction();
            $qr = CdpQrCodes::where('hash', $hash)->first();
            $order = CdpUsersOrders::where('id', $qr->order_id)->where(['is_activated' => FALSE])->first();
            if ($order){
                CdpUsersOrders::where('id', $qr->order_id)->update(['is_activated' => TRUE, 'activated_at' => Carbon::now()]);
                CdpUserOrdersCount::where('user_id' , $order->user_id)->increment('count_activated', 1);
                CdpUserOrdersCount::where('user_id' , $order->user_id)->decrement('count_unactivated', 1);
                $user = CdpUsers::where('id' , $order->user_id)->first();
                DB::commit();
                $data = [
                    'orderId'   =>  $order->id,
                    'mall_id'   =>  $user->mall_id,
                    'params'    =>  [
                        'product_image'   =>  $order->file_link,
                        'data_purchase'   =>  date("Y-m-d", strtotime($order->data_purchase)),
                        'product_name'   =>  $order->product_title,
                        'activated_at'   => Carbon::now()->format('Y-m-d'),
                    ]
                ];

                return  $data;
            }
        }catch (\Exception $exception)
        {
            DB::rollBack();
            return ApiController::sendError('Ошибка сервера', 'Проблема активации.', 500);
        }
    }
}
