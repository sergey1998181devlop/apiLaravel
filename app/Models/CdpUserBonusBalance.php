<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpUserBonusBalance extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'balance'
    ];

    public static function index($user_id)
    {
        return CdpUserBonusBalance::where('user_id' , $user_id)->first();
    }

    public static function decrease($user , $amount)
    {
        try{
            return CdpUserBonusBalance::where('user_id' , $user)->decrement('balance' , $amount);
        }catch (\Exception $exception){
            return response()->json([
               'message' => 'Недостаточно средств для покупки'
            ]);
        }
    }

    public static function increase($user , $amount)
    {
        return CdpUserBonusBalance::where('user_id' , $user)->increment('balance' , $amount);
    }
}
