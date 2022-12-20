<?php

namespace App\Http\Controllers;

use App\Models\bank_list;
use App\Models\calculate;
use App\Models\company_bank_data;
use App\Models\head_rtpay;
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
    public function Auth_check(Request $request)
    {
        $user_id = $request->input('user_id'); //사용자 아이디
        $user_password = $request->input('user_password'); //사용자 비밀번호
        if (empty($user_id) || empty($user_password)) {
            return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
        }
        //아이디가 존재하지 않을경우
        if (!User::where('user_id', $user_id)->exists()) {
            return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
        } else {
            $User_data = User::where('user_id', $user_id)->first();

            if (Hash::check($user_password, $User_data->user_password)) {
                if ($User_data->user_state == 5) {
                    return Return_json("9999", 1, "사용이 불가능한 계정입니다.", 422, null);
                }
                if ($User_data->auth_2 == 0) {
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
                    return Return_json("0000", 0, "로그인 정상", 200, ['code' => 0000, 'XToken' => $Token, 'HToken' => $HToken]);
                } else {
                    return Return_json("0000", 0, "2차인증 필요", 200, ['code' => 1000]);
                }
            } else {
                return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
            }
        }
    }

    //2차인증 로그인
    public function Auth_check2(Request $request)
    {
        $user_id = $request->input('user_id'); //사용자 아이디
        $user_password = $request->input('user_password'); //사용자 비밀번호
        $user_auth2_password = $request->input('user_auth2_password'); //사용자 비밀번호

        if (empty($user_id) || empty($user_password)) {
            return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
        }
        //아이디가 존재하지 않을경우
        if (!User::where('user_id', $user_id)->exists()) {
            return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
        } else {
            $User_data = User::where('user_id', $user_id)->first();

            if (Hash::check($user_password, $User_data->user_password)) {
                if (!Hash::check($user_auth2_password, $User_data->auth_2_password)) {
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
                return Return_json("0000", 0, "로그인 정상", 200, ['code' => 0000, 'XToken' => $Token, 'HToken' => $HToken]);
            } else {
                return Return_json('9999', 1, "입력하신 정보를 확인해주세요.", 422, null);
            }
        }
    }

    //인덱스
    public function Index(Request $request)
    {
        $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
        if (!session('state') == 0) {
            $company_key = User::where('key', $HToken)->value('company_key');
        }
        //관리자 요청이라면
        if (session('state') == 0) {
            $data = transaction_history::where('date_ymd', date('Y-m-d'))->orderBy('id', 'desc')->limit(15)->get(); //오늘중 15 개 데이터
            $today_money = transaction_history::where('date_ymd', date('Y-m-d'))->sum('transaction_money'); //금일 입금액
            $today_money_count = transaction_history::where('date_ymd', date('Y-m-d'))->count(); //금일 입금 건수
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->sum('calculate_money'); //금일 출금액
            $today_withdraw_count = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->count(); //금일 출금 건수
            $my_money = User::where('key', $HToken)->value('money'); //현재 잔액
            $bank_mode_int = null;
            $bank_route = null;
        } //본사 요청
        elseif (session('state') == 1) {
            $data = transaction_history::where('date_ymd', date('Y-m-d'))->where('head_key', $company_key)->orderBy('id', 'desc')->limit(15)->get(); //오늘중 15 개 데이터
            $today_money = transaction_history::where('date_ymd', date('Y-m-d'))->where('head_key', $company_key)->sum('transaction_money'); //금일 입금액
            $today_money_count = transaction_history::where('date_ymd', date('Y-m-d'))->where('head_key', $company_key)->count(); //금일 입금 건수
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->where('head_key', $company_key)->sum('calculate_money'); //금일 출금액
            $today_withdraw_count = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->where('head_key', $company_key)->count(); //금일 출금 건수
            $my_money = company::where('company_key', $company_key)->value('money'); //현재 잔액
            $bank_mode_int = null;
            $bank_route = null;
        } //지사 요청
        elseif (session('state') == 2) {
            $data = transaction_history::where('date_ymd', date('Y-m-d'))->where('branch_key', $company_key)->orderBy('id', 'desc')->limit(15)->get(); //오늘중 15 개 데이터
            $today_money = transaction_history::where('date_ymd', date('Y-m-d'))->where('branch_key', $company_key)->sum('transaction_money'); //금일 입금액
            $today_money_count = transaction_history::where('date_ymd', date('Y-m-d'))->where('branch_key', $company_key)->count(); //금일 입금 건수
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->where('company_key', $company_key)->sum('calculate_money'); //금일 출금액
            $today_withdraw_count = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->where('company_key', $company_key)->count(); //금일 출금 건수
            $my_money = company::where('company_key', $company_key)->value('money'); //현재 잔액
            $bank_mode_int = null;
            $bank_route = null;
        } //총판 요청
        elseif (session('state') == 3) {
            $data = transaction_history::where('date_ymd', date('Y-m-d'))->where('distributor_key', $company_key)->orderBy('id', 'desc')->limit(15)->get(); //오늘중 15 개 데이터
            $today_money = transaction_history::where('date_ymd', date('Y-m-d'))->where('distributor_key', $company_key)->sum('transaction_money'); //금일 입금액
            $today_money_count = transaction_history::where('date_ymd', date('Y-m-d'))->where('distributor_key', $company_key)->count(); //금일 입금 건수
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->where('company_key', $company_key)->sum('calculate_money'); //금일 출금액
            $today_withdraw_count = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->where('company_key', $company_key)->count(); //금일 출금 건수
            $my_money = company::where('company_key', $company_key)->value('money'); //현재 잔액
            $bank_mode_int = null;
            $bank_route = null;
        } //가맹점
        elseif (session('state') == 4) {
            $data = transaction_history::where('date_ymd', date('Y-m-d'))->where('company_key', $company_key)->orderBy('id', 'desc')->limit(15)->get(); //오늘중 15 개 데이터
            $today_money = transaction_history::where('date_ymd', date('Y-m-d'))->where('company_key', $company_key)->sum('transaction_money'); //금일 입금액
            $today_money_count = transaction_history::where('date_ymd', date('Y-m-d'))->where('company_key', $company_key)->count(); //금일 입금 건수
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->where('company_key', $company_key)->sum('calculate_money'); //금일 출금액
            $today_withdraw_count = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->where('company_key', $company_key)->count(); //금일 출금 건수
            $my_money = company::where('company_key', $company_key)->value('money'); //현재 잔액
            $bank_mode_int = company::where('company_key', $company_key)->value('bank_mode_int'); //가상계좌 영구만 사용인지, 임시만 사용인지

            if ($bank_mode_int == 0 || $bank_mode_int == 1 || $bank_mode_int == 2) {
                $head_key = company::where('company_key', $company_key)->value('head_key'); //가맹점에 연결된 본사 키
                $bank_route_s = company_bank_data::where('company_key', $head_key)->value('route_id'); //가상계좌 발급 라우트ID
                $bank_route = "$bank_route_s/$company_key";
            }

        }

        return view('welcome', [
            'data' => $data,
            'today_money' => $today_money,
            'today_money_count' => $today_money_count,
            'my_money' => $my_money,
            'today_withdraw_money' => $today_withdraw_money,
            'today_withdraw_count' => $today_withdraw_count,
            'bank_route' => $bank_route,
            'bank_mode_int' => $bank_mode_int
        ]);
    }

    //업체 리스트
    public function company_lists(Request $request)
    {

        //관리자가 본사 리스트 요청
        if ($_GET['mode'] == "all" && session('state') == 0) {
            $data = company::where('state', 1)->get();
            foreach ($data as $row) {
                $row['branch_count'] = company::where('head_key', $row->company_key)->where('state', 2)->count(); //각 본사의 연결된 지사 카운팅
                $row['distributor_key'] = company::where('head_key', $row->company_key)->where('state', 3)->count(); //각 본사의 연결된 총판 카운팅
                $row['franchisee_count'] = company::where('head_key', $row->company_key)->where('state', 4)->count(); //각 본사의 연결된 가맹점 카운팅
            }
        }

        //관리자가 지사 리스트 요청
        if ($_GET['mode'] == "branch" && session('state') == 0) {
            $data = company::where('state', 2)->get();
            foreach ($data as $row) {
                $row['distributor_key'] = company::where('branch_key', $row->company_key)->where('state', 3)->count(); //각 지사의 연결된 총판 카운팅
                $row['franchisee_count'] = company::where('branch_key', $row->company_key)->where('state', 4)->count(); //각 지사의 연결된 가맹점 카운팅
            }
        }

        //관리자가 총판 리스트 요청
        if ($_GET['mode'] == "distributor" && session('state') == 0) {
            $data = company::where('state', 3)->get();
            foreach ($data as $row) {
                $row['franchisee_count'] = company::where('distributor_key', $row->company_key)->where('state', 4)->count(); //각 총판의 연결된 가맹점 카운팅
            }
        }

        //관리자가 가맹점 리스트 요청
        if ($_GET['mode'] == "franchisee" && session('state') == 0) {
            $data = company::where('state', 4)->get();
        }

        //본사가 지사 리스트 요청
        if ($_GET['mode'] == "branch" && session('state') == 1) {
            $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
            $company_key = User::where('key', $HToken)->value('company_key');
            $data = company::where('head_key', $company_key)->where('state', 2)->get();
            foreach ($data as $row) {
                $row['distributor_key'] = company::where('branch_key', $row->company_key)->where('state', 3)->count(); //각 지사의 연결된 총판 카운팅
                $row['franchisee_count'] = company::where('branch_key', $row->company_key)->where('state', 4)->count(); //각 지사의 연결된 가맹점 카운팅
            }
        }

        //본사가 총판 리스트 요청
        if ($_GET['mode'] == "distributor" && session('state') == 1) {
            $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
            $company_key = User::where('key', $HToken)->value('company_key');
            $data = company::where('head_key', $company_key)->where('state', 3)->get();
            foreach ($data as $row) {
                $row['franchisee_count'] = company::where('distributor_key', $row->company_key)->where('state', 4)->count(); //각 총판의 연결된 가맹점 카운팅
            }
        }

        //본사가 가맹점 리스트 요청
        if ($_GET['mode'] == "franchisee" && session('state') == 1) {
            $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
            $company_key = User::where('key', $HToken)->value('company_key');
            $data = company::where('head_key', $company_key)->where('state', 4)->get();
        }

        //지사가 총판 리스트 요청
        if ($_GET['mode'] == "distributor" && session('state') == 2) {
            $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
            $company_key = User::where('key', $HToken)->value('company_key');
            $data = company::where('branch_key', $company_key)->where('state', 3)->get();
            foreach ($data as $row) {
                $row['franchisee_count'] = company::where('distributor_key', $row->company_key)->where('state', 4)->count(); //각 총판의 연결된 가맹점 카운팅
            }
        }

        //지사가 가맹점 리스트 요청
        if ($_GET['mode'] == "franchisee" && session('state') == 2) {
            $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
            $company_key = User::where('key', $HToken)->value('company_key');
            $data = company::where('branch_key', $company_key)->where('state', 4)->get();
        }

        //총판이 가맹점 리스트 요청
        if ($_GET['mode'] == "franchisee" && session('state') == 3) {
            $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
            $company_key = User::where('key', $HToken)->value('company_key');
            $data = company::where('distributor_key', $company_key)->where('state', 4)->get();
        }
        return view('company_lists', ['data' => $data]);
    }

    //정산 내역 페이지
    public function Calculate(Request $request)
    {
        $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
        if (!session('state') == 0) {
            $company_key = User::where('key', $HToken)->value('company_key');
        }
        //관리자 일경우
        if(session('state') == 0){
            $compay_lists = company::get();
            //본사일 경우
        }elseif (session('state') == 1){
            $compay_lists = company::where('head_key',$company_key)->get();
        }else{
            $compay_lists = null;
        }
        return view('calculate_history',['data'=>$compay_lists]);
    }

    //거래 내역 페이지
    public function Transaction_history(Request $request){
        $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
        if (!session('state') == 0) {
            $company_key = User::where('key', $HToken)->value('company_key');
        }
        //관리자 일경우
        if(session('state') == 0){
            $compay_lists = company::where('state',4)->get();
        //본사일 경우
        }elseif (session('state') == 1){
            $compay_lists = company::where('head_key',$company_key)->where('state',4)->get();
        //지사일 경우
        }elseif (session('state') == 2){
            $compay_lists = company::where('branch_key',$company_key)->where('state',4)->get();
        //총판일 경우
        }elseif (session('state') == 3){
            $compay_lists = company::where('distributor_key',$company_key)->where('state',4)->get();
        }else{
            $compay_lists = null;
        }
        return view('transaction_history',['data'=>$compay_lists]);
    }

    //업체 정보 가져오기
    public function Get_company_data(Request $request)
    {
        $id = $request->input('id');
        $data = company::where('id', $id)->first();
        return Return_json("0000", 200, '정상처리', 200, $data);
    }

    //업체 정보 업데이트
    public function Company_update(Request $request)
    {
        $id = $request->input('id');
        $mode = $request->input('mode');//업체 수정 구분 heed, ....

        $w_state = $request->input('w_state'); //출금 상태
        $a_state = $request->input('a_state'); //장 사용 옵션
        $company_name = $request->input('company_name');
        $company_margin = $request->input('company_margin');
        $company_money = $request->input('company_money');

        if ($mode == "head") {
            company::where('id', $id)->update(['bank_mode' => $a_state]); //장 사용 구분 업데이트
            company::where('id', $id)->update(['withdraw_state' => $w_state]); //출금 사용여부 업데이트
            company::where('id', $id)->update(['company_name' => $company_name]); //업체 이름 업데이트
            company::where('id', $id)->update(['company_margin' => $company_margin]); //수수료 업데이트
            company::where('id', $id)->update(['money' => $company_money]); //수수료 업데이트
        }

        return Return_json("0000",200,"정상처리",200);

    }

    //충전 요청 페이지
    public function Charge_view(Request $request){
        return view('charge');
    }

    //정산 요청 페이지
    public function Calculate_view(Request $request){
        $bank_data = bank_list::get();
        $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
        if (!session('state') == 0) {
            $company_key = User::where('key', $HToken)->value('company_key');
            $calculate_fee= company::where('company_key',$company_key)->value('calculate_fee'); //출금 수수료
            $company_money = company::where('company_key',$company_key)->value('money'); //현재 잔액

        }

        return view('calculate_request',['data'=>$bank_data,'calculate_fee'=>$calculate_fee,'company_money'=>$company_money]);
    }

}
