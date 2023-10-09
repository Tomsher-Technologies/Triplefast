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
use Illuminate\Support\Facades\Auth;
use Validator;
use Storage;
use Str;
use File;
use Hash;
use DB;

class OrdersController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:order-list|order-create|order-edit|order-delete|order-view', ['only' => ['index','store']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
        $this->middleware('permission:order-view', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search_term =  $status_search = $search_order_date = '';
        if ($request->has('keyword')) {
            $search_term = $request->keyword;
        }
        if ($request->has('status')) {
            $status_search = $request->status;
        }

        if($request->has('order_date')){
            $search_order_date = $request->order_date;
        }
       
        $query = SalesOrders::with(['sales_person','customer'])->where('is_deleted',0);
        if($search_term){
            $query->Where(function ($query) use ($search_term) {
                $query->orWhere('order_no', 'LIKE', "%$search_term%")
                ->orWhere('po_number', 'LIKE', "%$search_term%"); 
                $query->orWhereHas('customer', function ($query)  use($search_term)  {
                    $query->where('custom_id', 'LIKE', "%$search_term%");
                });  
            }); 
        }

        if($status_search != ''){
            $query->where('status', $status_search);
        }

        if($search_order_date != ''){
            $query->where('order_date', $search_order_date);
        }

        $data = $query->orderBy('id','DESC')->paginate(10);
        
        return view('admin.orders.index',compact('data','search_term', 'status_search','search_order_date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $salesTeam = User::where('user_type',4)->where('is_deleted',0)->where('is_active',1)->orderBy('name', 'ASC')->get();
        return view('admin.orders.create',compact('salesTeam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = new SalesOrders();
        $order->order_no        =   $request->order_number;
        $order->customer_id     =   $request->customer_id;
        $order->shipping_id     =   $request->shipping_address;
        $order->order_date      =   date('Y-m-d', strtotime($request->order_date));
        $order->status          =   1;
        $order->need_by_date    =   date('Y-m-d', strtotime($request->need_by_date));
        $order->ship_by_date    =   date('Y-m-d', strtotime($request->ship_by_date));
        $order->po_number       =   $request->po_number;
        $order->sales_person_id =   $request->sales_person;
        $order->terms           =   $request->terms;
        $order->shipping_terms  =   $request->shipping_terms;
        $order->shipping_via    =   $request->shipping_via;
        $order->description     =   $request->description;
        $order->created_by      =   Auth::user()->id;
        $order->save();

        $orderId = $order->id; 

        if ($request->shipping && $orderId) {
            $details = [];
            foreach ($request->shipping as $parts) {
                $details[] = [
                            'order_id'  => $orderId ,
                            'part_id'  => $parts['part_number'] ,
                            'quantity'  => $parts['quantity'] ,
                            'description'  => $parts['part_description'] ,
                            'rev'  => $parts['rev'] ,
                            'need_by_date'  => date('Y-m-d', strtotime($parts['line_need_by_date'])) ,
                            'created_at'  => date('Y-m-d H:i:s')
                        ];
            }

            if(!empty($details)){
                SalesOrderParts::insert($details);
            }
        }
        return redirect()->route('order.index')->with('success','Sales order created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = SalesOrders::with(['sales_person','customer','customer_shipping','order_parts'])
                    ->where('is_deleted',0)
                    ->where('id', $id)->get();
       
        return view('admin.orders.view',compact('order'));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = SalesOrders::with(['sales_person','customer','customer_shipping'])->find($id);
        $custShipAddress = ShippingAddresses::where('customer_id', $order->customer_id)->where('is_deleted',0)->get();
        $parts = SalesOrderParts::with(['part_details'])->where('order_id', $id)->where('is_deleted',0)->get();

        $order_parts = [];

        foreach ($parts as $i) {
            $arr = [];
            $arr['order_part_id'] = $i->id;
            $arr['part_number'] = '<option value="'.$i->part_id.'" selected>'.$i->part_details->part_number.'</option>';
            $arr['quantity'] = $i->quantity;
            $arr['part_description'] = $i->description;
            $arr['rev'] = $i->rev;
            $arr['line_need_by_date'] = date('d-M-Y', strtotime($i->need_by_date));
            $order_parts[] = $arr;
        }

        $order_parts = json_encode($order_parts);
        $salesTeam = User::where('user_type',4)->where('is_deleted',0)->where('is_active',1)->orderBy('name', 'ASC')->get();
        return view('admin.orders.edit',compact('salesTeam','order_parts','order','custShipAddress'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $order = SalesOrders::find($id);
        $order->order_no        =   $request->order_number;
        $order->customer_id     =   $request->customer_id;
        $order->shipping_id     =   $request->shipping_address;
        $order->need_by_date    =   date('Y-m-d', strtotime($request->need_by_date));
        $order->ship_by_date    =   date('Y-m-d', strtotime($request->ship_by_date));
        $order->po_number       =   $request->po_number;
        $order->sales_person_id =   $request->sales_person;
        $order->terms           =   $request->terms;
        $order->shipping_terms  =   $request->shipping_terms;
        $order->shipping_via    =   $request->shipping_via;
        $order->description     =   $request->description;
        $order->updated_by      =   Auth::user()->id;
        $order->save();

        $orderId = $order->id; 
        $partsOld = SalesOrderParts::where('order_id', $id)->where('is_deleted',0)->get();

        $idsOld = $idsNow = [];

        foreach ($partsOld as $i) {
            $idsOld[] = $i->id;
        }
        $details = []; 
        if ($request->shipping && $orderId) {
            foreach ($request->shipping as $add) {
                if($add['order_part_id'] != '' && $add['order_part_id'] != 0){
                    $idsNow[] = $add['order_part_id'];
                    SalesOrderParts::where('id', $add['order_part_id'])->update([
                                                    'part_id'  => $add['part_number'] ,
                                                    'quantity'  => $add['quantity'] ,
                                                    'description'  => $add['part_description'] ,
                                                    'rev'  => $add['rev'] ,
                                                    'need_by_date'  => date('Y-m-d', strtotime($add['line_need_by_date'])) ,
                                                ]);
                }else{
                    $details[] = [
                        'order_id'  => $orderId ,
                        'part_id'  => $add['part_number'] ,
                        'quantity'  => $add['quantity'] ,
                        'description'  => $add['part_description'] ,
                        'rev'  => $add['rev'] ,
                        'need_by_date'  => date('Y-m-d', strtotime($add['line_need_by_date'])) ,
                        'created_at'  => date('Y-m-d H:i:s')
                    ];
                }
            }
            if(!empty($details)){
                SalesOrderParts::insert($details);
            }
        }

        if(!empty($idsOld)){
            $differenceArray = array_diff($idsOld, $idsNow);
            if(!empty($differenceArray)){
                SalesOrderParts::whereIn('id',$differenceArray)->update(['is_deleted' => 1]);
            }
        }
        return redirect()->route('order.index')->with('success','Sales Order details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        SalesOrders::where('id',$id)->update(['is_deleted' => 1,'deleted_by' => Auth::user()->id,'deleted_date' =>date('Y-m-d H:i:s')]);
    }
}
