<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrders extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no', 'customer_id', 'shipping_id', 'order_date', 'status', 'need_by_date', 'ship_by_date', 'po_number', 'sales_person_id', 'terms', 'shipping_terms', 'shipping_via', 'description', 'release_date', 'completed_date', 'is_active', 'is_deleted', 'created_by', 'updated_by', 'deleted_by', 'deleted_date'
    ];

    public function sales_person(){
    	return $this->belongsTo(User::class,'sales_person_id','id');
    }

    public function customer(){
    	return $this->belongsTo(Customers::class,'customer_id','id');
    }

    public function customer_shipping(){
    	return $this->belongsTo(ShippingAddresses::class,'shipping_id','id');
    }

    public function order_parts()
    {
        return $this->hasMany(SalesOrderParts::class,'order_id','id')->with(['part_details'])->where('is_deleted',0);
    }
}
