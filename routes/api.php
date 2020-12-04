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

// Two routes are defined for single and multiple Expense. Reason: on getExpenses later can be defined pagination on url
// but also can be added as url parameter /?size=15&page=2
Route::middleware(['isAuthorized'])->group(function () {
    Route::get('expenses/{deletes?}', 'App\Http\Controllers\ApiController@_list')->name('getExpenses');
    Route::get('expense/{id}', 'App\Http\Controllers\ApiController@_byId')->name('getExpense');
    Route::put('expense', 'App\Http\Controllers\ApiController@_addExpense')->name('addExpense');
    Route::patch('expense/{id}', 'App\Http\Controllers\ApiController@_updateExpense')->name('updateExpense');
    Route::delete('expense/{id}', 'App\Http\Controllers\ApiController@_deleteExpense')->name('deleteExpense');
});
