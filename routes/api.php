<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

 


Route::get('device/info/{token}', 'device\AuthController@GetUserByToken');





Route::get('device/inst/detail', 'device\InstitutionsController@GetTheInstDetail');




Route::get('device/educations/detail', 'device\InstitutionsController@GetDetailEdu');



 
Route::get('device/map', 'device\InstitutionsController@MapData');


 Route::get('device/educations', 'device\InstitutionsController@GetAllEducation');

 Route::post('device/auth/social', 'device\AuthController@loginWithSocial');

 Route::post("device/auth/login/", "device\AuthController@login");
 Route::get('device/products', 'device\ProductController@index');

 Route::get('device/product', 'device\ProductController@Get_Products_Details');
 

 Route::get('device/categories', 'device\CategoryController@GetCategories');
 Route::post("device/auth/register/", "device\AuthController@register");

 Route::post("device/auth/login/", "device\AuthController@login");

 Route::get('device/inst', 'device\InstitutionsController@get');

 Route::get('drops/gettypes', 'DropsController@getTypes');

 Route::get('drops/list/data', 'DropsController@listITems');

 
 Route::get('device/drops/list/data', 'DropsController@listITemsDev');
/*auth middleware api passport token*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('device/institutions', 'device\InstitutionsController@index');




//--------------------------- Reset Password  ---------------------------

Route::group([
    'prefix' => 'password',
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::post('reset', 'PasswordResetController@reset');
});

Route::post('device/auth/password/change', 'device\AuthController@changePassword');

Route::post("device/users/message/", "device\AuthController@GetUsers");
Route::middleware(['auth:api', 'Is_Active'])->group(function () {

    Route::post('device/profile/image', 'device\AuthController@changeImage');

    Route::get('device/fav/delete', 'device\AuthController@DeleteFav');

    Route::get("device/auth/user", "device\AuthController@User");
    Route::post('device/auth/profile/update', 'device\AuthController@updateProfile');



    Route::get("device/calander", "device\AuthController@GetClanader");
    Route::post("device/calander", "device\AuthController@AddToCalander");

    Route::post("device/favourit", "device\AuthController@AddToFavourit");
    Route::get("device/favourit", "device\AuthController@GetFavourit");

    
    Route::get('device/mycart', 'device\ProductController@GetMyCart');

    Route::post('device/mycart', 'device\ProductController@AddToCart');

    
    Route::post('device/order/confirm', 'device\ProductController@storeSale');
    
    //-------------------------- Clear Cache ---------------------------

    Route::get("Clear_Cache", "SettingsController@Clear_Cache");


    Route::resource('Numbers', 'NumbersController');



    //------------------------------- Kindergrants --------------------------\
//------------------------------------------------------------------\
Route::resource('Kindergrants', 'KindergrantsController');
Route::get('Kindergrants/export/Excel', 'KindergrantsController@export_Excel');
Route::post('Kindergrants/import/csv', 'KindergrantsController@import_Kindergrants');
Route::post('Kindergrants/delete/by_selection', 'KindergrantsController@delete_by_selection');
Route::get('Kindergrants/Detail/{id}', 'KindergrantsController@Get_Kindergrants_Details');



Route::resource('Forms', 'FormsController');
Route::get('Forms/export/Excel', 'FormsController@export_Excel');
Route::post('Forms/import/csv', 'FormsController@import_forms');
Route::post('Forms/delete/by_selection', 'FormsController@delete_by_selection');
Route::get('Forms/Detail/{id}', 'FormsController@Get_Forms_Details');


    //------------------------------- Areas--------------------------\
    //------------------------------------------------------------------\
    Route::resource('areas', 'AreasController');
    Route::post('areas/delete/by_selection', 'AreasController@delete_by_selection');
    





     //-------------------------------Drops--------------------------\
    //------------------------------------------------------------------\
    Route::resource('drops', 'DropsController');
    Route::post('drops/delete/by_selection', 'DropsController@delete_by_selection');

   

     //-------------------------------Section--------------------------\
    //------------------------------------------------------------------\
    Route::resource('sections', 'SectionsController');
    Route::post('sections/delete/by_selection', 'SectionsController@delete_by_selection');





//------------------------------- Teachers --------------------------\
//------------------------------------------------------------------\
Route::resource('Teachers', 'TeachersController');
Route::get('Teachers/export/Excel', 'TeachersController@export_Excel');
Route::post('Teachers/import/csv', 'TeachersController@import_teachers');
Route::post('Teachers/delete/by_selection', 'TeachersController@delete_by_selection');
Route::get('Teachers/Detail/{id}', 'TeachersController@Get_Teachers_Details');


//------------------------------- Educations --------------------------\
//------------------------------------------------------------------\
Route::resource('Educations', 'EducationsController');
Route::get('Educations/export/Excel', 'EducationsController@export_Excel');
Route::post('Educations/import/csv', 'EducationsController@import_educations');
Route::post('Educations/delete/by_selection', 'EducationsController@delete_by_selection');
Route::get('Educations/Detail/{id}', 'EducationsController@Get_Educations_Details');



//------------------------------- Kindergartens --------------------------\
//------------------------------------------------------------------\
Route::resource('Kindergartens', 'KindergartensController');
Route::get('Kindergartens/export/Excel', 'KindergartensController@export_Excel');
Route::post('Kindergartens/import/csv', 'KindergartensController@import_kindergartens');
Route::post('Kindergartens/delete/by_selection', 'KindergartensController@delete_by_selection');
Route::get('Kindergartens/Detail/{id}', 'KindergartensController@Get_Kindergartens_Details');



//------------------------------- Educenters --------------------------\
//------------------------------------------------------------------\


Route::resource('Educenters', 'EducentersController');
Route::get('Educenters/export/Excel', 'EducentersController@export_Excel');
Route::post('Educenters/import/csv', 'EducentersController@import_educenters');
Route::post('Educenters/delete/by_selection', 'EducentersController@delete_by_selection');
Route::get('Educenters/Detail/{id}', 'EducentersController@Get_Educenters_Details');




 //------------------------------- Centers --------------------------\
//------------------------------------------------------------------\
Route::resource('Centers', 'CentersController');
Route::get('Centers/export/Excel', 'CentersController@export_Excel');
Route::post('Centers/import/csv', 'CentersController@import_centers');
Route::post('Centers/delete/by_selection', 'CentersController@delete_by_selection');
Route::get('Centers/Detail/{id}', 'CentersController@Get_Centers_Details');





                                                      //------------------------------- Specialneeds --------------------------\
//------------------------------------------------------------------\
Route::resource('Specialneeds', 'SpecialneedsController');
Route::get('Specialneeds/export/Excel', 'SpecialneedsController@export_Excel');
Route::post('Specialneeds/import/csv', 'SpecialneedsController@import_specialneeds');
Route::post('Specialneeds/delete/by_selection', 'SpecialneedsController@delete_by_selection');
Route::get('Specialneeds/Detail/{id}', 'SpecialneedsController@Get_Specialneeds_Details');





//------------------------------- Kindergartens --------------------------\
//------------------------------------------------------------------\
Route::resource('Universities', 'UniversitiesController');
 
 
Route::post('Universities/delete/by_selection', 'UniversitiesController@delete_by_selection');
Route::get('Universities/Detail/{id}', 'UniversitiesController@Get_Universities_Details');





//------------------------------- Schools --------------------------\
//------------------------------------------------------------------\
Route::resource('Schools', 'SchoolsController');
Route::get('Schools/export/Excel', 'SchoolsController@export_Excel');
Route::post('Schools/import/csv', 'SchoolsController@import_educations');
Route::post('Schools/delete/by_selection', 'SchoolsController@delete_by_selection');
Route::get('Schools/Detail/{id}', 'SchoolsController@Get_Schools_Details');


    //-------------------------- Reports ---------------------------

    Route::get("[report/client]", "ReportController@Client_Report");
    Route::get("report/client/{id}", "ReportController@Client_Report_detail");
    Route::get("report/client_Sales", "ReportController@Sales_Client");
    Route::get("report/client_payments", "ReportController@Payments_Client");
    Route::get("report/client_quotations", "ReportController@Quotations_Client");
    Route::get("report/client_returns", "ReportController@Returns_Client");
    Route::get("report/client_Top_Clients", "ReportController@TopCustomers");
    Route::get("report/TopProducts_year", "ReportController@Top_Products_Year");
    Route::get("report/TopProducts_Month", "ReportController@TopProducts_Month");
    Route::get("report/provider", "ReportController@Providers_Report");
    Route::get("report/provider/{id}", "ReportController@Provider_Report_detail");
    Route::get("report/provider_purchases", "ReportController@Purchases_Provider");
    Route::get("report/provider_payments", "ReportController@Payments_Provider");
    Route::get("report/provider_returns", "ReportController@Returns_Provider");
    Route::get("report/ToProviders", "ReportController@ToProviders");
    Route::get("report/Sales", "ReportController@Report_Sales");
    Route::get("report/Purchases", "ReportController@Report_Purchases");
    Route::get("report/Get_last_Sales", "ReportController@Get_last_Sales");
    Route::get("report/stock_alert", "ReportController@Products_Alert");
    Route::get("report/Payment_chart", "ReportController@Payment_chart");
    Route::get("report/Warehouse_Report", "ReportController@Warehouse_Report");
    Route::get("report/Sales_Warehouse", "ReportController@Sales_Warehouse");
    Route::get("report/Quotations_Warehouse", "ReportController@Quotations_Warehouse");
    Route::get("report/Returns_Sale_Warehouse", "ReportController@Returns_Sale_Warehouse");
    Route::get("report/Returns_Purchase_Warehouse", "ReportController@Returns_Purchase_Warehouse");
    Route::get("report/Expenses_Warehouse", "ReportController@Expenses_Warehouse");
    Route::get("report/Warhouse_Count_Stock", "ReportController@Warhouse_Count_Stock");
    Route::get("report/Warhouse_Value_Stock", "ReportController@Warhouse_Value_Stock");
    Route::get("report/report_today", "ReportController@report_today");
    Route::get("report/count_quantity_alert", "ReportController@count_quantity_alert");
    Route::get("report/ProfitAndLoss", "ReportController@ProfitAndLoss");
    Route::get("chart/SalesPurchasesChart", "ReportController@SalesPurchasesChart");
    Route::get("chart/report_with_echart", "ReportController@report_with_echart");
    Route::get("report/report_dashboard", "ReportController@report_dashboard");


    //------------------------------- CLIENTS --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('clients', 'ClientController');
    Route::get('clients/export/Excel', 'ClientController@exportExcel');
    Route::post('clients/import/csv', 'ClientController@import_clients');
    Route::get('Get_Clients_Without_Paginate', 'ClientController@Get_Clients_Without_Paginate');
    Route::post('clients/delete/by_selection', 'ClientController@delete_by_selection');


    //------------------------------- Providers --------------------------\\
    //--------------------------------------------------------------------\\

    Route::resource('providers', 'ProvidersController');
    Route::get('providers/export/Excel', 'ProvidersController@exportExcel');
    Route::post('providers/import/csv', 'ProvidersController@import_providers');
    Route::post('providers/delete/by_selection', 'ProvidersController@delete_by_selection');


    //---------------------- POS (point of sales) ----------------------\\
    //------------------------------------------------------------------\\

    Route::post('pos/CreatePOS', 'PosController@CreatePOS');
    Route::post('pos/calculTotal', 'PosController@CalculGrandTotal');
    Route::get('getArticlesByCategory/{id}', 'PosController@getArticlesByCategory');
    Route::get('GetProductsByParametre', 'PosController@GetProductsByParametre');
    Route::get('pos/GetELementPos', 'PosController@GetELementPos');

    //------------------------------- PRODUCTS --------------------------\\
    //------------------------------------------------------------------\\

  
   

    Route::resource('Products', 'ProductsController');
    Route::get('Products/export/Excel', 'ProductsController@export_Excel');
    Route::post('Products/import/csv', 'ProductsController@import_products');
    Route::get('Products/Warehouse/{id}', 'ProductsController@Products_by_Warehouse');
    Route::get('Products/Detail/{id}', 'ProductsController@Get_Products_Details');
    Route::get('Products/Stock/Alerts', 'ProductsController@Products_Alert');
    Route::get('Products/Get_element/barcode', 'ProductsController@Get_element_barcode');
    Route::post('Products/delete/by_selection', 'ProductsController@delete_by_selection');

    // Route::get('Products/filter/{id}/{input}', 'ProductsController@Filter_Products');


    
    //------------------------------- Institutions--------------------------\
    //------------------------------------------------------------------\
    Route::resource('institutions', 'InstitutionsController');
    Route::post('institutions/delete/by_selection', 'InstitutionsController@delete_by_selection');


    //------------------------------- Cats--------------------------\
    //------------------------------------------------------------------\
    Route::resource('cats', 'CatsController');
    Route::post('cats/delete/by_selection', 'CatsController@delete_by_selection');

    //------------------------------- Category --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('categories', 'CategorieController');
    Route::post('categories/delete/by_selection', 'CategorieController@delete_by_selection');

    //------------------------------- Units --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('units', 'UnitsController');
    Route::get('Get_Units_SubBase', 'UnitsController@Get_Units_SubBase');
    Route::get('Get_sales_units', 'UnitsController@Get_sales_units');

    //------------------------------- Brands--------------------------\\
    //------------------------------------------------------------------\\
    Route::resource('brands', 'BrandsController');
    Route::post('brands/delete/by_selection', 'BrandsController@delete_by_selection');

    //------------------------------- Currencies --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('currencies', 'CurrencyController');
    Route::get('Get_Currencies/All', 'CurrencyController@Get_Currencies');
    Route::post('currencies/delete/by_selection', 'CurrencyController@delete_by_selection');


    //------------------------------- WAREHOUSES --------------------------\\

    Route::resource('warehouses', 'WarehouseController');
    Route::get('Get_Warehouses/All', 'WarehouseController@Get_Warehouses');
    Route::post('warehouses/delete/by_selection', 'WarehouseController@delete_by_selection');

    //------------------------------- PURCHASES --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('purchases', 'PurchasesController');
    Route::get('purchases/Payments/{id}', 'PurchasesController@Get_Payments');
    Route::post('purchases/send/email', 'PurchasesController@Send_Email');
    Route::post('purchases/send/sms', 'PurchasesController@Send_SMS');
    Route::get('purchases/export/Excel', 'PurchasesController@exportExcel');
    Route::post('purchases/delete/by_selection', 'PurchasesController@delete_by_selection');


    //------------------------------- Payments  Purchases --------------------------\\
    //------------------------------------------------------------------------------\\

    Route::resource('payment/purchase', 'PaymentPurchasesController');
    Route::get('payment/purchase/Number/Order', 'PaymentPurchasesController@getNumberOrder');
    Route::get('payment/purchase/export/Excel', 'PaymentPurchasesController@exportExcel');
    Route::post('payment/purchase/send/email', 'PaymentPurchasesController@SendEmail');
    Route::post('payment/purchase/send/sms', 'PaymentPurchasesController@Send_SMS');

    //-------------------------------  Sales --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('sales', 'SalesController');
    Route::get('sales/Change_to_Sale/{id}', 'SalesController@Elemens_Change_To_Sale');
    Route::get('sales/payments/{id}', 'SalesController@Payments_Sale');
    Route::post('sales/send/email', 'SalesController@Send_Email');
    Route::post('sales/send/sms', 'SalesController@Send_SMS');
    Route::get('sales/export/Excel', 'SalesController@exportExcel');
    Route::post('sales/delete/by_selection', 'SalesController@delete_by_selection');


    //------------------------------- Payments  Sales --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('payment/sale', 'PaymentSalesController');
    Route::get('payment/sale/Number/Order', 'PaymentSalesController@getNumberOrder');
    Route::get('payment/sale/export/Excel', 'PaymentSalesController@exportExcel');
    Route::post('payment/sale/send/email', 'PaymentSalesController@SendEmail');
    Route::post('payment/sale/send/sms', 'PaymentSalesController@Send_SMS');

    //------------------------------- Expenses --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('expenses', 'ExpensesController');
    Route::get('expenses/export/Excel', 'ExpensesController@exportExcel');
    Route::post('expenses/delete/by_selection', 'ExpensesController@delete_by_selection');


    //------------------------------- Expenses Category--------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('expensescategory', 'CategoryExpenseController');
    Route::post('expensescategory/delete/by_selection', 'CategoryExpenseController@delete_by_selection');


    //------------------------------- Quotations --------------------------\\
    //------------------------------------------------------------------\\
    Route::resource('quotations', 'QuotationsController');
    Route::post('quotations/sendQuote/email', 'QuotationsController@SendEmail');
    Route::post('quotations/send/sms', 'QuotationsController@Send_SMS');
    Route::get('quotations/export/Excel', 'QuotationsController@exportExcel');
    Route::post('quotations/delete/by_selection', 'QuotationsController@delete_by_selection');

    //------------------------------- Sales Return --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('returns/sale', 'SalesReturnController');
    Route::post('returns/sale/send/email', 'SalesReturnController@Send_Email');
    Route::post('returns/sale/send/sms', 'SalesReturnController@Send_SMS');
    Route::get('returns/sale/export/Excel', 'SalesReturnController@exportExcel');
    Route::get('returns/sale/payment/{id}', 'SalesReturnController@Payment_Returns');
    Route::post('returns/sale/delete/by_selection', 'SalesReturnController@delete_by_selection');

    //------------------------------- Purchases Return --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('returns/purchase', 'PurchasesReturnController');
    Route::post('returns/purchase/send/email', 'PurchasesReturnController@Send_Email');
    Route::post('returns/purchase/send/sms', 'PurchasesReturnController@Send_SMS');
    Route::get('returns/purchase/export/Excel', 'PurchasesReturnController@exportExcel');
    Route::get('returns/purchase/payment/{id}', 'PurchasesReturnController@Payment_Returns');
    Route::post('returns/purchase/delete/by_selection', 'PurchasesReturnController@delete_by_selection');

    //------------------------------- Payment Sale Returns --------------------------\\
    //--------------------------------------------------------------------------------\\

    Route::resource('payment/returns_sale', 'PaymentSaleReturnsController');
    Route::get('payment/returns_sale/Number/order', 'PaymentSaleReturnsController@getNumberOrder');
    Route::get('payment/returns_sale/export/Excel', 'PaymentSaleReturnsController@exportExcel');
    Route::post('payment/returns_sale/send/email', 'PaymentSaleReturnsController@SendEmail');
    Route::post('payment/returns_sale/send/sms', 'PaymentSaleReturnsController@Send_SMS');

    //------------------------------- Payments Purchase Returns --------------------------\\
    //---------------------------------------------------------------------------------------\\

    Route::resource('payment/returns_purchase', 'PaymentPurchaseReturnsController');
    Route::get('payment/returns_purchase/Number/Order', 'PaymentPurchaseReturnsController@getNumberOrder');
    Route::get('payment/returns_purchase/export/Excel', 'PaymentPurchaseReturnsController@exportExcel');
    Route::post('payment/returns_purchase/send/email', 'PaymentPurchaseReturnsController@SendEmail');
    Route::post('payment/returns_purchase/send/sms', 'PaymentPurchaseReturnsController@Send_SMS');

    //------------------------------- Adjustments --------------------------\\
    //------------------------------------------------------------------\\

    Route::resource('adjustments', 'AdjustmentController');
    Route::get('adjustments/detail/{id}', 'AdjustmentController@Adjustment_detail');
    Route::get('adjustments/export/Excel', 'AdjustmentController@exportExcel');
    Route::post('adjustments/delete/by_selection', 'AdjustmentController@delete_by_selection');

    //------------------------------- Transfers --------------------------\\
    //--------------------------------------------------------------------\\
    Route::resource('transfers', 'TransferController');
    Route::get('transfers/export/Excel', 'TransferController@exportExcel');
    Route::post('transfers/delete/by_selection', 'TransferController@delete_by_selection');

    //------------------------------- Users --------------------------\\
    //------------------------------------------------------------------\\

    Route::get('GetUserAuth', 'UserController@GetUserAuth');
    Route::get("/GetPermissions", "UserController@GetPermissions");
    Route::resource('users', 'UserController');
    Route::put('users/Activated/{id}', 'UserController@IsActivated');
    Route::get('users/export/Excel', 'UserController@exportExcel');
    Route::get('users/Get_Info/Profile', 'UserController@GetInfoProfile');
    Route::put('updateProfile/{id}', 'UserController@updateProfile');

    //------------------------------- Permission Groups user -----------\\
    //------------------------------------------------------------------\\

    Route::resource('roles', 'PermissionsController');
    Route::resource('roles/check/Create_page', 'PermissionsController@Check_Create_Page');
    Route::get('getRoleswithoutpaginate', 'PermissionsController@getRoleswithoutpaginate');
    Route::post('roles/delete/by_selection', 'PermissionsController@delete_by_selection');

    
    //------------------------------- Settings ------------------------\\
    //------------------------------------------------------------------\\    
    Route::resource('settings', 'SettingsController');

    Route::put('pos_settings/{id}', 'SettingsController@update_pos_settings');
    Route::get('get_pos_Settings', 'SettingsController@get_pos_Settings');
    
    Route::put('SMTP/{id}', 'SettingsController@updateSMTP');
    Route::post('SMTP', 'SettingsController@CreateSMTP');
    Route::get('getSettings', 'SettingsController@getSettings');
    Route::get('getSMTP', 'SettingsController@getSMTP');
    Route::get('get_sms_config', 'SettingsController@get_sms_config');


    Route::post('payment_gateway', 'SettingsController@Update_payment_gateway');
    Route::post('sms_config', 'SettingsController@sms_config');
    Route::get('Get_payment_gateway', 'SettingsController@Get_payment_gateway');

    //------------------------------- Backup --------------------------\\
    //------------------------------------------------------------------\\
    
    Route::get("GetBackup", "ReportController@GetBackup");
    Route::get("GenerateBackup", "ReportController@GenerateBackup");
    Route::delete("DeleteBackup/{name}", "ReportController@DeleteBackup");

});

    //-------------------------------  Print & PDF ------------------------\\
    //------------------------------------------------------------------\\

    Route::get('Sale_PDF/{id}', 'SalesController@Sale_PDF');
    Route::get('Quote_PDF/{id}', 'QuotationsController@Quotation_pdf');
    Route::get('Purchase_PDF/{id}', 'PurchasesController@Purchase_pdf');
    Route::get('Return_sale_PDF/{id}', 'SalesReturnController@Return_pdf');
    Route::get('Return_Purchase_PDF/{id}', 'PurchasesReturnController@Return_pdf');
    Route::get('Payment_Purchase_PDF/{id}', 'PaymentPurchasesController@Payment_purchase_pdf');
    Route::get('payment_Return_sale_PDF/{id}', 'PaymentSaleReturnsController@payment_return');
    Route::get('payment_Return_Purchase_PDF/{id}', 'PaymentPurchaseReturnsController@payment_return');
    Route::get('payment_Sale_PDF/{id}', 'PaymentSalesController@payment_sale');
    Route::get('Sales/Print_Invoice/{id}', 'SalesController@Print_Invoice_POS');

   
    Route::get('Products/filter/{id}/{input}', 'ProductsController@Filter_Products');

    // deffered
    Route::resource('Deffereds', 'DefferedController');