<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SopcItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'sopc_id', 'line_no', 'status', 'remark', 'updated_by'
    ];

    public function sopcReport(){
    	return $this->belongsTo(SopcReports::class,'sopc_id','id');
    }

    public function updatedUser(){
    	return $this->belongsTo(User::class,'updated_by','id');
    }
}
