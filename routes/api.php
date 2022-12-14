<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Transaction_Controller;
use App\Http\Controllers\Transaction_Api_Controller;
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

//업체측 API요청
Route::get('/v2/user/calculate_history_data',[Transaction_Api_Controller::class,'Calculate_history_data']);


Route::prefix('/v1')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::post('/auth-check',[Controller::class,'Auth_check']); //로그인 POST
        Route::post('/auth2-check',[Controller::class,'Auth_check2']); //로그인 POST

        //가상계좌 관리
        Route::post('/1won_shipment/{route_id}',[Transaction_Controller::class,'Won_shipment']); //1원 인증 발송
        Route::post('/1won_shipment_check/{route_id}',[Transaction_Controller::class,'Won_shipment_check']); //1원 인증 체크
        Route::post('/account_temporary_issuance/{route_id}/{company_id}',[Transaction_Controller::class,'Account_temporary_issuance']);//임시 계좌발급 [페이투스 전용]
        Route::post('/account_everlasting_issuance/{route_id}/{company_id}',[Transaction_Controller::class,'Account_everlasting_issuance']);//영구 계좌발급 [페이투스 전용]
        Route::post('/account_everlasting_issuance_v2/{route_id}/{company_id}',[Transaction_Controller::class,'Account_everlasting_issuance_v2']);//영구 계좌발급 [K-WON 전용]
        Route::post('/deposit_notification/{route_id}',[Transaction_Controller::class,'Deposit_notification']); //입금 노티 [페이투스 전용]
        Route::post('/deposit_notification_v2/{route_id}',[Transaction_Controller::class,'Deposit_notification_v2']); //입금 노티 [K-WON 전용]

        Route::post('/telegram_setting',[Transaction_Controller::class,'Telegram_setting']);//텔레그램 셋팅
        //Rtpay 관련
        Route::post('/rtpay_v1/{route_id}',[Transaction_Controller::class,'Rtpay_noti_v1']);//Rtpay

        //로그인후 라우트
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/index_transaction_history_data',[Transaction_Controller::class,'Index_data']); //INDEX 정보 가져오기
            Route::get('/token_check', function () {return true;}); //토큰 유효여부 체크
            Route::get('/transaction_history_data',[Transaction_Controller::class,'Transaction_history_data']); //거래 내역 가져오기
            Route::get('/calculate_history_data',[Transaction_Controller::class,'Calculate_history_data']); //정산요청 내역 가져오기
            Route::post('/charge_request',[Transaction_Controller::class,'Charge_request']); //잔액 충전 요청 (Rtpay 혹은 송금을위한 잔액 충전요청)
            Route::post('/rtpay_insert_or_update',[Transaction_Controller::class,'Rtpay_insert_or_update']); //Rtpay 등록 및 수정
            Route::post('/account_insert_or_update',[Transaction_Controller::class,'Account_insert_or_update']); //가상계좌 등록 및 수정 [페이투스 전용]
            Route::post('/account_insert_or_update_v2',[Transaction_Controller::class,'Account_insert_or_update_v2']); //가상계좌 등록 및 수정 [K-WON 전용]
            Route::get('/get_company_data',[Controller::class,'Get_company_data']); //업체 정보 가져오기 (리스트 내 수정하기위하여)
            Route::post('/company_update',[Controller::class,'Company_update']); //업체 정보 업데이트
            Route::post('/company_delete',[Controller::class,'Company_delete']); //업체 정보 업데이트
            Route::post('/calculate_request',[Transaction_Controller::class,'Calculate_request']);//정산 요청 Req 2차인증 X
            Route::post('/calculate_auth2_request',[Transaction_Controller::class,'Calculate_auth2_request']);//정산 요청 Req 2차인증 O
            Route::post('/transform_request',[Transaction_Controller::class,'Transform_request']);//익스 전환 요청 Req 2차인증 O
            Route::post('/calculate_state_change',[Transaction_Controller::class,'Calculate_state_change']);//정산 승인 거절 본사혹은 관리자 전용
            Route::post('/add_company',[Controller::class,'Add_company_req']);//압체 추가
            Route::post('/user_setting_req',[Controller::class,'User_setting_req']);//사용자 설정 Req
            Route::get('/accounts_history_data',[Transaction_Controller::class,'Accounts_history_data']); //가상계좌 발급내역 가져오기

            Route::post('/add_user',[Controller::class,'Add_user']);//사용자 추가
            Route::post('/noti_add',[Controller::class,'Noti_add']);//공지사항 추가
        });

    });
});
