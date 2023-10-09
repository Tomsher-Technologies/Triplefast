<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCardOperations extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_card_id', 'seq_no', 'job_operation_id', 'op_comment', 'op_qty', 'status', 'is_deleted', 'created_by', 'updated_by', 'deleted_by', 'deleted_date'
    ];

    public function job_details(){
    	return $this->belongsTo(JobCards::class,'job_card_id','id');
    }

    public function operation(){
    	return $this->belongsTo(Operations::class,'job_operation_id','id');
    }
}
