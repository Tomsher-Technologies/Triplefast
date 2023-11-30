<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserTypes;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Validator;
use Storage;
use Str;
use File;
use Hash;
use DB;
    
class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        // $this->middleware(function ($request, $next) {
        //     if(Auth::user()->user_type != 'superd_admin'){
                
        //         return $next($request);
        //     }else{
        //         return $next($request);
        //     }
            
        // });

        $this->middleware('permission:user-list|user-create|user-edit|user-delete|user-view', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-view', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_term =  $status_search = $team_search = '';
        if ($request->has('keyword')) {
            $search_term = $request->keyword;
        }
        if ($request->has('status')) {
            $status_search = $request->status;
        }
        if ($request->has('team')) {
            $team_search = $request->team;
        }
        $query = User::with(['user_details','userType'])
                    ->where('user_type', '!=',1)
                    ->where('is_deleted',0);
        if($search_term){
            $query->Where(function ($query) use ($search_term) {
                $query->orWhere('users.name', 'LIKE', "%$search_term%")
                ->orWhere('users.email', 'LIKE', "%$search_term%")
                ->orWhereHas('user_details', function ($query)  use($search_term) {
                    $query->where('phone_number', 'LIKE', "%$search_term%");
                });   
            }); 
        }

        if($team_search){
            $query->where('users.user_type', $team_search);
        }

        if($status_search != ''){
            $query->where('users.is_active', $status_search);
        }

        $data = $query->orderBy('id','DESC')->paginate(10);
        $user_types = UserTypes::where('is_active',1)->orderBy('type', 'ASC')->get();
        return view('admin.users.index',compact('data','user_types','search_term','team_search','status_search'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_types = UserTypes::where('is_active',1)->orderBy('type', 'ASC')->get();
        return view('admin.users.create',compact('user_types'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:confirm-password',
            'role' => 'required',
            'user_type' => 'required',
            'confirm-password' => 'required',
            'phone_number' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User;
        $user->user_type = $request->user_type;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_notification = ($request->has('notification')) ? 1 : 0;
        $user->save();
        $userId = $user->id;
        setPermissionsTeamId($request->user_type);
        $user->assignRole($request->role);

        if($userId){
            $profileImage = NULL;
            if ($request->hasFile('profile_image')) {
                $uploadedFile = $request->file('profile_image');
                $filename =    strtolower(Str::random(2)).time().'.'. $uploadedFile->getClientOriginalName();
                $name = Storage::disk('public')->putFileAs(
                    'users/'.$userId,
                    $uploadedFile,
                    $filename
                );
               $profileImage = Storage::url($name);
            } 
            

            $uDetails = new UserDetails();
            $uDetails->user_id = $user->id;
            $uDetails->first_name = $request->name;
            $uDetails->phone_number = $request->phone_number;
            $uDetails->profile_image = $profileImage;
            $uDetails->save();
        }
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $user = User::with(['user_details','userType'])->find($id);
        $viewdata = view('admin.users.show', compact('user'))->render();
        return $viewdata;
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with(['user_details','userType'])->find($id);
        $roles = Role::where('type', $user->user_type)->orderBy('name', 'ASC')->get()->toArray();
        setPermissionsTeamId($user->user_type);
        $userRole = $user->roles->pluck('id')->all();
       
        $user_types = UserTypes::where('is_active',1)->orderBy('type', 'ASC')->get();
        return view('admin.users.edit',compact('user','roles','userRole','user_types'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6',
            'role' => 'required',
            'user_type' => 'required',
            'phone_number' => 'nullable|numeric',
            'is_active' => 'required'
        ]);

        // echo '<pre>';
        // print_r($request->all());
        // die;
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::with(['user_details'])->find($id);
        $user->user_type = $request->user_type;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_notification = ($request->has('notification')) ? 1 : 0;
        if($request->password != ''){
            $user->password = Hash::make($request->password);
        }

        $presentLogo = $user->user_details->profile_image;
        $logo = '';
        if ($request->hasFile('profile_image')) {
            $uploadedFilel = $request->file('profile_image');
            $filenamel =    strtolower(Str::random(2)).time().'.'. $uploadedFilel->getClientOriginalName();
            $namel = Storage::disk('public')->putFileAs(
                'users/'.$id,
                $uploadedFilel,
                $filenamel
            );
            $logo = Storage::url($namel);
            if($presentLogo != '' && File::exists(public_path($presentLogo))){
                unlink(public_path($presentLogo));
            }
        } 

        $user->is_active = $request->is_active;
        $user->save();
        $userId = $user->id;
        
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        setPermissionsTeamId($request->user_type);
        $user->assignRole($request->role);

        $datas = [
            'first_name' => $request->name,
            'phone_number' => $request->phone_number,
            'profile_image' => ($logo != '') ? $logo : $presentLogo
        ];
        UserDetails::where('user_id', $userId)->update($datas);
    
        return redirect()->route('users.index')->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        User::where('id',$id)->update(['is_deleted' => 1]);
    }

    public function rolesAjax(Request $request){
        $type = $request->type;
        $roles = Role::where('type', $type)->orderBy('name', 'ASC')->get()->toArray();
        $html = '<option value="">Select</option>';
        if($roles){
            foreach($roles as $role){
                $html .= '<option value="'.$role['id'].'">'.$role['name'].'</option>';
            }
        }
        return $html;
    }
}