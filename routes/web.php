<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
