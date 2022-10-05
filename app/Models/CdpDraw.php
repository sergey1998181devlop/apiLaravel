<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpDraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'october_id',
        'title',
        'description',
        'bonus_price',
        'date_start',
        'date_end',
        'mall_id',
        'big_image_link',
        'small_image_link',
    ];
}
