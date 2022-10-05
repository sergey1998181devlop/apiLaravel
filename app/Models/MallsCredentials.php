<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MallsCredentials extends Model
{
    use HasFactory;

    protected $fillable = [
      'mail_user',
      'mail_password',
      'sms_user',
      'sms_password',
      'mall_id',
        'sms_name'
    ];
}
