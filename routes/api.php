<?php

use App\Http\Controllers\AlarmHistController;
use App\Http\Controllers\MgmtGroupController;
use App\Http\Controllers\RtInfoController;
use App\Http\Controllers\SigEventHistController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('alarm-hist',[AlarmHistController::class,'alarm_hist']);
Route::get('alarm-stat',[AlarmHistController::class,'alarm_stat']);
Route::get('sigevent-hist',[SigEventHistController::class,'sigeventhist']);
Route::get('rt-info',[RtInfoController::class,'info']);
Route::get('mgmt-group',[MgmtGroupController::class,'mgmt']);

Route::post('/send-alarm-data', [AlarmHistController::class, 'sendAlarmData']);
