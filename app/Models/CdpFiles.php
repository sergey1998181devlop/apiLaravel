<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpFiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'file_directory',
        'file_name',
    ];
}
