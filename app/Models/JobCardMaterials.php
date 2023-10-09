<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCardMaterials extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_card_id', 'seq_no', 'job_part_id', 'description', 'req_qty', 'is_deleted'
    ];

    public function job_details(){
    	return $this->belongsTo(JobCards::class,'job_card_id','id');
    }

    public function material_part(){
    	return $this->belongsTo(Parts::class,'job_part_id','id');
    }
}
