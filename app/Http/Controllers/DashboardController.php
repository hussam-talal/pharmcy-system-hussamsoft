<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Admin_panel_setting;
use Illuminate\Http\Request;
use Illuminate\Http\LoginRequest;
use App\Models\User;
class DashboardController extends Controller
{
    public function index(){
        $com_code = auth()->user()->com_code;
        $systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","photo"),array("com_code"=>$com_code));

return view('dashboard',['systemData'=>$systemData]);
    }
}
