<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpDrawMembers extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'mall_id',
        'draw_id'
    ];
}
