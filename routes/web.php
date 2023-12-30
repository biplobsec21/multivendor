<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BrandController as BackendBrandController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\User\AllUserController as UserAllUserController;

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('frontend.index');
});
Route::middleware(['auth'])->group(function() {

    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');

    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');

    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');

    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');


}); // Gorup Milldeware End
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
 // User Dashboard All Route
 Route::controller(UserAllUserController::class)->group(function(){
    Route::get('/user/account/page' , 'UserAccount')->name('user.account.page');
    Route::get('/user/change/password' , 'UserChangePassword')->name('user.change.password');

    Route::get('/user/order/page' , 'UserOrderPage')->name('user.order.page');

    Route::get('/user/order_details/{order_id}' , 'UserOrderDetails');
    Route::get('/user/invoice_download/{order_id}' , 'UserOrderInvoice');

    Route::post('/return/order/{order_id}' , 'ReturnOrder')->name('return.order');

    Route::get('/return/order/page' , 'ReturnOrderPage')->name('return.order.page');

     // Order Tracking
     Route::get('/user/track/order' , 'UserTrackOrder')->name('user.track.order');
     Route::post('/order/tracking' , 'OrderTracking')->name('order.tracking');

   });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/admin/logout',[AdminController::class,'logout'])->name('admin.logout');
    Route::get('/admin/profile',[AdminController::class,'profile'])->name('admin.profile');
    Route::post('/admin/profile/store',[AdminController::class,'store'])->name('admin.profile.store');
    Route::get('/admin/profile/changePassword',[AdminController::class,'changePassword'])->name('admin.profile.changepassword');
    Route::post('/admin/profile/updatePassword',[AdminController::class,'updatePassword'])->name('admin.profile.updatepassword');
});

Route::middleware(['auth','role:vendor'])->group(function(){
    Route::get('/vendor/dashboard',[VendorController::class,'dashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout',[VendorController::class,'logout'])->name('vendor.logout');
    Route::get('/vendor/profile',[VendorController::class,'profile'])->name('vendor.profile');
    Route::post('/vendor/profile/store',[VendorController::class,'store'])->name('vendor.profile.store');
    Route::get('/vendor/profile/changePassword',[VendorController::class,'changePassword'])->name('vendor.profile.changepassword');
    Route::post('/vendor/profile/updatePassword',[VendorController::class,'updatePassword'])->name('vendor.profile.updatepassword');
});
Route::get('/admin/login',[AdminController::class,'login'])->name('admin.login');
Route::get('/vendor/login',[VendorController::class,'login'])->name('vendor.login');


// for admin only
Route::middleware(['auth','role:admin'])->group(function() {

    // Brand All Route
   Route::controller(BackendBrandController::class)->group(function(){
       Route::get('/all/brand' , 'AllBrand')->name('all.brand');
       Route::get('/add/brand' , 'AddBrand')->name('add.brand');
       Route::post('/store/brand' , 'StoreBrand')->name('store.brand');
       Route::get('/edit/brand/{id}' , 'EditBrand')->name('edit.brand');
       Route::post('/update/brand' , 'UpdateBrand')->name('update.brand');
       Route::get('/delete/brand/{id}' , 'DeleteBrand')->name('delete.brand');

   });


//     // Category All Route
//    Route::controller(CategoryController::class)->group(function(){
//        Route::get('/all/category' , 'AllCategory')->name('all.category');
//        Route::get('/add/category' , 'AddCategory')->name('add.category');
//        Route::post('/store/category' , 'StoreCategory')->name('store.category');
//        Route::get('/edit/category/{id}' , 'EditCategory')->name('edit.category');
//        Route::post('/update/category' , 'UpdateCategory')->name('update.category');
//        Route::get('/delete/category/{id}' , 'DeleteCategory')->name('delete.category');

//    });


//     // Category All Route
//    Route::controller(SubCategoryController::class)->group(function(){
//        Route::get('/all/subcategory' , 'AllSubCategory')->name('all.subcategory');
//        Route::get('/add/subcategory' , 'AddSubCategory')->name('add.subcategory');
//        Route::post('/store/subcategory' , 'StoreSubCategory')->name('store.subcategory');
//        Route::get('/edit/subcategory/{id}' , 'EditSubCategory')->name('edit.subcategory');
//        Route::post('/update/subcategory' , 'UpdateSubCategory')->name('update.subcategory');
//        Route::get('/delete/subcategory/{id}' , 'DeleteSubCategory')->name('delete.subcategory');
//        Route::get('/subcategory/ajax/{category_id}' , 'GetSubCategory');

//    });


//     // Vendor Active and Inactive All Route
//    Route::controller(AdminController::class)->group(function(){
//         Route::get('/inactive/vendor' , 'InactiveVendor')->name('inactive.vendor');
//         Route::get('/active/vendor' , 'ActiveVendor')->name('active.vendor');
//         Route::get('/inactive/vendor/details/{id}' , 'InactiveVendorDetails')->name('inactive.vendor.details');
//         Route::post('/active/vendor/approve' , 'ActiveVendorApprove')->name('active.vendor.approve');
//         Route::get('/active/vendor/details/{id}' , 'ActiveVendorDetails')->name('active.vendor.details');
//         Route::post('/inactive/vendor/approve' , 'InActiveVendorApprove')->name('inactive.vendor.approve');
//    });
});
