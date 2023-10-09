<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserTypes;
use App\Models\Operations;
use App\Models\Customers;
use App\Models\ShippingAddresses;
use App\Models\SalesOrders;
use App\Models\SalesOrderParts;
use App\Models\JobCards;
use App\Models\JobCardMaterials;
use App\Models\JobCardOperations;
use Illuminate\Support\Facades\Auth;
use Validator;
use Storage;
use Str;
use File;
use Hash;
use DB;

class JobCardsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:jobcard-list|jobcard-create|jobcard-edit|jobcard-delete|jobcard-view', ['only' => ['index','store']]);
        $this->middleware('permission:jobcard-create', ['only' => ['create','store']]);
        $this->middleware('permission:jobcard-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:jobcard-delete', ['only' => ['destroy']]);
        $this->middleware('permission:jobcard-view', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $job_id = $request->job_id;
        $oldOrderPartId = '';
        if($job_id != '' && $job_id != 0){
            $job = JobCards::with(['job_materials'])->find($job_id);
            $oldOrderPartId = $job->order_part_id;
            $job->updated_by        =   Auth::user()->id;
        }else{
            $job = new JobCards();
            $job->created_by        =   Auth::user()->id;
        }

        $job->order_id          =   $request->order_id;
        $job->order_part_id     =   $request->part_id;
        $job->job_number        =   $request->job_number;
        $job->description       =   $request->part_description;
        $job->order_processer   =   $request->order_processor;
        $job->due_date          =   date('Y-m-d', strtotime($request->due_date));
        $job->start_date        =   date('Y-m-d', strtotime($request->start_date));
        $job->need_by_date      =   date('Y-m-d', strtotime($request->need_date));
        $job->req_date          =   date('Y-m-d', strtotime($request->req_date));
        $job->qty_req           =   $request->req_quantity;
        $job->for_order         =   $request->for_order;
        $job->for_stock         =   $request->for_stock;
        $job->status            =   0;
        $job->save();

        $jobId = $job->id; 

        $materialsOld = JobCardMaterials::where('job_card_id', $jobId)->where('is_deleted',0)->get();

        $idsOld = $idsNow = [];

        foreach ($materialsOld as $i) {
            $idsOld[] = $i->id;
        }
        $details = []; 

        if ($request->components && $jobId) {
            $details = [];
            foreach ($request->components as $parts) {
                if($parts['component_id'] != '' && $parts['component_id'] != 0){
                    $idsNow[] = $parts['component_id'];
                    JobCardMaterials::where('id', $parts['component_id'])->update([
                                                'seq_no'  => $parts['seq_no'] ,
                                                'job_part_id'  => $parts['part_number'] ,
                                                'description'  => $parts['comp_description'] ,
                                                'req_qty'  => $parts['req_qty'] ,
                                                'updated_at'  => date('Y-m-d H:i:s')
                                            ]);
                }else{
                    $details[] = [
                        'job_card_id'  => $jobId ,
                        'seq_no'  => $parts['seq_no'] ,
                        'job_part_id'  => $parts['part_number'] ,
                        'description'  => $parts['comp_description'] ,
                        'req_qty'  => $parts['req_qty'] ,
                        'created_at'  => date('Y-m-d H:i:s')
                    ];
                }
            }

            if(!empty($details)){
                JobCardMaterials::insert($details);
            }
        }

        if(!empty($idsOld)){
            $differenceArray = array_diff($idsOld, $idsNow);
            if(!empty($differenceArray)){
                JobCardMaterials::whereIn('id',$differenceArray)->update(['is_deleted' => 1]);
            }
        }

        if($oldOrderPartId != '' && $oldOrderPartId != $request->part_id){
            SalesOrderParts::where('id', $oldOrderPartId)->update(['is_card_added' => 0]);
            SalesOrderParts::where('id', $request->part_id)->update(['is_card_added' => 1]);
        }else{
            SalesOrderParts::where('id', $request->part_id)->update(['is_card_added' => 1]);
        }
        
        return redirect()->back()->with('success','Job Card saved successfully');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobs = JobCards::where('is_deleted',0)->where('order_id', $id)->orderBy('id', 'ASC')->get();
        $order = SalesOrders::with(['sales_person','customer','customer_shipping'])
                    ->where('is_deleted',0)
                    ->where('id', $id)->get();

        $orderParts = SalesOrderParts::with(['part_details'])->where('order_id', $id)->where('is_deleted',0)->where('is_card_added',0)->orderBy('id', 'ASC')->get();

        $salesTeam = User::where('user_type',4)->where('is_deleted',0)->where('is_active',1)->orderBy('name', 'ASC')->get();
        return view('admin.orders.job_cards',compact('order','salesTeam','orderParts','jobs'));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        JobCards::where('id',$id)->update(['is_deleted' => 1,'deleted_by' => Auth::user()->id,'deleted_date' =>date('Y-m-d H:i:s')]);
    }

    public function getOrderPartDetails(Request $request){
        $id = $request->id;
        $orderParts = SalesOrderParts::where('id', $id)->first()->toArray();

        $orderParts['need_by_date'] = date('d-M-Y', strtotime($orderParts['need_by_date']));
        return json_encode($orderParts);
    }

    public function getJobCardDetails(Request $request){
        $id = $request->id;

        $card = JobCards::with(['order','order_processer_user','job_materials','order_part'])
                        ->where('is_deleted',0)
                        ->where('id', $id)->get()->toArray();

        $card[0]['due_date_format'] = date('d-M-Y', strtotime($card[0]['due_date']));
        $card[0]['start_date_format'] = date('d-M-Y', strtotime($card[0]['start_date']));
        $card[0]['need_by_date_format'] = date('d-M-Y', strtotime($card[0]['need_by_date']));
        $card[0]['req_date_format'] = date('d-M-Y', strtotime($card[0]['req_date']));
        
        return json_encode($card);
    }

    public function storeOperation(Request $request)
    {
        $job_operation_id = $request->job_operation_id;
        
        if($job_operation_id != '' && $job_operation_id != 0){
            $op = JobCardOperations::find($job_operation_id);
            $op->updated_by = Auth::user()->id;
        }else{
            $op = new JobCardOperations();
            $op->job_card_id    = $request->job_card_id;
            $op->created_by     = Auth::user()->id;
        }
        $op->seq_no             = $request->op_seq_no;
        $op->job_operation_id   = $request->operation_id;
        $op->op_comment         = $request->op_comments;
        $op->op_qty             = $request->op_qty;
        $op->save();

        return redirect()->back()->with('success','Job card operation saved successfully');
    }

    public function operationsAjax(Request $request)
    {
    	$data = [];

        if($request->has('q')){
            $search = $request->q;
           
            $query = Operations::where('is_deleted',0)->where('is_active',1);
           
            if($search){
                $query->Where(function ($query) use ($search) {
                    $query->orWhere('operation_id', 'LIKE', "%$search%");   
                }); 
            }           
            $data = $query->orderBy('operation_id','ASC')->get();
        }
        return response()->json($data);
    }

    public function getJobOperationDetails(Request $request){
        $id = $request->id;

        $card = JobCardOperations::with(['operation'])
                        ->where('is_deleted',0)
                        ->where('id', $id)->get()->toArray();

        return json_encode($card);
    }

    public function destroyOperation(Request $request)
    {
        $id = $request->id;
        JobCardOperations::where('id',$id)->update(['is_deleted' => 1,'deleted_by' => Auth::user()->id,'deleted_date' =>date('Y-m-d H:i:s')]);
    }
}
