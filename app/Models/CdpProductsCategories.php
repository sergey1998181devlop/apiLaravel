<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdpProductsCategories extends Model
{
    use HasFactory;

    protected $table = 'cdp_products_categories';

    protected $fillable = [
        'name',
        'catalog_id',
        'october_id',
        'visible',
        'category_image',
        'sort_categories',
    ];

}
