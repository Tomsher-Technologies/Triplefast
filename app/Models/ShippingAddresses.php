<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddresses extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'shipping_address'
    ];

    public function customer(){
    	return $this->belongsTo(Customers::class,'customer_id','id');
    }
}
