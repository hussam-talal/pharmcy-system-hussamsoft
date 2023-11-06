<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\MinController;
use App\Http\Controllers\Admin_panel_settingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TreasuriesController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\items_categories;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\Account_types_controller;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\SupplierCategoriesController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\SalesInvoicesController;
use App\Http\Controllers\purchasesreturn;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\repcustomers;
use App\Http\Controllers\repsuppliers;
use App\Http\Controllers\support;
use App\Http\Controllers\Inv_stores_inventoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    

define('PAGINATION_COUNT', 11);
Route::group(['middleware' => 'auth'], function () {
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/adminpanelsetting/index', [Admin_panel_settingsController::class, 'index'])->name('adminPanelSetting.index');
Route::get('/adminpanelsetting/edit', [Admin_panel_settingsController::class, 'edit'])->name('adminPanelSetting.edit');
Route::post('/adminpanelsetting/update', [Admin_panel_settingsController::class, 'update'])->name('adminPanelSetting.update');


    /*         start treasuries                */
Route::get('/treasuries/index', [TreasuriesController::class, 'index'])->name('treasuries.index');
Route::get('/treasuries/create', [TreasuriesController::class, 'create'])->name('treasuries.create');
Route::post('/treasuries/store', [TreasuriesController::class, 'store'])->name('treasuries.store');
Route::get('/treasuries/edit/{id}', [TreasuriesController::class, 'edit'])->name('treasuries.edit');
Route::post('/treasuries/update/{id}', [TreasuriesController::class, 'update'])->name('treasuries.update');
Route::post('/treasuries/ajax_search', [TreasuriesController::class, 'ajax_search'])->name('treasuries.ajax_search');
Route::get('/treasuries/details/{id}', [TreasuriesController::class, 'details'])->name('treasuries.details');
Route::get('/treasuries/Add_treasuries_delivery/{id}', [TreasuriesController::class, 'Add_treasuries_delivery'])->name('treasuries.Add_treasuries_delivery');
Route::post('/treasuries/store_treasuries_delivery/{id}', [TreasuriesController::class, 'store_treasuries_delivery'])->name('treasuries.store_treasuries_delivery');
Route::get('/treasuries/delete_treasuries_delivery/{id}', [TreasuriesController::class, 'delete_treasuries_delivery'])->name('treasuries.delete_treasuries_delivery');
/*           end treasuries                */

//حركات المخازن
Route::get('/stores/index', [StoresController::class, 'index'])->name('stores.index');
Route::get('/stores/create', [StoresController::class, 'create'])->name('stores.create');
Route::post('/stores/store', [StoresController::class, 'store'])->name('stores.store');
Route::get('/stores/edit/{id}', [StoresController::class, 'edit'])->name('stores.edit');
Route::post('/stores/update/{id}', [StoresController::class, 'update'])->name('stores.update');
Route::get('/stores/delete/{id}', [StoresController::class, 'delete'])->name('stores.delete');
Route::get('/stores_inventory/index', [Inv_stores_inventoryController::class, 'index'])->name('stores_inventory.index');
           
Route::get('/stores_inventory/create', [Inv_stores_inventoryController::class, 'create'])->name('stores_inventory.create');
Route::post('/stores_inventory/store', [Inv_stores_inventoryController::class, 'store'])->name('stores_inventory.store');
Route::get('/stores_inventory/edit/{id}', [Inv_stores_inventoryController::class, 'edit'])->name('stores_inventory.edit');
Route::post('/stores_inventory/update/{id}', [Inv_stores_inventoryController::class, 'update'])->name('stores_inventory.update');
Route::get('/stores_inventory/delete/{id}', [Inv_stores_inventoryController::class, 'delete'])->name('stores_inventory.delete');
Route::get('/stores_inventory/show/{id}', [Inv_stores_inventoryController::class, 'show'])->name('stores_inventory.show');
Route::get('/stores_inventory/do_close_parent/{id}', [Inv_stores_inventoryController::class, 'do_close_parent'])->name('stores_inventory.do_close_parent');
Route::get('/stores_inventory/load_edit_item_details', [Inv_stores_inventoryController::class, 'load_edit_item_details'])->name('stores_inventory.load_edit_item_details');
Route::post('/stores_inventory/add_new_details/{id}', [Inv_stores_inventoryController::class, 'add_new_details'])->name('stores_inventory.add_new_details');
Route::get('/stores_inventory/delete_details/{id}/{is_parent}', [Inv_stores_inventoryController::class, 'delete_details'])->name('stores_inventory.delete_details');

Route::post('/stores_inventory/ajax_search', [Inv_stores_inventoryController::class, 'ajax_search'])->name('stores_inventory.ajax_search');
Route::get('/stores_inventory/printsaleswina4/{id}/{size}', [Inv_stores_inventoryController::class, 'printsaleswina4'])->name('stores_inventory.printsaleswina4');

/*         start  Units                */
Route::get('/units/index', [UnitsController::class, 'index'])->name('units.index');
Route::get('/units/create', [UnitsController::class, 'create'])->name('units.create');
Route::post('/units/store', [UnitsController::class, 'store'])->name('units.store');
Route::get('/units/edit/{id}', [UnitsController::class, 'edit'])->name('units.edit');
Route::post('/units/update/{id}', [UnitsController::class, 'update'])->name('units.update');
Route::get('/units/delete/{id}', [UnitsController::class, 'delete'])->name('units.delete');
Route::post('/units/ajax_search', [UnitsController::class, 'ajax_search'])->name('units.ajax_search');
            /*           end Units                */
    
            /*         start  items_categories */
Route::get('/items_categories/delete/{id}', [items_categories::class, 'delete'])->name('items_categories.delete');
Route::resource('/items_categories', items_categories::class);
            /*         End items_categories */
/*         start  alternative medicine                */
Route::get('/alternatives/index', [AlternativeController::class, 'index'])->name('alternatives.index');
Route::get('/alternatives/create', [AlternativeController::class, 'create'])->name('alternatives.create');
Route::post('/alternatives/store', [AlternativeController::class, 'store'])->name('alternatives.store');
Route::get('/alternatives/edit/{id}', [AlternativeController::class, 'edit'])->name('alternatives.edit');
Route::post('/alternatives/update/{id}', [AlternativeController::class, 'update'])->name('alternatives.update');
Route::get('/alternatives/delete/{id}', [AlternativeController::class, 'delete'])->name('alternatives.delete');
Route::post('/alternatives/ajax_search', [AlternativeController::class, 'ajax_search'])->name('alternatives.ajax_search');

            /*         start  Item                */
Route::get('/items/index', [ItemsController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemsController::class, 'create'])->name('items.create');
Route::post('/items/store', [ItemsController::class, 'store'])->name('items.store');
Route::get('/items/edit/{id}', [ItemsController::class, 'edit'])->name('items.edit');
Route::post('/items/update/{id}', [ItemsController::class, 'update'])->name('items.update');
Route::get('/items/delete/{id}', [ItemsController::class, 'delete'])->name('items.delete');
Route::post('/items/ajax_search', [ItemsController::class, 'ajax_search'])->name('items.ajax_search');
Route::get('/items/show/{id}', [ItemsController::class, 'show'])->name('items.show');
Route::post('/items/ajax_search_movements', [ItemsController::class, 'ajax_search_movements'])->name('items.ajax_search_movements');
              /*           end Item                */

                /*         start  account types              */
Route::get('/accountTypes/index', [Account_types_controller::class, 'index'])->name('accountTypes.index');
               /*           end account types                */

              /*         start  accounts                */
Route::get('/accounts/index', [AccountsController::class, 'index'])->name('accounts.index');
Route::get('/accounts/create', [AccountsController::class, 'create'])->name('accounts.create');
Route::post('/accounts/store', [AccountsController::class, 'store'])->name('accounts.store');
Route::get('/accounts/edit/{id}', [AccountsController::class, 'edit'])->name('accounts.edit');
Route::post('/accounts/update/{id}', [AccountsController::class, 'update'])->name('accounts.update');
Route::get('/accounts/delete/{id}', [AccountsController::class, 'delete'])->name('accounts.delete');
Route::post('/accounts/ajax_search', [AccountsController::class, 'ajax_search'])->name('accounts.ajax_search');
Route::get('/accounts/show/{id}', [AccountsController::class, 'show'])->name('accounts.show');
              /*           end accounts                */

             /*           start customer                */
Route::get('/customer/index', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::post('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::get('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
Route::post('/customer/ajax_search', [CustomerController::class, 'ajax_search'])->name('customer.ajax_search');
Route::get('/customer/show/{id}', [CustomerController::class, 'show'])->name('customer.show');
         /*           end customer                */
        
        
        
 Route::get('/exchange_transaction/index', [ExchangeController::class, 'index'])->name('exchange_transaction.index');
 Route::get('/exchange_transaction/create', [ExchangeController::class, 'create'])->name('exchange_transaction.create');
 Route::post('/exchange_transaction/store', [ExchangeController::class, 'store'])->name('exchange_transaction.store');
 Route::post('/exchange_transaction/get_account_blance', [ExchangeController::class, 'get_account_blance'])->name('exchange_transaction.get_account_blance');
 Route::post('/exchange_transaction/ajax_search', [ExchangeController::class, 'ajax_search'])->name('exchange_transaction.ajax_search');
 
 /*         start  suppliers                */
Route::get('/supplier/index', [SuppliersController::class, 'index'])->name('supplier.index');
Route::get('/supplier/create', [SuppliersController::class, 'create'])->name('supplier.create');
Route::post('/supplier/store', [SuppliersController::class, 'store'])->name('supplier.store');
Route::get('/supplier/edit/{id}', [SuppliersController::class, 'edit'])->name('supplier.edit');
Route::post('/supplier/update/{id}', [SuppliersController::class, 'update'])->name('supplier.update');
Route::get('/supplier/delete/{id}', [SuppliersController::class, 'delete'])->name('supplier.delete');
Route::post('/supplier/ajax_search', [SuppliersController::class, 'ajax_search'])->name('supplier.ajax_search');
Route::get('/supplier/show/{id}', [SuppliersController::class, 'show'])->name('supplier.show');
      /*           end suppliers                */
/*         start suppliers_categories                */
Route::get('/suppliers_categories/index', [SupplierCategoriesController::class, 'index'])->name('suppliers_categories.index');
Route::get('/suppliers_categories/create', [SupplierCategoriesController::class, 'create'])->name('suppliers_categories.create');
Route::post('/suppliers_categories/store', [SupplierCategoriesController::class, 'store'])->name('suppliers_categories.store');
Route::get('/suppliers_categories/edit/{id}', [SupplierCategoriesController::class, 'edit'])->name('suppliers_categories.edit');
Route::post('/suppliers_categories/update/{id}', [SupplierCategoriesController::class, 'update'])->name('suppliers_categories.update');
Route::get('/suppliers_categories/delete/{id}', [SupplierCategoriesController::class, 'delete'])->name('suppliers_categories.delete');
/*           end suppliers_categories                */

            /*         start  purchases   المشتريات             */
Route::get('/purchases/index', [PurchasesController::class, 'index'])->name('purchases.index');
Route::get('/purchases/create', [PurchasesController::class, 'create'])->name('purchases.create');
Route::post('/purchases/store', [PurchasesController::class, 'store'])->name('purchases.store');
Route::get('/purchases/edit/{id}', [PurchasesController::class, 'edit'])->name('purchases.edit');
Route::post('/purchases/update/{id}', [PurchasesController::class, 'update'])->name('purchases.update');
Route::get('/purchases/delete/{id}', [PurchasesController::class, 'delete'])->name('purchases.delete');
Route::post('/purchases/ajax_search', [PurchasesController::class, 'ajax_search'])->name('purchases.ajax_search');
Route::get('/purchases/show/{id}', [PurchasesController::class, 'show'])->name('purchases.show');
Route::post('/purchases/load_modal_add_details', [PurchasesController::class, 'load_modal_add_details'])->name('purchases.load_modal_add_details');
Route::post('/purchases/add_new_details', [PurchasesController::class, 'add_new_details'])->name('purchases.add_new_details');
Route::post('/purchases/add_items_new', [PurchasesController::class, 'add_items_new'])->name('purchases.add_items_new');
Route::post('/purchases/add_items_new_items', [PurchasesController::class, 'add_items_new_items'])->name('purchases.add_items_new_items');

Route::post('/purchases/reload_itemsdetials', [PurchasesController::class, 'reload_itemsdetials'])->name('purchases.reload_itemsdetials');
Route::post('/purchases/reload_main_pill', [PurchasesController::class, 'reload_main_pill'])->name('purchases.reload_main_pill');
Route::post('/purchases/load_edit_item_details', [PurchasesController::class, 'load_edit_item_details'])->name('purchases.load_edit_item_details');
Route::post('/purchases/edit_item_details', [PurchasesController::class, 'edit_item_details'])->name('purchases.edit_item_details');
Route::get('/purchases/delete_details/{id}/{main_id}', [PurchasesController::class, 'delete_details'])->name('purchases.delete_details');
Route::post('/purchases/do_approve/{id}', [PurchasesController::class, 'do_approve'])->name('purchases.do_approve');
Route::post('/purchases/load_modal_approve_invoice', [PurchasesController::class, 'load_modal_approve_invoice'])->name('purchases.load_modal_approve_invoice');
Route::post('/purchases/load_userTreasuryDiv', [PurchasesController::class, 'load_userTreasuryDiv'])->name('purchases.load_userTreasuryDiv');
Route::get('/purchases/printsaleswina4/{id}/{size}', [PurchasesController::class, 'printsaleswina4'])->name('purchases.printsaleswina4');
               /*           end purchases               */

               /*         start treasuries                */
Route::get('/users_accounts/index', [UserController::class, 'index'])->name('users_accounts.index');
Route::get('/users_accounts/create', [UserController::class, 'create'])->name('users_accounts.create');
Route::post('/users_accounts/store', [UserController::class, 'store'])->name('users_accounts.store');
Route::get('/users_accounts/edit/{id}', [UserController::class, 'edit'])->name('users_accounts.edit');
Route::post('/users_accounts/update/{id}', [UserController::class, 'update'])->name('users_accounts.update');
Route::post('/users_accounts/ajax_search', [UserController::class, 'ajax_search'])->name('users_accounts.ajax_search');
Route::get('/users_accounts/details/{id}', [UserController::class, 'details'])->name('users_accounts.details');
Route::get('/users_accounts/Add_treasuries_delivery/{id}', [UserController::class, 'Add_treasuries_delivery'])->name('users_accounts.Add_treasuries_delivery');
Route::post('/users_accounts/Add_treasuries_To_User/{id}', [UserController::class, 'Add_treasuries_To_User'])->name('users_accounts.Add_treasuries_To_User');
Route::get('/users_accounts/delete_treasuries_delivery/{id}', [UserController::class, 'delete_treasuries_delivery'])->name('users_accounts.delete_treasuries_delivery');
               /*           end treasuries                */

               /*         start  collect_transaction                */
Route::get('/collect_transaction/index', [CollectController::class, 'index'])->name('collect_transaction.index');
Route::get('/collect_transaction/create', [CollectController::class, 'create'])->name('collect_transaction.create');
Route::post('/collect_transaction/store', [CollectController::class, 'store'])->name('collect_transaction.store');
Route::post('/collect_transaction/get_account_blance', [CollectController::class, 'get_account_blance'])->name('collect_transaction.get_account_blance');
Route::post('/collect_transaction/ajax_search', [CollectController::class, 'ajax_search'])->name('collect_transaction.ajax_search');
/*           end  collect_transaction                  */
  


/*         start  sales Invoices   المبيعات             */
Route::get('/SalesInvoices/index', [SalesInvoicesController::class, 'index'])->name('SalesInvoices.index');
Route::get('/SalesInvoices/create', [SalesInvoicesController::class, 'create'])->name('SalesInvoices.create');
Route::post('/SalesInvoices/store', [SalesInvoicesController::class, 'store'])->name('SalesInvoices.store');
Route::get('/SalesInvoices/edit/{id}', [SalesInvoicesController::class, 'edit'])->name('SalesInvoices.edit');
Route::post('/SalesInvoices/update/{id}', [SalesInvoicesController::class, 'update'])->name('SalesInvoices.update');
Route::get('/SalesInvoices/delete/{id}', [SalesInvoicesController::class, 'delete'])->name('SalesInvoices.delete');
Route::get('/SalesInvoices/show/{id}', [SalesInvoicesController::class, 'show'])->name('SalesInvoices.show');
Route::post('/SalesInvoices/get_item_units', [SalesInvoicesController::class, 'get_item_units'])->name('SalesInvoices.get_item_units');
Route::post('/SalesInvoices/get_item_batches', [SalesInvoicesController::class, 'get_item_batches'])->name('SalesInvoices.get_item_batches');
Route::post('/SalesInvoices/get_item_unit_price', [SalesInvoicesController::class, 'get_item_unit_price'])->name('SalesInvoices.get_item_unit_price');
Route::post('/SalesInvoices/get_Add_new_item_row', [SalesInvoicesController::class, 'get_Add_new_item_row'])->name('SalesInvoices.get_Add_new_item_row');
Route::post('/SalesInvoices/load_modal_addMirror', [SalesInvoicesController::class, 'load_modal_addMirror'])->name('SalesInvoices.load_modal_addMirror');
Route::post('/SalesInvoices/load_modal_addActiveInvoice', [SalesInvoicesController::class, 'load_modal_addActiveInvoice'])->name('SalesInvoices.load_modal_addActiveInvoice');
Route::post('/SalesInvoices/store', [SalesInvoicesController::class, 'store'])->name('SalesInvoices.store');
Route::get('/SalesInvoices/load_invoice_update_modal/{auto_serial}', [SalesInvoicesController::class, 'load_invoice_update_modal'])->name('SalesInvoices.load_invoice_update_modal');
Route::post('/SalesInvoices/Add_item_to_invoice', [SalesInvoicesController::class, 'Add_item_to_invoice'])->name('SalesInvoices.Add_item_to_invoice');
Route::post('/SalesInvoices/reload_main_pill', [SalesInvoicesController::class, 'reload_main_pill'])->name('SalesInvoices.reload_main_pill');

Route::post('/SalesInvoices/reload_items_in_invoice', [SalesInvoicesController::class, 'reload_items_in_invoice'])->name('SalesInvoices.reload_items_in_invoice');
Route::post('/SalesInvoices/recalclate_parent_invoice', [SalesInvoicesController::class, 'recalclate_parent_invoice'])->name('SalesInvoices.recalclate_parent_invoice');
Route::post('/SalesInvoices/remove_active_row_item', [SalesInvoicesController::class, 'remove_active_row_item'])->name('SalesInvoices.remove_active_row_item');
Route::post('/SalesInvoices/DoApproveInvoiceFinally/{auto_serial}', [SalesInvoicesController::class, 'DoApproveInvoiceFinally'])->name('SalesInvoices.DoApproveInvoiceFinally');
Route::post('/SalesInvoices/load_usershiftDiv', [SalesInvoicesController::class, 'load_usershiftDiv'])->name('SalesInvoices.load_usershiftDiv');
Route::post('/SalesInvoices/load_invoice_details_modal', [SalesInvoicesController::class, 'load_invoice_details_modal'])->name('SalesInvoices.load_invoice_details_modal');
Route::post('/SalesInvoices/ajax_search', [SalesInvoicesController::class, 'ajax_search'])->name('SalesInvoices.ajax_search');
Route::post('/SalesInvoices/do_add_new_customer', [SalesInvoicesController::class, 'do_add_new_customer'])->name('SalesInvoices.do_add_new_customer');
Route::post('/SalesInvoices/get_last_added_customer', [SalesInvoicesController::class, 'get_last_added_customer'])->name('SalesInvoices.get_last_added_customer');
Route::post('/SalesInvoices/searchforcustomer', [SalesInvoicesController::class, 'searchforcustomer'])->name('SalesInvoices.searchforcustomer');
Route::post('/SalesInvoices/searchforitems', [SalesInvoicesController::class, 'searchforitems'])->name('SalesInvoices.searchforitems');
Route::get('/SalesInvoices/printsaleswina4/{id}/{size}', [SalesInvoicesController::class, 'printsaleswina4'])->name('SalesInvoices.printsaleswina4');
/*           sales Invoices   المبيعات                   */


Route::resource('/purchasesreturn',purchasesreturn::class);
Route::get('/purchasesreturn/delete/{id}', [purchasesreturn::class, 'delete'])->name('purchasesreturn.delete');
Route::post('/purchasesreturn/ajax_search', [purchasesreturn::class, 'ajax_search'])->name('purchasesreturn.ajax_search');
Route::post('/purchasesreturn/ajax_data_items', [purchasesreturn::class, 'ajax_data_items'])->name('purchasesreturn.ajax_data_items');

Route::post('/purchasesreturn/get_item_units', [purchasesreturn::class, 'get_item_units'])->name('purchasesreturn.get_item_units');
Route::post('/purchasesreturn/load_modal_add_details', [purchasesreturn::class, 'load_modal_add_details'])->name('purchasesreturn.load_modal_add_details');
Route::post('/purchasesreturn/Add_item_to_invoice', [purchasesreturn::class, 'Add_item_to_invoice'])->name('purchasesreturn.Add_item_to_invoice');
Route::post('/purchasesreturn/reload_itemsdetials', [purchasesreturn::class, 'reload_itemsdetials'])->name('purchasesreturn.reload_itemsdetials');
Route::post('/purchasesreturn/load_edit_item_details', [purchasesreturn::class, 'load_edit_item_details'])->name('purchasesreturn.load_edit_item_details');
Route::post('/purchasesreturn/edit_item_details', [purchasesreturn::class, 'edit_item_details'])->name('purchasesreturn.edit_item_details');
Route::get('/purchasesreturn/delete_details/{id}/{id_parent}', [purchasesreturn::class, 'delete_details'])->name('purchasesreturn.delete_details');
Route::post('/purchasesreturn/do_approve/{id}', [purchasesreturn::class, 'do_approve'])->name('purchasesreturn.do_approve');
Route::post('/purchasesreturn/load_modal_approve_invoice', [purchasesreturn::class, 'load_modal_approve_invoice'])->name('purchasesreturn.load_modal_approve_invoice');
Route::post('/purchasesreturn/load_usersTreasuryDiv', [purchasesreturn::class, 'load_usersTreasuryDiv'])->name('purchasesreturn.load_usersTreasuryDiv');
Route::post('/purchasesreturn/get_item_batches', [purchasesreturn::class, 'get_item_batches'])->name('purchasesreturn.get_item_batches');
Route::get('/purchasesreturn/printsaleswina4/{id}/{size}', [purchasesreturn::class, 'printsaleswina4'])->name('purchasesreturn.printsaleswina4');
/*           end  suppliers_orders Gernal Return                */


/*           تقرير مورد                       */
Route::get('/repsuppliers/index', [repsuppliers::class, 'index'])->name('repsuppliers.index');
Route::post('/repsuppliers/create', [repsuppliers::class, 'create'])->name('repsuppliers.create');
Route::get('/repsuppliers/print/{id}/{size}/{order_date_from}/{order_date_to}/{code_sup}', [repsuppliers::class, 'print'])->name('repsuppliers.print');

/*           تقرير عميل                       */
Route::get('/repcustomers/index', [repcustomers::class, 'index'])->name('repcustomers.index');
Route::post('/repcustomers/create', [repcustomers::class, 'create'])->name('repcustomers.create');
Route::get('/repcustomers/print/{id}/{size}/{order_date_from}/{order_date_to}/{code_cus}', [repcustomers::class, 'print'])->name('repcustomers.print');

/*           الدعم الفني                       */
Route::get('/support/index', [support::class, 'index'])->name('support.index');
    


/*           المستخدمين                        */
Route::resource('users',UserController::class);
    Route::get('/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
   
   /*         صلاحيات  المستخدمين                        */
    Route::resource('roles',RoleController::class);
    Route::get('/roles/delete/{id}', [RoleController::class, 'delete'])->name('roles.delete');
    Route::post('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');

    });

    Route::group([ 'middleware' => 'guest'], function () {
        Route::get('login', [LoginController::class, 'show_login_view'])->name('showlogin');
        Route::post('login', [LoginController::class, 'login'])->name('login');
        });