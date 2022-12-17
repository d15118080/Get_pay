<?php

namespace App\Http\Controllers;

use App\Models\company_bank_data;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Personal_access_tokens;
use  App\Models\company;
use App\Models\transaction_history;
use App\Models\withdraw;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //로그인 리퀘스트
    public function Auth_check(Request $request){
        $user_id = $request->input('user_id'); //사용자 아이디
        $user_password = $request->input('user_password'); //사용자 비밀번호
        if(empty($user_id) || empty($user_password)){
            return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
        }
        //아이디가 존재하지 않을경우
        if(!User::where('user_id',$user_id)->exists()){
            return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
        }else{
            $User_data = User::where('user_id',$user_id)->first();

            if (Hash::check($user_password, $User_data->user_password)) {
                if ($User_data->user_state == 5) {
                    return Return_json("9999", 1, "사용이 불가능한 계정입니다.", 422, null);
                }
                if($User_data->auth_2 == 0) {
                    if (!Personal_access_tokens::where('name', $User_data->key)->exists()) {
                        if ($User_data->user_authority == 0) { //관리자 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:admin'])->plainTextToken;
                        } else if ($User_data->user_authority == 1) { //본사 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:head'])->plainTextToken;
                        } else if ($User_data->user_authority == 2) { //지사 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:branch'])->plainTextToken;
                        } else if ($User_data->user_authority == 3) { //총판 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:distributor'])->plainTextToken;
                        } else if ($User_data->user_authority == 4) { //가맹점 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:franchisee'])->plainTextToken;
                        }
                    } else {
                        $User_data->tokens()->where('name', $User_data->key)->delete();
                        if ($User_data->user_authority == 0) { //본사 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:admin'])->plainTextToken;
                        } else if ($User_data->user_authority == 1) { //본사 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:head'])->plainTextToken;
                        } else if ($User_data->user_authority == 2) { //지사 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:branch'])->plainTextToken;
                        } else if ($User_data->user_authority == 3) { //총판 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:distributor'])->plainTextToken;
                        } else if ($User_data->user_authority == 4) { //가맹점 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:franchisee'])->plainTextToken;
                        }
                    }
                    $HToken = base_64_end_code_en($User_data->key, _key_, _iv_);
                    return Return_json("0000", 0, "로그인 정상", 200, ['code'=> 0000,'XToken' => $Token, 'HToken' => $HToken]);
                }else{
                    return Return_json("0000", 0, "2차인증 필요", 200, ['code'=> 1000]);
                }
            }else{
                return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
            }
        }
    }

    //2차인증 로그인
    public function Auth_check2(Request $request){
        $user_id = $request->input('user_id'); //사용자 아이디
        $user_password = $request->input('user_password'); //사용자 비밀번호
        $user_auth2_password = $request->input('user_auth2_password'); //사용자 비밀번호

        if(empty($user_id) || empty($user_password)){
            return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
        }
        //아이디가 존재하지 않을경우
        if(!User::where('user_id',$user_id)->exists()){
            return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
        }else{
            $User_data = User::where('user_id',$user_id)->first();

            if (Hash::check($user_password, $User_data->user_password)) {
                if(!Hash::check($user_auth2_password, $User_data->auth_2_password)){
                    return Return_json('9999', 1, "2차인증 비밀번호가 일치하지 않습니다.", 422, null);
                }
                if ($User_data->user_state == 5) {
                    return Return_json("9999", 1, "사용이 불가능한 계정입니다.", 422, null);
                }
                    if (!Personal_access_tokens::where('name', $User_data->key)->exists()) {
                        if ($User_data->user_authority == 0) { //관리자 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:admin'])->plainTextToken;
                        } else if ($User_data->user_authority == 1) { //본사 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:head'])->plainTextToken;
                        } else if ($User_data->user_authority == 2) { //지사 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:branch'])->plainTextToken;
                        } else if ($User_data->user_authority == 3) { //총판 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:distributor'])->plainTextToken;
                        } else if ($User_data->user_authority == 4) { //가맹점 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:franchisee'])->plainTextToken;
                        }
                    } else {
                        $User_data->tokens()->where('name', $User_data->key)->delete();
                        if ($User_data->user_authority == 0) { //본사 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:admin'])->plainTextToken;
                        } else if ($User_data->user_authority == 1) { //본사 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:head'])->plainTextToken;
                        } else if ($User_data->user_authority == 2) { //지사 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:branch'])->plainTextToken;
                        } else if ($User_data->user_authority == 3) { //총판 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:distributor'])->plainTextToken;
                        } else if ($User_data->user_authority == 4) { //가맹점 일경우
                            $Token = $User_data->createToken($User_data->key, ['Auth:franchisee'])->plainTextToken;
                        }
                    }
                    $HToken = base_64_end_code_en($User_data->key, _key_, _iv_);
                    return Return_json("0000", 0, "로그인 정상", 200, ['code'=> 0000,'XToken' => $Token, 'HToken' => $HToken]);
            }else{
                return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
            }
        }
    }

    //인덱스
    public function Index(Request $request){
        $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
        if(!session('state') == 0){
            $company_key = User::where('key',$HToken)->value('company_key');
        }
        //관리자 요청이라면
        if(session('state') == 0){
            $data = transaction_history::where('date_ymd',date('Y-m-d'))->orderBy('id', 'desc')->limit(15)->get(); //오늘중 15 개 데이터
            $today_money = transaction_history::where('date_ymd',date('Y-m-d'))->sum('transaction_money'); //금일 입금액
            $today_money_count = transaction_history::where('date_ymd',date('Y-m-d'))->count(); //금일 입금 건수
            $today_withdraw_money = withdraw::where('date_ymd',date('Y-m-d'))->sum('money'); //금일 출금액
            $today_withdraw_count = withdraw::where('date_ymd',date('Y-m-d'))->count(); //금일 출금 건수
            $my_money = User::where('key',$HToken)->value('money'); //현재 잔액
            $bank_mode_int = null;
            $bank_route = null;
        }

        //본사 요청
        elseif (session('state') == 1){
            $data = transaction_history::where('date_ymd',date('Y-m-d'))->where('head_key',$company_key)->orderBy('id', 'desc')->limit(15)->get(); //오늘중 15 개 데이터
            $today_money = transaction_history::where('date_ymd',date('Y-m-d'))->where('head_key',$company_key)->sum('transaction_money'); //금일 입금액
            $today_money_count = transaction_history::where('date_ymd',date('Y-m-d'))->where('head_key',$company_key)->count(); //금일 입금 건수
            $today_withdraw_money = withdraw::where('date_ymd',date('Y-m-d'))->where('head_key',$company_key)->sum('money'); //금일 출금액
            $today_withdraw_count = withdraw::where('date_ymd',date('Y-m-d'))->where('head_key',$company_key)->count(); //금일 출금 건수
            $my_money = company::where('company_key',$company_key)->value('money'); //현재 잔액
            $bank_mode_int = null;
            $bank_route = null;
        }

        //지사 요청
        elseif (session('state') == 2){
            $data = transaction_history::where('date_ymd',date('Y-m-d'))->where('branch_key',$company_key)->orderBy('id', 'desc')->limit(15)->get(); //오늘중 15 개 데이터
            $today_money = transaction_history::where('date_ymd',date('Y-m-d'))->where('branch_key',$company_key)->sum('transaction_money'); //금일 입금액
            $today_money_count = transaction_history::where('date_ymd',date('Y-m-d'))->where('branch_key',$company_key)->count(); //금일 입금 건수
            $today_withdraw_money = withdraw::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->sum('money'); //금일 출금액
            $today_withdraw_count = withdraw::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->count(); //금일 출금 건수
            $my_money = company::where('company_key',$company_key)->value('money'); //현재 잔액
            $bank_mode_int = null;
            $bank_route = null;
        }

        //총판 요청
        elseif (session('state') == 3){
            $data = transaction_history::where('date_ymd',date('Y-m-d'))->where('distributor_key',$company_key)->orderBy('id', 'desc')->limit(15)->get(); //오늘중 15 개 데이터
            $today_money = transaction_history::where('date_ymd',date('Y-m-d'))->where('distributor_key',$company_key)->sum('transaction_money'); //금일 입금액
            $today_money_count = transaction_history::where('date_ymd',date('Y-m-d'))->where('distributor_key',$company_key)->count(); //금일 입금 건수
            $today_withdraw_money = withdraw::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->sum('money'); //금일 출금액
            $today_withdraw_count = withdraw::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->count(); //금일 출금 건수
            $my_money = company::where('company_key',$company_key)->value('money'); //현재 잔액
            $bank_mode_int = null;
            $bank_route = null;
        }

        //가맹점
        elseif (session('state') == 4){
            $data = transaction_history::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->orderBy('id', 'desc')->limit(15)->get(); //오늘중 15 개 데이터
            $today_money = transaction_history::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->sum('transaction_money'); //금일 입금액
            $today_money_count = transaction_history::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->count(); //금일 입금 건수
            $today_withdraw_money = withdraw::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->sum('money'); //금일 출금액
            $today_withdraw_count = withdraw::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->count(); //금일 출금 건수
            $my_money = company::where('company_key',$company_key)->value('money'); //현재 잔액
            $bank_mode_int = company::where('company_key',$company_key)->value('bank_mode_int'); //가상계좌 영구만 사용인지, 임시만 사용인지

            if($bank_mode_int == 0||$bank_mode_int == 1||$bank_mode_int == 2){
                $head_key = company::where('company_key',$company_key)->value('head_key'); //가맹점에 연결된 본사 키
                $bank_route_s = company_bank_data::where('company_key',$head_key)->value('route_id'); //가상계좌 발급 라우트ID
                $bank_route = "$bank_route_s/$company_key";
            }

        }

        return view('welcome',[
            'data'=>$data,
            'today_money'=>$today_money,
            'today_money_count'=>$today_money_count,
            'my_money'=>$my_money,
            'today_withdraw_money'=>$today_withdraw_money,
            'today_withdraw_count'=>$today_withdraw_count,
            'bank_route'=>$bank_route,
            'bank_mode_int'=>$bank_mode_int
        ]);
    }
}
