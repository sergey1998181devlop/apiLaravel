<?php

namespace App\Models;

use App\Enums\BonusTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpLoyalChecks extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mall_id',
        'bonus_id',
        'bonus_sum',
        'check_sum',
        'status',
        'check_data_start',
        'check_data_end',
        'file_link'
    ];


    public static function index($user , $mall)
    {
        return CdpLoyalChecks::where('user_id', $user)->where('mall_id' , $mall)->get()->toArray();
    }

    public static function create($user , $file , $hash , $filename)
    {
       return CdpLoyalChecks::query()->create([
            'user_id' => $user->id,
            'check_sum' => 0,
            'bonus_sum' => 0,
            'mall_id' => $user->mall_id,
            'file_link' => 'storage/'.$file->file_name,
            'status' => 'neutral'
        ]);
    }
}
