<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\purchases;
use App\Models\purchases_details;
use App\Models\items;
use App\Models\units;
use App\Models\Store;
use App\Models\Users_treasuries;
use App\Models\Treasuries;
use App\Models\Treasuries_transactions;
use App\Models\items_movements;
use App\Models\Account;
use App\Models\Supplier;
use App\Models\Admin_panel_setting;
use App\Models\items_batches;
use App\Http\Requests\Suppliers_orders_general_returnRequest;
use App\Http\Requests\Suppliers_orders_general_returnEditRequest;
class purchasesreturn extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new purchases(), array("*"), array("com_code" => $com_code,'order_type'=>3), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = User::where('id', $info->added_by)->value('name');
 $info->supplier_name = Supplier::where('suuplier_code', $info->suuplier_code)->value('name');
 $info->store_name = Store::where('id', $info->store_id)->value('name');

//  $info->item_card_name = items::where('item_code', $info->item_code)->value('name');
// $info->unit_name = get_field_value(new units(), "name", array("id" => $info->unit_id));
// $info->total_accurent = items::where('item_code', $info->item_code)->value('QUENTITY');


if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = User::where('id', $info->updated_by)->value('name');
}
}
}
$suupliers = get_cols_where(new Supplier(), array('suuplier_code', 'name'), array('com_code' => $com_code), 'id', 'DESC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
return view('purchases_return.index', ['data' => $data, 'suupliers' => $suupliers, 'stores' => $stores]);
}



