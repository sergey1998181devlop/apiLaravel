<?php

namespace App\Models;

use App\Enums\BonusTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpUsersOrders extends Model
{
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_price',
        'user_id',
        'product_type',
        'product_duration',
        'product_title',
        'data_purchase',
        'file_link',

    ];

    public static function create($user_id, $amount, $type)
    {
        try {
            $order = CdpUsersOrders::query()->create([
                'product_id' => $amount->id,
                'product_price' => $amount->price,
                'product_duration' => Carbon::now()->addMonth(),
                'user_id' => $user_id,
                'product_type' => $type,
                'file_link' => $amount->product_image,
                'data_purchase' => Carbon::now(),
                'product_title' => $amount->name
            ]);
            CdpLoyalBonusLogs::create([
                'bonus_transaction' => $amount->price,
                'bonus_date' => Carbon::now(),
                'check_id' => NULL,
                'bonus_type' => BonusTypeEnum::BONUS_TYPE_DECREASE_PRODUCT,
                'user_id' => $user_id,
                'bonus_description' => BonusTypeEnum::BONUS_TYPE_DECREASE_PRODUCT_DESCRIPTION,
                'payment_status' => BonusTypeEnum::BONUS_TYPE_DECREASE_STATUS,
            ]);
            return $order;
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public static function index($user_id)
    {
        return CdpUsersOrders::where('user_id', $user_id)->get();
    }
}
