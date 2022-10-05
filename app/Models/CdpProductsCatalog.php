<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpProductsCatalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mall_id',
        'id',
        'visible'
    ];
}