public function create()
{
$com_code = auth()->user()->com_code;
$suupliers = get_cols_where(new Supplier(), array('suuplier_code', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
return view('purchases_return.create', ['suupliers' => $suupliers, 'stores' => $stores]);
}

public function store(Request $request)
{
    // if ($request->ajax()) {
    $com_code = auth()->user()->com_code;
    //حنعمل اضافة للفاتورة اول مرة 
    //$data = get_cols_where(new purchases(), array("*"), array("com_code" => $com_code,"order_type" => 3),'id','DESC');
    
    $return_data = get_cols_where_row_orderby(new purchases(), array("auto_serial","order_type"), array("com_code" => $com_code, "order_type" => 3), 'id', 'DESC');
    if (empty($return_data)) {
    // $data_insert['auto_serial'] = $last_auto_serial_Date['auto_serial'] + 1;
    // } else {
    $data_insert['auto_serial'] = 1;
    $data_insert['added_by'] = auth()->user()->id;
    $data_insert['created_at'] = date("Y-m-d H:i:s");
    $data_insert['date'] = date("Y-m-d");
    $data_insert['com_code'] = $com_code;
    $data_insert['order_type'] = 3;

    $flag = insert(new purchases(), $data_insert);
    if ($flag) {
    $auto_serial = get_field_value(new purchases(), "auto_serial", array("auto_serial" => $data_insert['auto_serial'], "com_code" => $com_code,"order_type" => 3));
    $data = get_cols_where_row(new purchases(), array("auto_serial"), array("com_code" => $com_code,"auto_serial"=>$auto_serial,'order_type'=>3));
   return redirect()->route('purchasesreturn.show',$auto_serial);

    }
    }else{
    $auto_serial = get_field_value(new purchases(), "auto_serial", array("auto_serial" => $return_data['auto_serial'], "com_code" => $com_code,"order_type" => 3));
    $data = get_cols_where_row(new purchases(), array("auto_serial"), array("com_code" => $com_code,"auto_serial"=>$auto_serial,'order_type'=>3));
    return redirect()->route('purchasesreturn.show',$auto_serial);
}
     //echo  json_encode($data['auto_serial']);
    }


public function delete($id)
{
try {
$com_code = auth()->user()->com_code;
$pill_data = get_cols_where_row(new purchases(), array("is_approved", "auto_serial","store_id","suuplier_code"), array("id" => $id, "com_code" => $com_code, 'order_type' => 3));
if (empty($pill_data)) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
if ($pill_data['is_approved'] == 1) {
if (empty($pill_data)) {
return redirect()->back()
->with(['error' => 'عفوا  لايمكن الحذف بتفاصيل فاتورة معتمده ومؤرشفة']);
}
}
//حنجيب الاصناف المضافة علي الفاتورة
$items_details=get_cols_where(new purchases_details(),array("*"),array("com_code"=>$com_code,"order_type"=>3,"purchases_auto_serial"=>$pill_data['auto_serial']));
//حنحذف الفاتورة الاب
$flag = delete(new purchases(), array("id" => $id, "com_code" => $com_code, 'order_type' => 3));
if ($flag) {
//حنلف علي الاصناف المضافه علي الفاتورة ونطبق عليهم نفس اللي عملناها في حذف تفاصيل عنصر علي الفاتورة
if(!empty($items_details)){
foreach($items_details as $info){
    //حيتم الحذف بشكل الي من خلال العلاقه بين الجدولين ونقدر نستغني عن الكود الخاص بالحذف  
$flagDelete=delete(new purchases_details(),array("com_code"=>$com_code,"order_type"=>3,"suppliers_with_orders_auto_serial"=>$pill_data['auto_serial'],'id'=>$info->id));
if($flagDelete){
$itemCard_Data = get_cols_where_row(new items(), array("unit_id", "retail_unit_quntToParent", "retail_unit_id", "does_has_retailunit","item_type"), array("com_code" => $com_code, "item_code" => $info->item_code));
$batch_data = get_cols_where_row(new items_batches(), array("quantity", "unit_cost_price", "id","production_date","expired_date"), array("com_code" => $com_code, "auto_serial" => $info->batch_auto_serial, 'store_id' => $pill_data['store_id'], 'item_code' => $info->item_code));
if (!empty($itemCard_Data) and !empty($batch_data)) {
//خصم الكمية من الباتش 
//كمية الصنف بكل المخازن قبل الحركة
$quantityBeforMove = get_sum_where(
new items_batches(),
"quantity",
array(
"item_code" => $info->item_code,
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي قبل الحركة
$quantityBeforMoveCurrntStore = get_sum_where(
new items_batches(),
"quantity",
array(
"item_code" => $info->item_code, "com_code" => $com_code,
'store_id' => $pill_data['store_id']
)
);
//هنا حنرجع الكمية لحظيا من باتش الصنف
//update current Batch تحديث علي الباتش القديمة
if($info->ismainunit==1){
//حخصم بشكل مباشر لانه بنفس وحده الباتش الاب
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] + $info->deliverd_quantity;
}else{
//مرجع بالوحده الابن التجزئة فلازم تحولها الي الاب قبل الخصم انتبه !!
$item_quantityByMainUnit=$info->deliverd_quantity/$itemCard_Data['retail_unit_quntToParent'];
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] + $item_quantityByMainUnit;
}
$dataUpdateOldBatch['total_cost_price'] = $batch_data['unit_cost_price'] * $dataUpdateOldBatch['quantity'];
$dataUpdateOldBatch["updated_at"] = date("Y-m-d H:i:s");
$dataUpdateOldBatch["updated_by"] = auth()->user()->id;
$flag = update(new items_batches(), $dataUpdateOldBatch, array("id" => $batch_data['id'], "com_code" => $com_code));
if ($flag) {
$quantityAfterMove = get_sum_where(
new items_batches(),
"quantity",
array(
"item_code" => $info->item_code,
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي بعد الحركة
$quantityAfterMoveCurrentStore = get_sum_where(
new items_batches(),
"quantity",
array("item_code" => $info->item_code, "com_code" => $com_code, 'store_id' => $pill_data['store_id'])
);
//التاثير في حركة كارت الصنف
$dataInsert_inv_itemcard_movements['items_movements_categories'] = 1;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 3;
$dataInsert_inv_itemcard_movements['item_code'] = $info->item_code;
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $pill_data['auto_serial'];
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $info->id;
$SupplierName = get_field_value(new Supplier(), "name", array("com_code" => $com_code, "suuplier_code" => $pill_data['suuplier_code']));
$dataInsert_inv_itemcard_movements['byan'] = " نظير حذف سطر الصنف من فاتورة مرتجع مشتريات عام   الي المورد" . " " . $SupplierName . " فاتورة رقم" . " " . $pill_data['auto_serial'];
$MainUomName = get_field_value(new units(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['unit_id']));
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
$dataInsert_inv_itemcard_movements["store_id"] = $pill_data['store_id'];
$dataInsert_inv_itemcard_movements["created_at"] = date("Y-m-d H:i:s");
$dataInsert_inv_itemcard_movements["added_by"] = auth()->user()->id;
$dataInsert_inv_itemcard_movements["date"] = date("Y-m-d");
$dataInsert_inv_itemcard_movements["com_code"] = $com_code;
$flag = insert(new items_movements(), $dataInsert_inv_itemcard_movements);
if ($flag) {
//update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
do_update_itemCardQuantity(
new items(),
$info->item_code,
new items_batches(),
$itemCard_Data['retail_unit_quntToParent']
);
}
}
}
}
}
}
return redirect()->route('purchases_return.index')->with(['success' => 'لقد تم حذف  البيانات بنجاح']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function show($auto_serial)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new purchases(), array("*"), array('auto_serial' => $auto_serial, 'com_code' => $com_code, 'order_type' => 3));
// if (empty($data)) {
// return redirect()->route('purchasesreturn.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
// }

// $data['supplier_name'] = Supplier::where('suuplier_code', $data['suuplier_code'])->value('name');
$stores = get_cols_where(new Store(), array("id", "name"), array("com_code" => $com_code, "active" => 1), 'id', 'ASC');
$suuplier = get_cols_where(new Supplier(), array("suuplier_code", "name"), array("com_code" => $com_code));

$details = get_cols_where(new purchases_details(), array("*"), array('purchases_auto_serial' => $auto_serial,'order_type'=>3, 'com_code' => $com_code), 'id', 'DESC');
if (!empty($details)) {
foreach ($details as $info) {
$info->item_card_name = items::where('item_code', $info->item_code)->value('name');
$info->unit_name = get_field_value(new units(), "name", array("id" => $info->unit_id));
// $data['added_by_admin'] = User
// ::where('id', $data['added_by'])->value('name');
// if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
// $data['updated_by_admin'] = User
// ::where('id', $data['updated_by'])->value('name');
// }
}
}
return view("purchases_return.show", ['data' => $data,"details"=>$details, "stores"=>$stores,"suuplier"=>$suuplier]);
}


public function reload_itemsdetials(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$auto_serial = $request->autoserail;
$data = get_cols_where_row(new purchases(), array("is_approved","id"), array("auto_serial" => $auto_serial, "com_code" => $com_code, 'order_type' => 3));
if (!empty($data)) {
$details = get_cols_where(new purchases_details(), array("*"), array('purchases_auto_serial' => $auto_serial, 'order_type' => 3, 'com_code' => $com_code), 'id', 'DESC');
if (!empty($details)) {
foreach ($details as $info) {
$info->item_card_name = items::where('item_code', $info->item_code)->value('name');
$info->unit_name = get_field_value(new units(), "name", array("id" => $info->unit_id));
$data['added_by_admin'] = User
::where('id', $data['added_by'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = User
::where('id', $data['updated_by'])->value('name');
}
}
}
}
return view("purchases_return.reload_itemsdetials", ['data' => $data, 'details' => $details]);
}
}


public function load_edit_item_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$pill_data = get_cols_where_row(new purchases(), array("is_approved"), array("auto_serial" => $request->autoserail, "com_code" => $com_code, 'order_type' => 3));
if (!empty($pill_data)) {
if ($pill_data['is_approved'] == 0) {
$item_data_detials = get_cols_where_row(new purchases_details(), array("*"), array("purchases_auto_serial" => $request->autoserail, "com_code" => $com_code, 'order_type' => 3, 'id' => $request->id));
$item_cards = get_cols_where(new items(), array("name", "item_code", "item_type"), array('active' => 1, 'com_code' => $com_code), 'id', 'DESC');
$item_card_Data = get_cols_where_row(new items(), array( "retail_units_id", "unit_id"), array("item_code" => $item_data_detials['item_code'], "com_code" => $com_code));
if (!empty($item_card_Data)) {

$item_card_Data['parent_unit_name'] = get_field_value(new units(), "name", array("id" => $item_card_Data['unit_id']));
$item_card_Data['retial_unit_name'] = get_field_value(new units(), "name", array("id" => $item_card_Data['retail_units_id']));

return view("purchases_return.load_edit_item_details", ['pill_data' => $pill_data, 'item_data_detials' => $item_data_detials, 'item_cards' => $item_cards, 'item_card_Data' => $item_card_Data]);
}
}
}
}
}
public function load_modal_add_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$supplierData = get_cols_where_row(new Supplier(), array("account_number"), array("suuplier_code" => $request->suuplier_code, "com_code" => $com_code));
if (empty($supplierData)) {
return redirect()->back()
->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات المورد المحدد'])
->withInput();
}
$data = get_cols_where_row(new purchases(), array("is_approved","store_id"), array("auto_serial" => $request->autoserail, "com_code" => $com_code, 'order_type' => 3));
if (!empty($data)) {
if ($data['is_approved'] == 0) {
    $data_insert['order_date'] = $request->order_date;
    $data_insert['suuplier_code'] = $request->suuplier_code;
    $data_insert['store_id'] = $request->store_id;
    $data_insert['account_number'] = $supplierData['account_number'];
    
$flag=update(new purchases(), $data_insert,array("auto_serial"=>$request->autoserail,"com_code" => $com_code,'order_type' => 3));
  if ($flag) {
    $pill_data = get_cols_where_row(new purchases(), array("is_approved","store_id"), array("auto_serial" => $request->autoserail, "com_code" => $com_code, 'order_type' => 3));
if (!empty($pill_data)) {
  
$item_cards = get_cols_where(new items(), array("name", "item_code", "item_type"), array('active' => 1, 'com_code' => $com_code), 'id', 'DESC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'id' => $pill_data['store_id']), 'id', 'DESC');
return view("purchases_return.load_add_new_itemdetails", ['pill_data' => $pill_data, 'item_cards' => $item_cards,'stores'=>$stores]);
}
}
}
}
}
}

public function edit_item_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$pill_data = get_cols_where_row(new purchases(), array("is_approved", "order_date", "discount_value"), array("auto_serial" => $request->autoserail, "com_code" => $com_code, 'order_type' => 3));
if (!empty($pill_data)) {
if ($pill_data['is_approved'] == 0) {
$data_to_update['item_code'] = $request->item_code_add;
$data_to_update['deliverd_quantity'] = $request->quantity_add;
$data_to_update['unit_price'] = $request->price_add;
$data_to_update['unit_id'] = $request->unit_id_Add;
$data_to_update['ismainunit'] = $request->ismainunit;
if ($request->type == 2) {
$data_to_update['production_date'] = $request->production_date;
$data_to_update['expire_date'] = $request->expire_date;
}
$data_to_update['item_card_type'] = $request->type;
$data_to_update['total_price'] = $request->total_add;
$data_to_update['order_date'] = $pill_data['order_date'];
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
$data_to_update['com_code'] = $com_code;
$flag = update(new purchases_details(), $data_to_update, array("id" => $request->id, 'com_code' => $com_code, 'order_type' => 3, 'purchases_auto_serial' => $request->autoserail));
if ($flag) {
/** update parent pill */
$total_detials_sum = get_sum_where(new purchases_details(), 'total_price', array("purchases_auto_serial" => $request->autoserail, 'order_type' => 3, 'com_code' => $com_code));
$dataUpdateParent['total_cost_items'] = $total_detials_sum;
$dataUpdateParent['total_befor_discount'] = $total_detials_sum ;
$dataUpdateParent['total_cost'] = $dataUpdateParent['total_befor_discount'] - $pill_data['discount_value'];
$dataUpdateParent['updated_by'] = auth()->user()->id;
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
update(new purchases(), $dataUpdateParent, array("auto_serial" => $request->autoserail, "com_code" => $com_code, 'order_type' => 3));
echo json_encode("done");
}
}
}
}
}
public function delete_details($id, $parent_id)
{ 
try {
$com_code = auth()->user()->com_code;
$pill_data = get_cols_where_row(new purchases(), array("is_approved", "auto_serial","store_id","suuplier_code"), array("id" => $parent_id, "com_code" => $com_code, 'order_type' => 3));
if (empty($pill_data)) {
return redirect()->back()
->with(['error' => '1 عفوا حدث خطأ ما'  ]);
}
if ($pill_data['is_approved'] == 1) {
if (empty($pill_data)) {
return redirect()->back()
->with(['error' => 'عفوا  لايمكن الحذف بتفاصيل فاتورة معتمده ومؤرشفة']);
}
}
$item_row = purchases_details::find($id);
if (!empty($item_row)) {
$flag = $item_row->delete();
if ($flag) {
/** update parent pill */
$this->recalclate_parent_invoice($pill_data['auto_serial']);
$itemCard_Data = get_cols_where_row(new items(), array("unit_id", "retail_unit_quntToParent", "retail_units_id","item_type"), array("com_code" => $com_code, "item_code" => $item_row['item_code']));
$batch_data = get_cols_where_row(new items_batches(), array("quantity", "unit_cost_price", "id","production_date","expired_date"), array("com_code" => $com_code, "auto_serial" => $item_row['batch_auto_serial'], 'store_id' => $pill_data['store_id'], 'item_code' => $item_row['item_code']));
if (!empty($itemCard_Data) and !empty($batch_data)) {
//خصم الكمية من الباتش 
//كمية الصنف بكل المخازن قبل الحركة
$quantityBeforMove = get_sum_where(
new items_batches(),
"quantity",
array(
"item_code" => $item_row['item_code'],
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي قبل الحركة
$quantityBeforMoveCurrntStore = get_sum_where(
new items_batches(),
"quantity",
array(
"item_code" => $item_row['item_code'], "com_code" => $com_code,
'store_id' => $pill_data['store_id']
)
);
//حنرجع  الكمية لحظيا من باتش الصنف
//update current Batch تحديث علي الباتش القديمة
if($item_row['ismainunit']==1){
//حنرجع بشكل مباشر لانه بنفس وحده الباتش الاب
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] + $item_row['deliverd_quantity'];
}else{
//مرجع بالوحده الابن التجزئة فلازم تحولها الي الاب قبل الخصم انتبه !!
$item_quantityByParentUom=$item_row['deliverd_quantity']/$itemCard_Data['retail_uom_quntToParent'];
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] + $item_quantityByParentUom;
}
$dataUpdateOldBatch['total_cost_price'] = $batch_data['unit_cost_price'] * $dataUpdateOldBatch['quantity'];
$dataUpdateOldBatch["updated_at"] = date("Y-m-d H:i:s");
$dataUpdateOldBatch["updated_by"] = auth()->user()->id;
$flag = update(new items_batches(), $dataUpdateOldBatch, array("id" => $batch_data['id'], "com_code" => $com_code));
if ($flag) {
$quantityAfterMove = get_sum_where(
new items_batches(),
"quantity",
array(
"item_code" => $item_row['item_code'],
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي بعد الحركة
$quantityAfterMoveCurrentStore = get_sum_where(
new items_batches(),
"quantity",
array("item_code" => $item_row['item_code'], "com_code" => $com_code, 'store_id' => $pill_data['store_id'])
);
//التاثير في حركة كارت الصنف
$dataInsert_inv_itemcard_movements['items_movements_categories'] = 1;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 3;
$dataInsert_inv_itemcard_movements['item_code'] = $item_row['item_code'];
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $pill_data['auto_serial'];
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $item_row['id'];
$SupplierName = get_field_value(new Supplier(), "name", array("com_code" => $com_code, "suuplier_code" => $pill_data['suuplier_code']));
$dataInsert_inv_itemcard_movements['byan'] = " نظير حذف سطر الصنف من فاتورة مرتجع مشتريات عام   الي المورد" . " " . $SupplierName . " فاتورة رقم" . " " . $pill_data['auto_serial'];
$MainUomName = get_field_value(new units(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['unit_id']));
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
$dataInsert_inv_itemcard_movements["store_id"] = $pill_data['store_id'];
$dataInsert_inv_itemcard_movements["created_at"] = date("Y-m-d H:i:s");
$dataInsert_inv_itemcard_movements["added_by"] = auth()->user()->id;
$dataInsert_inv_itemcard_movements["date"] = date("Y-m-d");
$dataInsert_inv_itemcard_movements["com_code"] = $com_code;
$flag = insert(new items_movements(), $dataInsert_inv_itemcard_movements);
if ($flag) {
//update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
do_update_itemCardQuantity(
new items(),
$item_row['item_code'],
new items_batches(),
$itemCard_Data['retail_unit_quntToParent']
);
return redirect()->back()
->with(['success' => '   تم حذف البيانات بنجاح']);
}
}else{
return redirect()->back()
->with(['error' => '2عفوا حدث خطأ ما']);
}
}else{
return redirect()->back()
->with(['error' => '3عفوا حدث خطأ ما']);
}
} else {
return redirect()->back()
->with(['error' => '4عفوا حدث خطأ ما']);
}
} else {
return redirect()->back()
->with(['error' => 'عفوا غير قادر الي الوصول للبيانات المطلوبة']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => '5عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}


public function load_modal_approve_invoice(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new purchases(), array("*"), array("auto_serial" => $request->autoserail, "com_code" => $com_code, 'order_type' => 3));
//current user treasury
$user_treasurcy = get_user_treasuries(new Users_treasuries(), new Treasuries(), new Treasuries_transactions());
$counterDetails=get_count_where(new purchases_details(),array("purchases_auto_serial"=>$request->autoserail, "com_code" => $com_code, 'order_type' => 3));
return view("purchases_return.load_modal_approve_invoice", ['data' => $data, 'user_treasurcy' => $user_treasurcy
,'counterDetails'=>$counterDetails]);
}
}


public function load_usersTreasuryDiv(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
//current user shift
$user_treasurcy= get_user_treasuries
(new Users_treasuries(), new Treasuries(), new Treasuries_transactions());
}
return view("purchases_return.load_usersTreasuryDiv", ['user_treasurcy' => $user_treasurcy
]);
}


// ترحيل فاتورة مرتجع المشتريات 
function do_approve($auto_serial, Request $request)
{
$com_code = auth()->user()->com_code;
//check is not approved 
$data = get_cols_where_row(new purchases(), array("total_cost_items", "is_approved",
 "id", "account_number", "store_id", "suuplier_code"), array("auto_serial" => $auto_serial, "com_code" => $com_code, 'order_type' => 3));
if (empty($data)) {
return redirect()->route("purchasesreturn.index")->with(['error' => "عفوا غير قادر علي الوصول الي البيانات المطلوبة !!"]);
}
if ($data['is_approved'] == 1) {
return redirect()->route("purchasesreturn.show", $data['id'])->with(['error' => "عفوا لايمكن ترحيل فاتورة مرحلة من قبل !!"]);
}
$SupplierName = get_field_value(new Supplier(), "name", array("com_code" => $com_code, "suuplier_code" => $data['suuplier_code']));
$counterDetails=get_count_where(new purchases_details(),array("purchases_auto_serial"=>$auto_serial, "com_code" => $com_code, 'order_type' => 3));
if ($counterDetails== 0) {
return redirect()->route("purchasesreturn.show", $data['id'])->with(['error' => "عفوا لايمكن ترحيل الفاتورة قبل اضافة الأصناف عليها !!"]);
}

//$dataUpdateParent['total_befor_discount'] = $request['total_befor_discount'];
$dataUpdateParent['discount_type'] = $request['discount_type'];
$dataUpdateParent['discount_percent'] = $request['discount_percent'];
$dataUpdateParent['discount_value'] = $request['discount_value'];
$dataUpdateParent['total_cost'] = $request['total_cost'];
$dataUpdateParent['pill_type'] = $request['pill_type'];
$dataUpdateParent['money_for_account'] = $request['total_cost'] ;
$dataUpdateParent['is_approved'] = 1;
$dataUpdateParent['approved_by'] = auth()->user()->com_code;
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
$dataUpdateParent['updated_by'] = auth()->user()->com_code;
//first check for pill type sate cash
if ($request['pill_type'] == 1) {
if ($request['what_paid'] != $request['total_cost']) {
return redirect()->route("purchasesreturn.show", $data['id'])->with(['error' => " يجب ان يكون المبلغ بالكامل مدفوع في حالة الفاتورة نقدية !!"]);
}
}
//second  check for pill type sate agel
if ($request['pill_type'] == 2) {
if ($request['what_paid'] == $request['total_cost']) {
return redirect()->route("purchasesreturn.show", $data['id'])->with(['error' => " يجب ان لايكون المبلغ بالكامل مدفوع في حالة الفاتورة اجل !!"]);
}
}
$dataUpdateParent['what_paid'] = $request['what_paid'];
$dataUpdateParent['what_remain'] = $request['what_remain'];
//thaird  check for what paid 
if ($request['what_paid'] > 0) {
if ($request['what_paid'] > $request['total_cost']) {
return redirect()->route("purchasesreturn.show", $data['id'])->with(['error' => " يجب ان لايكون المبلغ المدفوع اكبر من اجمالي الفاتورة!!"]);
}
//check for user shift
$user_treasurcy
 = get_user_treasuries
(new Users_treasuries(), new Treasuries(), new Treasuries_transactions());
//chehck if is empty
if (empty($user_treasurcy)) {
return redirect()->route("purchasesreturn.show", $data['id'])->with(['error' => "  لاتملتك الان  خزنة مفتوحة لكي تتمكن من اتمام عمليه الصرف"]);
}
}
$flag = update(new purchases(), $dataUpdateParent, array("auto_serial" => $auto_serial, "com_code" => $com_code, 'order_type' => 3));
if ($flag) {
//Affect on Supplier Balance  سوف نؤثر رصيد المورد
//سوف نجيب  سجل المورد من الدليل المحاسبية برقم الحساب المالي
//حركات  مختلفه
//first make treasuries_transactions  action if what paid >0
if ($request['what_paid'] > 0) {
//first get isal number with treasuries 
$treasury_date = get_cols_where_row(new Treasuries(), array("last_isal_collect"), array("com_code" => $com_code, "id" => $user_treasurcy
['treasuries_id']));
if (empty($treasury_date)) {
return redirect()->route("suppliers_orders.show", $data['id'])->with(['error' => " عفوا غير قادر علي الوصول الي بيانات الخزنة المطلوبة"]);
}
$last_record_treasuries_transactions_record = get_cols_where_row_orderby(new Treasuries_transactions(), array("auto_serial"), array("com_code" => $com_code), "auto_serial", "DESC");
if (!empty($last_record_treasuries_transactions_record)) {
$dataInsert_treasuries_transactions['auto_serial'] = $last_record_treasuries_transactions_record['auto_serial'] + 1;
} else {
$dataInsert_treasuries_transactions['auto_serial'] = 1;
}
$dataInsert_treasuries_transactions['isal_number'] = $treasury_date['last_isal_collect'] + 1;

// مدين
$dataInsert_treasuries_transactions['money'] = $request['what_paid'];
$dataInsert_treasuries_transactions['treasuries_id'] = $user_treasurcy
['treasuries_id'];
$dataInsert_treasuries_transactions['mov_type'] = 10;
$dataInsert_treasuries_transactions['move_date'] = date("Y-m-d");
$dataInsert_treasuries_transactions['account_number'] = $data["account_number"];
$dataInsert_treasuries_transactions['is_account'] = 1;
$dataInsert_treasuries_transactions['is_approved'] = 1;
$dataInsert_treasuries_transactions['the_foregin_key'] = $data["auto_serial"];
//debit مدين
$dataInsert_treasuries_transactions['money_for_account'] = $request['what_paid']*(-1);
$dataInsert_treasuries_transactions['byan'] = "تحصيل نظير فاتورة مرتجع مشتريات عام فاتورة  رقم" . $auto_serial;
$dataInsert_treasuries_transactions['created_at'] = date("Y-m-Y H:i:s");
$dataInsert_treasuries_transactions['added_by'] = auth()->user()->id;
$dataInsert_treasuries_transactions['com_code'] = $com_code;
$flag = insert(new Treasuries_transactions(), $dataInsert_treasuries_transactions);
if ($flag) {
//update Treasuries last_isal_collect
$dataUpdateTreasuries['last_isal_collect'] = $dataInsert_treasuries_transactions['isal_number'];
update(new Treasuries(), $dataUpdateTreasuries, array("com_code" => $com_code, "id" => $user_treasurcy
['treasuries_id']));
}
}
refresh_account_blance_supplier($data['account_number'], new Account(), new Supplier(), new Treasuries_transactions(), new purchases(), false);
$data = get_cols_where_row_orderby(new purchases(), array("auto_serial" ), array("com_code" => $com_code, "auto_serial" => $auto_serial,'order_type'=>3),"id","desc");
if (!empty($data)) {
    $data_insert['auto_serial'] =$data['auto_serial']+1;
    $data_insert['order_type'] =3;
}else{
    $data_insert['auto_serial'] = 1;
}

$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
$flag = insert(new purchases(), $data_insert, false);
if ($flag) {

return redirect()->route("purchasesreturn.index", $data['id'])->with(['success' => " تم ترحيل الفاتورة بنجاح  "]);

} else {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
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
if ($order_date_form == '') {
//دائما  true
$field3 = "id";
$operator3 = ">";
$value3 = 0;
} else {
$field3 = "order_date";
$operator3 = ">=";
$value3 = $order_date_form;
}
if ($order_date_to == '') {
//دائما  true
$field4 = "id";
$operator4 = ">";
$value4 = 0;
} else {
$field4 = "order_date";
$operator4 = "<=";
$value4 = $order_date_to;
}
if ($search_by_text != '') {
if ($searchbyradio == 'auto_serial') {
$field5 = "auto_serial";
$operator5 = "=";
$value5 = $search_by_text;
} else {
$field5 = "auto_serial";
$operator5 = "=";
$value5 = $search_by_text;
}
} else {
//true 
$field5 = "id";
$operator5 = ">";
$value5 = 0;
}
$data = purchases::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->where($field4, $operator4, $value4)->where($field5, $operator5, $value5)->where('order_type','=',1)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
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
return view('purchases_return.ajax_search', ['data' => $data]);
}
}
public function get_item_units(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$item_code = $request->item_code;
$item_card_Data = get_cols_where_row(new items(), array( "retail_units_id", "unit_id"), array("item_code" => $item_code, "com_code" => $com_code));
if (!empty($item_card_Data)) {

    $item_card_Data['main_unit_name'] = get_field_value(new units(), "name", array("id" => $item_card_Data['unit_id']));
    $item_card_Data['retial_unit_name'] = get_field_value(new units(), "name", array("id" => $item_card_Data['retail_units_id']));
    
}
return view("purchases_return.get_item_units", ['item_card_Data' => $item_card_Data]);
}
}
public function get_item_batches(Request $request)
{
$com_code = auth()->user()->com_code;
if ($request->ajax()) {
$item_card_Data = get_cols_where_row(new items(), array("item_type", "unit_id", "retail_unit_quntToParent"), array("com_code" => $com_code, "item_code" => $request->item_code));
if (!empty($item_card_Data)) {
$requesed['unit_id'] = $request->unit_id;
$requesed['store_id'] = $request->store_id;
$requesed['item_code'] = $request->item_code;
$parent_uom = $item_card_Data['unit_id'];
$uom_Data = get_cols_where_row(new units(), array("name", "is_main"), array("com_code" => $com_code, "id" => $requesed['unit_id']));
if (!empty($uom_Data)) {
//لو صنف مخزني يبقي ههتم بالتواريخ
if ($item_card_Data['item_type'] == 2) {
$inv_itemcard_batches = get_cols_where(
new items_batches(),
array("unit_cost_price", "quantity", "production_date", "expired_date", "auto_serial"),
array("com_code" => $com_code, "store_id" => $requesed['store_id'], "item_code" => $requesed['item_code'], "unit_id" => $parent_uom),
'production_date',
'ASC'
);
} else {
$inv_itemcard_batches = get_cols_where(
new items_batches(),
array("unit_cost_price", "quantity", "auto_serial"),
array("com_code" => $com_code, "store_id" => $requesed['store_id'], "item_code" => $requesed['item_code'], "unit_id" => $parent_uom),
'id',
'ASC'
);
}
return view("purchases_return.get_item_batches", ['item_card_Data' => $item_card_Data, 'requesed' => $requesed, 'uom_Data' => $uom_Data, 'inv_itemcard_batches' => $inv_itemcard_batches]);
}
}
}
}


public function Add_item_to_invoice(Request $request)
{ 
try {
if ($request->ajax()) { 
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new purchases(), array("is_approved", "order_date", "suuplier_code","id"), array("com_code" => $com_code, "auto_serial" => $request->autoserail,'order_type'=>3));
if (!empty($data)) {  
if ($data['is_approved'] == 0) {
$batch_data = get_cols_where_row(new items_batches(), array("quantity", "unit_cost_price", "id","production_date","expired_date"), array("com_code" => $com_code, "auto_serial" => $request->items_batches_autoserial, 'store_id' => $request->store_id, 'item_code' => $request->item_code));
if (!empty($batch_data)) {
if ($batch_data['quantity'] >= $request->item_quantity) {
$itemCard_Data = get_cols_where_row(new items(), array("unit_id", "retail_unit_quntToParent", "retail_units_id","item_type"), array("com_code" => $com_code, "item_code" => $request->item_code));
if (!empty($itemCard_Data)) {
$MainUomName = get_field_value(new units(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['unit_id']));
$datainsert_items['purchases_auto_serial'] = $request->autoserail;
$datainsert_items['order_type'] = 3;
$datainsert_items['purchases_id'] = $data['id'];
$datainsert_items['order_date'] = $data['order_date'];
$datainsert_items['item_code'] = $request->item_code;
$datainsert_items['unit_id'] = $request->unit_id;
$datainsert_items['batch_auto_serial'] = $request->items_batches_autoserial;
$datainsert_items['deliverd_quantity'] = $request->item_quantity;
$datainsert_items['unit_price'] = $request->item_price;
$datainsert_items['total_price'] = $request->item_total;
$datainsert_items['ismainunit'] = $request->ismainunit;
$datainsert_items['item_card_type'] = $itemCard_Data['item_type'];
$datainsert_items['production_date'] = $batch_data['production_date'];
$datainsert_items['expire_date'] = $batch_data['expired_date'];
$datainsert_items['added_by'] = auth()->user()->id;
$datainsert_items['created_at'] = date("Y-m-d H:i:s");
$datainsert_items['com_code'] = $com_code;
$flag_datainsert_items = insert(new purchases_details(), $datainsert_items, true);
if (!empty($flag_datainsert_items)) {
    $data_R = get_cols_where_row(new purchases(), array("*"), array("com_code" => $com_code, "auto_serial" => $request->autoserail,'order_type'=>3));
if (!empty($data_R)) {
//first get sum of details
$dataUpdateParent['total_cost_items'] =get_sum_where(new purchases_details(),"total_price",array("com_code" => $com_code, "purchases_auto_serial" => $request->autoserail,'order_type'=>3));
$dataUpdateParent['total_cost'] =$dataUpdateParent['total_cost_items'];
$dataUpdateParent['total_befor_discount'] =$dataUpdateParent['total_cost_items'];
$dataUpdateParent['money_for_account'] =$dataUpdateParent['total_cost_items'];
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
$dataUpdateParent['updated_by'] = auth()->user()->com_code;
update(new purchases(), $dataUpdateParent, array("com_code" => $com_code, "auto_serial" => $request->autoserail,'order_type'=>3));
}

    
 //$this->recalclate_parent_invoice($request->autoserail);
//خصم الكمية من الباتش 
//كمية الصنف بكل المخازن قبل الحركة
$quantityBeforMove = get_sum_where(
new items_batches(),
"quantity",
array(
"item_code" => $request->item_code,
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي قبل الحركة
$quantityBeforMoveCurrntStore = get_sum_where(
new items_batches(),
"quantity",
array(
"item_code" => $request->item_code, "com_code" => $com_code,
'store_id' => $request->store_id
)
);
//هنا حخصم الكمية لحظيا من باتش الصنف
//update current Batch تحديث علي الباتش القديمة
if($request->ismainunit==1){
//حخصم بشكل مباشر لانه بنفس وحده الباتش الرئسية
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] - $request->item_quantity;
}else{
//مرجع بالوحده التجزئة التجزئة فلازم تحولها الي الرئسية قبل الخصم انتبه !!
$item_quantityByMainUnit=$request->item_quantity / $itemCard_Data['retail_unit_quntToParent'];
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] - $item_quantityByMainUnit;
}
$dataUpdateOldBatch['total_cost_price'] = $batch_data['unit_cost_price'] * $dataUpdateOldBatch['quantity'];
$dataUpdateOldBatch["updated_at"] = date("Y-m-d H:i:s");
$dataUpdateOldBatch["updated_by"] = auth()->user()->id;
$flag = update(new items_batches(), $dataUpdateOldBatch, array("id" => $batch_data['id'], "com_code" => $com_code));
if ($flag) {
$quantityAfterMove = get_sum_where(
new items_batches(),
"quantity",
array(
"item_code" => $request->item_code,
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي بعد الحركة
$quantityAfterMoveCurrentStore = get_sum_where(
new items_batches(),
"quantity",
array("item_code" => $request->item_code, "com_code" => $com_code, 'store_id' => $request->store_id)
);
//التاثير في حركة كارت الصنف
$dataInsert_inv_itemcard_movements['items_movements_categories'] = 1;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 3;
$dataInsert_inv_itemcard_movements['item_code'] = $request->item_code;
//كود الفاتورة الرئيسة
$dataInsert_inv_itemcard_movements['FK_table'] = $request->autoserail;
//كود صف التجزئة بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $flag_datainsert_items['id'];
$SupplierName = get_field_value(new Supplier(), "name", array("com_code" => $com_code, "suuplier_code" => $data['suuplier_code']));
$dataInsert_inv_itemcard_movements['byan'] = " نظير مرتجع مشتريات عام الي المورد" . " " . $SupplierName . " فاتورة رقم" . " " . $request->autoserail;
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
$dataInsert_inv_itemcard_movements["store_id"] = $request->store_id;
$dataInsert_inv_itemcard_movements["created_at"] = date("Y-m-d H:i:s");
$dataInsert_inv_itemcard_movements["added_by"] = auth()->user()->id;
$dataInsert_inv_itemcard_movements["date"] = date("Y-m-d");
$dataInsert_inv_itemcard_movements["com_code"] = $com_code;
$flag = insert(new items_movements(), $dataInsert_inv_itemcard_movements);
if ($flag) {
//update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
do_update_itemCardQuantity(
new items(),
$request->item_code,
new items_batches(),

$itemCard_Data['retail_unit_quntToParent']
);
echo  json_encode("done");
}
}
}
}
}
}
}
}
}
} catch (\Exception $ex) {
echo "there is error " . $ex->getMessage();
}
}



function recalclate_parent_invoice($auto_serial)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new purchases(), array("*"), array("com_code" => $com_code, "auto_serial" => $auto_serial,'order_type'=>3));
if (!empty($data)) {
//first get sum of details
$dataUpdateParent['total_cost_items'] =get_sum_where(new purchases_details(),"total_price",array("com_code" => $com_code, "purchases_auto_serial" => $auto_serial,'order_type'=>3));
$dataUpdateParent['total_cost'] =$dataUpdateParent['total_cost_items'];
$dataUpdateParent['total_befor_discount'] =$dataUpdateParent['total_cost_items'];
$dataUpdateParent['money_for_account'] =$dataUpdateParent['total_cost_items'];
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
$dataUpdateParent['updated_by'] = auth()->user()->com_code;
update(new purchases(), $dataUpdateParent, array("com_code" => $com_code, "auto_serial" => $auto_serial,'order_type'=>3));
}
}


public function printsaleswina4($id,$size){

    try {
    $com_code = auth()->user()->com_code;
    $invoice_data = get_cols_where_row(new purchases(), array("*"), array("id" => $id, "com_code" => $com_code, 'order_type' => 3));
    if (empty($invoice_data)) {
    return redirect()->route('suppliers_orders.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
    $invoice_data['added_by_admin'] = User::where('id', $invoice_data['added_by'])->value('name');
    $invoice_data['supplier_name'] = Supplier::where('suuplier_code', $invoice_data['suuplier_code'])->value('name');
    $invoice_data['supplier_phone'] = Supplier::where('suuplier_code', $invoice_data['suuplier_code'])->value('phones');
    $invoice_data['store_name'] = Store::where('id', $invoice_data['store_id'])->value('name');
    $invoices_details = get_cols_where(new purchases_details(), array("*"), array('purchases_auto_serial' => $invoice_data['auto_serial'], 'order_type' => 3, 'com_code' => $com_code), 'id', 'DESC');
    if (!empty($invoices_details)) {
    foreach ($invoices_details as $info) {
    $info->item_card_name = items::where('item_code', $info->item_code)->value('name');
    $info->uom_name = get_field_value(new units(), "name", array("id" => $info->unit_id));
    }
    }
    $systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
    
    if($size=="A4"){
        return view('purchases_return.printsaleswina4',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$invoices_details]);
    }
    } catch (\Exception $ex) {
    return redirect()->back()
    ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
    }
    }
    


}