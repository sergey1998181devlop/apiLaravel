<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CdpUsersVerificationHashes extends Model
{
    use HasFactory;

    protected $table = 'cdp_user_verification_hashes';

    protected $fillable = [
        'user_id',
        'hash'
    ];

    public static function create($user_id)
    {
        return CdpUsersVerificationHashes::query()->create([
            'user_id' => $user_id,
            'hash' =>  Str::random(40),
        ]);
    }

    public static function getUser($hash)
    {
        $user_id = CdpUsersVerificationHashes::where('hash' , $hash)->pluck('user_id')->first();

        if (empty($user_id)) return null;

        return CdpUsers::where('id', $user_id)->first();
    }
}
