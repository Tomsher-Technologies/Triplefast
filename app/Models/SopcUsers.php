<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SopcUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        'sopc_id', 'user_id', 'is_active','created_at'
    ];

    public function sopcReport(){
    	return $this->belongsTo(SopcReports::class,'sopc_id','id');
    }

    public function salesUser(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
}

