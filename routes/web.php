<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OperationsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PartsController;
use App\Http\Controllers\JobCardsController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CustomAuthController::class, 'index'])->name('/');

Route::get('setSuperPermission', [HomeController::class, 'setSuperAdminPermissions'])->name('set-super');

Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('logout');

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard'); 
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::post('/user/delete/', [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/user/view', [UserController::class, 'show'])->name('users.view');

    Route::get('/ajax-roles', [UserController::class, 'rolesAjax'])->name('ajax-roles');
    
    Route::resource('operations', OperationsController::class);
    Route::post('/operations/delete/', [OperationsController::class, 'destroy'])->name('operations.delete');
    Route::get('/bulk-operations/create', [OperationsController::class, 'createBulkOperations'])->name('operations.bulk-create');
    Route::post('/operations/bulk-store', [OperationsController::class, 'storeBulkOperations'])->name('operations.bulk-store');

    Route::resource('customer', CustomersController::class);
    Route::post('/customer/delete/', [CustomersController::class, 'destroy'])->name('customer.delete');
    Route::get('/ajax-customers', [CustomersController::class, 'customerAjax'])->name('ajax-customers');
    Route::get('/customer-addresses', [CustomersController::class, 'getCustomerAddresses'])->name('customer-addresses');
    Route::get('/bulk-customer/create', [CustomersController::class, 'createBulkCustomers'])->name('customer.bulk-create');
    Route::post('/customer/bulk-store', [CustomersController::class, 'storeBulkCustomers'])->name('customer.bulk-store');

    Route::resource('order', OrdersController::class);
    Route::post('/order/delete/', [OrdersController::class, 'destroy'])->name('order.delete');

    Route::get('/job-cards/{order}', [JobCardsController::class, 'show'])->name('job-cards');
    Route::post('/job-cards-save', [JobCardsController::class, 'store'])->name('job-cards-save');
    Route::get('/order-part-data', [JobCardsController::class, 'getOrderPartDetails'])->name('order-part-data');
    Route::get('/view-jobcard', [JobCardsController::class, 'getJobCardDetails'])->name('view-jobcard');
    Route::post('/job-card/delete/', [JobCardsController::class, 'destroy'])->name('job-card.delete');

    Route::post('/job-operation-save', [JobCardsController::class, 'storeOperation'])->name('job-operation-save');
    Route::get('/ajax-operations', [JobCardsController::class, 'operationsAjax'])->name('ajax-operations');
    Route::get('/view-joboperation', [JobCardsController::class, 'getJobOperationDetails'])->name('view-joboperation');
    Route::post('/job-operation/delete/', [JobCardsController::class, 'destroyOperation'])->name('job-operation.delete');
    
    Route::resource('parts', PartsController::class);
    Route::post('/parts/delete/', [PartsController::class, 'destroy'])->name('parts.delete');
    Route::get('/bulk-parts/create', [PartsController::class, 'createBulkParts'])->name('parts.bulk-create');
    Route::post('/parts/bulk-store', [PartsController::class, 'storeBulkParts'])->name('parts.bulk-store');
    Route::get('/ajax-parts', [PartsController::class, 'partsAjax'])->name('ajax-parts');

    Route::resource('sopc', ReportController::class);
    Route::get('/sopc/notification/{id}', [ReportController::class, 'notificationSettings'])->name('sopc.notification');
    Route::post('/sopc-setting-store', [ReportController::class, 'storeNotificationSettings'])->name('sopc.setting-store');
    Route::get('/sopc/timeline/{id}', [ReportController::class, 'timeline'])->name('sopc.timeline');
    Route::get('/sopc/status/{id}', [ReportController::class, 'sopcStatus'])->name('sopc.status');
    Route::post('/sopc-status-store', [ReportController::class, 'storeStatus'])->name('sopc.status-store');
    Route::post('/line-cancel', [ReportController::class, 'cancelLine'])->name('line.cancel');
    Route::post('/line-add', [ReportController::class, 'addNewLine'])->name('line.add');

    Route::get('/notifications', [HomeController::class, 'notifications'])->name('notifications');
    Route::get('/cron', [ReportController::class, 'cron'])->name('cron');
});
