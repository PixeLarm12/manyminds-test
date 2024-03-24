<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = "products";

    protected $fillable = [
        'code',
        'title',
        'price',
    ];

    public function orders() {
        return $this->belongsToMany(Order::class)->withPivot(['amount', 'unit_price', 'total_price']);
    }
}
