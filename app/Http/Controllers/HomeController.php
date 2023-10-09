<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\SalesOrders;
use App\Models\Customers;
use App\Models\Notifications;
use App\Models\SopcReports;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Hash;

class HomeController extends Controller
{
    public function dashboard()
    {
        if(Auth::check()){
            $customers = Customers::where('is_deleted',0)->count();
            
            $partial = SopcReports::where('job_status',2)->where('is_deleted',0)->count();
            $hold = SopcReports::where('job_status',3)->where('is_deleted',0)->count();
            $completed = SopcReports::where('job_status',4)->where('is_deleted',0)->count();
            $cancelled = SopcReports::where('job_status',5)->where('is_deleted',0)->count();

            return view('admin.dashboard', compact('customers','partial','hold','completed','cancelled'));
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function setSuperAdminPermissions(){
        $user = User::where('user_type',1)->first();
        $permissions = Permission::pluck('id','id')->all();
        setPermissionsTeamId(1);
        $user->syncPermissions($permissions);
        echo 'super admin permissions successfully set';
    }

    public function notifications(Request $request){
        $userId = Auth::user()->id; 

        $date_search = '';
        if($request->has('date_search')){
            $date_search = $request->date_search;
        }
        
        $query = Notifications::where('user_id', $userId)->orderBy('created_at','desc');
        
        if($date_search){
            $query->whereDate('created_at', date('Y-m-d', strtotime($request->date_search)));
        }
        $notifications = $query->paginate(15);
        Notifications::where('user_id', $userId)->where('is_read',0)->update(['is_read' => 1]);
        return view('admin.notifications', compact('notifications','date_search'));
    }
}
