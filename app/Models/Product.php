<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'product_name',
        'product_description',
    'image'
    ];

    public function brands()
    {
        return $this->hasMany(ProductBrand::class);
    }
}
