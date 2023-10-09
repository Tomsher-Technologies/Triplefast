<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderParts extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'part_id', 'quantity', 'description', 'rev', 'need_by_date', 'is_card_added', 'is_deleted'
    ];

    public function order(){
    	return $this->belongsTo(SalesOrders::class,'order_id','id');
    }

    public function part_details(){
    	return $this->belongsTo(Parts::class,'part_id','id');
    }
}
