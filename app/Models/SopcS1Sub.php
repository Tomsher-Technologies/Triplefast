<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SopcS1Sub extends Model
{
    use HasFactory;
    protected $table = 'sopc_s1_sub';

    protected $fillable = [
        'type', 'content_date', 'content', 'is_deleted', 'created_by', 'updated_by'
    ];

    public function createdBy(){
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public function updatedBy(){
    	return $this->belongsTo(User::class,'updated_by','id');
    }
}
