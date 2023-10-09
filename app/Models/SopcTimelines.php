<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SopcTimelines extends Model
{
    protected $table = 'sopc_timeline';

    use HasFactory;

    protected $fillable = [
        'sopc_id', 'content', 'updated_by', 'is_active','created_at'
    ];

    public function sopcReport(){
    	return $this->belongsTo(SopcReports::class,'sopc_id','id');
    }

    public function updatedBy(){
    	return $this->belongsTo(User::class,'updated_by','id');
    }
}
