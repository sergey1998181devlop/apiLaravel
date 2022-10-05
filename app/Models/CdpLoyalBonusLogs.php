<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpLoyalBonusLogs extends Model
{
    protected $fillable = [
        'bonus_transaction',
        'bonus_date',
        'bonus_id',
        'bonus_type',
        'user_id',
        'bonus_description',
        'payment_status',
        'created_at',
        'updated_at',
    ];

    use HasFactory;

    public static function userHistory($user) {
       return CdpLoyalBonusLogs::where('user_id' , $user)->get();
    }


}
