<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserTypes;
use App\Models\Operations;
use App\Models\Customers;
use App\Models\ShippingAddresses;
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

class CustomersController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete|customer-view', ['only' => ['index','store']]);
        $this->middleware('permission:customer-create', ['only' => ['create','store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
        $this->middleware('permission:customer-view', ['only' => ['show']]);
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
       
        $query = Customers::with(['shipping_address'])
                    ->where('is_deleted',0);
        if($search_term){
            $query->Where(function ($query) use ($search_term) {
                $query->orWhere('customers.first_name', 'LIKE', "%$search_term%")
                ->orWhere('customers.email', 'LIKE', "%$search_term%")
                ->orWhere('customers.phone_number', 'LIKE', "%$search_term%")
                ->orWhere('customers.custom_id', 'LIKE', "%$search_term%")
                ->orWhere('customers.address', 'LIKE', "%$search_term%");   
            }); 
        }

        if($status_search != ''){
            $query->where('customers.is_active', $status_search);
        }

        $data = $query->orderBy('id','DESC')->paginate(10);
       
        return view('admin.customers.index',compact('data','search_term','status_search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_id' => 'required|unique:customers,custom_id',
            // 'address' => 'required',
            // 'email' => 'required|email|unique:customers,email',
            // 'phone_number' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $custom = new Customers;
        $custom->first_name = $request->customer_name;
        // $custom->last_name = $request->last_name;
        $custom->custom_id = $request->customer_id;
        $custom->email = $request->email ?? NULL;
        $custom->phone_number = $request->phone_number ?? NULL;
        $custom->address = $request->address ?? NULL;
        $custom->save();
        
        $customerId = $custom->id;

        // if ($request->shipping && $customerId) {
        //     foreach ($request->shipping as $address) {
        //         ShippingAddresses::create([
        //             'customer_id' => $customerId,
        //             'shipping_address' =>  $address['shipping_address']
        //         ]);
        //     }
        // }

        return redirect()->route('customer.index')->with('success','Customer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customers::with(['shipping_address'])
                    ->where('is_deleted',0)
                    ->where('id', $id)->get();
        return view('admin.customers.view',compact('customer'));             
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customers::with(['shipping_address'])->find($id);

        $shipping = ShippingAddresses::where('customer_id', $customer->id)->where('is_deleted',0)->get();

        $shipping_addresses = [];

        foreach ($shipping as $i) {
            $arr = [];
            $arr['shipping_id'] = $i->id;
            $arr['customer_id'] = $i->customer_id;
            $arr['shipping_address'] = $i->shipping_address;
            $shipping_addresses[] = $arr;
        }

        $shipping_addresses = json_encode($shipping_addresses);
        // echo '<pre>';
        // print_r($shipping_addresses);
        // die;

        return view('admin.customers.edit',compact('customer','shipping_addresses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_id' => 'required|unique:customers,custom_id,'.$id,
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $custom =  Customers::find($id);
        $custom->first_name = $request->customer_name;
        $custom->custom_id = $request->customer_id;
        $custom->email = $request->email ?? NULL;
        $custom->phone_number = $request->phone_number ?? NULL;
        $custom->address = $request->address ?? NULL;
        $custom->is_active = $request->status;
        $custom->save();
        
        $customerId = $custom->id;

        // $shippingOld = ShippingAddresses::where('customer_id', $id)->where('is_deleted',0)->get();

        // $idsOld = $idsNow = [];

        // foreach ($shippingOld as $i) {
        //     $idsOld[] = $i->id;
        // }

        // if ($request->shipping && $customerId) {
        //     foreach ($request->shipping as $add) {
        //         if($add['shipping_id'] != '' && $add['shipping_id'] != 0){
        //             $idsNow[] = $add['shipping_id'];
        //             ShippingAddresses::where('id', $add['shipping_id'])->update(['shipping_address' => $add['shipping_address']]);
        //         }else{
        //             ShippingAddresses::create([
        //                 'customer_id' => $customerId,
        //                 'shipping_address' =>  $add['shipping_address']
        //             ]);
        //         }
        //     }
        // }
        // if(!empty($idsOld)){
        //     $differenceArray = array_diff($idsOld, $idsNow);
        //     if(!empty($differenceArray)){
        //         ShippingAddresses::whereIn('id',$differenceArray)->update(['is_deleted' => 1]);
        //     }
        // }
        return redirect()->route('customer.index')->with('success','Customer details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Customers::where('id',$id)->update(['is_deleted' => 1]);
    }

    public function customerAjax(Request $request)
    {
    	$data = [];

        if($request->has('q')){
            $search = $request->q;
           
            $query = Customers::where('is_deleted',0)->where('is_active',1);
           
            if($search){
                $query->Where(function ($query) use ($search) {
                    $query->orWhere('first_name', 'LIKE', "%$search%")
                    ->orWhere('custom_id', 'LIKE', "%$search%");   
                }); 
            }           
            $data = $query->orderBy('first_name','ASC')->get();
        }
        return response()->json($data);
    }

    public function getCustomerAddresses(Request $request){
        $id = $request->id;
        $addresses = ShippingAddresses::where('customer_id', $id)->where('is_deleted',0)->orderBy('id', 'ASC')->get();

        $options = '';
        foreach($addresses as $div){
            $options .= '<option value="'.$div->id.'">'.$div->shipping_address.'</option>';
        }
        return $options;
    }

    public function createBulkCustomers(){
        return view('admin.customers.bulk_create');
    }

    public function storeBulkCustomers(Request $request){
        $validator = Validator::make($request->all(), [
            'customers_file' => 'required|mimes:xlsx, csv, xls'
        ],[
            'customers_file.required'=>'File is required!',
        ]);
       
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $the_file = $request->file('customers_file');
        $customers = Customers::where('is_deleted',0)->get()->pluck('custom_id')->toArray();
        
        $notFound = [];
        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet        = $spreadsheet->getActiveSheet();
        $row_limit    = $sheet->getHighestDataRow();
        $column_limit = $sheet->getHighestDataColumn();
        $row_range    = range( 2, $row_limit );
        $data = array();

        foreach ( $row_range as $row ) {
            $customerId = trim($sheet->getCell( 'B' . $row )->getValue());
            if($customerId != ''){
                if(!in_array($customerId, $customers)){
                    $data[] = [
                        'first_name' => $sheet->getCell( 'A' . $row )->getValue(),
                        'custom_id' => $customerId,
                        'email' => $sheet->getCell( 'C' . $row )->getValue() ?? NULL,
                        'phone_number' => $sheet->getCell( 'D' . $row )->getValue() ?? NULL,
                        'address' => $sheet->getCell( 'E' . $row )->getValue() ?? NULL
                    ];
                }else{
                    $notFound[] = $customerId;
                }
            }
        }
        $warning = '' ;
        if(!empty($notFound)){
            $warning .= "The following Customer Id's were already saved in the system ( ".implode(', ',$notFound)." )";
        }

        if(!empty($data)){
            Customers::insert($data);
            if($warning != ''){
                return redirect()->route('customer.index')->with('success', 'Successfully uploaded!')->with('warning',$warning);
            }else{
                return redirect()->route('customer.index')->with('success','Successfully uploaded!');
            }
        }else{
            if($warning != ''){
                return redirect()->route('customer.index')->with(['error' => "No data uploaded", 'warning' => $warning]);
            }else{
                return redirect()->route('customer.index')->with('error',"No data uploaded");
            }
        }
    }
}
