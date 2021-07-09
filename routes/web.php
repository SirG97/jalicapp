<?php

use App\Http\Controllers\ContributionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('dashboard', [HomeController::class, 'index'])->name('home');

Route::get( 'staff/{id}', [HomeController::class, 'getSingleStaff']);
Route::get('staff', [HomeController::class, 'getStaff']);
Route::get( 'newstaff', [HomeController::class, 'newStaffForm'])->name('new');
Route::post('staff/add', [HomeController::class, 'storeStaff']);
Route::post( 'staff/{id}/edit', [HomeController::class, 'editStaff']);
Route::post( 'staff/{id}/delete', [HomeController::class, 'deleteStaff']);


Route::get('customers', [CustomerController::class, 'index']);
Route::get('customer/new', [CustomerController::class, 'create']);
Route::post('customer/new', [CustomerController::class, 'store']);
Route::get('verify/{id}', [CustomerController::class, 'verify']);
Route::get('message', [CustomerController::class, 'message']);
Route::post('sendsms', [CustomerController::class, 'send_sms']);
Route::get('getnumber/{id}/search', [CustomerController::class, 'get_number']);



Route::get('contributions', [ContributionController::class, 'index']);
Route::get('unapproved', [ContributionController::class, 'unapproved']);
Route::post('contribution/approve', [ContributionController::class, 'approve']);
Route::get('contribute', [ContributionController::class, 'create']);
Route::post('contribute', [ContributionController::class, 'store']);
