<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Users_treasuries;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use App\Models\Treasuries;
class UserController extends Controller
{
    
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new User(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = User::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = User::where('id', $info->updated_by)->value('name');
}
}
}
return view('users_accounts.index', ['data' => $data]);
}

public function create()
{
$roles = Role::select(['name','id'])->get();
return view('users_accounts.Add_user',compact('roles'));

}

public function store(UserRequest $request)
{
    $com_code = auth()->user()->com_code;
$input = $request->all();
$input['password'] = Hash::make($input['password']);
$input['added_by'] =auth()->user()->id;
$input['com_code'] =$com_code;
$user = User::create($input);
$user ->assignRole($request->input('role'));
return redirect()->route('users_accounts.index')
->with('success','تم اضافة المستخدم بنجاح');
}

public function show($id)
{
$users = User::find($id);
return view('users_accounts.show',compact('users'));
}

public function details($id)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new User(), array("*"), array("id" => $id, 'com_code' => $com_code));
if (empty($data)) {
return redirect()->route('users_accounts.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$data['added_by_admin'] = User::where('id', $data['added_by'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = User::where('id', $data['updated_by'])->value('name');
}
$treasuries = get_cols_where(new Treasuries(), array("id", "name"), array("active" => 1, "com_code" => $com_code), 'id', 'ASC');
$users_treasuries = get_cols_where(new Users_treasuries(), array("*"), array("admin_id" => $id, 'com_code' => $com_code), 'id', 'DESC');
if (!empty($users_treasuries)) {
foreach ($users_treasuries as $info) {
$info->name = Treasuries::where('id', $info->treasuries_id)->value('name');
$info->added_by_admin = User::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = User::where('id', $info->updated_by)->value('name');
}
}
}
return view("users_accounts.details", ['data' => $data, 'users_treasuries' => $users_treasuries, 'treasuries' => $treasuries]);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
public function Add_treasuries_To_User($id,Request $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new User(), array("*"), array("id" => $id, 'com_code' => $com_code));
if (empty($data)) {
return redirect()->route('users_accounts.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
//check if not exists
$users_treasuries_exsits = get_cols_where_row(new Users_treasuries(), array("id"), array("admin_id" => $id,"treasuries_id"=>$request->treasuries_id, 'com_code' => $com_code));
if (!empty($users_treasuries_exsits)) {
return redirect()->route('users_accounts.details',$id)->with(['error' => 'عفوا هذه الخزنة بالفعل مضافة من قبل لهذا المستخدم !!!']);
}
$data_insert['admin_id'] = $id;
$data_insert['treasuries_id'] = $request->treasuries_id;
$data_insert['active'] = 1;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['added_by'] = auth()->user()->id;
$data_insert['com_code'] = $com_code;
$data_insert['date'] = date("Y-m-d");
$flag=insert(new Users_treasuries(),$data_insert);
if($flag){
return redirect()->route('users_accounts.details',$id)->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
}else{
return redirect()->route('users_accounts.details',$id)->with(['error' => 'عفوا حدث خطأ ما من فضلك حاول مرة اخري !!!']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function delete($id,Request $request)
    {
        $users = User::find($id);
        $users->delete();
        $notification = array(
            'message'=>"Role deleted successfully!!.",
            'alert-type'=>'success'
        );
        return back()->with("successfully");
    }
    public function delete_treasuries_delivery($id){
        try{
        $Users_treasuries=Users_treasuries::find($id);
        if(!empty($Users_treasuries)){
        $flag=$Users_treasuries->delete();
        if($flag){
        return redirect()->back()
        ->with(['error'=>'   تم حذف البيانات بنجاح']);
        }else{
        return redirect()->back()
        ->with(['error'=>'عفوا حدث خطأ ما']);
        }
        }else{
        return redirect()->back()
        ->with(['error'=>'عفوا غير قادر الي الوصول للبيانات المطلوبة']);
        }
        }catch(\Exception $ex){
        return redirect()->back()
        ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()]);
        }
        }
}