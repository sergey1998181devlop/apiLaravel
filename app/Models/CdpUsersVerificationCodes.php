<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpUsersVerificationCodes extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'code',
    ];

    public static function create($request)
    {
         return CdpUsersVerificationCodes::query()->create([
        'phone' => $request->phone,
        'code' => mt_rand(1241 , 9888),
    ]);
    }

    public static function findCode($phone , $code)
    {
        return CdpUsersVerificationCodes::where('phone' , $phone)->where('code' , $code)->first();
    }

    public static function destroy($id)
    {
        CdpUsersVerificationCodes::find($id)->delete();
    }

}
