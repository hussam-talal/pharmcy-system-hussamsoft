<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Account;
use App\Models\Treasuries_transactions;
use App\Models\Admin_panel_setting;
use App\Models\Customer;
use App\Http\Requests\repcustomersRequest;
use App\Models\Sales_invoices;


class repcustomers extends Controller
{
    //
    public function index()
    {
   
        $com_code = auth()->user()->com_code;
        $customer = get_cols_where(new Customer(), array('customer_code', 'name'), array('com_code' => $com_code), 'id', 'DESC');
    return view('repcustomers.index',['customer'=>   $customer]);
    }


    public function create( repcustomersRequest $request)
    {
       $code_cus=$request->input('customer_code');
       $order_date_form=date($request->input('order_date_form'));
       $order_date_to=date($request->input('order_date_to'));
       $name_cus=Customer::where('customer_code',$code_cus)->value('name'); 
       $account_number=Account::where('name',$name_cus)->value('account_number'); 
         
//if( ($request->suuplier_code =='all')&& empty($request->order_date_form)&& empty($request->order_date_to)){
   // return redirect()->route('repsuppliers.index');}

       //)->whereBetween('created_at',[$order_date_form,$order_date_to])
    //return view('repsuppliers.creat',['name_sup'=>   $name_sup,'trans'=>$trans,'account_number'=>   $account_number]);}
    
 //else {
    $sale=Sales_invoices::select("*")->where('customer_code',"=",$code_cus)->whereBetween('invoice_date',[$order_date_form,$order_date_to])->get();

    
    $tt=Treasuries_transactions::select("*")->where('account_number',"=",$account_number)->whereBetween('move_date',[$order_date_form,$order_date_to])->get();
    $trans=collect($sale)->merge($tt);
    
return view('repcustomers.creat',['name_cus'=>$name_cus,'sale'=>$sale,'trans'=>$trans,'account_number'=>$account_number,'order_date_form'=>$order_date_form,'order_date_to'=>$order_date_to,'code_cus'=>$code_cus]);

}

      
    public function print($id,$size,$order_date_form,$order_date_to,$code_cus){


        try {
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new Treasuries_transactions(), array("*"), array("account_number" => $id, "com_code" => $com_code, ));
           // $data=Treasuries_transactions::select("*")->where('account_number',"=",$id)->whereBetween('move_date',[$order_date_form,$order_date_to])->get();
            if (empty($data)) {
            return redirect()->route('repcustomers.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
            }
            $data['added_by_admin'] = User::where('id', $data['added_by'])->value('name');
            $data['customer_name'] = Customer::where('account_number', $data['account_number'])->value('name');
            $data['customer_phone'] = Customer::where('customer_code', $data['account_number'])->value('phones');
            
            
            //$details = get_cols_where(new Treasuries_transactions(), array("*"),array("account_number" => $id, "com_code" => $com_code,), 'id', 'DESC');
           // $=Treasuries_transactions::select("*")->where('account_number',"=",$id)->whereBetween('move_date',[$order_date_form,$order_date_to])->where("com_code","=",$com_code)->get();
            $tt=Treasuries_transactions::select("*")->where('account_number',"=",$id)->whereBetween('move_date',[$order_date_form,$order_date_to])->get();
            $sale=Sales_invoices::select("*")->where('customer_code',"=",$code_cus)->whereBetween('invoice_date',[$order_date_form,$order_date_to])->get();
           $details=collect($tt)->merge($sale);
    
            $systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
            
            if($size=="A4"){
                return view('repcustomers.print',['data'=>$data,'systemData'=>$systemData,'details'=>$details]);
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
    }  
   

}
