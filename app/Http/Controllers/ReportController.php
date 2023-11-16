<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SopcReports;
use App\Models\SopcItems;
use App\Models\SopcTimelines;
use App\Models\SopcUsers;
use App\Models\User;
use App\Models\Notifications;
use App\Models\Customers;
use App\Models\SopcS1Sub;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMail;
use App\Mail\MailSend;
use Validator;
use DB;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:sopc-list|sopc-create|sopc-edit|sopc-view', ['only' => ['index','store']]);
        $this->middleware('permission:sopc-create', ['only' => ['create','store']]);
        $this->middleware('permission:sopc-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sopc-view', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->session()->put('last_url', url()->full());

        $search_so_number =  $status_search = $type_search = $dates_search = $customer_id = '';
        $customer = [];

        if ($request->has('so_number')) {
            $search_so_number = $request->so_number;
        }
        if ($request->has('status')) {
            $status_search = $request->status;
        }

        if ($request->has('date_type')) {
            $type_search = $request->date_type;
        }

        if ($request->has('dates')) {
            $dates_search = $request->dates;
        }

        if ($request->has('customer_id')) {
            $customer_id = $request->customer_id;
        }
   
        $query = SopcReports::with(['customer','createdBy'])->where('is_deleted',0);

        if($search_so_number){
            $query->where('so_number', 'LIKE', "%$search_so_number%");
        }

        if($status_search != ''){
            $query->where('job_status', $status_search);
        }
        if($customer_id != ''){
            $query->where('customer_id', $customer_id);
            $customer = Customers::find($customer_id);
        }
        if($type_search != '' && $dates_search != ''){
            $date = explode(' - ', $dates_search);
            $start_date = str_replace('/', '-', trim($date[0])) ?? '';
            $end_date = str_replace('/', '-', trim($date[1])) ?? '';

            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));

            if($type_search == 'due'){
                $query->whereBetween('due_date', [$start_date, $end_date]);
            }

            if($type_search == 'issue'){
                $query->whereBetween('issue_date', [$start_date, $end_date]);
            }
            if($type_search == 'start'){
                $query->whereBetween('started_date', [$start_date, $end_date]);
            }
            if($type_search == 'target'){
                $query->whereBetween('target_date', [$start_date, $end_date]);
            }
            if($type_search == 'completed'){
                $query->whereBetween('completed_date', [$start_date, $end_date]);
            }
        }
        $data = $query->sortable(['id' => 'desc'])->paginate(50);

        return view('admin.sopc.index',compact('data','search_so_number','status_search','type_search','dates_search','customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $customers = getActiveCustomers();
        return view('admin.sopc.create',compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'so_number'     => 'required|unique:sopc_reports,so_number',
            // 'enter_date'    => 'required',
            // 'issue_date'    => 'required',
            // 'due_date'      => 'required',
            'total_items'   => 'required',
            'customer_id'   => 'required',
            'po_number'     => 'required',
            'job_status'    => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $total_items = $request->total_items;

        $sopc = new SopcReports;
        $sopc->so_number        = $request->so_number;
        $sopc->report_type      = $request->report_type;
        $sopc->enter_date       = ($request->enter_date != '') ? date('Y-m-d', strtotime($request->enter_date)) : NULL;
        $sopc->issue_date       = ($request->issue_date != '') ? date('Y-m-d', strtotime($request->issue_date)) : NULL;
        $sopc->started_date     = ($request->started_date != '') ? date('Y-m-d', strtotime($request->started_date)) : NULL;
        $sopc->due_date         = ($request->due_date != '') ? date('Y-m-d', strtotime($request->due_date)) : NULL;
        $sopc->target_date      = ($request->target_date != '') ? date('Y-m-d', strtotime($request->target_date)) : NULL;
        $sopc->completed_date   = ($request->completed_date != '') ? date('Y-m-d', strtotime($request->completed_date)) : NULL;
        $sopc->total_items      = $total_items;
        $sopc->division         = $request->division;
        $sopc->customer_id      = $request->customer_id;
        $sopc->po_number        = $request->po_number;
        $sopc->jobs_to_do       = $request->jobs_to_do;
        $sopc->job_status       = $request->job_status;
        $sopc->machining        = ($request->machining != '') ? date('Y-m-d', strtotime($request->machining)) : NULL;
        $sopc->heat_treatment   = ($request->heat_treatment != '') ? date('Y-m-d', strtotime($request->heat_treatment)) : NULL;
        $sopc->s1_date          = $request->s1_date;
        $sopc->subcon           = $request->subcon;
        $sopc->stock            = $request->stock;
        $sopc->total_value      = $request->total_value;
        $sopc->fasteners        = $request->fasteners ?? NULL;
        $sopc->gasket           = $request->gasket ?? NULL;
        $sopc->ptfe             = $request->ptfe ?? NULL;
        $sopc->s1f              = $request->s1f ?? NULL;
        $sopc->s1g              = $request->s1g ?? NULL;
        $sopc->s1p              = $request->s1p ?? NULL;
        $sopc->fim_ptfe         = $request->fim_ptfe ?? NULL;
        $sopc->fim_zy           = $request->fim_zy ?? NULL;
        $sopc->charges          = $request->charges ?? NULL;
        $sopc->hold             = $request->hold ?? NULL;
        $sopc->created_by       = Auth::user()->id;
        $sopc->save();

        $reportId = $sopc->id;

        $s1_datas = $subcon_datas = [];
        if ($request->s1_data && $reportId) {
            foreach ($request->s1_data as $s1_data) {
                if($s1_data['s1_date'] != '' || $s1_data['s1_content'] != ''){
                    $s1_datas[] = [
                        'sopc_id' => $reportId,
                        'type' => 's1', 
                        'content_date' => ($s1_data['s1_date'] != '') ? date('Y-m-d', strtotime($s1_data['s1_date'])) : NULL,
                        'content' => $s1_data['s1_content'],
                        'created_by' => Auth::user()->id
                    ];
                }
            }
            if(!empty($s1_datas)){
                SopcS1Sub::insert($s1_datas);
            }
        }

        if ($request->subcon_data && $reportId) {
            foreach ($request->subcon_data as $subcon_data) {
                if($subcon_data['subcon'] != '' || $subcon_data['subcon_content'] != ''){
                    $subcon_datas[] = [
                        'sopc_id' => $reportId,
                        'type' => 'subcon', 
                        'content_date' => ($subcon_data['subcon'] != '') ? date('Y-m-d', strtotime($subcon_data['subcon'])) : NULL,
                        'content' => $subcon_data['subcon_content'],
                        'created_by' => Auth::user()->id
                    ];
                }
            }
            if(!empty($subcon_datas)){
                SopcS1Sub::insert($subcon_datas);
            }
        }
            

        $items = [];
        for($i = 1; $i <= $total_items; $i++){
            $items[] = [
                'line_no' => $i,
                'sopc_id' => $reportId,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        SopcItems::insert($items);
        $content = 'New SOPC report created for SO Number: <b>'.$request->so_number.'</b>';
        if($request->target_date != NULL){
            $content .= ' with target date <b>'.$request->target_date.'</b>'; 
        }
        SopcTimelines::create([
            'sopc_id' => $reportId, 
            'content' =>  $content, 
            'updated_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('sopc.index')->with(['success' => "SOPC report created succesfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sopc = SopcReports::with(['sopcItems'])
                    ->where('is_deleted',0)
                    ->where('id', $id)->first();

        $s1_sub = SopcS1Sub::where('sopc_id', $id)->where('is_deleted',0)->orderBy('id','ASC')->get();

        $s1_data = $subcon_data = [];
        if(isset($s1_sub[0])){
            foreach ($s1_sub as $ss) {
                $arr = [];
                
                if($ss->type == 's1'){
                    $arr['content_date'] = ($ss->content_date != NULL) ? date('d-m-Y', strtotime($ss->content_date)) : '';
                    $arr['content'] = $ss->content;
                    $s1_data[] = $arr;
                }else{
                    $arr['content_date'] =  ($ss->content_date != NULL) ? date('d-m-Y', strtotime($ss->content_date)) : '';
                    $arr['content'] = $ss->content;
                    $subcon_data[] = $arr;
                }
            }
        }
        
        return view('admin.sopc.view',compact('sopc','s1_data','subcon_data'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sopc = SopcReports::with(['customer'])->find($id);
        $customers = getActiveCustomers();

        $s1_sub = SopcS1Sub::where('sopc_id', $id)->where('is_deleted',0)->get();

        $s1_data = $subcon_data = [];
       
        foreach ($s1_sub as $ss) {
            $arr = [];
            
            if($ss->type == 's1'){
                $arr['s1_id'] = $ss->id;
                $arr['s1_date'] = ($ss->content_date != NULL) ? date('d-m-Y', strtotime($ss->content_date)) : '';
                $arr['s1_content'] = $ss->content;
                $s1_data[] = $arr;
            }else{
                $arr['sub_id'] = $ss->id;
                $arr['subcon'] =  ($ss->content_date != NULL) ? date('d-m-Y', strtotime($ss->content_date)) : '';
                $arr['subcon_content'] = $ss->content;
                $subcon_data[] = $arr;
            }
        }

        $s1Data = json_encode($s1_data);
        $subconData = json_encode($subcon_data);

        return view('admin.sopc.edit',compact('sopc','customers','s1Data','subconData'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $validator = Validator::make($request->all(), [
            'so_number'     => 'required|unique:sopc_reports,so_number,'.$id,
            'total_items'   => 'required',
            'customer_id'   => 'required',
            'po_number'     => 'required',
            'job_status'    => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $sopc = SopcReports::find($id);

        $old_target         = $sopc->target_date;
        $old_completed_date = $sopc->completed_date;
        $old_job_status     = $sopc->job_status;
        $old_machining_date = $sopc->machining;
        $old_heat_date      = $sopc->heat_treatment;
        $old_s1_date        = trim($sopc->s1_date);
        $old_subcon         = trim($sopc->subcon);
        $old_stock          = trim($sopc->stock);
        $so_num             = $sopc->so_number;

        $target_date        = $request->target_date;
        $completed_date     = $request->completed_date;
        $machining          = $request->machining;
        $heat_treatment     = $request->heat_treatment;
        $s1_date            = trim($request->s1_date);
        $subcon             = trim($request->subcon);
        $stock              = trim($request->stock);

        $new_target         = ($target_date != '') ? date('Y-m-d', strtotime($target_date)) : NULL;
        $new_completed_date = ($completed_date != '') ? date('Y-m-d', strtotime($completed_date)) : NULL;
        $new_job_status     = $request->job_status;
        $new_machining_date = ($machining != '') ? date('Y-m-d', strtotime($machining)) : NULL;
        $new_heat_date      = ($heat_treatment != '') ? date('Y-m-d', strtotime($heat_treatment)) : NULL;
        $new_s1_date        = ($s1_date != '') ? $s1_date : NULL;
        $new_subcon         = ($subcon != '') ? $subcon : NULL;
        $new_stock          = ($stock != '') ? $stock : NULL;

        $jobStatus = ['Not Started','Started','Partial','Hold','Completed','Cancelled'];
        $created_at = date('Y-m-d H:i:s');

        $timeline = $notifications = $mailData = [];

        if($old_target != $new_target){
            if($new_target == ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Target date removed.' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];

                $notifications[] = 'Target date for SO Number: <b>'.$so_num.'</b> is removed.' ;
                $mailData[] = 'Target date for SO Number: <b>'.$so_num.'</b> is removed.' ;
            }else{
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Target date changed to <b>'.$target_date.'</b>' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Target date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$target_date.'</b>';
                $mailData[] = 'Target date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$target_date.'</b>';
            }
        }

        if($old_completed_date != $new_completed_date){
            if($new_completed_date == ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Completed date removed.' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Completed date for SO Number: <b>'.$so_num.'</b> is removed.' ;
                $mailData[] = 'Completed date for SO Number: <b>'.$so_num.'</b> is removed.' ;
            }else{
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Completed date changed to <b>'.$completed_date.'</b>' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Completed date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$completed_date.'</b>';
                $mailData[] = 'Completed date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$completed_date.'</b>';
            }
        }

        if($old_machining_date != $new_machining_date){
            if($new_machining_date == '' && $old_machining_date != ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Machining date removed.' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Machining date for SO Number: <b>'.$so_num.'</b> is removed.' ;
            }elseif($new_machining_date != ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Machining date changed to <b>'.$machining.'</b>' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Machining date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$machining.'</b>';
            }
        }

        if($old_heat_date != $new_heat_date){
            if($new_heat_date == '' && $old_heat_date != ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Heat Treatment date removed.' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Heat Treatment date for SO Number: <b>'.$so_num.'</b> is removed.' ;
            }elseif($new_heat_date != ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Heat Treatment date changed to <b>'.$heat_treatment.'</b>' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Heat Treatment date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$heat_treatment.'</b>';
            }
        }

        if($old_stock !== $new_stock){
            if($new_stock == '' && $old_stock != ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Stock data removed.' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Stock data for SO Number: <b>'.$so_num.'</b> is removed.' ;
            }elseif($new_stock != ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Stock data changed to <b>'.$stock.'</b>' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Stock data for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$stock.'</b>';
            }
        }

        

        $dataOldS1Sub = SopcS1Sub::where('sopc_id', $id)->where('is_deleted',0)->get();

        $idsOldS1Sub = $idsNowS1Sub = $s1Array = $subconArray = [];

        foreach ($dataOldS1Sub as $iS1Sub) {
            $idsOldS1Sub[] = $iS1Sub->id;
            if($iS1Sub->type == 's1'){
                $s1Array[$iS1Sub->id] = $iS1Sub;
            }elseif($iS1Sub->type == 'subcon'){
                $subconArray[$iS1Sub->id] = $iS1Sub;
            }
        }
        $detailsS1Sub = []; 

        if ($request->s1_data && $id) {
            foreach ($request->s1_data as $s1_data) {
                if($s1_data['s1_date'] != '' || $s1_data['s1_content'] != ''){
                    $content_date = ($s1_data['s1_date'] != '') ? date('Y-m-d', strtotime($s1_data['s1_date'])) : NULL;
                    $content = $s1_data['s1_content'];

                    if($s1_data['s1_id'] != '' && $s1_data['s1_id'] != 0){
                        $idsNowS1Sub[] = $s1_data['s1_id'];
                        
                        if(isset($s1Array[$s1_data['s1_id']])){
                            $oldContentDate = $s1Array[$s1_data['s1_id']]['content_date'] ?? NULL;
                            $oldContent =  $s1Array[$s1_data['s1_id']]['content'] ?? NULL;
                            if(($oldContentDate !== $content_date) && ($content_date != '')){
                                $timeline[] = [
                                        'sopc_id' => $id, 
                                        'content' => 'S1 date changed to <b>'.$content_date.'</b>' , 
                                        'updated_by' => Auth::user()->id,
                                        'created_at' => $created_at
                                    ];
                                $notifications[] = 'S1 date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$content_date.'</b>';
                            }

                            if(($oldContent !== $content) && ($content != '')){
                                $timeline[] = [
                                        'sopc_id' => $id, 
                                        'content' => 'S1 content changed to <b>'.$content.'</b>' , 
                                        'updated_by' => Auth::user()->id,
                                        'created_at' => $created_at
                                    ];
                                $notifications[] = 'S1 content for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$content.'</b>';
                            }
                        }
                        
                        SopcS1Sub::where('id', $s1_data['s1_id'])->update([
                                                            'type' => 's1', 
                                                            'content_date' => $content_date,
                                                            'content' => $content,
                                                            'updated_by' => Auth::user()->id
                                                        ]);
                    }else{
                        $detailsS1Sub[] = [
                            'sopc_id' => $id,
                            'type' => 's1', 
                            'content_date' => $content_date,
                            'content' => $content,
                            'created_by' => Auth::user()->id
                        ];
                    }
                }
            }
        }

        if ($request->subcon_data && $id) {
            foreach ($request->subcon_data as $subcon_data) {
                if($subcon_data['subcon'] != '' || $subcon_data['subcon_content'] != ''){
                    $subContent_date = ($subcon_data['subcon'] != '') ? date('Y-m-d', strtotime($subcon_data['subcon'])) : NULL;
                    $subContent = $subcon_data['subcon_content'];

                    if($subcon_data['sub_id'] != '' && $subcon_data['sub_id'] != 0){
                        $idsNowS1Sub[] = $subcon_data['sub_id'];
                        
                        if(isset($subconArray[$subcon_data['sub_id']])){
                            $oldSubContentDate = $subconArray[$subcon_data['sub_id']]['content_date'] ?? NULL;
                            $oldContent =  $subconArray[$subcon_data['sub_id']]['content'] ?? NULL;
                            if(($oldSubContentDate !== $subContent_date) && ($subContent_date != '')){
                                $timeline[] = [
                                        'sopc_id' => $id, 
                                        'content' => 'Subcon date changed to <b>'.$subContent_date.'</b>' , 
                                        'updated_by' => Auth::user()->id,
                                        'created_at' => $created_at
                                    ];
                                $notifications[] = 'Subcon date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$subContent_date.'</b>';
                            }

                            if(($oldContent !== $subContent) && ($subContent != '')){
                                $timeline[] = [
                                        'sopc_id' => $id, 
                                        'content' => 'Subcon content changed to <b>'.$subContent.'</b>' , 
                                        'updated_by' => Auth::user()->id,
                                        'created_at' => $created_at
                                    ];
                                $notifications[] = 'Subcon content for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$subContent.'</b>';
                            }
                        }
                        
                        SopcS1Sub::where('id', $subcon_data['sub_id'])->update([
                                                            'type' => 'subcon', 
                                                            'content_date' => $subContent_date,
                                                            'content' => $subContent,
                                                            'updated_by' => Auth::user()->id
                                                        ]);
                    }else{
                        $detailsS1Sub[] = [
                            'sopc_id' => $id,
                            'type' => 'subcon', 
                            'content_date' => $subContent_date,
                            'content' => $subContent,
                            'created_by' => Auth::user()->id
                        ];
                    }
                }
            }
        }


        if(!empty($detailsS1Sub)){
            SopcS1Sub::insert($detailsS1Sub);
        }

        if(!empty($idsOldS1Sub)){
            $differenceArray = array_diff($idsOldS1Sub, $idsNowS1Sub);
            if(!empty($differenceArray)){
                SopcS1Sub::whereIn('id',$differenceArray)->update(['is_deleted' => 1]);
            }
        }

        if($old_job_status != $new_job_status){
            $timeline[] = [
                'sopc_id' => $id, 
                'content' => 'Job Status changed to <b>'.$jobStatus[$new_job_status].'</b>' , 
                'updated_by' => Auth::user()->id,
                'created_at' => $created_at
            ];
            $notifications[] = 'Job Status for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$jobStatus[$new_job_status].'</b>';
            if($new_job_status == '2' || $new_job_status == '4'){
                $mailData[] = 'Job Status for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$jobStatus[$new_job_status].'</b>';
            }
            if($new_job_status == '4'){
                SopcItems::where('sopc_id',$id)->where('status',0)->where('is_cancelled',0)->update(['status' => 1]);
                $messageCont = 'All Lines for SO Number : <b>'.$so_num.'</b> is completed.';
                $mailData[] = $messageCont;
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' =>  $messageCont ?? '',
                    'updated_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $notifications[] = $messageCont ?? '';
            }
        }

        if(!empty($timeline)){
            SopcTimelines::insert($timeline);
        }

        if(!empty($notifications)){
            $salesNotify = [];

            $mailContent['subject'] = 'SO Number : '.$so_num.' details updated.';
            $mailContent['message'] = $mailData;


            $notify_users = User::where('user_type',4)->where('is_deleted',0)->where('is_active',1)
                                ->get()->toArray();

            foreach($notify_users as $notuser){
                foreach($notifications as $not){
                    $salesNotify[] = [
                        'user_id' => $notuser['id'],
                        'content' => $not,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
                if(!empty($mailData) && $notuser['email_notification'] == 1){
                    dispatch(new SendMail($notuser,$mailContent));
                }
            }

            if(!empty($salesNotify)){
                Notifications::insert($salesNotify);
            }
        }
        $sopc->so_number        = $request->so_number;
        $sopc->enter_date       = ($request->enter_date != '') ? date('Y-m-d', strtotime($request->enter_date)) : NULL;
        $sopc->issue_date       = ($request->issue_date != '') ? date('Y-m-d', strtotime($request->issue_date)) : NULL;
        $sopc->started_date     = ($request->started_date != '') ? date('Y-m-d', strtotime($request->started_date)) : NULL;
        $sopc->due_date         = ($request->due_date != '') ? date('Y-m-d', strtotime($request->due_date)) : NULL;
        $sopc->target_date      = $new_target;
        $sopc->completed_date   = $new_completed_date;
        $sopc->report_type      = $request->report_type;
        $sopc->division         = $request->division;
        $sopc->customer_id      = $request->customer_id;
        $sopc->po_number        = $request->po_number;
        $sopc->jobs_to_do       = $request->jobs_to_do;
        $sopc->job_status       = $new_job_status;
        $sopc->machining        = $new_machining_date;
        $sopc->heat_treatment   = $new_heat_date;
        $sopc->s1_date          = $new_s1_date;
        $sopc->subcon           = $new_subcon;
        $sopc->stock            = $new_stock;
        $sopc->total_value      = $request->total_value;
        $sopc->fasteners        = $request->fasteners ?? NULL;
        $sopc->gasket           = $request->gasket ?? NULL;
        $sopc->ptfe             = $request->ptfe ?? NULL;
        $sopc->s1f              = $request->s1f ?? NULL;
        $sopc->s1g              = $request->s1g ?? NULL;
        $sopc->s1p              = $request->s1p ?? NULL;
        $sopc->fim_ptfe         = $request->fim_ptfe ?? NULL;
        $sopc->fim_zy           = $request->fim_zy ?? NULL;
        $sopc->charges          = $request->charges ?? NULL;
        $sopc->hold             = $request->hold ?? NULL;
        $sopc->updated_by       = Auth::user()->id;
        $sopc->save();

        return redirect($request->session()->get('last_url'))->with(['success' => "SOPC report updated succesfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function notificationSettings(string $id){
        $sopc = SopcReports::find($id);
        $sopc_users = SopcUsers::where('sopc_id',$id)->pluck('user_id')->toArray();
        $salesTeam = User::where('user_type',4)->where('is_deleted',0)->where('is_active',1)->orderBy('name', 'ASC')->get();
        return view('admin.sopc.notifications',compact('sopc_users','salesTeam','sopc'));  
    }

    public function storeNotificationSettings(Request $request){
        $validator = Validator::make($request->all(), [
            'users'     => 'required',
            'sopc_id'     => 'required'
        ],[
            'users.required' => 'This field is required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sopc_id = $request->sopc_id;
        SopcUsers::where('sopc_id', $sopc_id)->delete();

        $notify = [];
        foreach($request->users as $user){
            $notify[] = [
                'user_id' => $user,
                'sopc_id' => $sopc_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        
        if(!empty($notify)){
            SopcUsers::insert($notify);
        }
        return redirect()->route('sopc.index')->with(['success' => "Notification settings updated succesfully"]);
    }

    public function timeline(string $id){
        $sopc = SopcReports::find($id);
        $timeline = SopcTimelines::with(['updatedBy'])->where('sopc_id',$id)->orderBy('created_at','ASC')->get()->toArray();

        return view('admin.sopc.timeline',compact('timeline','sopc'));  
    }

    public function sopcStatus(string $id){
        $sopc = SopcReports::find($id);
        $items = SopcItems::with(['updatedUser'])->where('sopc_id',$id)->get()->toArray();
        return view('admin.sopc.status',compact('items','sopc')); 
    }

    public function storeStatus(Request $request){
        $remarks = $request->remark;
        $sopc_id = $request->sopc_id;
        $status = ($request->has('status')) ? $request->status : [];

        $updatedUser = $request->user;
        $updatedDate = $request->date;
     
        if(!empty($remarks)){
            $data = [];
            foreach($remarks as $key => $rem){
                $item_id    = explode('-',$key);
                $id         = $item_id[0];
                $line_no    = $item_id[1];
                $updUser = ($updatedUser[$key] != NULL) ? $updatedUser[$key] : Auth::user()->id;
                $updDate = ($updatedUser[$key] != NULL) ? date('Y-m-d H:i:s', strtotime($updatedDate[$key])) : date('Y-m-d H:i:s');
                $data[] = [
                        'id'        => $id,
                        'sopc_id'   => $sopc_id,
                        'line_no'   => $line_no,
                        'status'    => array_key_exists($key, $status) ? 1 : 0,
                        'updated_by' => (array_key_exists($key, $status) || $rem != '') ? $updUser : NULL,
                        'updated_at' => (array_key_exists($key, $status) || $rem != '') ? $updDate : NULL,
                        'remark'    => $rem, 
                    ];
            }
            SopcItems::upsert($data,['id'],['status','remark','updated_by']);
        }

        $checkItems = SopcItems::where('sopc_id',$sopc_id)->where('status',0)->where('is_cancelled',0)->count();
        
        if($checkItems == 0){
            $salesNotify = [];
            $sopcReport = SopcReports::find($sopc_id);

            $mailContent['subject'] = 'SO Number : '.$sopcReport->so_number.' Lines Completed.';
            $mailContent['message'] = ['All Lines for SO Number : <b>'.$sopcReport->so_number.'</b> is completed.'];

            SopcTimelines::create([
                'sopc_id' => $sopc_id, 
                'content' =>  $mailContent['message'][0], 
                'updated_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $notify_users = User::where('user_type',4)->where('is_deleted',0)->where('is_active',1)
                                ->get()->toArray();

            foreach($notify_users as $notuser){
                if($notuser['email_notification'] == 1){
                    dispatch(new SendMail($notuser,$mailContent));
                }
                $salesNotify[] = [
                    'user_id' => $notuser['id'],
                    'content' => $mailContent['message'][0] ?? '',
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            if(!empty($salesNotify)){
                Notifications::insert($salesNotify);
            }
        }

        return redirect()->back()->with(['success' => "Status updated succesfully"]);
    }

    public function cron(){
        
        // DB::enableQueryLog();
        $reports = SopcReports::whereNotIn('job_status',['4','5'])
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->get();

        $not = [];
        if($reports){
            $notification = [];
            foreach($reports as $pack){
                $mach_date = $pack->machining;
                if($mach_date != ''){
                    $machdiff =  strtotime($mach_date)-strtotime(date("Y-m-d"));
                    $machdays = round($machdiff / (60 * 60 * 24));
                    if($machdays == 1){
                        $notification[] = "Machining date for SO Number: <b>".$pack->so_number."</b> is due on tomorrow.";
                    }
                }

                $heat_date = $pack->heat_treatment;
                if($heat_date != ''){
                    $heatdiff =  strtotime($heat_date)-strtotime(date("Y-m-d"));
                    $heatdays = round($heatdiff / (60 * 60 * 24));
                    if($heatdays == 1){
                        $notification[] = "Heat treatment date for SO Number: <b>".$pack->so_number."</b> is due on tomorrow.";
                    }
                }

                echo '<br><br>target_date == '. $target_date = $pack->target_date;
                if($target_date != ''){
                    $targetdiff =  strtotime($target_date)-strtotime(date("Y-m-d"));
                    $targetdays = round($targetdiff / (60 * 60 * 24));
                    if($targetdays == 1){
                    $notification[] = "Target date for SO Number: <b>".$pack->so_number."</b> is due on tomorrow.";
                    }
                }
            }
            if(!empty($notification)){
                echo '<pre>';
                print_r($notification);
                die;
                $notify = [];

                $mailContent['subject'] = "Tomorrow's due dates";
                $mailContent['message'] = $notification;

                $notify_users = User::where('user_type','3')->where('is_deleted',0)->where('is_active',1)->get()->toArray();

                foreach($notify_users as $notuser){
                    foreach($notification as $not){
                        $notify[] = [
                            'user_id' => $notuser['id'],
                            'content' => $not,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                    }
                    // dispatch(new SendMail($notuser,$mailContent));
                }

                if(!empty($notify)){
                    // Notifications::insert($notify);
                }
            }
        }
        // dd(DB::getQueryLog());
     
    }

    public function cancelLine(Request $request){
        $lineId = $request->id;
        $userId = Auth::user() ? Auth::user()->id : '';
        $sopc_id = $request->sopc_id;
        $line_no = $request->line_no;

        if($lineId != '' && $sopc_id != ''){
            $updateItem = SopcItems::where('id',$lineId)->update(['is_cancelled'=>1, 'updated_by'=>$userId, 'updated_at'=>date("Y-m-d h:i:s")]); 
            $report = SopcReports::find($sopc_id);
            $oldQty = $report->total_items;
            $so_number = $report->so_number;
            $report->total_items = $oldQty - 1;
            $report->save();

            SopcTimelines::create([
                'sopc_id' => $sopc_id, 
                'content' =>  'Line Number : <b>'.$line_no.'</b> for SO Number : <b>'.$so_number.'</b> is cancelled', 
                'updated_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function addNewLine(Request $request){
        $count = $request->count;
        $sopc_id = $request->sopc_id;

        if($count != 0){
            $lastItem = SopcItems::where('sopc_id', $sopc_id)->orderBy('id','desc')->limit(1)->pluck('line_no')->toArray();
            $lastLineNumber = $lastItem[0] ?? 0;
            
            $items = [];
            for($i = 1; $i <= $count; $i++){
                $items[] = [
                    'line_no' => $lastLineNumber + 1,
                    'sopc_id' => $sopc_id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $lastLineNumber++;
            }
            SopcItems::insert($items);

            $report = SopcReports::find($sopc_id);
            $oldQty = $report->total_items;
            $report->total_items = $oldQty + $count;
            $report->save();
        }
    }

}