<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserTypes;
use App\Models\Parts;
use App\Models\SalesOrderParts;
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

class PartsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:parts-list|parts-create|parts-edit|parts-delete', ['only' => ['index','store']]);
        $this->middleware('permission:parts-create', ['only' => ['create','store']]);
        $this->middleware('permission:parts-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:parts-delete', ['only' => ['destroy']]);
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
       
        $query = Parts::where('is_deleted',0);
        if($search_term){
            $query->Where(function ($query) use ($search_term) {
                $query->orWhere('part_number', 'LIKE', "%$search_term%")
                ->orWhere('description', 'LIKE', "%$search_term%");   
            }); 
        }

        if($status_search != ''){
            $query->where('is_active', $status_search);
        }

        $data = $query->orderBy('id','DESC')->paginate(10);
        
        return view('admin.parts.index',compact('data','search_term', 'status_search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.parts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'part_number' => 'required|unique:parts,part_number',
            // 'description' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $part = new Parts;
        $part->part_number = $request->part_number;
        $part->description = $request->description;
        $part->save();
        
        if($part->id){
            return redirect()->route('parts.index')->with('success','Part created successfully');
        }else{
            return redirect()->route('parts.index')->with('error','Error while adding operation.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $part = Parts::find($id);
        return view('admin.parts.edit',compact('part'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'part_number' => 'required|unique:parts,part_number,'.$id,
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $part = Parts::find($id);
        $part->part_number = $request->part_number;
        $part->description = $request->description;
        $part->is_active = $request->is_active;
        $part->save();

        return redirect()->route('parts.index')->with('success','Part details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $check = SalesOrderParts::where('part_id', $id)->where('is_deleted', 0)->count();
        if($check == 0){
            Parts::where('id',$id)->update(['is_deleted' => 1]);
        }
        return $check;
    }

    public function createBulkParts(){
        return view('admin.parts.bulk_create');
    }

    public function storeBulkParts(Request $request){
        $validator = Validator::make($request->all(), [
            'parts_file' => 'required|mimes:xlsx, csv, xls'
        ]);
       
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $parts = Parts::where('is_deleted',0)->get()->pluck('part_number')->toArray();
       
        $the_file = $request->file('parts_file');
        
        $notFound = [];
        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet        = $spreadsheet->getActiveSheet();
        $row_limit    = $sheet->getHighestDataRow();
        $column_limit = $sheet->getHighestDataColumn();
        $row_range    = range( 2, $row_limit );
        $data = array();

        foreach ( $row_range as $row ) {
            $dob = '';
            $part_number = trim($sheet->getCell( 'A' . $row )->getValue());
            if($part_number != ''){
                if(!in_array($part_number, $parts)){
                    $description = $sheet->getCell( 'B' . $row )->getValue();
                    $data[] = [
                        'part_number' => $part_number,
                        'description' => $description
                    ];
                }else{
                    $notFound[] = $part_number;
                }
            }
        }
        $warning = '' ;
        if(!empty($notFound)){
            $warning .= "The following part numbers were already saved in the system ( ".implode(', ',$notFound)." )";
        }

        if(!empty($data)){
            Parts::insert($data);
            if($warning != ''){
                return redirect()->route('parts.index')->with('success', 'Successfully uploaded!')->with('warning',$warning);
            }else{
                return redirect()->route('parts.index')->with('success','Successfully uploaded!');
            }
        }else{
            if($warning != ''){
                return redirect()->route('parts.index')->with(['error' => "No data uploaded", 'warning' => $warning]);
            }else{
                return redirect()->route('parts.index')->with('error',"No data uploaded");
            }
        }
    }

    public function partsAjax(Request $request)
    {
    	$data = [];

        if($request->has('q')){
            $search = $request->q;
           
            $query = Parts::where('is_deleted',0)->where('is_active',1);
           
            if($search){
                $query->Where(function ($query) use ($search) {
                    $query->orWhere('part_number', 'LIKE', "%$search%");   
                }); 
            }           
            $data = $query->orderBy('part_number','ASC')->get();
        }
        return response()->json($data);
    }
}
