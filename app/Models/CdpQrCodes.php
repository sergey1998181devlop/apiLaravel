<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpQrCodes extends Model
{
    use HasFactory;

    protected $fillable = [
      'order_id',
        'is_activated',
        'hash',
        'link'
    ];
}
