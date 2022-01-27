<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WalmartGetAllTemsController;
use App\Http\Controllers\testingApiController;
use App\Http\Controllers\Walmart\WalmartAlertEmailController;
use App\User;

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

Route::get('dashboard', 'UserController@dashboard')->middleware('auth');

/*Route::get('/', function () {
    return view('welcome');
});*/
//Auth::routes(['verify' => true]);

//Route::get('/', 'HomeController@index');
//Route::get('/dashboard_first', function(){
//    return view('front_dashboard');
//});

//Route::group(['middleware' => 'auth'] , function(){

Auth::routes(['verify' => true]);

    Route::prefix('dashboard')->group(function () {

        Route::get('/product' , [WalmartGetAllTemsController::class , 'index'])->name('dashboard.index');
        Route::post('/check' , [WalmartGetAllTemsController::class , 'checkProduct'])->name('dashboard.check');
        Route::get('/emailtemplate' , [WalmartGetAllTemsController::class , 'emailTemplate'])->name('dashboard.check');
        Route::get('/testing' , [testingApiController::class , 'index'])->name('dashboard.testing');
        Route::post('/working' , [testingApiController::class , 'testing'])->name('dashboard.index');

    });

    Route::prefix('dashboard')->group(function () {

        Route::get('/walmart_email_alert' , [WalmartAlertEmailController::class , 'index'])->name('dashboard.walmart_email_alert');
        Route::get('/email_template/{id}' , [WalmartAlertEmailController::class , 'email_template'])->name('dashboard.email_template');

    });




## Subscription start
Route::get('/subscription','SubscriptionController@index')->name('subscription');
Route::post('/subscription','SubscriptionController@payment')->name('subscription_post');

## Subscription end

Route::get('/subscribers','SubscriberController@index')->name('subscribers');
Route::get('/sellers','SellersController@index')->name('sellers');

## get all list of items using walmart api start
Route::get('/walmartListing','GetAllOrdersController@get_all_items')->name('walmartListing');
Route::get('/walmartOrders','GetAllOrdersController@get_all_orders')->name('walmartOrders');


Route::get('/items',function(){

    $data['subscription_plans'] = DB::table('subscription_plans')
            ->select('*')
            ->where('user_id',1)
            ->get();

    return view('walmarts/items',$data);

});

## get all list of items using walmart api end



## Subscription Plan start
Route::get('subscription_plan','SunscriptionPlanController@index')->name('subscription_plan');
Route::get('subscription_plan','SunscriptionPlanController@index')->name('subscription_plan.index');
Route::post('subscription_plan/store','SunscriptionPlanController@store')->name('subscription_plan.store');
Route::post('subscription_plan/update','SunscriptionPlanController@update')->name('subscription_plan.update');
Route::get('subscription_plan/destroy','SunscriptionPlanController@destroy')->name('subscription_plan.destroy');
//Route::get('/subscription_plan','SubscriptionPlanController@subscription_plan')->name('subscription_plan');
//Route::post('/subscription_plan','SubscriptionController@subscription_plan_list')->name('subscription_plan_post');
## Subscription PLan end


## Settings page route start
Route::post('/walmartSetting', 'UsersController@walmartSetting')->name('walmartSetting');
Route::post('/changePassword', 'UsersController@changePassword')->name('changePassword');
Route::post('/AmazonSettingsUpdate', 'UsersController@AmazonSettingsUpdate')->name('AmazonSettingsUpdate');
## Settings page route end



//Route::get('/sign-up','SignupController@index')->name('sign-up');
Route::get('register','SignupController@index')->name('register_get');
Route::post('register','SignupController@postRegister')->name('user_register');


