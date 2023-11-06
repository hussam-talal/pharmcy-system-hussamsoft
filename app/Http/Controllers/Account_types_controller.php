<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account_types;
class Account_types_controller extends Controller
{
public function index()
{
$data=get_cols(new Account_types(),array("*"),'relatediternalaccounts','ASC');
return view('account_types.index', ['data' => $data]);
}
}