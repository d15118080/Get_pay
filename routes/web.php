<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\transaction_history;
use App\Http\Controllers\Transaction_Controller;

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

Route::get('/',[Controller::class,'Index'] )->middleware('Token_Check');

Route::get('/account_view',[Controller::class,'Account_view'])->middleware('Token_Check');

//업체 리스트
Route::get('/company_lists',[Controller::class,'company_lists'])->middleware('Token_Check');

//거래내역
Route::get('/transaction_history',[Controller::class,'Transaction_history'])->middleware('Token_Check');
//가상계좌 발급 내역
Route::get('/accounts_history',[Controller::class,'Accounts_history'])->middleware('Token_Check');

//정산 내역
Route::get('/calculates',[Controller::class,'Calculate'])->middleware('Token_Check');
//정산 요청 페이지
Route::get('/calculate_view',[Controller::class,'Calculate_view'])->middleware('Token_Check');
//정산 요청 승인/거절 페이지
Route::get('/calculate_admin_view',[Controller::class,'Calculate_admin_view'])->middleware('Token_Check');
//텔레그램 알림 설정 페이지
Route::get('/user_telegram_setting',[Controller::class,'Telegarm_setting'])->middleware('Token_Check');
//사용자 계정설정 페이지
Route::get('/user_setting',[Controller::class,'User_setting'])->middleware('Token_Check');
//업체 추가 페이지
Route::get('/add_company',[Controller::class,'Add_compnays']);
//본사 Rtpay 설정
Route::get('/rtpay_setting',[Transaction_Controller::class,'Rtpay_setting'])->middleware('Token_Check');

//본사 가상계좌 설정
Route::get('/account_setting',[Transaction_Controller::class,'Account_setting'])->middleware('Token_Check');


//가맹점 충전 신청
Route::get('/charge',[Controller::class,'Charge_view'])->middleware('Token_Check');

/*일반 유저*/

//계좌 발급 페이지
Route::get('/account_issuance/{route_id}/{company_id}',[Transaction_Controller::class,'Account_add_view']);

//로그인
Route::get('/login', function () {
    return view('login');
});

//로그아웃
Route::get('/logout',function (){
    if(count($_COOKIE))
    {foreach($_COOKIE as $key => $value)
    {setcookie($key, NULL, -3600, '/');}
    }
    return redirect('/login');
});


