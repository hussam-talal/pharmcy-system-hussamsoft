<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\purchases;
use App\Models\purchases_details;
use App\Models\items;
use App\Models\units;
use App\Models\Store;
use App\Models\User_Shifts;
use App\Models\Treasuries;
use App\Models\Treasuries_transactions;
use App\Models\items_movements;
use App\Models\Account;
use App\Models\Supplier;
use App\Models\Admin_panel_setting;
use App\Models\items_batches;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\purchasesRequest;
use App\Models\items_categorie;
use App\Models\Alternativemedicine;
use App\Models\Users_treasuries;

class PurchasesController extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new purchases(), array("*"), array("com_code" => $com_code,'order_type'=>1), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = User::where('id', $info->added_by)->value('name');
$info->supplier_name = Supplier::where('suuplier_code', $info->suuplier_code)->value('name');
$info->store_name = Store::where('id', $info->store_id)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = User::where('id', $info->updated_by)->value('name');
}
}
}
$suupliers = get_cols_where(new Supplier(), array('suuplier_code', 'name'), array('com_code' => $com_code), 'id', 'DESC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
return view('purchases.index', ['data' => $data, 'suupliers' => $suupliers, 'stores' => $stores]);
}
public function create()
{
$com_code = auth()->user()->com_code;
$suupliers = get_cols_where(new Supplier(), array('suuplier_code', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
return view('purchases.create', ['suupliers' => $suupliers, 'stores' => $stores]);
}
public function store(purchasesRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$supplierData = get_cols_where_row(new Supplier(), array("account_number"), array("suuplier_code" => $request->suuplier_code, "com_code" => $com_code));
if (empty($supplierData)) {
return redirect()->back()
->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات المورد المحدد'])
->withInput();
}
$row = get_cols_where_row_orderby(new purchases(), array("auto_serial","id"), array("com_code" => $com_code,'order_type'=>1), 'id', 'DESC');
if (!empty($row)) {
$data_insert['auto_serial'] = $row['auto_serial'] + 1;
} else {
$data_insert['auto_serial'] = 1;
}
$data_insert['order_date'] = $request->order_date;
$data_insert['order_type'] = 1;
$data_insert['DOC_NO'] = $request->DOC_NO;
$data_insert['suuplier_code'] = $request->suuplier_code;
$data_insert['pill_type'] = $request->pill_type;
$data_insert['store_id'] = $request->store_id;
$data_insert['account_number'] = $supplierData['account_number'];
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
purchases::create($data_insert);
$id = get_field_value(new purchases(), "id", array("auto_serial" => $data_insert['auto_serial'], "com_code" => $com_code, "order_type" => 1));

return redirect()->route("purchases.show", $id)->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}


public function show($id)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new purchases(), array("*"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route('purchases.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$data['added_by_admin'] = User::where('id', $data['added_by'])->value('name');
$data['supplier_name'] = Supplier::where('suuplier_code', $data['suuplier_code'])->value('name');
$data['store_name'] = Store::where('id', $data['store_id'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = User::where('id', $data['updated_by'])->value('name');
}
$details = get_cols_where(new purchases_details(), array("*"), array('purchases_auto_serial' => $data['auto_serial'], 'order_type' => 1, 'com_code' => $com_code), 'id', 'DESC');
if (!empty($details)) {
foreach ($details as $info) {
$info->item_card_name = items::where('item_code', $info->item_code)->value('name');
$info->unit_name = get_field_value(new units(), "name", array("id" => $info->unit_id));
$data['added_by_admin'] = User::where('id', $data['added_by'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = User::where('id', $data['updated_by'])->value('name');
}
}
}
return view("purchases.show", ['data' => $data, 'details' => $details]);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new purchases(), array("*"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route('purchases.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_approved'] == 1) {
return redirect()->route('purchases.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}
$suupliers = get_cols_where(new Supplier(), array('suuplier_code', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
return view('purchases.edit', ['data' => $data, 'suupliers' => $suupliers, 'stores' => $stores]);
}
public function update($id, purchasesRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new purchases(), array("is_approved"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route('purchases.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$supplierData = get_cols_where_row(new Supplier(), array("account_number"), array("suuplier_code" => $request->suuplier_code, "com_code" => $com_code));
if (empty($supplierData)) {
return redirect()->back()
->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات المورد المحدد'])
->withInput();
}
$data_to_update['order_date'] = $request->order_date;
$data_to_update['order_type'] = 1;
$data_to_update['DOC_NO'] = $request->DOC_NO;
$data_to_update['suuplier_code'] = $request->suuplier_code;
$data_to_update['pill_type'] = $request->pill_type;
$data_to_update['store_id'] = $request->store_id;
$data_to_update['account_number'] = $supplierData['account_number'];
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
update(new purchases(), $data_to_update, array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
return redirect()->route('purchases.show', $id)->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}

public function add_new_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$item_code = $request->item_code;
$purchasesData = get_cols_where_row(new purchases(), array("is_approved", "order_date", "tax_value", "discount_value","id"), array("auto_serial" => $request->autoserailmain, "com_code" => $com_code, 'order_type' => 1));
if (!empty($purchasesData)) {
if ($purchasesData['is_approved'] == 0) {
$data_insert['purchases_auto_serial'] = $request->autoserailmain;
$data_insert['order_type'] = 1;
$data_insert['purchases_id'] = $purchasesData['id'];
$data_insert['item_code'] = $request->item_code_add;
$data_insert['deliverd_quantity'] = $request->quantity_add;
$data_insert['unit_price'] = $request->price_add;
$data_insert['unit_id'] = $request->unit_id_Add;
//$data_insert['isparentuom'] = $request->isparentuom;
if ($request->type == 2) {
$data_insert['production_date'] = $request->production_date;
$data_insert['expire_date'] = $request->expire_date;
}
$data_insert['item_card_type'] = $request->type;
$data_insert['total_price'] = $request->total_add;
$data_insert['order_date'] = $purchasesData['order_date'];
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['com_code'] = $com_code;
$flag = insert(new purchases_details(), $data_insert);
if ($flag) {
/** update parent pill */
$total_detials_sum = get_sum_where(new purchases_details(), 'total_price', array("purchases_auto_serial" => $request->autoserailmain, 'order_type' => 1, 'com_code' => $com_code));
$dataUpdateMain['total_cost_items'] = $total_detials_sum;
$dataUpdateMain['total_befor_discount'] = $total_detials_sum + $purchasesData['tax_value'];
$dataUpdateMain['total_cost'] = $dataUpdateMain['total_befor_discount'] - $purchasesData['discount_value'];
$dataUpdateMain['updated_by'] = auth()->user()->id;
$dataUpdateMain['updated_at'] = date("Y-m-d H:i:s");
update(new purchases(), $dataUpdateMain, array("auto_serial" => $request->autoserailmain, "com_code" => $com_code, 'order_type' => 1));
echo json_encode("done");
}
}
}
}

}

public function add_items_new_items(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$main_pill_data = get_cols_where_row(new purchases(), array("is_approved"), array("auto_serial" => $request->autoserailmain, "com_code" => $com_code, 'order_type' => 1));
if (!empty($main_pill_data)) {
if ($main_pill_data['is_approved'] == 0) {
    $items_categories = get_cols_where(new items_categorie(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
    $units_main = get_cols_where(new units(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1, ), 'id', 'DESC');
    $units_retail = get_cols_where(new units(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1, ), 'id', 'DESC');
    $alternative_medicine = get_cols_where(new Alternativemedicine(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
    
    return view("purchases.add_items_new", ['main_pill_data' => $main_pill_data, 'items_categories' => $items_categories,'units_main'=>$units_main,
            'units_retail'=>$units_retail,'alternative_medicine'=>$alternative_medicine
]);
}
}
}
}
 

public function add_items_new(Request $request)
{

$com_code = auth()->user()->com_code;
//$item_code = $request->item_code;
if ($request->ajax()) {
 
$itemsData = get_cols_where_row_orderby(new items(), array("item_code"), array( "com_code" => $com_code ), 'id', 'DESC');
if (!empty($itemsData)) {
    $data_insert['item_code'] = $itemsData['item_code'] + 1;
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


//$data_insert['barcode'] = $request->barcode;
$data_insert['name'] = $request->name;
$data_insert['item_type'] = $request->item_type;
$data_insert['items_categories_id'] = $request->items_categories_id;
$data_insert['unit_id'] = $request->unit_id;
if ($request->retail_unit_quntToParent=='') {
    $data_insert['retail_unit_quntToParent'] =1;  
}
$data_insert['retail_unit_quntToParent'] = $request->retail_unit_quntToParent;
$data_insert['retail_units_id'] = $request->retail_units_id;
$data_insert['price'] = $request->price;

$data_insert['gomla_price'] = $request->gomla_price;//$request->gomla_price;
$data_insert['cost_price'] = $request->cost_price;
$data_insert['active'] =1;  //$request->active;

$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['com_code'] = $com_code;
$data_insert['date'] = date('y-m-d');
$flag=insert(new items() , $data_insert);
if ($flag) {

echo json_encode("done");
}
}

//return view('purchases.create')->with(['success' => 'لقد تم اضافة الصنف بنجاح']);

//return view("purchases.load_add_new_itemdetails");

}

public function reload_itemsdetials(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$auto_serial = $request->autoserailmain;
$data = get_cols_where_row(new purchases(), array("is_approved","id","total_befor_discount"), array("auto_serial" => $auto_serial, "com_code" => $com_code, 'order_type' => 1));
if (!empty($data)) {
$details = get_cols_where(new purchases_details(), array("*"), array('purchases_auto_serial' => $auto_serial, 'order_type' => 1, 'com_code' => $com_code), 'id', 'DESC');
if (!empty($details)) {
foreach ($details as $info) {
$info->item_card_name = items::where('item_code', $info->item_code)->value('name');
$info->unit_name = get_field_value(new units(), "name", array("id" => $info->unit_id));
$data['added_by_admin'] = User::where('id', $data['added_by'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = User::where('id', $data['updated_by'])->value('name');
}
}
}
}
return view("purchases.reload_itemsdetials", ['data' => $data, 'details' => $details]);
}
}
public function reload_main_pill(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new purchases(), array("*"), array("auto_serial" => $request->autoserailmain, "com_code" => $com_code, 'order_type' => 1));
if (!empty($data)) {
$data['added_by_admin'] = User::where('id', $data['added_by'])->value('name');
$data['supplier_name'] = Supplier::where('suuplier_code', $data['suuplier_code'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = User::where('id', $data['updated_by'])->value('name');
}
return view("purchases.reload_main_pill", ['data' => $data]);
}
}
}
public function load_edit_item_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$main_pill_data = get_cols_where_row(new purchases(), array("is_approved"), array("auto_serial" => $request->autoserailmain, "com_code" => $com_code, 'order_type' => 1));
if (!empty($main_pill_data)) {
if ($main_pill_data['is_approved'] == 0) {
$item_data_detials = get_cols_where_row(new purchases_details(), array("*"), array("purchases_auto_serial" => $request->autoserailmain, "com_code" => $com_code, 'order_type' => 1, 'id' => $request->id));
$item_cards = get_cols_where(new items(), array("name", "item_code", "item_type"), array('active' => 1, 'com_code' => $com_code), 'id', 'DESC');

return view("purchases.load_edit_item_details", ['main_pill_data' => $main_pill_data, 'item_data_detials' => $item_data_detials, 'item_cards' => $item_cards ]);
}
}
}
}
public function load_modal_add_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$main_pill_data = get_cols_where_row(new purchases(), array("is_approved"), array("auto_serial" => $request->autoserailmain, "com_code" => $com_code, 'order_type' => 1));
if (!empty($main_pill_data)) {
if ($main_pill_data['is_approved'] == 0) {
$item_cards = get_cols_where(new items(), array("name", "item_code", "item_type","unit_id"), array('active' => 1, 'com_code' => $com_code), 'id', 'DESC');
return view("purchases.load_add_new_itemdetails", ['main_pill_data' => $main_pill_data, 'item_cards' => $item_cards]);
}
}
}
}
public function edit_item_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$main_pill_data = get_cols_where_row(new purchases(), array("is_approved", "order_date", "tax_value", "discount_value"), array("auto_serial" => $request->autoserailmain, "com_code" => $com_code, 'order_type' => 1));
if (!empty($main_pill_data)) {
if ($main_pill_data['is_approved'] == 0) {
$data_to_update['item_code'] = $request->item_code_add;
$data_to_update['deliverd_quantity'] = $request->quantity_add;
$data_to_update['unit_price'] = $request->price_add;
$data_to_update['unit_id'] = $request->unit_id_Add;
// $data_to_update['isparentuom'] = $request->isparentuom;
if ($request->type == 2) {
$data_to_update['production_date'] = $request->production_date;
$data_to_update['expire_date'] = $request->expire_date;
}
$data_to_update['item_card_type'] = $request->type;
$data_to_update['total_price'] = $request->total_add;
$data_to_update['order_date'] = $main_pill_data['order_date'];
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
$data_to_update['com_code'] = $com_code;
$flag = update(new purchases_details(), $data_to_update, array("id" => $request->id, 'com_code' => $com_code, 'order_type' => 1, 'purchases_auto_serial' => $request->autoserailmain));
if ($flag) {
/** update parent pill */
$total_detials_sum = get_sum_where(new purchases_details(), 'total_price', array("purchases_auto_serial" => $request->autoserailmain, 'order_type' => 1, 'com_code' => $com_code));
$dataUpdateMain['total_cost_items'] = $total_detials_sum;
$dataUpdateMain['total_befor_discount'] = $total_detials_sum + $main_pill_data['tax_value'];
$dataUpdateMain['total_cost'] = $dataUpdateMain['total_befor_discount'] - $main_pill_data['discount_value'];
$dataUpdateMain['updated_by'] = auth()->user()->id;
$dataUpdateMain['updated_at'] = date("Y-m-d H:i:s");
update(new purchases(), $dataUpdateMain, array("auto_serial" => $request->autoserailmain, "com_code" => $com_code, 'order_type' => 1));
echo json_encode("done");
}
}
}
}
}

public function delete($id)
{
try {
$com_code = auth()->user()->com_code;
$main_pill_data = get_cols_where_row(new purchases(), array("is_approved", "auto_serial"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($main_pill_data)) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
if ($main_pill_data['is_approved'] == 1) {
if (empty($main_pill_data)) {
return redirect()->back()
->with(['error' => 'عفوا  لايمكن الحذف بتفاصيل فاتورة معتمده ومؤرشفة']);
}
}
$flag = delete(new purchases(), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if ($flag) {
    //حيتم الحذف بشكل الي من خلال العلاقه بين الجدولين ونقدر نستغني عن الكود الخاص بالحذف 
delete(new purchases_details(), array("purchases_auto_serial" => $main_pill_data['auto_serial'], "com_code" => $com_code, 'order_type' => 1));
return redirect()->route('purchases.index')->with(['success' => 'لقد تم حذف  البيانات بنجاح']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
public function delete_details($id, $main_id)
{
try {
$com_code = auth()->user()->com_code;
$main_pill_data = get_cols_where_row(new purchases(), array("is_approved", "auto_serial"), array("id" => $main_id, "com_code" => $com_code, 'order_type' => 1));
if (empty($main_pill_data)) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
if ($main_pill_data['is_approved'] == 1) {
if (empty($main_pill_data)) {
return redirect()->back()
->with(['error' => 'عفوا  لايمكن الحذف بتفاصيل فاتورة مرحلة ومؤرشفة']);
}
}
$item_row = purchases_details::find($id);
if (!empty($item_row)) {
$flag = $item_row->delete();
if ($flag) {
/** update parent pill */
$total_detials_sum = get_sum_where(new purchases_details(), 'total_price', array("purchases_auto_serial" => $main_pill_data['auto_serial'], 'order_type' => 1, 'com_code' => $com_code));
$dataUpdateMain['total_cost_items'] = $total_detials_sum;
$dataUpdateMain['total_befor_discount'] = $total_detials_sum + $main_pill_data['tax_value'];
$dataUpdateMain['total_cost'] = $dataUpdateMain['total_befor_discount'] - $main_pill_data['discount_value'];
$dataUpdateMain['updated_by'] = auth()->user()->id;
$dataUpdateMain['updated_at'] = date("Y-m-d H:i:s");
update(new purchases(), $dataUpdateMain, array("id" => $main_id, "com_code" => $com_code, 'order_type' => 1));
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


public function load_modal_approve_invoice(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new purchases(), array("*"), array("auto_serial" => $request->autoserailmain, "com_code" => $com_code, 'order_type' => 1));
//current user shift
$user_treasuries = get_user_treasuries(new Users_treasuries(), new Treasuries(), new Treasuries_transactions());
$counterDetails=get_count_where(new purchases_details(),array("purchases_auto_serial"=>$request->autoserailmain, "com_code" => $com_code, 'order_type' => 1));
return view("purchases.load_modal_approve_invoice", ['data' => $data, 'user_treasuries' => $user_treasuries,'counterDetails'=>$counterDetails]);
}
}
public function load_userTreasuryDiv(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
//current user treasu
$user_treasuries = get_user_treasuries(new Users_treasuries(), new Treasuries(), new Treasuries_transactions());
}
return view("purchases.load_userTreasuryDiv", ['user_treasuries' => $user_treasuries]);
}


//اعتماد وترحيل فاتورة المشتريات 
function do_approve($auto_serial, Request $request)
{
$com_code = auth()->user()->com_code;
//check is not approved 
//فحص انه يوجد بيانات برقم الفاتورة الذي نريد ترحيلها
$data = get_cols_where_row(new purchases(), array("total_cost_items", "is_approved", "id", "account_number", "store_id", "suuplier_code"), array("auto_serial" => $auto_serial, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route("purchases.index")->with(['error' => "عفوا غير قادر علي الوصول الي البيانات المطلوبة !!"]);
}
//اسم المورد الذي مسجل في فاتورة المشتريات
$SupplierName = get_field_value(new Supplier(), "name", array("com_code" => $com_code, "suuplier_code" => $data['suuplier_code']));

if ($data['is_approved'] == 1) {
return redirect()->route("purchases.show", $data['id'])->with(['error' => " لايمكن ترحيل فاتورة مُرحلة من قبل !!"]);
}
//عدد الاصناف وتفاصيها في فاتورة الشراء المراد ترحيلها
$counterDetails=get_count_where(new purchases_details(),array("purchases_auto_serial"=>$auto_serial, "com_code" => $com_code, 'order_type' => 1));
if ($counterDetails== 0) {
return redirect()->route("purchases.show", $data['id'])->with(['error' => " لايمكن ترحيل الفاتورة قبل اضافة الأصناف عليها !!!            "]);
}
$dataUpdateMain['tax_percent'] = $request['tax_percent'];
$dataUpdateMain['tax_value'] = $request['tax_value'];
$dataUpdateMain['total_befor_discount'] = $request['total_befor_discount'];
$dataUpdateMain['discount_type'] = $request['discount_type'];
$dataUpdateMain['discount_percent'] = $request['discount_percent'];
$dataUpdateMain['discount_value'] = $request['discount_value'];
$dataUpdateMain['total_cost'] = $request['total_cost'];
$dataUpdateMain['pill_type'] = $request['pill_type'];
$dataUpdateMain['money_for_account'] = $request['total_cost'] * (-1);
$dataUpdateMain['is_approved'] = 1;
$dataUpdateMain['approved_by'] = auth()->user()->com_code;
$dataUpdateMain['updated_at'] = date("Y-m-d H:i:s");
$dataUpdateMain['updated_by'] = auth()->user()->com_code;
//first check for pill type cash
if ($request['pill_type'] == 1) {
if ($request['what_paid'] != $request['total_cost']) {
return redirect()->route("purchases.show", $data['id'])->with(['error' => "يجب ان يكون المبلغ بالكامل مدفوع في حالة الفاتورة نقدي !!"]);
}
}
//second  check for pill type agel
if ($request['pill_type'] == 2) {
if ($request['what_paid'] == $request['total_cost']) {
return redirect()->route("purchases.show", $data['id'])->with(['error' => " يجب ان لايكون المبلغ بالكامل مدفوع في حالة الفاتورة اجل !!"]);
}
}
$dataUpdateMain['what_paid'] = $request['what_paid'];
$dataUpdateMain['what_remain'] = $request['what_remain'];
//thaird  check for what paid 
if ($request['what_paid'] > 0) {
if ($request['what_paid'] > $request['total_cost']) {
return redirect()->route("purchases.show", $data['id'])->with(['error' => " يجب ان لايكون المبلغ المدفوع اكبر من اجمالي الفاتورة !!"]);
}
//check for user treasuries
$user_treasuries = get_user_treasuries(new Users_treasuries(), new Treasuries(), new Treasuries_transactions());
//chehck if is empty
if (empty($user_treasuries)) {
return redirect()->route("purchases.show", $data['id'])->with(['error' => "  لاتملتك   خزنة متاحة لكي تتمكن من اتمام عمليه الصرف"]);
}
//check for blance treasury
if ($user_treasuries['balance'] < $request['what_paid']) {
return redirect()->route("purchases.show", $data['id'])->with(['error' => "  لاتملتك رصيد كافي بخزنة الصرف  لكي تتمكن من اتمام عمليه الصرف"]);
}
}
$flag = update(new purchases(), $dataUpdateMain, array("auto_serial" => $auto_serial, "com_code" => $com_code, 'order_type' => 1));
if ($flag) {
//Affect on Supplier Balance  سوف نؤثر في رصيد المورد
//سوف نجيب سجل المورد من الدليل المحاسبي برقم الحساب المالي
//حركات  مختلفه
//first make treasuries_transactions  action if what paid >0
if ($request['what_paid'] > 0) {
//first get isal number with treasuries 
$treasury_date = get_cols_where_row(new Treasuries(), array("last_isal_exhcange"), array("com_code" => $com_code, "id" => $user_treasuries['treasuries_id']));
if (empty($treasury_date)) {
return redirect()->route("purchases.show", $data['id'])->with(['error' => "  غير قادر علي الوصول الي بيانات الخزنة المطلوبة"]);
}
$last_record_treasuries_transactions_record = get_cols_where_row_orderby(new Treasuries_transactions(), array("auto_serial"), array("com_code" => $com_code), "auto_serial", "DESC");
if (!empty($last_record_treasuries_transactions_record)) {
$dataInsert_treasuries_transactions['auto_serial'] = $last_record_treasuries_transactions_record['auto_serial'] + 1;
} else {
$dataInsert_treasuries_transactions['auto_serial'] = 1;
}
$dataInsert_treasuries_transactions['isal_number'] = $treasury_date['last_isal_exhcange'] + 1;
//$dataInsert_treasuries_transactions['treasuries_id'] = $user_treasuries['treasuries_id'];
//Credit دائن
$dataInsert_treasuries_transactions['money'] = $request['what_paid'] * (-1);
$dataInsert_treasuries_transactions['treasuries_id'] = $user_treasuries['treasuries_id'];
$dataInsert_treasuries_transactions['mov_type'] = 9;
$dataInsert_treasuries_transactions['move_date'] = date("Y-m-d");
$dataInsert_treasuries_transactions['account_number'] = $data["account_number"];
$dataInsert_treasuries_transactions['is_account'] = 1;
$dataInsert_treasuries_transactions['is_approved'] = 1;
$dataInsert_treasuries_transactions['the_foregin_key'] = $data["auto_serial"];
//debit مدين
$dataInsert_treasuries_transactions['money_for_account'] = $request['what_paid'];
$dataInsert_treasuries_transactions['byan'] = "صرف نظير فاتورة مشتريات  رقم" . $auto_serial;
$dataInsert_treasuries_transactions['created_at'] = date("Y-m-Y H:i:s");
$dataInsert_treasuries_transactions['added_by'] = auth()->user()->id;
$dataInsert_treasuries_transactions['com_code'] = $com_code;
$flag = insert(new Treasuries_transactions(), $dataInsert_treasuries_transactions);
if ($flag) {
//update Treasuries last_isal_collect
$dataUpdateTreasuries['last_isal_exhcange'] = $dataInsert_treasuries_transactions['isal_number'];
update(new Treasuries(), $dataUpdateTreasuries, array("com_code" => $com_code, "id" => $user_treasuries['treasuries_id']));
}
}
//تحديث الرصيد لحساب المورد
refresh_account_blance_supplier($data['account_number'], new Account(), new Supplier(),new Treasuries_transactions(),new purchases(), false);
//store move حركة المخزن
//first Get item card data نجيب الاصناف اللي علي الفاتورة
$items = get_cols_where(new purchases_details(), array("*"), array("purchases_auto_serial" => $auto_serial, "com_code" => $com_code, "order_type" => 1), "id", "ASC");
if (!empty($items)) {
foreach ($items as $info) {
//get items Data
$itemCard_Data = get_cols_where_row(new items(), array("unit_id", "retail_unit_quntToParent", "retail_units_id"), array("com_code" => $com_code, "item_code" => $info->item_code));
if (!empty($itemCard_Data)) {
//get Quantity Befor any Action  سوف نجيب كيمة الصنف بكل المخازن قبل الحركة
$quantityBeforMove = get_sum_where(new items_batches(), "quantity", array("item_code" => $info->item_code, "com_code" => $com_code));
//get Quantity Befor any Action  سوف نجيب كيمة الصنف  بمخزن فاتورة المشتريات الحالي قبل الحركة
$quantityBeforMoveCurrntStore = get_sum_where(new items_batches(), "quantity", array("item_code" => $info->item_code, "com_code" => $com_code, 'store_id' => $data['store_id']));
$MainUnitName = get_field_value(new units(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['unit_id']));

//if ($info->isparentuom == 1) {
$quntity = $info->deliverd_quantity;
$unit_price = $info->unit_price;

// if is retail  لو كان بوحده  التجزئة
//التحويل من الرئيسية للتجزئة بنضرب   في النسبة بينهم - اما التحويل من التجزئة للرئيسية بنقسم علي النسبه بينهما 
//$quntity = ($info->deliverd_quantity / $itemCard_Data['retail_unit_quntToParent']);
//$unit_price = $info->unit_price * $itemCard_Data['retail_unit_quntToParent'];

//بندخل الكميات للمخزن بوحده القياس الرئيسية  اجباري 
//لو الصنف استهلاكي له تاريخ صلاحيه وانتاج فبعمل تحقق بسعر الشراء مع التواريخ
//لو الصنف  غير استهلاكي يبقي بعمل تحقق فقط بسعر الشراء
if ($info->item_card_type == 2) {
//استهلاكي بتواريخ 
$dataInsertBatch["store_id"] = $data['store_id'];
$dataInsertBatch["item_code"] = $info->item_code;
$dataInsertBatch["production_date"] = $info->production_date;
$dataInsertBatch["expired_date"] = $info->expire_date;
$dataInsertBatch["unit_cost_price"] = $unit_price;
$dataInsertBatch["unit_id"] = $itemCard_Data['unit_id'];

} else {
//بسعر فقط
$dataInsertBatch["store_id"] = $data['store_id'];
$dataInsertBatch["item_code"] = $info->item_code;
$dataInsertBatch["unit_cost_price"] = $unit_price;
$dataInsertBatch["unit_id"] = $itemCard_Data['unit_id'];
}
$OldBatchExsists = get_cols_where_row(new items_batches(), array("quantity", "id", "unit_cost_price"), $dataInsertBatch);

if (!empty($OldBatchExsists)) {
//update current Batch تحديث علي الباتش القديمة
$dataUpdateOldBatch['quantity'] = $OldBatchExsists['quantity'] + $quntity;
$dataUpdateOldBatch['total_cost_price'] = $OldBatchExsists['unit_cost_price'] * $dataUpdateOldBatch['quantity'];

$dataUpdateOldBatch["updated_at"] = date("Y-m-d H:i:s");
$dataUpdateOldBatch["updated_by"] = auth()->user()->id;
update(new items_batches(), $dataUpdateOldBatch, array("id" => $OldBatchExsists['id'], "com_code" => $com_code));
} else {
//insert new Batch ادخال باتش جديده
$dataInsertBatch["quantity"] = $quntity;
$dataInsertBatch["total_cost_price"] = $info->total_price;
$dataInsertBatch["created_at"] = date("Y-m-d H:i:s");
$dataInsertBatch["added_by"] = auth()->user()->id;
$dataInsertBatch["com_code"] = $com_code;
$row = get_cols_where_row_orderby(new items_batches(), array("auto_serial"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$dataInsertBatch['auto_serial'] = $row['auto_serial'] + 1;
} else {
$dataInsertBatch['auto_serial'] = 1;
}
insert(new items_batches(), $dataInsertBatch);
}
//كمية الصنف بكل المخازن بعد اتمام حركة الباتشات وترحيلها
$quantityAfterMove = get_sum_where(new items_batches(), "quantity", array("item_code" => $info->item_code, "com_code" => $com_code));
//كمية الصنف بمخزن فاتورة الشراء  بعد اتمام حركة الباتشات وترحيلها
$quantityAfterMoveCurrentStore = get_sum_where(new items_batches(), "quantity", array("item_code" => $info->item_code, "com_code" => $com_code, 'store_id' => $data['store_id']));
$dataInsert_items_movements['items_movements_categories'] = 1;
$dataInsert_items_movements['items_movements_types'] = 1;
$dataInsert_items_movements['item_code'] = $info->item_code;
//كود الفاتورة الرئيسية
$dataInsert_items_movements['FK_table'] = $auto_serial;
//كود صف  بتفاصيل الفاتورة
$dataInsert_items_movements['FK_table_details'] = $info->id;
$dataInsert_items_movements['byan'] = "نظير مشتريات من المورد " . " " . $SupplierName . " فاتورة رقم" . " " . $auto_serial;
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_items_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUnitName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_items_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUnitName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_items_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUnitName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_items_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUnitName;
$dataInsert_items_movements["store_id"] = $data['store_id'];
$dataInsert_items_movements["created_at"] = date("Y-m-d H:i:s");
$dataInsert_items_movements["added_by"] = auth()->user()->id;
$dataInsert_items_movements["date"] = date("Y-m-d");
$dataInsert_items_movements["com_code"] = $com_code;
insert(new items_movements(), $dataInsert_items_movements);
//item Move Card حركة الصنف 
}
//update last Cost price   تحديث اخر سعر شراء للصنف
//if ($info->isparentuom == 1) {
//لو الوحده اللي اشتريت بيها كانت وحده رئيسية 
$dataUpdateItemCardCosts['cost_price'] = $info->unit_price;

$dataUpdateItemCardCosts['cost_price_retail'] = $info->unit_price / $itemCard_Data['retail_unit_quntToParent'];

//} else {
// if is retail  لو كان بوحده  التجزئة
//التحويل من الاب للابن بنضرب   في النسبة بينهم - اما التحويل من الابن للاب بنقسم علي النسبه بينهما 
// $dataUpdateItemCardCosts['cost_price'] = $info->unit_price * $itemCard_Data['retail_unit_quntToParent'];
// $dataUpdateItemCardCosts['cost_price_retail'] = $info->unit_price;
//}
update(new items(), $dataUpdateItemCardCosts, array("com_code" => $com_code, "item_code" => $info->item_code));
// update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
do_update_itemCardQuantity(new items(), $info->item_code, new items_batches(), $itemCard_Data['retail_unit_quntToParent']);
}
}
return redirect()->route("purchases.show", $data['id'])->with(['success' => " تم اعتماد وترحيل الفاتورة بنجاح  "]);
}
}



public function ajax_search(Request $request)
{
if ($request->ajax()) {
$search_by_text = $request->search_by_text;
$suuplier_code = $request->suuplier_code;
$store_id = $request->store_id;
$order_date_form = $request->order_date_form;
$order_date_to = $request->order_date_to;
$searchbyradio = $request->searchbyradio;
if ($suuplier_code == 'all') {
//دائما  true
$field1 = "id";
$operator1 = ">";
$value1 = 0;
} else {
$field1 = "suuplier_code";
$operator1 = "=";
$value1 = $suuplier_code;
}
if ($store_id == 'all') {
//دائما  true
$field2 = "id";
$operator2 = ">";
$value2 = 0;
} else {
$field2 = "store_id";
$operator2 = "=";
$value2 = $store_id;
}
if ($order_date_form =='') {
//دائما  true
$field3 = "id";
$operator3 = ">";
$value3 = 0;
} else {
$field3 = "order_date";
$operator3 = ">=";
$value3 = $order_date_form;
}
if ($order_date_to =='') {
//دائما  true
$field4 = "id";
$operator4 = ">";
$value4 = 0;
} else {
$field4 = "order_date";
$operator4 = "<=";
$value4 = $order_date_to;
}
if ($search_by_text !='') {
if ($searchbyradio == 'auto_serial') {
$field5 = "auto_serial";
$operator5 = "=";
$value5 = $search_by_text;
} else {
$field5 = "DOC_NO";
$operator5 = "=";
$value5 = $search_by_text;
}
} else {
//true 
$field5 = "id";
$operator5 = ">";
$value5 =0;
}
$data = purchases::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->
where($field4, $operator4, $value4)->where($field5, $operator5, $value5)->where('order_type','=',1)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = User::where('id', $info->added_by)->value('name');
$info->supplier_name = Supplier::where('suuplier_code', $info->suuplier_code)->value('name');
$info->store_name = Store::where('id', $info->store_id)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = User::where('id', $info->updated_by)->value('name');
}
}
}
return view('purchases.ajax_search', ['data' => $data]);
}
}

public function printsaleswina4($id,$size){

try {
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new purchases(), array("*"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($invoice_data)) {
return redirect()->route('purchases.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$invoice_data['added_by_admin'] = User::where('id', $invoice_data['added_by'])->value('name');
$invoice_data['supplier_name'] = Supplier::where('suuplier_code', $invoice_data['suuplier_code'])->value('name');
$invoice_data['supplier_phone'] = Supplier::where('suuplier_code', $invoice_data['suuplier_code'])->value('phones');

$invoice_data['store_name'] = Store::where('id', $invoice_data['store_id'])->value('name');

$invoices_details = get_cols_where(new purchases_details(), array("*"), array('purchases_auto_serial' => $invoice_data['auto_serial'], 'order_type' => 1, 'com_code' => $com_code), 'id', 'DESC');
if (!empty($invoices_details)) {
foreach ($invoices_details as $info) {
$info->item_card_name = items::where('item_code', $info->item_code)->value('name');
$info->unit_name = get_field_value(new units(), "name", array("id" => $info->unit_id));
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));

if($size=="A4"){
    return view('purchases.printsaleswina4',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$invoices_details]);
}else{
    return view('purchases.printsaleswina6',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$invoices_details]);

}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

}