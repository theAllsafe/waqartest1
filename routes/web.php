<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\CreateAdminController;
use App\Http\Controllers\Admin\AppManagementController;
use App\Http\Controllers\Api\ForgotPasswordController;

use App\Http\Controllers\Partner\PartnerLoginController;
use App\Http\Controllers\Partner\StudentRegisterController;
use App\Http\Controllers\Partner\SessionController;
use App\Http\Controllers\Partner\ClassController;
use App\Http\Controllers\Partner\SectionController;
use App\Http\Controllers\Partner\CATEGORYController;
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
//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('reset/response', [ForgotPasswordController::class, 'sendResetResponse']);
Route::get('login', [AdminLoginController::class, 'login'])->name('login');
Route::post('makelogin', [AdminLoginController::class, 'makelogin']);
Route::get('admin/dashboard', [AdminLoginController::class, 'dashboard'])->name('admin.dashboard');
Route::get('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
Route::get('admin/profile', [AdminLoginController::class, 'profile'])->name('admin.profile');
Route::post('admin/updateprofile', [AdminLoginController::class, 'updateprofile'])->name('admin.updateprofile');
Route::post('admin/changepassword', [AdminLoginController::class, 'changepassword'])->name('admin.changepassword');

Route::group(['middleware' => 'auth'], function(){
    Route::get('admin/admin', [CreateAdminController::class, 'index'])->name('admin.create.partner');
    Route::get('admin/admin/create', [CreateAdminController::class, 'create'])->name('category.create');
    Route::post('admin/admin/store', [CreateAdminController::class, 'store'])->name('category.store');
    Route::get('admin/admin/edit/{id}', [CreateAdminController::class, 'edit']);
    Route::put('admin/admin/update/{id}', [CreateAdminController::class, 'update']);
    Route::get('admin/admin/destroy/{id}', [CreateAdminController::class, 'destroy']);
    Route::post('admin/admin/status', [CreateAdminController::class, 'status']);
    
    Route::get('admin/partner', [PartnerController::class, 'index'])->name('admin.partner');
    Route::get('admin/partner/create', [PartnerController::class, 'create'])->name('admin.create');
    Route::post('admin/partner/store', [PartnerController::class, 'store'])->name('admin.store');
    Route::post('admin/partner/import', [PartnerController::class, 'import'])->name('admin.partner.import');
    Route::get('admin/partner/edit/{id}', [PartnerController::class, 'edit']);
    Route::put('admin/partner/update/{id}', [PartnerController::class, 'update']);
    Route::get('admin/partner/destroy/{id}', [PartnerController::class, 'destroy']);
    Route::post('admin/partner/status', [PartnerController::class, 'status']);
    
    Route::get('admin/student/list', [AppManagementController::class, 'index'])->name('admin.student.list');
    #---------------------------------------Partner-------------------------------------------------------------------------
    Route::get('partner/login', [PartnerLoginController::class, 'login'])->name('partner.login');
    Route::post('partner/makelogin', [PartnerLoginController::class, 'makelogin']);
    Route::get('partner/profile', [PartnerLoginController::class, 'profile'])->name('partner.profile');
    Route::post('partner/updateprofile', [PartnerLoginController::class, 'updateprofile'])->name('partner.updateprofile');
    Route::post('partner/changepassword', [PartnerLoginController::class, 'changepassword'])->name('partner.changepassword');
    Route::post('partner/instituteimage', [PartnerLoginController::class, 'instituteimage'])->name('partner.instituteimage');
    Route::get('partner/dashboard', [PartnerLoginController::class, 'dashboard'])->name('partner.dashboard');
    Route::get('partner/logout', [PartnerLoginController::class, 'logout'])->name('partner.logout');
    
    Route::get('partner/student', [StudentRegisterController::class, 'index'])->name('partner.student');
    Route::post('partner/import/store', [StudentRegisterController::class, 'import'])->name('partner.import.store');
    Route::get('partner/student/export', [StudentRegisterController::class, 'export'])->name('partner.student.export');
    Route::get('partner/student/create', [StudentRegisterController::class, 'create'])->name('partner.student.create');
    Route::post('partner/student/store', [StudentRegisterController::class, 'store'])->name('partner.student.store');
    Route::get('partner/student/edit/{id}', [StudentRegisterController::class, 'edit']);
    Route::put('partner/student/update/{id}', [StudentRegisterController::class, 'update']);
    Route::get('partner/student/show/{id}', [StudentRegisterController::class, 'show']);
    Route::get('partner/student/destroy/{id}', [StudentRegisterController::class, 'destroy']);
    Route::get('partner/student/getsection', [StudentRegisterController::class, 'getsection']);
    Route::get('partner/student/getclass', [StudentRegisterController::class, 'getclass']);
    
    Route::get('partner/session', [SessionController::class, 'index'])->name('partner.session');
    Route::post('partner/session/store', [SessionController::class, 'store'])->name('partner.session.store');
    Route::get('partner/session/edit/{id}', [SessionController::class, 'edit']);
    Route::put('partner/session/update/{id}', [SessionController::class, 'update']);
    Route::get('partner/session/destroy/{id}', [SessionController::class, 'destroy']);
    
    Route::get('partner/class', [ClassController::class, 'index'])->name('partner.class');
    Route::post('partner/class/store', [ClassController::class, 'store'])->name('partner.class.store');
    Route::get('partner/class/edit/{id}', [ClassController::class, 'edit']);
    Route::put('partner/class/update/{id}', [ClassController::class, 'update']);
    Route::get('partner/class/destroy/{id}', [ClassController::class, 'destroy']);
    
    Route::get('partner/section', [SectionController::class, 'index'])->name('partner.section');
    Route::post('partner/section/store', [SectionController::class, 'store'])->name('partner.section.store');
    Route::get('partner/section/edit/{id}', [SectionController::class, 'edit']);
    Route::put('partner/section/update/{id}', [SectionController::class, 'update']);
    Route::get('partner/section/destroy/{id}', [SectionController::class, 'destroy']);
    
    Route::get('admin/category', [CATEGORYController::class, 'index']);
    Route::post('admin/category/store', [CATEGORYController::class, 'store']);
    Route::get('admin/category/edit/{id}', [CATEGORYController::class, 'edit']);
    Route::put('admin/category/update/{id}', [CATEGORYController::class, 'update']);
    Route::get('admin/category/destroy/{id}', [CATEGORYController::class, 'destroy']);
});

// <-----------------------------------------------Chat------------------------------------------------->
Route::get('socket-check', function () {
    return view('socket_check');
});
// <----------------------------------------------------------------------------------------------------->