<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpEmailNotes extends Model
{
    use HasFactory;

    protected $table = 'cdp_email_notes';

    protected $fillable = [
        'message_id',
        'send_type',
        'mall_id'
    ];
}
