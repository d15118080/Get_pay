<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Transaction_Controller;
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



Route::prefix('/v1')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::post('/auth-check',[Controller::class,'Auth_check']); //로그인 POST
        Route::post('/auth2-check',[Controller::class,'Auth_check2']); //로그인 POST

        //가상계좌 관리
        Route::post('/1won_shipment/{route_id}',[Transaction_Controller::class,'Won_shipment']); //1원 인증 발송
        Route::post('/1won_shipment_check/{route_id}',[Transaction_Controller::class,'Won_shipment_check']); //1원 인증 체크
        //로그인후 라우트
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/index_transaction_history_data',[Transaction_Controller::class,'Index_data']); //INDEX 정보 가져오기
            Route::get('/token_check', function () {return true;}); //토큰 유효여부 체크
        });

    });
});
