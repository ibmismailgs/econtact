<?php

use App\Models\CallManagement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customers\SmsController;
use App\Http\Controllers\Settings\GroupController;
use App\Http\Controllers\Settings\ThanaController;
use App\Http\Controllers\Customers\EmailController;
use App\Http\Controllers\Settings\OutletController;
use App\Http\Controllers\Customers\ReportController;
use App\Http\Controllers\Customers\MeetingController;
use App\Http\Controllers\Settings\CallTypeController;
use App\Http\Controllers\Settings\DistrictController;
use App\Http\Controllers\Settings\DivisionController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Customers\CustomerController;
use App\Http\Controllers\Customers\WhatsappController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Customers\QuotationController;
use App\Http\Controllers\Settings\MeetingTypeController;
use App\Http\Controllers\Settings\ClientSourceController;
use App\Http\Controllers\Settings\CustomerTypeController;
use App\Http\Controllers\Settings\QuotationTypeController;
use App\Http\Controllers\Settings\GeneralSettingController;
use App\Http\Controllers\Customers\CallManagementController;
use App\Http\Controllers\Customers\MeetingMinutesController;
use App\Http\Controllers\Settings\CustomerCategoryController;

/*0
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class,'index']);
Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () {
	return view('pages.forgot-password');
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);

	// dashboard route
	Route::get('/dashboard', [HomeController::class,'dashboard'])->name('dashboard');

	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
	Route::get('/users', [UserController::class,'index']);
	Route::get('/user/get-list', [UserController::class,'getUserList']);
		Route::get('/user/create', [UserController::class,'create']);
		Route::post('/user/create', [UserController::class,'store'])->name('create-user');
		Route::get('/user/{id}', [UserController::class,'edit']);
		Route::post('/user/update', [UserController::class,'update']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::get('/role/create', [RolesController::class,'create']);
        Route::post('/role/store', [RolesController::class,'store'])->name('role-store');
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);

    //general settings
    Route::get('general-settings', [GeneralSettingController::class, 'index'])->name('general-settings');
    Route::post('general-settings-store', [GeneralSettingController::class, 'store'])->name('general-settings-store');

    //division
    Route::get('division', [DivisionController::class, "index"])->name('division.index');
    Route::get('division/create', [DivisionController::class, "store"])->name('division.store');
    Route::get('division/edit/{id}', [DivisionController::class, "edit"])->name('division.edit');
    Route::get('division/update/{id}', [DivisionController::class, "update"])->name('division.update');
    Route::delete('division/destory/{id}', [DivisionController::class, "destroy"])->name('division.destroy');
    Route::get('division-status', [DivisionController::class,'StatusChange'])->name('division.status');

    //district
    Route::get('district', [DistrictController::class, "index"])->name('district.index');
    Route::get('district/create', [DistrictController::class, "store"])->name('district.store');
    Route::get('district/edit/{id}', [DistrictController::class, "edit"])->name('district.edit');
    Route::get('district/update/{id}', [DistrictController::class, "update"])->name('district.update');
    Route::delete('district/destory/{id}', [DistrictController::class, "destroy"])->name('district.destroy');
    Route::get('district-status', [DistrictController::class,'StatusChange'])->name('district.status');

    //thana
    Route::get('thana', [ThanaController::class, "index"])->name('thana.index');
    Route::get('thana/create', [ThanaController::class, "store"])->name('thana.store');
    Route::get('thana/edit/{id}', [ThanaController::class, "edit"])->name('thana.edit');
    Route::get('thana/update/{id}', [ThanaController::class, "update"])->name('thana.update');
    Route::delete('thana/destory/{id}', [ThanaController::class, "destroy"])->name('thana.destroy');
    Route::get('thana-status', [ThanaController::class,'StatusChange'])->name('thana.status');
    Route::get('division-wise-district', [ThanaController::class,'DivisionWiseDistrict'])->name('division-wise-district');
    Route::get('district-wise-thana', [ThanaController::class,'DistrictWiseThana'])->name('district-wise-thana');

    //client source
    Route::get('client-source', [ClientSourceController::class, "index"])->name('client-source.index');
    Route::get('client-source/create', [ClientSourceController::class, "store"])->name('client-source.store');
    Route::get('client-source/edit/{id}', [ClientSourceController::class, "edit"])->name('client-source.edit');
    Route::get('client-source/update/{id}', [ClientSourceController::class, "update"])->name('client-source.update');
    Route::delete('client-source/destory/{id}', [ClientSourceController::class, "destroy"])->name('client-source.destroy');
    Route::get('client-source.status', [ClientSourceController::class,'StatusChange'])->name('client-source.status');

    //customer type
    Route::get('client-type', [CustomerTypeController::class, "index"])->name('customer-type.index');
    Route::get('client-type/create', [CustomerTypeController::class, "store"])->name('customer-type.store');
    Route::get('client-type/edit/{id}', [CustomerTypeController::class, "edit"])->name('customer-type.edit');
    Route::get('client-type/update/{id}', [CustomerTypeController::class, "update"])->name('customer-type.update');
    Route::delete('client-type/destory/{id}', [CustomerTypeController::class, "destroy"])->name('customer-type.destroy');
    Route::get('client-type.status', [CustomerTypeController::class,'StatusChange'])->name('customer-type.status');

    //customer categories
    Route::get('client-categories', [CustomerCategoryController::class, "index"])->name('customer-categories.index');
    Route::get('client-categories/create', [CustomerCategoryController::class, "store"])->name('customer-categories.store');
    Route::get('client-categories/edit/{id}', [CustomerCategoryController::class, "edit"])->name('customer-categories.edit');
    Route::get('client-categories/update/{id}', [CustomerCategoryController::class, "update"])->name('customer-categories.update');
    Route::delete('client-categories/destory/{id}', [CustomerCategoryController::class, "destroy"])->name('customer-categories.destroy');
    Route::get('client-categories.status', [CustomerCategoryController::class,'StatusChange'])->name('customer-categories.status');
    Route::get('category-wise-subcategory', [CustomerCategoryController::class,'CategoryWiseSubcategory'])->name('category-wise-subcategory');

    //outlet
    Route::get('outlet', [OutletController::class, "index"])->name('outlet.index');
    Route::get('outlet/create', [OutletController::class, "store"])->name('outlet.store');
    Route::get('outlet/edit/{id}', [OutletController::class, "edit"])->name('outlet.edit');
    Route::get('outlet/update/{id}', [OutletController::class, "update"])->name('outlet.update');
    Route::delete('outlet/destory/{id}', [OutletController::class, "destroy"])->name('outlet.destroy');
    Route::get('outlet.status', [OutletController::class,'StatusChange'])->name('outlet.status');

    //meeting-type
    Route::get('meeting-type', [MeetingTypeController::class, "index"])->name('meeting-type.index');
    Route::get('meeting-type/create', [MeetingTypeController::class, "store"])->name('meeting-type.store');
    Route::get('meeting-type/edit/{id}', [MeetingTypeController::class, "edit"])->name('meeting-type.edit');
    Route::get('meeting-type/update/{id}', [MeetingTypeController::class, "update"])->name('meeting-type.update');
    Route::delete('meeting-type/destory/{id}', [MeetingTypeController::class, "destroy"])->name('meeting-type.destroy');
    Route::get('meeting-type.status', [MeetingTypeController::class,'StatusChange'])->name('meeting-type.status');

    //quotation-type
    Route::get('quotation-type', [QuotationTypeController::class, "index"])->name('quotation-type.index');
    Route::get('quotation-type/create', [QuotationTypeController::class, "store"])->name('quotation-type.store');
    Route::get('quotation-type/edit/{id}', [QuotationTypeController::class, "edit"])->name('quotation-type.edit');
    Route::get('quotation-type/update/{id}', [QuotationTypeController::class, "update"])->name('quotation-type.update');
    Route::delete('quotation-type/destory/{id}', [QuotationTypeController::class, "destroy"])->name('quotation-type.destroy');
    Route::get('quotation-type.status', [QuotationTypeController::class,'StatusChange'])->name('quotation-type.status');

    //call-type
    Route::get('call-type', [CallTypeController::class, "index"])->name('call-type.index');
    Route::get('call-type/create', [CallTypeController::class, "store"])->name('call-type.store');
    Route::get('call-type/edit/{id}', [CallTypeController::class, "edit"])->name('call-type.edit');
    Route::get('call-type/update/{id}', [CallTypeController::class, "update"])->name('call-type.update');
    Route::delete('call-type/destory/{id}', [CallTypeController::class, "destroy"])->name('call-type.destroy');
    Route::get('call-type.status', [CallTypeController::class,'StatusChange'])->name('call-type.status');

    //group
    Route::get('group', [GroupController::class, "index"])->name('group.index');
    Route::get('group/create', [GroupController::class, "store"])->name('group.store');
    Route::get('group/edit/{id}', [GroupController::class, "edit"])->name('group.edit');
    Route::get('group/update/{id}', [GroupController::class, "update"])->name('group.update');
    Route::delete('group/destory/{id}', [GroupController::class, "destroy"])->name('group.destroy');
    Route::get('group.status', [GroupController::class,'StatusChange'])->name('group.status');

    //meeting
    Route::resource('meeting', MeetingController::class);
    Route::get('meeting.status/{id}', [MeetingController::class,'MeetingStatus'])->name('meeting.status');
    Route::get('meeting.status/store/{id}', [MeetingController::class,'meetingStatustore'])->name('meeting.status.store');
    Route::get('meeting-minute/{id}', [MeetingMinutesController::class, "meetingMinute"])->name('meeting-minute');
    Route::get('meeting-minutes/create', [MeetingMinutesController::class, "meetingMinuteStore"])->name('meeting-minutes.create');
    Route::get('meeting-reschedule/{id}', [MeetingMinutesController::class, "meetingReschedule"])->name('meeting-reschedule');
    Route::get('meeting-reschedules/create', [MeetingMinutesController::class, "meetingRescheduleStore"])->name('meeting-reschedule.create');

    //customer
    Route::resource('client', CustomerController::class);
    Route::get('client.status', [CustomerController::class,'StatusChange'])->name('client.status');
    Route::get('client-assign/{id}', [CustomerController::class,'clientAssign'])->name('client.assign');
    Route::get('client-assign/create/{id}', [CustomerController::class,'clientAssignStore'])->name('client.assign.create');
    Route::get('customer-check', [CustomerController::class,'customerCheck'])->name('customer-check');

    Route::get('customer-export', [CustomerController::class, 'CustomerExport'])->name('customer-export');

    Route::get('excel-download', [CustomerController::class, 'ExcelDownload'])->name('excel-download');
    Route::post('excel-import', [CustomerController::class, 'ExcelImport'])->name('excel-import');

    //sms marketing
    Route::resource('sms-marketing', SmsController::class);
    Route::get('sms.status', [SmsController::class,'StatusChange'])->name('sms.status');
    Route::get('user-wise-client', [SmsController::class,'UserWiseClient'])->name('user-wise-client');
    //email marketing
    Route::resource('email-marketing', EmailController::class);
    Route::get('email.status', [EmailController::class,'StatusChange'])->name('email.status');
    //whatsapp marketing
    Route::resource('whatsapp-marketing', WhatsappController::class);
    Route::get('whatsapp.status', [WhatsappController::class,'StatusChange'])->name('whatsapp.status');

    //quotation
    Route::resource('quotations', QuotationController::class);
    Route::get('quotation.status', [QuotationController::class,'StatusChange'])->name('quotation.status');
    Route::get('quotation/{id}', [QuotationController::class, "quotation"])->name('quotation');
    Route::get('quotation.store', [QuotationController::class, "quotationStore"])->name('quotation.store');

    Route::get('quotation.status/{id}', [QuotationController::class,'QuotationStatus'])->name('quotation.status');
    Route::get('quotation.status/store/{id}', [QuotationController::class,'QuotationStatuStore'])->name('quotation.status.store');

    Route::resource('call-management', CallManagementController::class);

    //reports
    Route::get('client-report', [ReportController::class,'clientReport'])->name('client-report');
    Route::get('meeting-report', [ReportController::class,'meetingReport'])->name('meeting-report');
    Route::get('quotation-report', [ReportController::class,'quotationReport'])->name('quotation-report');
    Route::get('call-management-report', [ReportController::class,'callReport'])->name('call-management-report');

});


Route::get('/register', function () { return view('pages.register'); });
Route::get('/login-1', function () { return view('pages.login'); });
