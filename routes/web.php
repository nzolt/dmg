<?php

use Illuminate\Support\Facades\Route;
use AvtoDev\JsonRpc\RpcRouter;
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

/** Register /rpc route */
Route::post('/rpc', 'AvtoDev\JsonRpc\Http\Controllers\RpcController')
    ->middleware(['isAuthorized'])
    ->name('rpc');
/** RPC Routes */
RpcRouter::on('showFullRequest', 'App\Http\Controllers\Rpc\JsonRpcController@_showInfo');
RpcRouter::on('getExpenses', 'App\Http\Controllers\Rpc\JsonRpcController@_list');
RpcRouter::on('getExpense', 'App\Http\Controllers\Rpc\JsonRpcController@_byId');
RpcRouter::on('addExpense', 'App\Http\Controllers\Rpc\JsonRpcController@_addExpense');
RpcRouter::on('deleteExpense', 'App\Http\Controllers\Rpc\JsonRpcController@_deleteExpense');
RpcRouter::on('updateExpense', 'App\Http\Controllers\Rpc\JsonRpcController@_updateExpense');
