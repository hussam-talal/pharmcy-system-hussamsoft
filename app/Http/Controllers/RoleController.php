<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use app\Models\User;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{

    // function __construct()
    // {
    
    // $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
    // $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
    // $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
    // $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
    
    // }

    public function index()
    {
        $title = "user Roles";
        $roles = Role::with('permissions')->get();
        $permissions = Permission::get();
        return view('roles.index',compact(
            'title','roles','permissions'
        ));
    }

    public function create()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    $permission = Permission::get();
    return view('roles.create',compact('permission'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'role'=>'required|max:100',
            'permission'=>'required'
        ]);
        $role = Role::create(['name' => $request->role]);
        $permissions = $request->permission;
        $role->syncPermissions($permissions);

        // $notification = array(
        //     'message'=>"Role Created Successfully!!",
        //     'alert-type'=>"success"
        // );
        return redirect()->route('roles.index')
         ->with('success','Role Created successfully');
        //return back()->with($notification);
    }

    
    public function show($id)
    {
    $role = Role::find($id);
    $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
    ->where("role_has_permissions.role_id",$id)
    ->get();
    return view('roles.show',compact('role','rolePermissions'));
    }
  
    
    public function edit($id)
    {
    $role = Role::find($id);
    $permission = Permission::get();
    $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
    ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
    return view('roles.edit',compact('role','permission','rolePermissions'));
    }
    /**
  
    */
    public function update(Request $request, $id)
    {
    $this->validate($request, [
    'name' => 'required',
    'permission' => 'required',
    ]);
    $role = Role::find($id);
    $role->name = $request->input('name');
    $role->save();
    $role->syncPermissions($request->input('permission'));
    return redirect()->route('roles.index')
    ->with('success','Role updated successfully');
    }
    
   
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete($id,Request $request)
    {
        $role = Role::find($id);
        $role->delete();
        $notification = array(
            'message'=>"Role deleted successfully!!.",
            'alert-type'=>'success'
        );
        return back()->with("successfully");
    }
}


