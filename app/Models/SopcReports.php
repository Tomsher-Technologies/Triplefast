<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class SopcReports extends Model
{
    use HasFactory, Sortable;

    public $sortable = ['id','so_number', 'started_date', 'issue_date', 'target_date','completed_date','due_date'];

    protected $fillable = [
        'so_number', 'report_type', 'enter_date', 'issue_date', 'started_date', 'due_date', 'target_date', 'completed_date', 'total_items', 'division', 'customer_id', 'po_number', 'jobs_to_do', 'job_status', 'machining', 'heat_treatment', 's1_date', 'subcon', 'stock', 'total_value', 'fasteners', 'gasket', 'ptfe', 's1f', 's1g', 's1p', 'partial', 'fim_ptfe', 'fim_zy', 'charges', 'hold', 'is_active', 'is_deleted', 'created_by', 'updated_by','remarks'
    ];

    public function customer(){
    	return $this->belongsTo(Customers::class,'customer_id','id');
    }

    public function createdBy(){
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public function updatedBy(){
    	return $this->belongsTo(User::class,'updated_by','id');
    }

    public function sopcItems()
    {
        return $this->hasMany(SopcItems::class,'sopc_id','id')->with(['updatedUser']);
    }
}
