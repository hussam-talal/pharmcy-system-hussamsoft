<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\User;
use App\Models\purchases;
use App\Models\account;
use App\Models\Treasuries_transactions;
use App\Models\Admin_panel_setting;

use App\Http\Requests\repsuppliersRequest;
class repsuppliers extends Controller
{
    public function index()
    {
   
        $com_code = auth()->user()->com_code;
        $suupliers = get_cols_where(new Supplier(), array('suuplier_code', 'name'), array('com_code' => $com_code), 'id', 'DESC');
    return view('repsuppliers.index',['suupliers'=>   $suupliers]);
    }


    public function create( repsuppliersRequest $request)
    {
       $code_sup=$request->input('suuplier_code');
       $order_date_form=date($request->input('order_date_form'));
       $order_date_to=date($request->input('order_date_to'));
       $name_sup=Supplier::where('suuplier_code',$code_sup)->value('name'); 
       $account_number=account::where('name',$name_sup)->value('account_number'); 
         
//if( ($request->suuplier_code =='all')&& empty($request->order_date_form)&& empty($request->order_date_to)){
   // return redirect()->route('repsuppliers.index');}

  // elseif($request->suuplier_code!='all'&& empty($request->order_date_form)&& empty($request->order_date_to)){
      //  $trans=Treasuries_transactions::select("*")->where('account_number',"=",$account_number)->get();
        // if ($trans['money_for_account']<0) {
        //     foreach ($trans as $value) {
        //         $value->money_for_account;
        //     }
        // }else{
        //     foreach ($trans as $value) {
        //         $value->money_for_account;
        //     }
        // }
       //)->whereBetween('created_at',[$order_date_form,$order_date_to])
    //return view('repsuppliers.creat',['name_sup'=>   $name_sup,'trans'=>$trans,'account_number'=>   $account_number]);}
    
 //else {
    $pursh=purchases::select("*")->where('suuplier_code',"=",$code_sup)->whereBetween('order_date',[$order_date_form,$order_date_to])->get();
    $tt=Treasuries_transactions::select("*")->where('account_number',"=",$account_number)->whereBetween('move_date',[$order_date_form,$order_date_to])->get();
    $trans=collect($pursh)->merge($tt);
return view('repsuppliers.creat',['name_sup'=>   $name_sup,'trans'=>$trans,'account_number'=>   $account_number,'order_date_form'=>   $order_date_form,'order_date_to'=>   $order_date_to,'code_sup'=>$code_sup]);
}

      
    public function print($id,$size,$order_date_form,$order_date_to,$code_sup){


        try {
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new Treasuries_transactions(), array("*"), array("account_number" => $id, "com_code" => $com_code, ));
           // $data=Treasuries_transactions::select("*")->where('account_number',"=",$id)->whereBetween('move_date',[$order_date_form,$order_date_to])->get();
            if (empty($data)) {
            return redirect()->route('repsuppliers.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
            }
            $data['added_by_admin'] = User::where('id', $data['added_by'])->value('name');
            $data['supplier_name'] = Supplier::where('account_number', $data['account_number'])->value('name');
            $data['supplier_phone'] = Supplier::where('suuplier_code', $data['account_number'])->value('phones');
            
            
            //$details = get_cols_where(new Treasuries_transactions(), array("*"),array("account_number" => $id, "com_code" => $com_code,), 'id', 'DESC');
            $tt=Treasuries_transactions::select("*")->where('account_number',"=",$id)->whereBetween('move_date',[$order_date_form,$order_date_to])->where("com_code","=",$com_code)->get();
            $pursh=purchases::select("*")->where('suuplier_code',"=",$code_sup)->whereBetween('order_date',[$order_date_form,$order_date_to])->get();
            $details=collect($tt)->merge($pursh);
            $systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
            
            if($size=="A4"){
                return view('repsuppliers.print',['data'=>$data,'systemData'=>$systemData,'details'=>$details]);
            }
            } catch (\Exception $ex) {
            return redirect()->back()
            ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
            }
            



           
        
        // } else{ try {
        //     $com_code = auth()->user()->com_code;
        //     $data = get_cols_where_row(new Treasuries_transactions(), array("*"), array("account_number" => $id, "com_code" => $com_code, ));

        //     if (empty($data)) {
        //     return redirect()->route('repsuppliers.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
        //     }
        //     $data['added_by_admin'] = User::where('id', $data['added_by'])->value('name');
        //     $data['supplier_name'] = Supplier::where('account_number', $data['account_number'])->value('name');
        //     $data['supplier_phone'] = Supplier::where('suuplier_code', $data['account_number'])->value('phones');
            
            
        //     $details = get_cols_where(new Treasuries_transactions(), array("*"),array("account_number" => $id, "com_code" => $com_code,), 'id', 'DESC');
          
        //     $systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
            
        //     if($size=="A4"){
        //         return view('repsuppliers.print',['data'=>$data,'systemData'=>$systemData,'details'=>$details]);
        //     }
        //     } catch (\Exception $ex) {
        //     return redirect()->back()
        //     ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
        //     }
        //     }
    }       }
            
