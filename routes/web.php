<?php

use App\Http\Controllers\ZohoController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('zoho');
// });

Route::get('/', [ZohoController::class, 'index']);
Route::post('zoho_contact',[ZohoController::class, 'store'])->name('zoho_contact');
Route::post('zoho_update',[ZohoController::class, 'update'])->name('zoho_update');
Route::get('/zoho_edit/{item}',[ZohoController::class, 'edit']);

Route::get('/zoho_delete/{id}', [ZohoController::class, 'delete'])->name('zoho_delete');