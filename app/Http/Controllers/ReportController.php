<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SopcReports;
use App\Models\SopcItems;
use App\Models\SopcTimelines;
use App\Models\SopcUsers;
use App\Models\User;
use App\Models\Notifications;
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
        $search_so_number =  $status_search = '';
        if ($request->has('so_number')) {
            $search_so_number = $request->so_number;
        }
        if ($request->has('status')) {
            $status_search = $request->status;
        }
       
        $query = SopcReports::with(['createdBy'])->where('is_deleted',0);

        if($search_so_number){
            $query->where('so_number', 'LIKE', "%$search_so_number%");
        }

        if($status_search != ''){
            $query->where('job_status', $status_search);
        }

        $data = $query->orderBy('id','DESC')->paginate(15);
       
        return view('admin.sopc.index',compact('data','search_so_number','status_search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sopc.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'so_number'     => 'required',
            'enter_date'    => 'required',
            'issue_date'    => 'required',
            'started_date'  => 'required',
            'due_date'      => 'required',
            'target_date'   => 'required',
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
        $sopc->s1_date          = ($request->s1_date != '') ? date('Y-m-d', strtotime($request->s1_date)) : NULL;
        $sopc->subcon           = ($request->subcon != '') ? date('Y-m-d', strtotime($request->subcon)) : NULL;
        $sopc->stock            = ($request->stock != '') ? date('Y-m-d', strtotime($request->stock)) : NULL;
        $sopc->total_value      = $request->total_value;
        $sopc->created_by       = Auth::user()->id;
        $sopc->save();

        $reportId = $sopc->id;

        $items = [];
        for($i = 1; $i <= $total_items; $i++){
            $items[] = [
                'line_no' => $i,
                'sopc_id' => $reportId,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        $salesTeam = User::where('user_type',4)->where('is_deleted',0)->where('is_active',1)->get();
        $notify = [];
        foreach($salesTeam as $user){
            $notify[] = [
                'user_id' => $user->id,
                'sopc_id' => $reportId,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        SopcItems::insert($items);
        
        if(!empty($notify)){
            SopcUsers::insert($notify);
        }
        SopcTimelines::create([
            'sopc_id' => $reportId, 
            'content' => 'New SOPC report created for SO Number: '.$request->so_number.' with target date <b>'.$request->target_date.'</b>' , 
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
        return view('admin.sopc.view',compact('sopc'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sopc = SopcReports::with(['customer'])->find($id);
        return view('admin.sopc.edit',compact('sopc'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sopc = SopcReports::find($id);

        $old_target         = $sopc->target_date;
        $old_completed_date = $sopc->completed_date;
        $old_job_status     = $sopc->job_status;
        $old_machining_date = $sopc->machining;
        $old_heat_date      = $sopc->heat_treatment;
        $old_s1_date        = $sopc->s1_date;
        $old_subcon         = $sopc->subcon;
        $old_stock          = $sopc->stock;
        $so_num             = $sopc->so_number;

        $target_date    = $request->target_date;
        $completed_date = $request->completed_date;
        $machining      = $request->machining;
        $heat_treatment = $request->heat_treatment;
        $s1_date        = $request->s1_date;
        $subcon         = $request->subcon;
        $stock          = $request->stock;

        $new_target         = ($target_date != '') ? date('Y-m-d', strtotime($target_date)) : NULL;
        $new_completed_date = ($completed_date != '') ? date('Y-m-d', strtotime($completed_date)) : NULL;
        $new_job_status     = $request->job_status;
        $new_machining_date = ($machining != '') ? date('Y-m-d', strtotime($machining)) : NULL;
        $new_heat_date      = ($heat_treatment != '') ? date('Y-m-d', strtotime($heat_treatment)) : NULL;
        $new_s1_date        = ($s1_date != '') ? date('Y-m-d', strtotime($s1_date)) : NULL;
        $new_subcon         = ($subcon != '') ? date('Y-m-d', strtotime($subcon)) : NULL;
        $new_stock          = ($stock != '') ? date('Y-m-d', strtotime($stock)) : NULL;

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
        }

        if($old_machining_date != $new_machining_date){
            if($new_machining_date == ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Machining date removed.' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Machining date for SO Number: <b>'.$so_num.'</b> is removed.' ;
            }else{
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
            if($new_heat_date == ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Heat Treatment date removed.' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Heat Treatment date for SO Number: <b>'.$so_num.'</b> is removed.' ;
            }else{
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Heat Treatment date changed to <b>'.$heat_treatment.'</b>' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Heat Treatment date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$heat_treatment.'</b>';
            }
        }

        if($old_s1_date != $new_s1_date){
            if($new_s1_date == ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'S1 date removed.' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'S1 date for SO Number: <b>'.$so_num.'</b> is removed.' ;
            }else{
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'S1 date changed to <b>'.$s1_date.'</b>' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'S1 date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$s1_date.'</b>';
            } 
        }

        if($old_subcon != $new_subcon){
            if($new_subcon == ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Subcon date removed.' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Subcon date for SO Number: <b>'.$so_num.'</b> is removed.' ;
            }else{
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Subcon date changed to <b>'.$subcon.'</b>' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Subcon date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$subcon.'</b>';
            }
        }

        if($old_stock != $new_stock){
            if($new_stock == ''){
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Stock date removed.' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Stock date for SO Number: <b>'.$so_num.'</b> is removed.' ;
            }else{
                $timeline[] = [
                    'sopc_id' => $id, 
                    'content' => 'Stock date changed to <b>'.$stock.'</b>' , 
                    'updated_by' => Auth::user()->id,
                    'created_at' => $created_at
                ];
                $notifications[] = 'Stock date for SO Number: <b>'.$so_num.'</b> is changed to <b>'.$stock.'</b>';
            }
        }

        if(!empty($timeline)){
            SopcTimelines::insert($timeline);
        }

        if(!empty($notifications)){
            $salesNotify = [];

            $mailContent['subject'] = 'SO Number : '.$so_num.' details updated.';
            $mailContent['message'] = $mailData;


            $notify_users = SopcUsers::with(['salesUser'])->where('sopc_id',$id)->get()->toArray();
           
            foreach($notify_users as $notuser){
                foreach($notifications as $not){
                    $salesNotify[] = [
                        'user_id' => $notuser['sales_user']['id'],
                        'content' => $not,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
                if(!empty($mailData)){
                    dispatch(new SendMail($notuser['sales_user'],$mailContent));
                }
            }

            if(!empty($salesNotify)){
                Notifications::insert($salesNotify);
            }
        }
        
        $sopc->started_date     = ($request->started_date != '') ? date('Y-m-d', strtotime($request->started_date)) : NULL;
        $sopc->due_date         = ($request->due_date != '') ? date('Y-m-d', strtotime($request->due_date)) : NULL;
        $sopc->target_date      = $new_target;
        $sopc->completed_date   = $new_completed_date;

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
        $sopc->updated_by       = Auth::user()->id;
        $sopc->save();

        return redirect()->route('sopc.index')->with(['success' => "SOPC report updated succesfully"]);
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
        $items = SopcItems::where('sopc_id',$id)->get()->toArray();
        return view('admin.sopc.status',compact('items','sopc')); 
    }

    public function storeStatus(Request $request){
        $remarks = $request->remark;
        $sopc_id = $request->sopc_id;
        $status = ($request->has('status')) ? $request->status : [];
     
        if(!empty($remarks)){
            $data = [];
            foreach($remarks as $key => $rem){
                $item_id    = explode('-',$key);
                $id         = $item_id[0];
                $line_no    = $item_id[1];
                $data[] = [
                        'id'        => $id,
                        'sopc_id'   => $sopc_id,
                        'line_no'   => $line_no,
                        'status'    => array_key_exists($key, $status) ? 1 : 0,
                        'updated_by' => Auth::user()->id,
                        'remark'    => $rem, 
                    ];
            }
            SopcItems::upsert($data,['id'],['status','remark']);
        }

        $checkItems = SopcItems::where('sopc_id',$sopc_id)->where('status',0)->count();
        
        if($checkItems == 0){
            $salesNotify = [];
            $notify_users = SopcUsers::with(['salesUser','sopcReport'])->where('sopc_id',$sopc_id)->get()->toArray();
            
            foreach($notify_users as $notuser){
                $mailContent['subject'] = 'SO Number : '.$notuser['sopc_report']['so_number'].' Lines Completed.';
                $mailContent['message'] = ['All Lines for SO Number : '.$notuser['sopc_report']['so_number'].' is completed.'];
                dispatch(new SendMail($notuser['sales_user'],$mailContent));

                $salesNotify[] = [
                    'user_id' => $notuser['sales_user']['id'],
                    'content' => $mailContent['message'][0] ?? '',
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            if(!empty($salesNotify)){
                Notifications::insert($salesNotify);
            }
        }

        return redirect()->route('sopc.index')->with(['success' => "Status updated succesfully"]);
    }
}
