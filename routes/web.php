<?php

use App\Services\i2CrmService;
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

use \App\Http\Controllers\CompanyController;
Route::get('/', [CompanyController::class, 'list'])->middleware('auth');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('send', [\App\Services\PusherService::class, 'test']);
Route::get('company/store', function (){
    return view('company.store');
})->middleware('auth');
Route::post('company/store', [CompanyController::class, 'store'])->name('company.store')->middleware('auth');
Route::get('company/{id}/details', [CompanyController::class, 'detail'])->name('detail')->middleware('auth');
Route::get('company/{id}/generate', [CompanyController::class, 'generate'])->name('generate')->middleware('auth');
Route::post('company/save', [CompanyController::class, 'save'])->name('company.save')->middleware('auth');
Route::get('company/{id}/start', [CompanyController::class, 'start'])->name('company.start')->middleware('auth');
Route::get('company/{id}/stop', [CompanyController::class, 'stop'])->name('company.stop')->middleware('auth');

use \App\Http\Controllers\ClientController;
Route::post('file-import', [ClientController::class, 'fileImport'])->name('file-import')->middleware('auth');
Route::get('file-export/{company_id}', [ClientController::class, 'fileExport'])->name('file-export')->middleware('auth');

use \App\Http\Controllers\PhoneController;
Route::get('phones', [PhoneController::class, 'list'])->middleware('auth');
Route::post('phones/store', [PhoneController::class, 'store'])->name('phones.store')->middleware('auth');
Route::get('phones/store', function (){
    return view('phone.store');
})->middleware('auth');

Route::get('phones/{id}/details', [PhoneController::class, 'details'])->middleware('auth');
Route::get('phones/{id}/remove', [PhoneController::class, 'remove'])->middleware('auth');

use \App\Http\Controllers\StopListController;
Route::get('stoplist', [StopListController::class, 'list'])->middleware('auth');
Route::post('stoplist/store', [StopListController::class, 'store'])->name('stoplist.store')->middleware('auth');
Route::get('stoplist/store', function (){
    return view('stoplist.store');
})->middleware('auth');
Route::get('stoplist/{id}/details', [StopListController::class, 'details'])->middleware('auth');
Route::get('stoplist/{id}/remove', [StopListController::class, 'remove'])->middleware('auth');
