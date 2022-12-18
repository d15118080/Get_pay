<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\transaction_history;

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

//가상계좌 연결 관리(본사)
Route::get('/account_management',[Controller::class,'Account_management'])->middleware('Token_Check');

//업체 리스트
Route::get('/company_lists',[Controller::class,'company_lists'])->middleware('Token_Check');

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


//거래내역
Route::get('/transaction_history',[Controller::class,'Transaction_history'])->middleware('Token_Check');

//정산 내역
Route::get('/calculates',[Controller::class,'Calculate'])->middleware('Token_Check');
