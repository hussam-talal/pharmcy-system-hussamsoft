<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\units;
use App\Models\User;
use App\Http\Requests\UnitsRequest;
use App\Http\Requests\UnitsUpdateRequest;
use App\Models\Sales_invoices_details;
use App\Models\purchases_details;
class UnitsController extends Controller
{
public function index()
{
$data = units::select()->orderby('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = User::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = User::where('id', $info->updated_by)->value('name');
}
}
}
return view('units.index', ['data' => $data]);
}
public function create()
{
return view('units.create');
}
public function store(UnitsRequest $request)
{
try {
$com_code = auth()->user()->com_code;
//check if not exsits
$checkExists = units::where(['name' => $request->name, 'com_code' => $com_code,'is_main'=>$request->is_main])->first();
if ($checkExists == null) {
$data['name'] = $request->name;
$data['is_main'] = $request->is_main;
$data['active'] = $request->active;
$data['created_at'] = date("Y-m-d H:i:s");
$data['added_by'] = auth()->user()->id;
$data['com_code'] = $com_code;
$data['date'] = date("Y-m-d");
units::create($data);
return redirect()->route('units.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} else {
return redirect()->back()
->with(['error' => 'عفوا اسم الوحدة مسجل من قبل'])
->withInput();
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}

public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = units::select()->find($id);
//check if this uom used befor  نتحقق من الوحده هل تم استخدامها بالفعل ام ليس بعد
//check in suppliers_with_orders_details نتحقق من المشتريات
$purchases_detailsCount=get_count_where(new purchases_details(),array('com_code'=>$com_code,'unit_id'=>$data['id']));
//check in Sales_invoices_details نتحقق من المبيعات
$sales_invoices_detailsCount=get_count_where(new Sales_invoices_details(),array('com_code'=>$com_code,'unit_id'=>$data['id']));
$total_counter_used=$purchases_detailsCount+$sales_invoices_detailsCount;
return view('units.edit', ['data' => $data,'total_counter_used'=>$total_counter_used]);
}
public function update($id, UnitsUpdateRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = units::select()->find($id);
if (empty($data)) {
return redirect()->route('units.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$checkExists = units::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
if ($checkExists != null) {
return redirect()->back()
->with(['error' => 'عفوا اسم الوحدة مسجل من قبل'])
->withInput();
}
if($request->has('is_main')){ 
if($request->is_main==""){
return redirect()->back()
->with(['error' => '  عفوا من فضلك اختر نوع الوحدة '])
->withInput();
}
//check if this uom used befor  نتحقق من الوحده هل تم استخدامها بالفعل ام ليس بعد
//check in suppliers_with_orders_details نتحقق من المشتريات
$purchases_detailsCount=get_count_where(new purchases_details(),array('com_code'=>$com_code,'unit_id'=>$data['id']));
//check in Sales_invoices_details نتحقق من المبيعات
$sales_invoices_detailsCount=get_count_where(new Sales_invoices_details(),array('com_code'=>$com_code,'unit_id'=>$data['id']));
$total_counter_used=$purchases_detailsCount+$sales_invoices_detailsCount;
if($total_counter_used==0){
$data_to_update['is_main'] = $request->is_main;
}
}
$data_to_update['name'] = $request->name;
$data_to_update['active'] = $request->active;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
units::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
return redirect()->route('units.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}

public function delete($id)
{
try {
$item_row = units::find($id);
if (!empty($item_row)) {
$flag = $item_row->delete();
if ($flag) {
return redirect()->back()
->with(['success' => '   تم حذف البيانات بنجاح']);
} else {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
} else {
return redirect()->back()
->with(['error' => 'عفوا غير قادر الي الوصول للبيانات المطلوبة']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
public function ajax_search(Request $request){
if($request->ajax()){
$search_by_text=$request->search_by_text;
$is_main_search=$request->is_main_search;
if($search_by_text==''){
$field1="id";
$operator1=">";
$value1=0;
}else{
$field1="name";
$operator1="LIKE";
$value1="%{$search_by_text}%";
}
if($is_main_search=='all'){
$field2="id";
$operator2=">";
$value2=0;
}else{
$field2="is_main";
$operator2="=";
$value2=$is_main_search;
}
$data=units::where($field1,$operator1, $value1)->where($field2,$operator2,$value2)->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = User::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = User::where('id', $info->updated_by)->value('name');
}
}
}
return view('units.ajax_search',['data'=>$data]);
}
}


}