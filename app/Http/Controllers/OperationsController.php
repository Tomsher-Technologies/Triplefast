<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserTypes;
use App\Models\Operations;
use App\Models\JobCardOperations;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Validator;
use Storage;
use Str;
use File;
use Hash;
use DB;

class OperationsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:operation-list|operation-create|operation-edit|operation-delete', ['only' => ['index','store']]);
        $this->middleware('permission:operation-create', ['only' => ['create','store']]);
        $this->middleware('permission:operation-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:operation-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_term =  $status_search = '';
        if ($request->has('keyword')) {
            $search_term = $request->keyword;
        }
        if ($request->has('status')) {
            $status_search = $request->status;
        }
       
        $query = Operations::where('is_deleted',0);
        if($search_term){
            $query->Where(function ($query) use ($search_term) {
                $query->orWhere('operation_id', 'LIKE', "%$search_term%")
                ->orWhere('description', 'LIKE', "%$search_term%");   
            }); 
        }

        if($status_search != ''){
            $query->where('is_active', $status_search);
        }

        $data = $query->orderBy('id','DESC')->paginate(10);
        
        return view('admin.operations.index',compact('data','search_term', 'status_search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.operations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operation_id' => 'required|unique:operations,operation_id',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $op = new Operations;
        $op->operation_id = $request->operation_id;
        $op->description = $request->description;
        $op->save();
        
        if($op->id){
            return redirect()->route('operations.index')->with('success','Operation created successfully');
        }else{
            return redirect()->route('operations.index')->with('error','Error while adding operation.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $operation = Operations::find($id);
        return view('admin.operations.edit',compact('operation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'operation_id' => 'required|unique:operations,operation_id,'.$id,
            'description' => 'required',
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $op = Operations::find($id);
        $op->operation_id = $request->operation_id;
        $op->description = $request->description;
        $op->is_active = $request->is_active;
        $op->save();

        return redirect()->route('operations.index')->with('success','Operation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $checkAssigned = JobCardOperations::where('job_operation_id', $id)->where('is_deleted',0)->count();
        if($checkAssigned == 0){
            Operations::where('id',$id)->update(['is_deleted' => 1]);
            echo 1;
        }else{
            echo 0;
        }
       
    }

    public function createBulkOperations(){
        return view('admin.operations.bulk_create');
    }

    public function storeBulkOperations(Request $request){
        $validator = Validator::make($request->all(), [
            'operations_file' => 'required|mimes:xlsx, csv, xls'
        ]);
       
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $operations = Operations::where('is_deleted',0)->get()->pluck('operation_id')->toArray();
       
        $the_file = $request->file('operations_file');
        
        $notFound = [];
        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet        = $spreadsheet->getActiveSheet();
        $row_limit    = $sheet->getHighestDataRow();
        $column_limit = $sheet->getHighestDataColumn();
        $row_range    = range( 2, $row_limit );
        $data = array();

        foreach ( $row_range as $row ) {
            $dob = '';
            $operation_id = trim($sheet->getCell( 'B' . $row )->getValue());
            if($operation_id != ''){
                if(!in_array($operation_id, $operations)){
                    $description = $sheet->getCell( 'A' . $row )->getValue();
                    $data[] = [
                        'operation_id' => $operation_id,
                        'description' => $description
                    ];
                }else{
                    $notFound[] = $operation_id;
                }
            }
        }
        $warning = '' ;
        if(!empty($notFound)){
            $warning .= "The following Operation Ids were already saved in the system ( ".implode(', ',$notFound)." )";
        }

        if(!empty($data)){
            Operations::insert($data);
            if($warning != ''){
                return redirect()->route('operations.index')->with('success', 'Successfully uploaded!')->with('warning',$warning);
            }else{
                return redirect()->route('operations.index')->with('success','Successfully uploaded!');
            }
        }else{
            if($warning != ''){
                return redirect()->route('operations.index')->with(['error' => "No data uploaded", 'warning' => $warning]);
            }else{
                return redirect()->route('operations.index')->with('error',"No data uploaded");
            }
        }
    }
}
