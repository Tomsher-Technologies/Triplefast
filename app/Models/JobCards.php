<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCards extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'order_part_id', 'job_number', 'description', 'order_processer', 'due_date', 'start_date', 'need_by_date', 'req_date', 'qty_req', 'for_order', 'for_stock', 'status', 'is_deleted', 'created_by', 'updated_by', 'deleted_by', 'deleted_date'
    ];

    public function order(){
    	return $this->belongsTo(SalesOrders::class,'order_id','id')->with(['customer']);
    }

    public function order_part(){
    	return $this->belongsTo(SalesOrderParts::class,'order_part_id','id')->with(['part_details']);
    }

    public function order_processer_user(){
    	return $this->belongsTo(User::class,'order_processer','id');
    }

    public function job_materials()
    {
        return $this->hasMany(JobCardMaterials::class,'job_card_id','id')->with(['material_part'])->where('is_deleted',0)->orderBy('seq_no','ASC');
    }
    public function job_operations()
    {
        return $this->hasMany(JobCardOperations::class,'job_card_id','id')->with(['operation'])->where('is_deleted',0);
    }
}
