<?php
namespace App\Http\Controllers\auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\purchases;
use App\Models\User;
use App\Models\purchases_details;
use App\Models\items;
use Carbon\Carbon;
use App\Models\Admin_panel_setting;
use Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\Notification;
use App\Notifications\notificationsToProject;
class LoginController extends Controller
{
public function show_login_view(){
 $systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","photo"));
return view('auth.login',['systemData'=>$systemData]);
}
public function login(LoginRequest $request){
if(auth()->attempt((['username'=>$request->input('username'),'password'=>$request->input('password')])))
{
$com_code = auth()->user()->com_code;
$data = get_cols_where(new purchases(), array("*"), array("com_code" => $com_code,'order_type'=>1,'is_approved'=>1), 'id', 'DESC');
if (!empty($data)) {
$details = get_cols_where(new purchases_details(), array("*"), array( 'order_type' => 1, 'com_code' => $com_code), 'id', 'DESC');
if (!empty($details)) {
foreach ($details as $info) {
$item_card_name = items::where('item_code', $info->item_code)->value('name');
$data['added_by_admin'] = User::where('id',$info->added_by)->value('name');
$expiryDate=Carbon::parse($info->expire_date);
//echo($expiryDate);
$today=Carbon::now();
$daysUntilExpiry=$expiryDate->diffInDays($today);

if ($daysUntilExpiry <= 30) {
    $users=User::all();
    Notification::send($users, new notificationsToProject($item_card_name,$expiryDate));

}

}

}

}

return redirect()->route('dashboard'); 

}else{
return redirect()->route('showlogin'); 
}
}
public function logout(){
auth()->logout();
return redirect()->route('showlogin');
}

}