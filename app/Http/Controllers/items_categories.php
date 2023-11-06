<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\items_categorie;
use App\Models\User;
use App\Http\Requests\items_categoriesRequest;
class items_categories extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
$data=items_categorie::select()->orderby('id','DESC')->paginate(PAGINATION_COUNT); 
if(!empty($data)){
foreach($data as $info){
$info->added_by_admin=User::where('id',$info->added_by)->value('name');    
if($info->updated_by>0 and $info->updated_by!=null){
$info->updated_by_admin=User::where('id',$info->updated_by)->value('name');    
}
}
}
return view('items_categories.index',['data'=>$data]);    
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
return view('items_categories.create');
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(items_categoriesRequest $request){
try{
$com_code=auth()->user()->com_code;
//check if not exsits
$checkExists=items_categorie::where(['name'=>$request->name,'com_code'=>$com_code])->first();
if($checkExists==null){
$data['name']=$request->name;
$data['active']=$request->active;
$data['created_at']=date("Y-m-d H:i:s");
$data['added_by']=auth()->user()->id;
$data['com_code']=$com_code;
$data['date']=date("Y-m-d");
items_categorie::create($data);
return redirect()->route('items_categories.index')->with(['success'=>'لقد تم اضافة البيانات بنجاح']);
}else{
return redirect()->back()
->with(['error'=>'عفوا اسم الفئة مسجل من قبل'])
->withInput(); 
}
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
->withInput();           
}
} 
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
//
}
public function edit($id){
$data=items_categorie::select()->find($id);
return view('items_categories.edit',['data'=>$data]);
}         
public function update($id,items_categoriesRequest $request){
try{
$com_code=auth()->user()->com_code;
$data=items_categorie::select()->find($id);
if(empty($data)){
return redirect()->route('items_categories.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$checkExists=items_categorie::where(['name'=>$request->name,'com_code'=>$com_code])->where('id','!=',$id)->first();
if( $checkExists!=null){
return redirect()->back()
->with(['error'=>'عفوا اسم الخزنة مسجل من قبل'])
->withInput(); 
}
$data_to_update['name']=$request->name;
$data_to_update['active']=$request->active;
$data_to_update['updated_by']=auth()->user()->id;
$data_to_update['updated_at']=date("Y-m-d H:i:s");
items_categorie::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
return redirect()->route('items_categories.index')->with(['success'=>'لقد تم تحديث البيانات بنجاح']);
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
->withInput();           
}
}    
/*
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destory(){
}
public function delete($id){
try{
$Sales_matrial_types_row=items_categorie::find($id);
if(!empty($Sales_matrial_types_row)){
$flag=$Sales_matrial_types_row->delete();
if($flag){
return redirect()->back()
->with(['success'=>'   تم حذف البيانات بنجاح']);
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