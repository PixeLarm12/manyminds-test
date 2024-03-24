<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const ORDER_STATUS_ACTIVE = 'active';
    public const ORDER_STATUS_FINISHED = 'finished';

    protected $table = 'orders';

    protected $fillable = [
        'supplier_id',
        'status',
        'observation'
    ];

    protected $appends = [
        'supplier_label',
        'total_price',
    ];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($model) {
            $model->products()->detach();
        });
    }

    public function getSupplierLabelAttribute() {
        $supplier = Supplier::find($this->attributes['supplier_id']);
        
        return $supplier ? $supplier->name : 'Unknown name';
    }

    public function getTotalPriceAttribute() {
        $products = $this->products()->get();
        $total = 0;
        
        foreach($products as $product) {
            $total += $product->pivot->total_price;
        }

        return $total;
    }   

    public function scopeActive($query)
    {
        return $query->where('status', self::ORDER_STATUS_ACTIVE);
    }

    public function scopeFinished($query)
    {
        return $query->where('status', self::ORDER_STATUS_FINISHED);
    }

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot(['amount', 'unit_price', 'total_price']);
    }

    public static function getStatusByKey($key) 
    {
        $data = self::getStatus();

        foreach($data as $item) {
            if($item['key'] == $key) {
                return $item;
            }
        }
    }

    public static function getStatus() 
    {
        return [
            [
                'key' => self::ORDER_STATUS_ACTIVE,
                'value' => 'Active',
            ],
            [
                'key' => self::ORDER_STATUS_FINISHED,
                'value' => 'Finished',
            ],
        ];
    }
}
