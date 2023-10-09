<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_id', 'first_name', 'last_name', 'email', 'phone_number', 'address', 'is_active', 'is_deleted'
    ];

    public function shipping_address()
    {
        return $this->hasMany(ShippingAddresses::class,'customer_id','id')->where('is_deleted',0);
    }

    public function orders()
    {
        return $this->hasMany(SalesOrders::class,'id','customer_id');
    }
}