Route::get('forget-password', 'ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
Route::get('reset-password/{token}', 'ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post'); 



Route::get('/home', 'HomeController@index')->name('home');
Route::get('/scrapping', 'HomeController@scrap');
Route::get('/scrapproduct', 'HomeController@scrapproduct');
Route::get('/logout', 'HomeController@logout')->name('logout');

## View 
Route::get('/users', 'UsersController@index')->name('users');
Route::get('/profile/setting', 'UsersController@profile')->name('profile.setting');
Route::post('/mwsSettingUpdate', 'UsersController@mwsSettingUpdate')->name('mwsSettingUpdate');
## Create
Route::get('/users/create', 'UsersController@create')->name('users.create');
Route::post('/users/store', 'UsersController@store')->name('users.store');
## Update
Route::get('/users/store/{id}', 'UsersController@edit')->name('users.edit');
Route::post('/users/update/{id}', 'UsersController@update')->name('users.update');
## Delete
Route::get('/users/delete/{id}', 'UsersController@destroy')->name('users.delete');



Route::get('/roles', 'RoleController@index')->name('roles');
Route::get('/roles/create', 'RoleController@create')->name('roles.create');
Route::post('/roles/store', 'RoleController@store')->name('roles.store');
Route::get('/roles/store/{id}', 'RoleController@edit')->name('roles.edit');
Route::post('/roles/update/{id}', 'RoleController@update')->name('roles.update');
Route::get('/roles/delete/{id}', 'RoleController@destroy')->name('roles.delete');

Route::get('/batch', 'BatchController@index')->name('batch');
Route::get('/list', 'BatchController@list')->name('list');
Route::get('/batch/create', 'BatchController@addBatch')->name('batch.create');
Route::post('/batch/store', 'BatchController@store')->name('batch.store');
Route::post('/batch/edit_batch', 'BatchController@edit_batch')->name('batch.edit_batch');
Route::post('/searchAsin', 'BatchController@searchAsin')->name('searchAsin');
Route::post('/createmsku', 'BatchController@createmsku')->name('createmsku');

Route::get('/createShipment', 'ShipmentController@createShipment')->name('createShipment');
Route::get('/createShipmentPlan', 'HomeController@createShipmentPlan')->name('createShipmentPlan');
Route::get('/getPrepInstructions', 'HomeController@getPrepInstructions')->name('getPrepInstructions');

Route::get('/web_scraping', 'TestController@scraping');

Route::get('/walmart', 'WalmartController@index')->name('walmart');

Route::get('/walmartScrap', 'WalmartScrapController@index')->name('walmartScrap');
Route::post('/walmartScrapCat', 'WalmartScrapController@scrapCategory')->name('walmartScrapCat');
Route::get('/walmartproductlist', 'WalmartScrapController@walmartProductLog')->name('walmartproductlist');
Route::post('/walmartproductlist', 'WalmartScrapController@walmartProductLog')->name('walmartproductlist');
Route::get('/getAmazonPrice', 'WalmartScrapController@getAmazonPrice')->name('getAmazonPrice');
Route::post('/walmartproduct/filter', 'WalmartScrapController@filter')->name('walmart.filter');
//Route::get('/walmartScrapCategory', 'WalmartScrapController@scrapCategory');

/*Route::get('/globalnav/vanilla-fragments/mobile/get-all', function() {
    //return redirect('https://www.walmart.com/globalnav/vanilla-fragments/mobile/get-all');
    file_get_contents("https://www.walmart.com/globalnav/vanilla-fragments/mobile/get-all");
});*/
Route::get('/amazonExportedList', 'AmazonMWSController@index')->name('amazonExportedList');
Route::get('/amazon/productList', 'AmazonMWSController@product_list')->name('amazon.productList');
Route::post('/amazon/productList', 'AmazonMWSController@product_list')->name('amazon.productList');
Route::get('/productImportedList', 'AmazonMWSController@importedList')->name('productImportedList');
Route::get('/file_import_export', 'AmazonMWSController@fileImportExport')->name('file_import_export');
Route::post('/fileExport', 'AmazonMWSController@fileExport')->name('fileExport');
Route::get('/product/add', 'AmazonMWSController@add')->name('product.add');
Route::post('/product/upload', 'AmazonMWSController@upload')->name('product.upload');
Route::post('/amazonproduct/filter', 'AmazonMWSController@filter')->name('amazon.filter');

Route::get('/amazon/orderList', 'OrderController@index')->name('amazon.orderList');
Route::get('/orderList', 'OrderController@index')->name('orderList');
Route::get('/orderUpdate', 'OrderController@updateMwsOrderList')->name('orderUpdate');
Route::get('/amazon/refreshOrders', 'OrderController@refreshAmazonOrders')->name('amazon.refreshOrders');
Route::get('/amazon/feedbackRequest', 'OrderController@feedbackRequest')->name('amazon.feedbackRequest');
Route::get('/amazon/performanceRequest', 'OrderController@performanceRequest')->name('amazon.performanceRequest');

Route::get('/globalnav/vanilla-fragments/mobile/get-all', function () {
    return response()->streamDownload(function () {
        echo file_get_contents('https://www.walmart.com/globalnav/vanilla-fragments/mobile/get-all');
    });
});

/*Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
});*/


## Get and Set Rules

Route::get('shipping_program','RulesController@index')->name('shipping_program');
Route::get('delivered_order','RulesController@deliverdProduct')->name('delivered_order');
Route::get('shipped_order','RulesController@shipingProduct')->name('shipped_order');
Route::get('template','RulesController@template')->name('template');

// Route::get('pay' , 'PaymentController@pay')->name('pay');
// Route::post('/dopay/online' , 'PaymentController:@handleonlinepay')->name('dopay.online');

Route::get('authorization' , [PaymentController::class , 'viewAuthorization'])->name('authorization');
Route::get('pay' , [PaymentController::class , 'pay'])->name('pay');
Route::post('/dopay/online' , [PaymentController::class , 'handleonlinepay'])->name('dopay.online');

//});

//********** End of middleware */

//Route::get('userchangepassword', function() {
//    $user = User::where('email', 'seller@gmail.com')->first();
//    $user->password = Hash::make('amz4blog2021@!');
//    $user->save();
//
//    echo 'Password changed successfully.';
//});

## amzaon auth

##Route::get('amazon_auth','AmazonAuthenticationController@AmzAuthenticated');

##Route::get('/orders','UsersController@all_orders_notifications')->name('all_orders');
##Route::get('/walmart_orders','UsersController@walmart_orders_notifications')->name('walmart_orders');
##Route::get('/walmart_order','UsersController@walmart_orders_notification');

##Route::get('/amazon_reports','AmazonController@getfullfilmentreport');
##Route::get('/affected_walmart_notification','UsersController@item_affected_notification');
