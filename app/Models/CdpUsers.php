<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class CdpUsers extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'surname',
        'phone',
        'email',
        'sex',
        'permissions',
        'token',
        'mall_id',
        'birthdate',
        'password',
        'is_activated',
        'email_confirmed'
    ];

    protected $hidden = [
        'token'
    ];

    public static function index($token) {
        return CdpUsers::where('token' , $token)->first();
    }

    public function polymorphFiltrationByMall($table, $filter, $direction , $mall_id)
    {
        return DB::table('cdp_users')->where('mall_id' , $mall_id)
            ->join('cdp_user_bonus_balances', 'cdp_users.id', '=', 'cdp_user_bonus_balances.user_id')
            ->join('cdp_user_orders_counts', 'cdp_users.id', '=', 'cdp_user_orders_counts.user_id')
            ->join('cdp_malls', 'cdp_users.mall_id', '=', 'cdp_malls.mall_id')
            ->select('cdp_users.id', 'cdp_users.name', 'cdp_users.surname', 'cdp_users.email', 'cdp_users.phone', 'cdp_users.created_at',
                'cdp_user_bonus_balances.balance', 'cdp_users.mall_id','cdp_malls.mall_name', 'cdp_user_orders_counts.count_unactivated', 'cdp_user_orders_counts.count_activated')->orderBy("$table.$filter","$direction")->get();
    }

    public function polymorphFiltration($table, $filter, $direction)
    {
       return DB::table('cdp_users')
            ->join('cdp_user_bonus_balances', 'cdp_users.id', '=', 'cdp_user_bonus_balances.user_id')
           ->join('cdp_user_orders_counts', 'cdp_users.id', '=', 'cdp_user_orders_counts.user_id')
           ->join('cdp_malls', 'cdp_users.mall_id', '=', 'cdp_malls.mall_id')
            ->select('cdp_users.id', 'cdp_users.name', 'cdp_users.surname', 'cdp_users.email', 'cdp_users.phone', 'cdp_users.created_at',
                'cdp_user_bonus_balances.balance','cdp_users.mall_id','cdp_malls.mall_name', 'cdp_user_orders_counts.count_unactivated', 'cdp_user_orders_counts.count_activated')->orderBy("$table.$filter","$direction")->get();
    }

    public function polymorph()
    {
        return DB::table('cdp_users')
            ->join('cdp_user_bonus_balances', 'cdp_users.id', '=', 'cdp_user_bonus_balances.user_id')
            ->join('cdp_user_orders_counts', 'cdp_users.id', '=', 'cdp_user_orders_counts.user_id')
            ->join('cdp_malls', 'cdp_users.mall_id', '=', 'cdp_malls.mall_id')
            ->select('cdp_users.id', 'cdp_users.name', 'cdp_users.surname', 'cdp_users.email', 'cdp_users.phone', 'cdp_users.created_at',
                'cdp_user_bonus_balances.balance','cdp_users.mall_id','cdp_malls.mall_name', 'cdp_user_orders_counts.count_unactivated', 'cdp_user_orders_counts.count_activated')->get();
    }

}
