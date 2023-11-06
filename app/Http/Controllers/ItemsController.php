<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\items;
use App\Models\User;
use App\Models\items_categorie;
use App\Models\units;
use App\Http\Requests\ItemcardRequest;
use App\Http\Requests\ItemcardRequestUpdate;
use App\Models\items_movements;
use App\Models\Sales_invoices;
use App\Models\Sales_invoices_details;
use App\Models\purchases_details;
use App\Models\items_movements_categories;
use App\Models\items_movements_types;
use App\Models\Store;
use App\Models\Alternativemedicine;
class ItemsController extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new items(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = get_field_value(new User(), 'name', array('id' => $info->added_by));
$info->items_categories_name = get_field_value(new items_categorie(), 'name', array('id' => $info->items_categories_id));
$info->unit_name = get_field_value(new units(), 'name', array('id' => $info->unit_id));
$info->retail_units_name = get_field_value(new units(), 'name', array('id' => $info->retail_units_id));
$info->alternative_medicine_name = get_field_value(new Alternativemedicine(), 'name', array('id' => $info->alternative_medicine_id));
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = get_field_value(new User(), 'name', array('id' => $info->updated_by));
}
}
}
$items_categories = get_cols_where(new items_categorie(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
return view('items.index', ['data' => $data, 'items_categories' => $items_categories]);
}
public function create()
{
$com_code = auth()->user()->com_code;
$items_categories = get_cols_where(new items_categorie(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
$units_parent = get_cols_where(new units(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1, 'is_main' => 1), 'id', 'DESC');
$units_child = get_cols_where(new units(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1, 'is_main' => 0), 'id', 'DESC');
$alternative_medicine = get_cols_where(new Alternativemedicine(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');

//$item_card_data = get_cols_where(new items(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
return view('items.create', ['items_categories' => $items_categories, 'units_parent' => $units_parent, 'units_child' => $units_child,'alternative_medicine'=>$alternative_medicine ]);  //'item_card_data' => $item_card_data
}
public function store(ItemcardRequest $request)
{
try {
$com_code = auth()->user()->com_code;
//set item code for itemcard
$row = get_cols_where_row_orderby(new items(), array("item_code"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['item_code'] = $row['item_code'] + 1;
} else {
$data_insert['item_code'] = 1;
}
//check if not exsits for barcode
if ($request->barcode != '') {
$checkExists_barcode = items::where(['barcode' => $request->barcode, 'com_code' => $com_code])->first();
if (!empty($checkExists_barcode)) {
return redirect()->back()
->with(['error' => 'عفوا باركود الصنف مسجل من قبل'])
->withInput();
} else {
$data_insert['barcode'] = $request->barcode;
}
} else {
$data_insert['barcode'] = "item" . $data_insert['item_code'];
}
//check if not exsits for name
$checkExists_barcode = items::where(['name' => $request->name, 'com_code' => $com_code])->first();
if (!empty($checkExists_barcode)) {
return redirect()->back()
->with(['error' => 'عفوا اسم الصنف مسجل من قبل'])
->withInput();
}
$data_insert['name'] = $request->name;
$data_insert['name1'] = $request->name1;
$data_insert['item_type'] = $request->item_type;
$data_insert['items_categories_id'] = $request->items_categories_id;
$data_insert['unit_id'] = $request->unit_id;
$data_insert['alternative_medicine_id'] = $request->alternative_medicine_id;
$data_insert['price'] = $request->price;
$data_insert['expired'] = $request->expired;
//$data_insert['nos_gomla_price'] = $request->nos_gomla_price;
$data_insert['gomla_price'] = $request->gomla_price;
$data_insert['cost_price'] = $request->cost_price;
$data_insert['retail_units_id'] = $request->retail_units_id;


$data_insert['retail_unit_quntToParent'] = $request->retail_unit_quntToParent;
if ($data_insert['retail_unit_quntToParent']=='') {
    $data_insert['retail_unit_quntToParent']=1; 
}
$data_insert['price_retail'] = $request->price_retail;
//$data_insert['gomla_price_retail'] = $request->gomla_price_retail;
$data_insert['cost_price_retail'] = $request->cost_price_retail;

if ($request->has('Item_img')) {
$request->validate([
'Item_img' => 'required|mimes:png,jpg,jpeg|max:2000',
]);
$the_file_path = uploadImage('assets/uploads', $request->Item_img);
$data_insert['photo'] = $the_file_path;
}
//$data_insert['has_fixced_price'] = $request->has_fixced_price;
$data_insert['active'] = $request->active;
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
items::create($data_insert);
return redirect()->route('items.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}
public function edit($id)
{
$data = get_cols_where_row(new items(), array("*"), array("id" => $id));
$com_code = auth()->user()->com_code;
$items_categories = get_cols_where(new items_categorie(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
$units_parent = get_cols_where(new units(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1, 'is_main' => 1), 'id', 'DESC');
$units_child = get_cols_where(new units(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1, 'is_main' => 0), 'id', 'DESC');
$alternative_medicine = get_cols_where(new Alternativemedicine(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');

//$item_card_data = get_cols_where(new items(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
$counterUsedin_with_purchases = get_count_where(new purchases_details(), array("com_code" => $com_code, "item_code" => $data['item_code']));
$counterUsedin_with_sales = get_count_where(new Sales_invoices_details(), array("com_code" => $com_code, "item_code" => $data['item_code']));
$counterUsedBefore = $counterUsedin_with_purchases + $counterUsedin_with_sales;
return view('items.edit', ['data' => $data, 'items_categories' => $items_categories, 'units_parent' => $units_parent,
 'units_child' => $units_child,'alternative_medicine'=>$alternative_medicine, 'counterUsedBefore' => $counterUsedBefore]);   //'item_card_data' => $item_card_data
}
public function update($id, ItemcardRequestUpdate $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new items(), array("*"), array("id" => $id));
if (empty($data)) {
return redirect()->route('items.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($request->has('item_type')) {
if ($request->item_type == "") {
return redirect()->back()
->with(['error' => 'من فضلك اختر نوع الصنف'])
->withInput();
}
if ($request->item_type == "") {
return redirect()->back()
->with(['error' => 'من فضلك اختر نوع الصنف'])
->withInput();
}
if ($request->unit_id == "") {
return redirect()->back()
->with(['error' => 'من فضلك اختر  الوحدة  الرئيسية'])
->withInput();
}
// if ($request->does_has_retailunit == "") {
// return redirect()->back()
// ->with(['error' => 'من فضلك اختر  هل للصنف وحدة تجزئة'])
// ->withInput();
// }
//if ($request->does_has_retailunit == 1) {
if ($request->retail_units_id == "") {
return redirect()->back()
->with(['error' => 'من فضلك اختر  وحدة القياس التجزئة'])
->withInput();
}
if ($request->retail_unit_quntToParent == "" || $request->retail_unit_quntToParent == 0) {
return redirect()->back()
->with(['error' => 'من فضلك ادخل النسبة مابين الوحدة  الرئيسية  و التجزئة'])
->withInput();
}

}
//check if not exsits for barcode
if ($request->barcode != '') {
$checkExists_barcode = items::where(['barcode' => $request->barcode, 'com_code' => $com_code])->where("id", "!=", $id)->first();
if (!empty($checkExists_barcode)) {
return redirect()->back()
->with(['error' => 'عفوا باركود الصنف مسجل من قبل'])
->withInput();
} else {
$data_insert['barcode'] = $request->barcode;
}
}
//check if not exsits for name
$checkExists_barcode = items::where(['name' => $request->name, 'com_code' => $com_code])->where("id", "!=", $id)->first();
if (!empty($checkExists_barcode)) {
return redirect()->back()
->with(['error' => 'عفوا اسم الصنف مسجل من قبل'])
->withInput();
}
$data_to_update['name'] = $request->name;
$data_to_update['items_categories_id'] = $request->items_categories_id;
$data_to_update['alternative_medicine_id'] = $request->alternative_medicine_id;
$data_to_update['price'] = $request->price;

//$data_to_update['nos_gomla_price'] = $request->nos_gomla_price;
$data_to_update['gomla_price'] = $request->gomla_price;
$data_to_update['cost_price'] = $request->cost_price;
// $data_to_update['parent_inv_itemcard_id'] = $request->parent_inv_itemcard_id;
// if ($data_to_update['parent_inv_itemcard_id'] == "") {
// $data_to_update['parent_inv_itemcard_id'] = 0;
// }
if ($request->has('item_type')) {
$data_to_update['item_type'] = $request->item_type;
$data_to_update['unit_id'] = $request->unit_id;
//$data_to_update['does_has_retailunit'] = $request->does_has_retailunit;

$data_to_update['retail_unit_quntToParent'] = $request->retail_unit_quntToParent;
$data_to_update['retail_units_id'] = $request->retail_units_id;


//$data_to_update['does_has_retailunit'] = $data['does_has_retailunit'];


$data_to_update['price_retail'] = $request->price_retail;
//$data_to_update['nos_gomla_price_retail'] = $request->nos_gomla_price_retail;
//$data_to_update['gomla_price_retail'] = $request->gomla_price_retail;
$data_to_update['cost_price_retail'] = $request->cost_price_retail;
}
if ($request->has('photo')) {
$request->validate([
'photo' => 'required|mimes:png,jpg,jpeg|max:2000',
]);
$oldphotoPath = $data['photo'];
$the_file_path = uploadImage('assets/uploads', $request->photo);
if (file_exists('assets/uploads/' . $oldphotoPath) and !empty($oldphotoPath)) {
unlink('assets/uploads/' . $oldphotoPath);
}
$data_to_update['photo'] = $the_file_path;
}
//$data_to_update['has_fixced_price'] = $request->has_fixced_price;
$data_to_update['active'] = $request->active;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
update(new items(), $data_to_update, array('id' => $id, 'com_code' => $com_code));
return redirect()->route('items.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}
public function delete($id)
{
try {
$com_code = auth()->user()->com_code;
$item_row = get_cols_where_row(new items(), array("id"), array("id" => $id, 'com_code' => $com_code));
if (!empty($item_row)) {
$flag = delete(new items(), array("id" => $id, 'com_code' => $com_code));
if ($flag) {
return redirect()->back()
->with(['success' => '   تم حذف البيانات بنجاح']);
} else {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
} else {
return redirect()->back()
->with(['error' => 'لا يوجد بيانات لحذفها']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
public function show($id)
{
$data = get_cols_where_row(new items(), array("*"), array("id" => $id));
$com_code = auth()->user()->com_code;
$data['added_by_admin'] = get_field_value(new User(), 'name', array('id' => $data['added_by']));
$data['items_categories_name'] = get_field_value(new items_categorie(), 'name', array('id' => $data['items_categories_id']));
$data['alternative_medicine_name'] = get_field_value(new Alternativemedicine(), 'name', array('id' => $data['alternative_medicine_id']));

$data['parent_items_name'] = get_field_value(new items(), 'name', array('id' => $data['parent_items_id']));
$data['units_name'] = get_field_value(new units(), 'name', array('id' => $data['unit_id']));

$data['retail_units_name'] = get_field_value(new units(), 'name', array('id' => $data['retail_units_id']));

if ($data['updated_by'] > 0 and $data['updated_by']  != null) {
$data['updated_by_admin'] = get_field_value(new User(), 'name', array('id' => $data['updated_by']));
}
$items_movements_categories = get_cols(new items_movements_categories(), array("*"), "id", "ASC");
$items_movements_types = get_cols(new items_movements_types(), array("*"), "id", "ASC");
$stores = get_cols_where(new Store(), array("id", "name"),array("com_code"=>$com_code), "id", "ASC");
return view('items.show', ['data' => $data, 'items_movements_categories' => $items_movements_categories, 'items_movements_types' => $items_movements_types,'stores'=>$stores]);
}
public function ajax_search(Request $request)
{
if ($request->ajax()) {
$search_by_text = $request->search_by_text;
$item_type = $request->item_type;
$items_categories_id = $request->items_categories_id;
$searchbyradio = $request->searchbyradio;
if ($item_type == 'all') {
$field1 = "id";
$operator1 = ">";
$value1 = 0;
} else {
$field1 = "item_type";
$operator1 = "=";
$value1 = $item_type;
}
if ($items_categories_id == 'all') {
$field2 = "id";
$operator2 = ">";
$value2 = 0;
} else {
$field2 = "items_categories_id";
$operator2 = "=";
$value2 = $items_categories_id;
}
if ($search_by_text != '') {
if ($searchbyradio == 'barcode') {
$field3 = "barcode";
$operator3 = "=";
$value3 = $search_by_text;
} elseif ($searchbyradio == 'item_code') {
$field3 = "item_code";
$operator3 = "=";
$value3 = $search_by_text;
} else {
$field3 = "name";
$operator3 = "like";
$value3 = "%{$search_by_text}%";
}
} else {
//true 
$field3 = "id";
$operator3 = ">";
$value3 = 0;
}
$data = items::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = get_field_value(new User(), 'name', array('id' => $info->added_by));
$info->items_categories_name = get_field_value(new items_categorie(), 'name', array('id' => $info->items_categories_id));
$info->parent_items_id = get_field_value(new items(), 'name', array('id' => $info->parent_items_id));
$info->units_name = get_field_value(new units(), 'name', array('id' => $info->unit_id));
$info->retail_units_name = get_field_value(new units(), 'name', array('id' => $info->retail_units_id));
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = get_field_value(new User(), 'name', array('id' => $info->updated_by));
}
}
}
return view('items.ajax_search', ['data' => $data]);
}
}
public function ajax_search_movements(Request $request)
{
if ($request->ajax()) {
$store_id = $request->store_id;
$movements_categories = $request->movements_categories;
$movements_types = $request->movements_types;
$from_date = $request->from_date;
$to_date = $request->to_date;
$moveDateorderType = $request->moveDateorderType;
if ($store_id == 'all') {
$field1 = "id";
$operator1 = ">";
$value1 = 0;
} else {
$field1 = "store_id";
$operator1 = "=";
$value1 = $store_id;
}
if ($movements_categories == 'all') {
$field2 = "id";
$operator2 = ">";
$value2 = 0;
} else {
$field2 = "items_movements_categories";
$operator2 = "=";
$value2 = $movements_categories;
}
if ($movements_types == 'all') {
$field3 = "id";
$operator3 = ">";
$value3 = 0;
} else {
$field3 = "items_movements_types";
$operator3 = "=";
$value3 = $movements_types;
}
if ($from_date == '') {
$field4 = "id";
$operator4 = ">";
$value4 = 0;
} else {
$field4 = "date";
$operator4 = ">=";
$value4 = $from_date;
}
if ($to_date == '') {
$field5 = "id";
$operator5 = ">";
$value5 = 0;
} else {
$field5 = "date";
$operator5 = "<=";
$value5 = $to_date;
}
$data = items_movements::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->where($field4, $operator4, $value4)->where($field5, $operator5, $value5)->orderBy('id', $moveDateorderType)->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = get_field_value(new User(), 'name', array('id' => $info->added_by));
$info->items_movements_categories_name = get_field_value(new items_movements_categories(), 'name', array('id' => $info->items_movements_categories));
$info->items_movements_types_name = get_field_value(new items_movements_types(), 'type', array('id' => $info->items_movements_types));
$info->store_name = get_field_value(new Store(), 'name', array('id' => $info->store_id));
}
}
return view('items.ajax_search_movements', ['data' => $data]);
}
}
}