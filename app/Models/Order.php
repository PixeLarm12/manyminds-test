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
