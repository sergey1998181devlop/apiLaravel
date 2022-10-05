<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_product',
        'visible',
        'category_id',
        'description',
        'price',
        'october_id',
        'product_image',
        'product_count',
    ];

    protected $table = 'cdp_products';

    public static function index($product)
    {
        return CdpProducts::where('id' , $product)->first();
    }
}
