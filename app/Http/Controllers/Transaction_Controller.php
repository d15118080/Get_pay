<?php

namespace App\Http\Controllers;

use App\Models\account_list;
use App\Models\calculate;
use App\Models\charge_request;
use App\Models\company;
use App\Models\company_bank_data;
use App\Models\head_rtpay;
use App\Models\rtpay_data;
use App\Models\transaction_history;
use App\Models\withdraw;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;
use Telegram\Bot\Api;
use App\Fucntions\RTPay;
use Illuminate\Support\Facades\DB;

class Transaction_Controller extends Controller
{

    //인덱스 최근 거래내역 및 요약 차트
    public function Index_data(Request $request)
    {

        $company_key = User::where('key', $request->user()->key)->value('company_key');
        $arr_money = []; //입금 금액 0번키 가 7일전임 순서으로 ~ 당일
        $arr_date = []; // 7일전 까지의 날짜
        $arr_withdraw = []; //출금 금액 0번키 가 7일전임 순서으로 ~ 당일
        //관리자 요청일 경우
        if ($request->user()->tokenCan('Auth:admin')) {
            //입금 금액 배열 생성
            for ($i = 6; $i > 0; $i--) {
                $data = date("Y-m-d", strtotime(date('Y-m-d') . " -$i day"));
                $pu_arr_sum = transaction_history::where('date_ymd', $data)->sum('transaction_money');
                array_push($arr_money, $pu_arr_sum);
                array_push($arr_date, $data);
            }
            $today_money = transaction_history::where('date_ymd', date('Y-m-d'))->sum('transaction_money');
            array_push($arr_money, $today_money);

            //출금 금액 배열 생성
            for ($i = 6; $i > 0; $i--) {
                $data = date("Y-m-d", strtotime(date('Y-m-d') . " -$i day"));
                $pu_arr_withdraw = calculate::where('date_ymd', $data)->where('state', '완료')->sum('calculate_money');
                array_push($arr_withdraw, $pu_arr_withdraw);
            }
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('state', '완료')->sum('calculate_money');
            array_push($arr_withdraw, $today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date, date('Y-m-d')); //당일 일자 넣기
        } //본사 요청
        else if ($request->user()->tokenCan('Auth:head')) {
            //입금 금액 배열 생성
            for ($i = 6; $i > 0; $i--) {
                $data = date("Y-m-d", strtotime(date('Y-m-d') . " -$i day"));
                $pu_arr_sum = transaction_history::where('date_ymd', $data)->where('head_key', $company_key)->sum('transaction_money');
                array_push($arr_money, $pu_arr_sum);
                array_push($arr_date, $data);
            }
            $today_money = transaction_history::where('date_ymd', date('Y-m-d'))->where('head_key', $company_key)->sum('transaction_money');
            array_push($arr_money, $today_money);

            //출금 금액 배열 생성
            for ($i = 6; $i > 0; $i--) {
                $data = date("Y-m-d", strtotime(date('Y-m-d') . " -$i day"));
                $pu_arr_withdraw = calculate::where('date_ymd', $data)->where('head_key', $company_key)->where('state', '완료')->sum('calculate_money');
                array_push($arr_withdraw, $pu_arr_withdraw);
            }
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('head_key', $company_key)->where('state', '완료')->sum('calculate_money');
            array_push($arr_withdraw, $today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date, date('Y-m-d')); //당일 일자 넣기
        } //지사 요청
        else if ($request->user()->tokenCan('Auth:branch')) {
            //입금 금액 배열 생성
            for ($i = 6; $i > 0; $i--) {
                $data = date("Y-m-d", strtotime(date('Y-m-d') . " -$i day"));
                $pu_arr_sum = transaction_history::where('date_ymd', $data)->where('branch_key', $company_key)->sum('transaction_money');
                array_push($arr_money, $pu_arr_sum);
                array_push($arr_date, $data);
            }
            $today_money = transaction_history::where('date_ymd', date('Y-m-d'))->where('branch_key', $company_key)->sum('transaction_money');
            array_push($arr_money, $today_money);

            //출금 금액 배열 생성
            for ($i = 6; $i > 0; $i--) {
                $data = date("Y-m-d", strtotime(date('Y-m-d') . " -$i day"));
                $pu_arr_withdraw = calculate::where('date_ymd', $data)->where('company_key', $company_key)->where('state', '완료')->sum('calculate_money');
                array_push($arr_withdraw, $pu_arr_withdraw);
            }
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('company_key', $company_key)->where('state', '완료')->sum('calculate_money');
            array_push($arr_withdraw, $today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date, date('Y-m-d')); //당일 일자 넣기
        } //총판 요청
        else if ($request->user()->tokenCan('Auth:distributor')) {
            //입금 금액 배열 생성
            for ($i = 6; $i > 0; $i--) {
                $data = date("Y-m-d", strtotime(date('Y-m-d') . " -$i day"));
                $pu_arr_sum = transaction_history::where('date_ymd', $data)->where('distributor_key', $company_key)->sum('transaction_money');
                array_push($arr_money, $pu_arr_sum);
                array_push($arr_date, $data);
            }
            $today_money = transaction_history::where('date_ymd', date('Y-m-d'))->where('distributor_key', $company_key)->sum('transaction_money');
            array_push($arr_money, $today_money);

            //출금 금액 배열 생성
            for ($i = 6; $i > 0; $i--) {
                $data = date("Y-m-d", strtotime(date('Y-m-d') . " -$i day"));
                $pu_arr_withdraw = calculate::where('date_ymd', $data)->where('company_key', $company_key)->where('state', '완료')->sum('calculate_money');
                array_push($arr_withdraw, $pu_arr_withdraw);
            }
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('company_key', $company_key)->where('state', '완료')->sum('calculate_money');
            array_push($arr_withdraw, $today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date, date('Y-m-d')); //당일 일자 넣기
        } //가맹점 요청
        else if ($request->user()->tokenCan('Auth:franchisee')) {
            //입금 금액 배열 생성
            for ($i = 6; $i > 0; $i--) {
                $data = date("Y-m-d", strtotime(date('Y-m-d') . " -$i day"));
                $pu_arr_sum = transaction_history::where('date_ymd', $data)->where('company_key', $company_key)->sum('transaction_money');
                array_push($arr_money, $pu_arr_sum);
                array_push($arr_date, $data);
            }
            $today_money = transaction_history::where('date_ymd', date('Y-m-d'))->where('company_key', $company_key)->sum('transaction_money');
            array_push($arr_money, $today_money);

            //출금 금액 배열 생성
            for ($i = 6; $i > 0; $i--) {
                $data = date("Y-m-d", strtotime(date('Y-m-d') . " -$i day"));
                $pu_arr_withdraw = calculate::where('date_ymd', $data)->where('company_key', $company_key)->where('state', '완료')->sum('calculate_money');
                array_push($arr_withdraw, $pu_arr_withdraw);
            }
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('company_key', $company_key)->where('state', '완료')->sum('calculate_money');
            array_push($arr_withdraw, $today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date, date('Y-m-d')); //당일 일자 넣기
        }

        return Return_json(0000, 200, '정상처리', 200, ['dates' => $arr_date, 'arr_money' => $arr_money, 'arr_withdraw' => $arr_withdraw]);
    }

    //페이투스 가상계좌 1원 송금 (본사 키로 연결하여 데이터 가져옴)
    public function Won_shipment(Request $request, $route_id)
    {
        if (!company_bank_data::where('route_id', $route_id)->exists()) {
            return Return_json('9999', 1, "허용되지 않은 접근입니다.", 422, null);
        }
        $data = company_bank_data::where('route_id', $route_id)->first();
        $bank_code = $request->input('bankCode');
        $bank_number = $request->input('acctNo');
        $user_name = $request->input('custNm');
        if ($user_name == "" || $bank_code == "" || $bank_number == "") {
            return Return_json('9999', 1, "필수값을 입력해주세요.", 422, null);
        }

        $curl = curl_init();
        $curl_data = array("compUuid" => $data->comp_uuid,
            "bankCode" => "$bank_code",
            "acctNo" => "$bank_number",
            "custNm" => "$user_name");

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.cashes.co.kr/api/v1/viss/acct',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($curl_data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $data->basic_auth,
                'Content-Type: application/json'
            ),
        ));
        $bank_check_response = curl_exec($curl);
        curl_close($curl);
        $bank_check_response_data = json_decode($bank_check_response);

        if ($bank_check_response_data->code == "0000") {
            $return_data = [
                'verifyTrDt' => $bank_check_response_data->response->verifyTrDt,
                'verifyTrNo' => $bank_check_response_data->response->verifyTrNo,
                'acctNo' => $bank_number,
                'custNm' => $user_name,
                'bankCode' => $bank_code
            ];
            return Return_json('0000', 200, "정상처리", 200, $return_data);

        } else {
            return Return_json('9999', 1, "$bank_check_response_data->message", 422, null);
        }
    }

    //페이투스 가상계좌 1원 인증 (본시 키로 연결하여 데이터 가져옴)
    public function Won_shipment_check(Request $request, $route_id)
    {
        $verifyVal = $request->input('verifyVal');
        $verifyTrDt = $request->input('verifyTrDt');
        $verifyTrNo = $request->input('verifyTrNo');
        if ($verifyVal == "") {
            return Return_json('9999', 1, "필수값을 입력해주세요.", 422, null);
        }
        if (!company_bank_data::where('route_id', $route_id)->exists()) {
            return Return_json('9999', 1, "허용되지 않은 접근입니다.", 422, null);
        }
        $data = company_bank_data::where('route_id', $route_id)->first();
        $curl = curl_init();
        $curl_data = array("compUuid" => $data->comp_uuid,
            "verifyTrDt" => "$verifyTrDt",
            "verifyTrNo" => "$verifyTrNo",
            "verifyVal" => "$verifyVal");

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.cashes.co.kr/api/v1/viss/confirm',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($curl_data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $data->basic_auth,
                'Content-Type: application/json'
            ),
        ));
        $bank_check_response = curl_exec($curl);
        curl_close($curl);
        $bank_check_response_data = json_decode($bank_check_response);


        if ($bank_check_response_data->code == "0000") {
            return Return_json('0000', 200, "인증완료", 200, null);
        } else {
            return Return_json('9999', 1, "$bank_check_response_data->message", 422, null);
        }

    }

    //페이투스 가상계좌 임시계좌 발급
    public function Account_temporary_issuance(Request $request, $route_id, $company_key)
    {
        if (!company_bank_data::where('route_id', $route_id)->exists()) {
            return Return_json('9999', 1, "허용되지 않은 접근입니다.", 422, null);
        }
        if (!company::where('company_key', $company_key)->where('company_state', 0)->exists()) {
            return Return_json('9999', 1, "허용되지 않은 접근입니다.", 422, null);
        }
        $bank_code = $request->input('bankCode');
        $bank_number = $request->input('acctNo');
        $user_name = $request->input('custNm');
        $amount = $request->input('amount'); //입금 할 금액
        $data = company_bank_data::where('route_id', $route_id)->first();
        if ($amount == "" || $amount == "0") {
            return Return_json('9999', 1, "입금 금액을 확인해주세요.", 422, null);
        }

        $order_id = get_uuid_v1();

        $curl = curl_init();
        $curl_data = array("compUuid" => "$data->comp_uuid",
            "custNm" => "$user_name",
            "custTermDttm" => "$data->comp_uuid",
            "custBankCode" => "$bank_code",
            "custBankAcct" => "$bank_number",
            "custBirth" => "000000",
            "custPhoneNo" => "00000000000",
            "orderId" => "$order_id",
            "orderItemNm" => "$amount",
            "amount" => "$amount"
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.cashes.co.kr/api/v1/viss/request',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($curl_data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $data->basic_auth,
                'Content-Type: application/json'
            ),
        ));
        $bank_check_response = curl_exec($curl);
        curl_close($curl);
        $bank_check_response_data = json_decode($bank_check_response);


        if ($bank_check_response_data->code == "0000") {
            if (account_list::where('account_number', $bank_check_response_data->response->bankAcctNo)->exists()) {
                account_list::where('account_number', $bank_check_response_data->response->bankAcctNo)->delete();
            }
            account_list::insert([
                'company_key' => $company_key,
                'account_number' => $bank_check_response_data->response->bankAcctNo,
                'user_name' => $user_name,
                'account_state' => "임시계좌",
                'bank_name' => "경남은행",
                'date_ymd' => date('Y-m-d'),
                'date_time' => date('H:i:s')
            ]);
            return Return_json('0000', 200, "정상", 200, ['bank_no' => $bank_check_response_data->response->bankAcctNo, 'money' => number_format($amount)]);
        } else {
            return Return_json('9999', 1, "$bank_check_response_data->message", 422, null);
        }
    }

    //페이투스 가상계좌 영구계좌 발급
    public function Account_everlasting_issuance(Request $request, $route_id, $company_key)
    {
        if (!company_bank_data::where('route_id', $route_id)->exists()) {
            return Return_json('9999', 1, "허용되지 않은 접근입니다.", 422, null);
        }
        if (!company::where('company_key', $company_key)->where('company_state', 0)->exists()) {
            return Return_json('9999', 1, "허용되지 않은 접근입니다.", 422, null);
        }
        $bank_code = $request->input('bankCode');
        $bank_number = $request->input('acctNo');
        $user_name = $request->input('custNm');
        $data = company_bank_data::where('route_id', $route_id)->first();

        $curl = curl_init();
        $curl_data = array("compUuid" => "$data->comp_uuid",
            "custNm" => "$user_name",
            "custTermDttm" => "$data->comp_uuid",
            "custBankCode" => "$bank_code",
            "custBankAcct" => "$bank_number",
            "custBirth" => "000000",
            "custPhoneNo" => "00000000000",

        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.cashes.co.kr/api/v1/vips/request',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($curl_data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $data->basic_auth,
                'Content-Type: application/json'
            ),
        ));
        $bank_check_response = curl_exec($curl);
        curl_close($curl);
        $bank_check_response_data = json_decode($bank_check_response);


        if ($bank_check_response_data->code == "0000") {
            if (account_list::where('account_number', $bank_check_response_data->response->bankAcctNo)->exists()) {
                account_list::where('account_number', $bank_check_response_data->response->bankAcctNo)->delete();
            }
            account_list::insert([
                'company_key' => $company_key,
                'account_number' => $bank_check_response_data->response->bankAcctNo,
                'user_name' => $user_name,
                'account_state' => "영구계좌",
                'bank_name' => "경남은행",
                'date_ymd' => date('Y-m-d'),
                'date_time' => date('H:i:s')
            ]);
            return Return_json('0000', 200, "정상", 200, ['bank_no' => $bank_check_response_data->response->bankAcctNo]);
        } else {
            return Return_json('9999', 1, "$bank_check_response_data->message", 422, null);
        }
    }

    //페이투스 가상계좌 설정 페이지
    public function Account_setting(Request $request)
    {
        $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
        $company_key = User::where('key', $HToken)->value('company_key');
        if (company_bank_data::where('company_key', $company_key)->exists()) {
            $data = company_bank_data::where('company_key', $company_key)->first();
        } else {
            $data = null;
        }
        return view('account_setting', ['data' => $data]);
    }

    //페이투스 가상계좌 정보 등록및 업데이트
    public function Account_insert_or_update(Request $request)
    {
        $company_key = User::where('key', $request->user()->key)->value('company_key');
        $p_id = $request->input('p_id');//페이투스 아이디
        $p_pw = $request->input('p_pw');//페이투스 비밀번호
        $p_commuid = $request->input('p_commuid');//페이투스 고유번호
        $p_auth = $request->input('p_auth');//Basic Auth 변환한 것
        if (company_bank_data::where('company_key', $company_key)->exists()) {
            $head_account_date = company_bank_data::where('company_key', $company_key)->first();
            if ($head_account_date->p_id != $p_id) {
                company_bank_data::where('company_key', $company_key)->update(['p_id' => $p_id]); //아이디 업데이트
            }
            if ($head_account_date->p_pw != $p_pw) {
                company_bank_data::where('company_key', $company_key)->update(['p_pw' => $p_pw]); //비밀번호 업데이트
            }
            if ($head_account_date->p_commuid != $p_commuid) {
                company_bank_data::where('company_key', $company_key)->update(['comp_uuid' => $p_commuid]); //고유번호 업데이트
            }
            if ($head_account_date->basic_auth != $p_auth) {
                company_bank_data::where('company_key', $company_key)->update(['basic_auth' => $p_auth]); // basic_auth업데이트
            }
        } else {
            company_bank_data::insert([
                "company_key" => $company_key,
                'p_id' => $p_id,
                "p_pw" => $p_pw,
                "type" => 0,
                "basic_auth" => $p_auth,
                "comp_uuid" => $p_commuid,
                "route_id" => get_uuid_v4()
            ]);
        }
        return Return_json("0000", 200, "정상처리", 200);
    }

    //거래내역 가져오기
    public function Transaction_history_data(Request $request)
    {
        if (!$request->user()->tokenCan('Auth:admin')) {
            $company_key = User::where('key', $request->user()->key)->value('company_key');
        }
        $sh_company_key = $request->input('company_id'); //조회할 가맹점
        //관리자 요청일 경우
        if ($request->user()->tokenCan('Auth:admin')) {
            //데이터가 있을때
            if ($sh_company_key == "") {
                if (transaction_history::whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = transaction_history::whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = transaction_history::whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = transaction_history::whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('transaction_money');
                    $msg = "정상처리";
                    $code = "0000";
                    foreach ($data as $row) {
                        $row['transaction_money'] = number_format($row['transaction_money']);
                        $row['franchisee_money'] = number_format($row['franchisee_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "0001";
                    $count = 0;
                    $sum = 0;
                }
            } else {
                if (transaction_history::where('company_key', $sh_company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = transaction_history::where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = transaction_history::where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = transaction_history::where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('transaction_money');
                    $msg = "정상처리";
                    $code = "0000";
                    foreach ($data as $row) {
                        $row['transaction_money'] = number_format($row['transaction_money']);
                        $row['franchisee_money'] = number_format($row['franchisee_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "0001";
                    $count = 0;
                    $sum = 0;
                }
            }
            //본사 요청시
        } else if ($request->user()->tokenCan('Auth:head')) {
            //데이터가 있을때
            if ($sh_company_key == "") {
                if (transaction_history::where('head_key', $company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = transaction_history::where('head_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = transaction_history::where('head_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = transaction_history::where('head_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('transaction_money');
                    $msg = "정상처리";
                    $code = "0001";
                    foreach ($data as $row) {
                        $row['transaction_money'] = number_format($row['transaction_money']);
                        $row['franchisee_money'] = number_format($row['franchisee_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "9999";
                    $count = 0;
                    $sum = 0;
                }
            } else {
                if (transaction_history::where('head_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = transaction_history::where('head_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = transaction_history::where('head_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = transaction_history::where('head_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('transaction_money');
                    $msg = "정상처리";
                    $code = "0001";
                    foreach ($data as $row) {
                        $row['transaction_money'] = number_format($row['transaction_money']);
                        $row['franchisee_money'] = number_format($row['franchisee_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "9999";
                    $count = 0;
                    $sum = 0;
                }
            }
            //지사 요청시
        } else if ($request->user()->tokenCan('Auth:branch')) {
            //데이터가 있을때
            if ($sh_company_key == "") {
                if (transaction_history::where('branch_key', $company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = transaction_history::where('branch_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = transaction_history::where('branch_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = transaction_history::where('branch_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('transaction_money');
                    $msg = "정상처리";
                    $code = "0002";
                    foreach ($data as $row) {
                        $row['transaction_money'] = number_format($row['transaction_money']);
                        $row['franchisee_money'] = number_format($row['franchisee_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "9999";
                    $count = 0;
                    $sum = 0;
                }
            } else {
                if (transaction_history::where('branch_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = transaction_history::where('branch_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = transaction_history::where('branch_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = transaction_history::where('branch_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('transaction_money');
                    $msg = "정상처리";
                    $code = "0002";
                    foreach ($data as $row) {
                        $row['transaction_money'] = number_format($row['transaction_money']);
                        $row['franchisee_money'] = number_format($row['franchisee_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "9999";
                    $count = 0;
                    $sum = 0;
                }
            }
            //총판 요청시
        } else if ($request->user()->tokenCan('Auth:distributor')) {
            //데이터가 있을때
            if ($sh_company_key == "") {
                if (transaction_history::where('distributor_key', $company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = transaction_history::where('distributor_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = transaction_history::where('distributor_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = transaction_history::where('distributor_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('transaction_money');
                    $msg = "정상처리";
                    $code = "0003";
                    foreach ($data as $row) {
                        $row['transaction_money'] = number_format($row['transaction_money']);
                        $row['franchisee_money'] = number_format($row['franchisee_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "9999";
                    $count = 0;
                    $sum = 0;
                }
            } else {
                if (transaction_history::where('distributor_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = transaction_history::where('distributor_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = transaction_history::where('distributor_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = transaction_history::where('distributor_key', $company_key)->where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('transaction_money');
                    $msg = "정상처리";
                    $code = "0003";
                    foreach ($data as $row) {
                        $row['transaction_money'] = number_format($row['transaction_money']);
                        $row['franchisee_money'] = number_format($row['franchisee_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "9999";
                    $count = 0;
                    $sum = 0;
                }
            }
            //가맹점 요청시
        } else if ($request->user()->tokenCan('Auth:franchisee')) {
            //데이터가 있을때
            if (transaction_history::where('company_key', $company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                $data = transaction_history::where('company_key', $company_key)->whereBetween('date_ymd',
                    [
                        $request->input('start_date'),
                        $request->input('end_date'),
                    ])
                    ->get();
                $count = transaction_history::where('company_key', $company_key)->whereBetween('date_ymd',
                    [
                        $request->input('start_date'),
                        $request->input('end_date'),
                    ])
                    ->count();
                $sum = transaction_history::where('company_key', $company_key)->whereBetween('date_ymd',
                    [
                        $request->input('start_date'),
                        $request->input('end_date'),
                    ])
                    ->sum('transaction_money');
                $msg = "정상처리";
                $code = "0004";
                foreach ($data as $row) {
                    $row['transaction_money'] = number_format($row['transaction_money']);
                    $row['franchisee_money'] = number_format($row['franchisee_money']);
                }
                //없을때
            } else {
                $data = null;
                $msg = "데이터가 존재하지 않습니다.";
                $code = "9999";
                $count = 0;
                $sum = 0;
            }
        }

        return Return_json($code, 200, $msg, 200, ['data' => $data, 'count' => number_format($count), 'sum' => number_format($sum)]);
    }

    //정산내역 가져오기
    public function Calculate_history_data(Request $request)
    {
        if (!$request->user()->tokenCan('Auth:admin')) {
            $company_key = User::where('key', $request->user()->key)->value('company_key');
        }
        $sh_company_key = $request->input('company_id'); //조회할 가맹점
        //관리자 호출시
        if ($request->user()->tokenCan('Auth:admin')) {
            if ($sh_company_key == "") {
                if (calculate::whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = calculate::whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = calculate::where('state', '완료')->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = calculate::where('state', '완료')->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('calculate_money');
                    $msg = "정상처리";
                    $code = "0000";
                    foreach ($data as $row) {
                        $row['calculate_money'] = number_format($row['calculate_money']);
                        $row['calculate_to_money'] = number_format($row['calculate_to_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "0001";
                    $count = 0;
                    $sum = 0;
                }
            } else {
                if (calculate::where('company_key', $sh_company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = calculate::where('company_key', $sh_company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = calculate::where('company_key', $sh_company_key)->where('state', '완료')->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = calculate::where('company_key', $sh_company_key)->where('state', '완료')->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('calculate_money');
                    $msg = "정상처리";
                    $code = "0000";
                    foreach ($data as $row) {
                        $row['calculate_money'] = number_format($row['calculate_money']);
                        $row['calculate_to_money'] = number_format($row['calculate_to_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "0001";
                    $count = 0;
                    $sum = 0;
                }
            }
            //본사 호출시
        } else if ($request->user()->tokenCan('Auth:head')) {
            if ($sh_company_key == "") {
                if (calculate::where('head_key', $company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = calculate::where('head_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = calculate::where('head_key', $company_key)->where('state', '완료')->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = calculate::where('head_key', $company_key)->where('state', '완료')->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('calculate_money');
                    $msg = "정상처리";
                    $code = "0004";
                    foreach ($data as $row) {
                        $row['calculate_money'] = number_format($row['calculate_money']);
                        $row['calculate_to_money'] = number_format($row['calculate_to_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "9999";
                    $count = 0;
                    $sum = 0;
                }
            } else {
                if (calculate::where('company_key', $sh_company_key)->where('head_key', $company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                    $data = calculate::where('company_key', $sh_company_key)->where('head_key', $company_key)->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->get();
                    $count = calculate::where('company_key', $sh_company_key)->where('head_key', $company_key)->where('state', '완료')->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->count();
                    $sum = calculate::where('company_key', $sh_company_key)->where('head_key', $company_key)->where('state', '완료')->whereBetween('date_ymd',
                        [
                            $request->input('start_date'),
                            $request->input('end_date'),
                        ])
                        ->sum('calculate_money');
                    $msg = "정상처리";
                    $code = "0004";
                    foreach ($data as $row) {
                        $row['calculate_money'] = number_format($row['calculate_money']);
                        $row['calculate_to_money'] = number_format($row['calculate_to_money']);
                    }
                    //없을때
                } else {
                    $data = null;
                    $msg = "데이터가 존재하지 않습니다.";
                    $code = "9999";
                    $count = 0;
                    $sum = 0;
                }
            }
        } else {
            //데이터가 있을때
            if (calculate::where('company_key', $company_key)->whereBetween('date_ymd', [$request->input('start_date'), $request->input('end_date'),])->exists()) {
                $data = calculate::where('company_key', $company_key)->whereBetween('date_ymd',
                    [
                        $request->input('start_date'),
                        $request->input('end_date'),
                    ])
                    ->get();
                $count = calculate::where('company_key', $company_key)->where('state', '완료')->whereBetween('date_ymd',
                    [
                        $request->input('start_date'),
                        $request->input('end_date'),
                    ])
                    ->count();
                $sum = calculate::where('company_key', $company_key)->where('state', '완료')->whereBetween('date_ymd',
                    [
                        $request->input('start_date'),
                        $request->input('end_date'),
                    ])
                    ->sum('calculate_money');
                $msg = "정상처리";
                $code = "0004";
                foreach ($data as $row) {
                    $row['calculate_money'] = number_format($row['calculate_money']);
                    $row['calculate_to_money'] = number_format($row['calculate_to_money']);
                }
                //없을때
            } else {
                $data = null;
                $msg = "데이터가 존재하지 않습니다.";
                $code = "9999";
                $count = 0;
                $sum = 0;
            }
        }
        return Return_json($code, 200, $msg, 200, ['data' => $data, 'count' => number_format($count), 'sum' => number_format($sum)]);
    }

    //정산 요청 2차인증 X
    public function Calculate_request(Request $request)
    {

        if ($request->user()->tokenCan('Auth:head')) {
            return Return_json('9999', 1, '본사는 정산 요청이 불가합니다.', 422);
        }
        $money = $request->input('money'); //정산 요청 금액
        $bank_owner = $request->input('bank_owner'); // 정산받을 계좌의 예금주
        $bank_data = explode(',', $request->input('bank_data'));
        $bank_code = $bank_data[0]; //정산받을 계좌의 은행코드
        $bank_name = $bank_data[1]; //정산받을 계좌의 은행명
        $bank_number = $request->input('bank_number');//계좌번호
        if (!$request->user()->tokenCan('Auth:admin')) {
            $company_key = User::where('key', $request->user()->key)->value('company_key');
            $head_key = company::where('company_key', $company_key)->value('head_key');
            $company_name = company::where('company_key', $company_key)->value('company_name');
            $calculate_fee = company::where('company_key', $company_key)->value('calculate_fee'); //출금 수수료

            $company_money = company::where('company_key', $company_key)->value('money'); //현재 업체의 잔액
            if ($money == "") {
                return Return_json('9999', 1, '정산 요청 금액을 입력해주세요', 422);
            }
            if ($bank_owner == "") {
                return Return_json('9999', 1, '예금주 를 입력해주세요', 422);
            }
            if ($bank_name == "") {
                return Return_json('9999', 1, '은행명 을 선택해주세요.', 422);
            }
            if ($company_money < $money + $calculate_fee) {
                return Return_json('9999', 1, "출금 가능액 보다 클수없습니다 현재 출금하려는 금액은 " . number_format($money) . " 원 이며 수수료는 $calculate_fee 원 입니다", 400, null);
            }
            if ($request->user()->auth_2 == 1) {
                return Return_json('0001', 200, '2차인증 필요', 200);
            }
            company::where('company_key', $company_key)->update(['money' => $company_money - $money - $calculate_fee]); //가맹점 잔액 업데이트
            calculate::insert([
                'head_key' => $head_key,
                'company_key' => $company_key,
                'company_name' => $company_name,
                'calculate_money' => $money,
                'calculate_to_money' => $company_money - $money - $calculate_fee,
                'bank_code' => $bank_code,
                'bank_number' => $bank_number,
                'bank_owner' => $bank_owner,
                'bank_name' => $bank_name,
                'date_ymd' => date('Y-m-d'),
                'date_time' => date('H:i:s'),
                'fee' => $calculate_fee,
                'state' => '대기중'
            ]);

            $head_user_telegrams_get = User::where('company_key', $head_key)->get(); //본사와 연결된 계정 전부 가져오기

            //연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
            foreach ($head_user_telegrams_get as $row) {
                if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                    $number_amount = number_format($money);//출금 요청금액 콤마
                    Telegram_send($row['telegram_id'], "*[정산 요청 알림]*\n거래 가맹점 : $company_name\n정산 요청 금액 : $number_amount 원\n정산 후 잔액 : " . number_format($company_money - $money - $calculate_fee) . " 원");
                }
            }
            //관리자 정산 요청 할경우
        }
        return Return_json('0000', 200, '정상 처리되었습니다', 200);

    }

    //정산 요청 2차인증 O
    public function Calculate_auth2_request(Request $request)
    {

        if ($request->user()->tokenCan('Auth:head')) {
            return Return_json('9999', 1, '본사는 정산 요청이 불가합니다.', 422);
        }
        $money = $request->input('money'); //정산 요청 금액
        $bank_owner = $request->input('bank_owner'); // 정산받을 계좌의 예금주
        $bank_data = explode(',', $request->input('bank_data'));
        $bank_code = $bank_data[0]; //정산받을 계좌의 은행코드
        $bank_name = $bank_data[1]; //정산받을 계좌의 은행명
        $bank_number = $request->input('bank_number');//계좌번호
        $auth2_password = $request->input('auth2_password');//2차인증 비밀번호
        if (!$request->user()->tokenCan('Auth:admin')) {
            $company_key = User::where('key', $request->user()->key)->value('company_key');
            $head_key = company::where('company_key', $company_key)->value('head_key');
            $company_name = company::where('company_key', $company_key)->value('company_name');
            $calculate_fee = company::where('company_key', $company_key)->value('calculate_fee'); //출금 수수료

            $company_money = company::where('company_key', $company_key)->value('money'); //현재 업체의 잔액
            if ($money == "") {
                return Return_json('9999', 1, '정산 요청 금액을 입력해주세요', 422);
            }
            if ($bank_owner == "") {
                return Return_json('9999', 1, '예금주 를 입력해주세요', 422);
            }
            if ($bank_name == "") {
                return Return_json('9999', 1, '은행명 을 선택해주세요.', 422);
            }

            if ($company_money < $money + $calculate_fee) {
                return Return_json('9999', 1, "출금 가능액 보다 클수없습니다 현재 출금하려는 금액은 " . number_format($money) . " 원 이며 수수료는 $calculate_fee 원 입니다", 400, null);
            }
            if (!Hash::check($auth2_password, $request->user()->auth_2_password)) {
                return Return_json('9999', 1, '2차 비밀번호가 일치하지 않습니다.', 422);
            }
            company::where('company_key', $company_key)->update(['money' => $company_money - $money - $calculate_fee]); //가맹점 잔액 업데이트
            calculate::insert([
                'head_key' => $head_key,
                'company_key' => $company_key,
                'company_name' => $company_name,
                'calculate_money' => $money,
                'calculate_to_money' => $company_money - $money - $calculate_fee,
                'bank_code' => $bank_code,
                'bank_number' => $bank_number,
                'bank_owner' => $bank_owner,
                'bank_name' => $bank_name,
                'date_ymd' => date('Y-m-d'),
                'date_time' => date('H:i:s'),
                'fee' => $calculate_fee,
                'state' => '대기중'
            ]);

            $head_user_telegrams_get = User::where('company_key', $head_key)->get(); //본사와 연결된 계정 전부 가져오기

            //연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
            foreach ($head_user_telegrams_get as $row) {
                if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                    $number_amount = number_format($money);//출금 요청금액 콤마
                    Telegram_send($row['telegram_id'], "*[정산 요청 알림]*\n거래 가맹점 : $company_name\n정산 요청 금액 : $number_amount 원\n정산 후 잔액 : " . number_format($company_money - $money - $calculate_fee) . " 원");
                }
            }
            //관리자 정산 요청 할경우
        }
        return Return_json('0000', 200, '정상 처리되었습니다', 200);

    }

    //정산 요청 승인 / 거절
    public function Calculate_state_change(Request $request)
    {
        $mode = $request->input('mode');//승인 인지 거절인지
        $id = $request->input('id');//수정할 테이블 아이디

        if ($request->user()->tokenCan('Auth:admin') || $request->user()->tokenCan('Auth:head')) {
            //승인 일경우
            if ($mode == "OK") {
                $calculate_data = calculate::where('id', $id)->first(); //출금 요청한 정보
                $head_data = company::where('company_key', $calculate_data->head_key)->first();//본사 정보
                $updte_money = $head_data->money + $calculate_data->fee;
                company::where('company_key', $calculate_data->head_key)->update(['money' => $updte_money]); //본사 수수료 업데이트
                calculate::where('id', $id)->update(['state' => '완료']); //정산 상태 변경
                $company_user_telegrams_get = User::where('company_key', $calculate_data->company_key)->get(); //가맹점과 연결된 계정 전부 가져오기
                //연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
                foreach ($company_user_telegrams_get as $row) {
                    if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                        Telegram_send($row['telegram_id'], "*[정산 승인 알림]*\n요청 하신 정산요청이 승인되었습니다.");
                    }
                }
            }
            //거절 일경우
            if ($mode == "NO") {
                $calculate_data = calculate::where('id', $id)->first(); //출금 요청한 정보
                $company_data = company::where('company_key', $calculate_data->company_key)->first();//가맹점 정보
                $updte_money = $company_data->money + $calculate_data->calculate_money + $calculate_data->fee;

                company::where('company_key', $calculate_data->company_key)->update(['money' => $updte_money]); //가맹점 금액 원상복구
                $company_user_telegrams_get = User::where('company_key', $calculate_data->company_key)->get(); //가맹점과 연결된 계정 전부 가져오기
                calculate::where('id', $id)->update(['state' => '반려']); //정산 상태 변경
                //연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
                foreach ($company_user_telegrams_get as $row) {
                    if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                        Telegram_send($row['telegram_id'], "*[정산 거절 알림]*\n요청 하신 정산요청이 거절되었습니다.");
                    }
                }
            }
            return Return_json('0000', 200, '정상처리', 200);
        } else {
            return Return_json('9999', 1, '처리할수 없는 계정입니다', 422);
        }

    }

    //계좌 발급 페이지
    public function Account_add_view(Request $request, $route_id, $company_id)
    {
        return view('account_add', ['route_id' => $route_id, 'company_id' => $company_id]);
    }

    //계좌 발급 내역 가져오기
    public function Accounts_history_data(Request $request)
    {
        $company_key = User::where('key', $request->user()->key)->value('company_key');
        if (account_list::where('company_key', $company_key)->exists()) {
            $data = account_list::where('company_key', $company_key)->get();
        } else {
            $data = null;
        }
        return Return_json('0000', 200, '정상처리', 200, $data);
    }

    //Rtpay 설정 페이지
    public function Rtpay_setting(Request $request)
    {
        $HToken = base_64_end_code_de($_COOKIE['H-Token'], _key_, _iv_);
        $company_key = User::where('key', $HToken)->value('company_key');
        if (head_rtpay::where('head_key', $company_key)->exists()) {
            $data = head_rtpay::where('head_key', $company_key)->first();
        } else {
            $data = null;
        }
        return view('rtpay_setting', ['data' => $data]);
    }

    //Rtpay 등록및 업데이트
    public function Rtpay_insert_or_update(Request $request)
    {
        $company_key = User::where('key', $request->user()->key)->value('company_key');
        $req_rtpay_key = $request->input('rtpay_key');
        if (head_rtpay::where('head_key', $company_key)->exists()) {
            $Rtpay_key = head_rtpay::where('head_key', $company_key)->value('RTP_KEY'); //기존 등록된 Rtpay key
            if ($Rtpay_key != $req_rtpay_key) {
                head_rtpay::where('head_key', $company_key)->update(['RTP_KEY' => $req_rtpay_key]); //키 업데이트
            }
        } else {
            head_rtpay::insert([
                'head_key' => $company_key,
                'route_key' => get_uuid_v4(),
                'RTP_KEY' => $req_rtpay_key
            ]);
        }
        return Return_json("0000", 200, "정상처리", 200);
    }

    //Rtpay 입금 확인 혹은 수동입금 요청 혹은 송금을위한 잔액충전 요청
    public function Charge_request(Request $request)
    {
        $mode = $request->input('mode'); // 0 Rtpay 입금확인 요청 , 1 잔액충전을 위한 충전 요청
        $data = $request->input('data'); // 충전 요청 리스트
        $company_key = User::where('key', $request->user()->key)->value('company_key');
        $company_data = company::where('company_key', $company_key)->first();//가맹점 정보
        $head_key = $company_data->head_key; //연결된 본사 키
        if (!head_rtpay::where('head_key', $head_key)->exists()) {
            return Return_json('9999', 1, "해당 기능을 지원하지 않는 업체입니다.", 422,);
        }
        //Rtpay 입금 요청일경우
        if ($mode == "Rtpay") {
            $success_count = 0; //Rtpay 테이블에 존재하여 성공한 데이터 건수
            $failure_count = 0; //Rtpay 테이블에 존재하지 않아 수동승인이 필요한 데이터 건수
            $total_count = count($data); //총 요청 개수
            foreach ($data as $row) {
                //Rtpay에 데이터가 존재할 경우
                if (rtpay_data::where('user_name', $row['user_name'])->where('money', $row['money'])->where('head_key', $head_key)->exists()) {
                    $rtpay_id = rtpay_data::where('user_name', $row['user_name'])->where('money', $row['money'])->where('head_key', $head_key)->value('id');
                    $distributor_data = company::where('company_key', $company_data->distributor_key)->first(); //총판 정보
                    $branch_data = company::where('company_key', $company_data->branch_key)->first(); //지사 정보
                    $head_data = company::where('company_key', $company_data->head_key)->first(); //본사 정보
                    $amount = $row['money']; //입금 금액
                    $clientNm = $row['user_name']; //입금자 이름
                    $number_amount = number_format($amount); //거래금액 콤마찍기(텔레그램 발송용)

                    //가맹점 수수료 정리
                    $company_fee = $amount * $company_data->company_margin; //가맹점이 총판에게 올려줄 금액
                    $company_actual_amount = $amount - $company_fee - $company_data->company_fee; //실제 가맹점이 받는 금액(입금금액 - 가맹점 수수료 - 입금비 (존재할시) )
                    $company_update_money = $company_data->money + $company_actual_amount; //현재 가맹점 금액 + 입금받은 금액의 수수료제외후 금액
                    company::where('company_key', $company_key)->update(['money' => $company_update_money]); //가맹점 금액 업데이트
                    $company_user_telegrams_get = User::where('company_key', $company_key)->get(); //가맹점과 연결된 계정 전부 가져오기

                    //연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
                    foreach ($company_user_telegrams_get as $row) {
                        if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                            Telegram_send($row['telegram_id'], "*[입금 알림]*\n입금자명 : $clientNm\n입금 금액 : $number_amount 원\n수수료 : " . number_format($company_fee) . " 원\n입금비 : " . number_format($company_data->company_fee) . " 원\n정산 금액 : " . number_format($company_actual_amount) . " 원");
                        }
                    }

                    //총판 수수료 정리
                    $distributor_fee = $amount * $distributor_data->company_margin; //총판이 지사에게 올려줄 금액
                    $distributor_actual_amount = $amount * ($company_data->company_margin - $distributor_data->company_margin); //실제 총판이 받는 금액(가맹점 수수료 - 지사 수수료 * 입금금액)
                    $distributor_update_money = $distributor_data->money + $distributor_actual_amount; //현재 지사 금액 + 입금받은 금액의 수수료
                    company::where('company_key', $company_data->distributor_key)->update(['money' => $distributor_update_money]); //총판 금액 업데이트

                    $distributor_user_telegrams_get = User::where('company_key', $company_data->distributor_key)->get(); //총판과 연결된 계정 전부 가져오기

                    //연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
                    foreach ($distributor_user_telegrams_get as $row) {
                        if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                            Telegram_send($row['telegram_id'], "*[입금 알림]*\n거래 가맹점 : $company_data->company_name\n입금 금액 : $number_amount 원\n정산 금액 : " . number_format($distributor_actual_amount) . " 원");
                        }
                    }

                    //지사 수수료 정리
                    $branch_fee = $amount * $branch_data->company_margin; //지사가 본사에게 올려줄 금액
                    $branch_actual_amount = $amount * ($distributor_data->company_margin - $branch_data->company_margin); //실제 지사가 받는 금액(총판 수수료 - 지사 수수료 * 입금금액)
                    $branch_actual_update_money = $branch_data->money + $branch_actual_amount; //현재 지사 금액 + 입금받은 금액의 수수료
                    company::where('company_key', $company_data->branch_key)->update(['money' => $branch_actual_update_money]); //지사 금액 업데이트

                    $branch_user_telegrams_get = User::where('company_key', $company_data->branch_key)->get(); //지사와 연결된 계정 전부 가져오기

                    //연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
                    foreach ($branch_user_telegrams_get as $row) {
                        if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                            Telegram_send($row['telegram_id'], "*[입금 알림]*\n거래 가맹점 : $company_data->company_name\n입금 금액 : $number_amount 원\n정산 금액 : " . number_format($branch_actual_amount) . " 원");
                        }
                    }

                    //본사 수수료 정리
                    $head_fee = $amount * $head_data->company_margin; //본사가 관리자 에게 올려줄 금액
                    $head_actual_amount = $amount * ($branch_data->company_margin - $head_data->company_margin); //실제 본사가 받는 금액(지사 수수료 - 본사 수수료 * 입금금액)
                    $head_actual_update_money = $head_data->money + $head_actual_amount; //현재 본사 금액 + 입금받은 금액의 수수료
                    company::where('company_key', $company_data->head_key)->update(['money' => $head_actual_update_money]); //본사 금액 업데이트

                    $head_user_telegrams_get = User::where('company_key', $company_data->head_key)->get(); //본사와 연결된 계정 전부 가져오기

                    //연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
                    foreach ($head_user_telegrams_get as $row) {
                        if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                            Telegram_send($row['telegram_id'], "*[입금 알림]*\n거래 가맹점 : $company_data->company_name\n입금 금액 : $number_amount 원\n정산 금액 : " . number_format($head_actual_amount) . " 원");
                        }
                    }

                    //관리자 금액 업데이트
                    $super_admin_update_money = User::where('key', 'super_admin')->value('money') + $head_fee + $company_data->company_fee; //현재 관리자 금액 + (본사 수수료 + 입금비(존재할시))
                    User::where('key', 'super_admin')->update(['money' => $super_admin_update_money]); //관리자 금액 업데이트
                    if (User::where('key', 'super_admin')->value('telegram_id') != null || User::where('key', 'super_admin')->value('telegram_id') != "") {
                        Telegram_send($row['telegram_id'], "*[입금 알림]*\n거래 가맹점 : $company_data->company_name\n입금 금액 : $number_amount 원\n정산 금액 : " . number_format($head_fee + $company_data->company_fee) . " 원");
                    }
                    rtpay_data::where('id', $rtpay_id)->delete();
                    //거래내역 INSERT
                    transaction_history::insert([
                        'transaction_key' => get_uuid_v1(),
                        'head_key' => $company_data->head_key,
                        'branch_key' => $company_data->branch_key,
                        'distributor_key' => $company_data->distributor_key,
                        'company_key' => $company_key,
                        'transaction_user_name' => $clientNm,
                        'transaction_money' => $amount,
                        'company_name' => $company_data->company_name,
                        'head_fee' => number_format($head_fee) . "(" . number_format($head_actual_amount) . ")",
                        'branch_fee' => number_format($branch_fee) . "(" . number_format($branch_actual_amount) . ")",
                        'distributor_fee' => number_format($distributor_fee) . "(" . number_format($distributor_actual_amount) . ")",
                        'franchisee_fee' => $company_fee + $company_data->company_fee,
                        'franchisee_money' => $company_actual_amount,
                        'route_key' => "",
                        'date_ymd' => date('Y-m-d'),
                        'date_time' => date('H:i:s')
                    ]);

                    $success_count++;
                } else {
                    charge_request::insert([
                        'company_key' => $company_key,
                        'company_name' => $company_data->company_name,
                        'user_name' => $row['user_name'],
                        'money' => $row['money'],
                        'date_ymd' => date('Y-m-d'),
                        'date_time' => date('H:i:s'),
                        'state' => '승인대기',
                        'charge_request_state' => "수동입금"
                    ]);
                    $failure_count++;
                }
            }
            return Return_json('0000', 200, "총 $total_count 건중 자동승인 $success_count 건 수동승인 필요 $failure_count 건 으로 처리되었습니다.", 200,);
            //잔액 충전 요청일경우
        } elseif ($mode == "money_charge") {
            charge_request::insert([
                'company_key' => $company_key,
                'company_name' => $company_data->company_name,
                'user_name' => $request->input('user_name'),
                'money' => $request->input('money'),
                'date_ymd' => date('Y-m-d'),
                'date_time' => date('H:i:s'),
                'state' => '승인대기',
                'charge_request_state' => "잔액충전"
            ]);
            return Return_json('0000', 200, '정상처리', 200,);
        }

    }

    //페이투스 입금 노티
    public function Deposit_notification(Request $request, $route_id)
    {

        if (!account_list::where('account_number', $request->input('bankAcctNo'))->exists()) {
            //관리자로 텔레 발송 DB에 없는 계좌가 입금되었음
        }
        $company_key = account_list::where('account_number', $request->input('bankAcctNo'))->value('company_key');
        $acctIssuedSeq = $request->input('acctIssuedSeq');//거래번호
        $company_data = company::where('company_key', $company_key)->first();//가맹점 정보
        $distributor_data = company::where('company_key', $company_data->distributor_key)->first(); //총판 정보
        $branch_data = company::where('company_key', $company_data->branch_key)->first(); //지사 정보
        $head_data = company::where('company_key', $company_data->head_key)->first(); //본사 정보
        $amount = $request->input('amount'); //입금 금액
        $clientNm = account_list::where('account_number', $request->input('bankAcctNo'))->value('user_name'); //입금자 이름
        //$clientNm = $request->input('clientNm'); //입금자 이름 (페이투스 에서 보내준거 12-24 사용X 계좌발급 내역에서 가져옴)
        $number_amount = number_format($amount); //거래금액 콤마찍기(텔레그램 발송용)

        if (transaction_history::where('transaction_key', $acctIssuedSeq)->exists()) {
            return response()->json(['code' => "0000", 'message' => "정상"], 200);
        }

        //가맹점 수수료 정리
        $company_fee = $amount * $company_data->company_margin; //가맹점이 총판에게 올려줄 금액
        $company_actual_amount = $amount - $company_fee - $company_data->company_fee; //실제 가맹점이 받는 금액(입금금액 - 가맹점 수수료 - 입금비 (존재할시) )
        $company_update_money = $company_data->money + $company_actual_amount; //현재 가맹점 금액 + 입금받은 금액의 수수료제외후 금액

        //총판 수수료 정리
        $distributor_fee = $amount * $distributor_data->company_margin; //총판이 지사에게 올려줄 금액
        $distributor_actual_amount = $amount * ($company_data->company_margin - $distributor_data->company_margin); //실제 총판이 받는 금액(가맹점 수수료 - 지사 수수료 * 입금금액)
        $distributor_update_money = $distributor_data->money + $distributor_actual_amount; //현재 지사 금액 + 입금받은 금액의 수수료

        //지사 수수료 정리
        $branch_fee = $amount * $branch_data->company_margin; //지사가 본사에게 올려줄 금액
        $branch_actual_amount = $amount * ($distributor_data->company_margin - $branch_data->company_margin); //실제 지사가 받는 금액(총판 수수료 - 지사 수수료 * 입금금액)
        $branch_actual_update_money = $branch_data->money + $branch_actual_amount; //현재 지사 금액 + 입금받은 금액의 수수료

        //본사 수수료 정리
        $head_fee = $amount * $head_data->company_margin; //본사가 관리자 에게 올려줄 금액
        $head_actual_amount = $amount * ($branch_data->company_margin - $head_data->company_margin); //실제 본사가 받는 금액(지사 수수료 - 본사 수수료 * 입금금액)
        $head_actual_update_money = $head_data->money + $head_actual_amount; //현재 본사 금액 + 입금받은 금액의 수수료

        company::where('company_key', $company_key)->update(['money' => $company_update_money]); //가맹점 금액 업데이트
        $company_user_telegrams_get = User::where('company_key', $company_key)->get(); //가맹점과 연결된 계정 전부 가져오기

        company::where('company_key', $company_data->distributor_key)->update(['money' => $distributor_update_money]); //총판 금액 업데이트
        $distributor_user_telegrams_get = User::where('company_key', $company_data->distributor_key)->get(); //총판과 연결된 계정 전부 가져오기

        company::where('company_key', $company_data->branch_key)->update(['money' => $branch_actual_update_money]); //지사 금액 업데이트
        $branch_user_telegrams_get = User::where('company_key', $company_data->branch_key)->get(); //지사와 연결된 계정 전부 가져오기

        company::where('company_key', $company_data->head_key)->update(['money' => $head_actual_update_money]); //본사 금액 업데이트

        $db = transaction_history::insert([
            'transaction_key' => $acctIssuedSeq,
            'head_key' => $company_data->head_key,
            'branch_key' => $company_data->branch_key,
            'distributor_key' => $company_data->distributor_key,
            'company_key' => $company_key,
            'transaction_user_name' => $clientNm,
            'transaction_money' => $amount,
            'company_name' => $company_data->company_name,
            'head_fee' => number_format($head_fee) . "(" . number_format($head_actual_amount) . ")",
            'branch_fee' => number_format($branch_fee) . "(" . number_format($branch_actual_amount) . ")",
            'distributor_fee' => number_format($distributor_fee) . "(" . number_format($distributor_actual_amount) . ")",
            'franchisee_fee' => $company_fee + $company_data->company_fee,
            'franchisee_money' => $company_actual_amount,
            'company_to_money'=>number_format($company_update_money),
            'route_key' => $route_id,
            'date_ymd' => date('Y-m-d'),
            'date_time' => date('H:i:s')
        ]);
        if ($db) {

            //가맹점 연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
            foreach ($company_user_telegrams_get as $row) {
                if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                    Telegram_send($row['telegram_id'], "*[입금 알림]*\n입금자명 : $clientNm\n입금 금액 : $number_amount 원\n수수료 : " . number_format($company_fee) . " 원\n입금비 : " . number_format($company_data->company_fee) . " 원\n정산 금액 : " . number_format($company_actual_amount) . " 원");
                }
            }

            //총판 연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
            foreach ($distributor_user_telegrams_get as $row) {
                if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                    Telegram_send($row['telegram_id'], "*[입금 알림]*\n거래 가맹점 : $company_data->company_name\n입금 금액 : $number_amount 원\n정산 금액 : " . number_format($distributor_actual_amount) . " 원");
                }
            }

            //지사 연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
            foreach ($branch_user_telegrams_get as $row) {
                if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                    Telegram_send($row['telegram_id'], "*[입금 알림]*\n거래 가맹점 : $company_data->company_name\n입금 금액 : $number_amount 원\n정산 금액 : " . number_format($branch_actual_amount) . " 원");
                }
            }

            //본사로 수수료 입금 알림 삭제 22년 12월 27일 (부성페이만 해당)
            if (env('APP_URL') != "https://paygates.kr") {
                $head_user_telegrams_get = User::where('company_key', $company_data->head_key)->get(); //본사와 연결된 계정 전부 가져오기

                //연결된 계정만큼 반복후 텔레그램 설정한 계정만 알림 발송
                foreach ($head_user_telegrams_get as $row) {
                    if ($row['telegram_id'] != null || $row['telegram_id'] != "") {
                        Telegram_send($row['telegram_id'], "*[입금 알림]*\n거래 가맹점 : $company_data->company_name\n입금 금액 : $number_amount 원\n정산 금액 : " . number_format($head_actual_amount) . " 원");
                    }
                }
            }

            //관리자 금액 업데이트
            $super_admin_update_money = User::where('key', 'super_admin')->value('money') + $head_fee + $company_data->company_fee; //현재 관리자 금액 + (본사 수수료 + 입금비(존재할시))
            User::where('key', 'super_admin')->update(['money' => $super_admin_update_money]); //관리자 금액 업데이트
            if (User::where('key', 'super_admin')->value('telegram_id') != null || User::where('key', 'super_admin')->value('telegram_id') != "") {
                Telegram_send($row['telegram_id'], "*[입금 알림]*\n거래 가맹점 : $company_data->company_name\n입금 금액 : $number_amount 원\n정산 금액 : " . number_format($head_fee + $company_data->company_fee) . " 원");
            }

            return response()->json(['code' => "0000", 'message' => "정상"], 200);
        } else {
            return response()->json(['code' => "9999", 'message' => "실패"], 422);
        }

    }

    //Rtpay 입금 노티
    public function Rtpay_noti_v1(Request $request, $route_id)
    {
        $RTPay = new RTPay;
        $RTP_KEY = head_rtpay::where('route_key', $route_id)->value('RTP_KEY');
        $head_key = head_rtpay::where('route_key', $route_id)->value('head_key');
        $RTPay->RTP_KEY = $RTP_KEY; //인증키값 설정

        $resultArray = array();
        $resultArray['PCHK'] = "NO";

        if ($_POST['regPkey'] == $RTPay->RTP_KEY) {
            if ($RTPay->checkCURL()) {
                if ($_POST['ugrd'] < 20) {
                    $RTPay->RTP_URL = "https://rtpay.net/CheckPay/test_checkpay.php";
                } else {
                    $RTPay->RTP_URL = "https://rtpay.net/CheckPay/checkpay.php";
                }

                $retRTP = $RTPay->getRTPay();

                if ($retRTP->RCODE == '200') {
                    $pbank = $retRTP->RBANK; //은행명
                    $pname = $retRTP->RNAME; //입금자명
                    $pmoney = $retRTP->RPAY; //입금금액
                    $tall = $retRTP->RTEXT; //전송 데이터 전문

                    rtpay_data::insert([
                        'head_key' => $head_key,
                        'user_name' => mb_substr($pname, 0, 3, 'utf-8'),
                        'money' => $pmoney,
                        'date_ymd' => date('Y-m-d'),
                        'date_time' => date('H:i:s'),
                    ]);
                    $resultArray['PCHK'] = "OK";
                    //========================== 인증키값 설정과 이 부분만 고쳐주세요. =======================

                    //입금신청을 기록하신 기존 DB 데이터와 비교하는 코드 입력부분
                    //입금자명과 금액이 일치하는 갯수를 비교하여 한개 이상이면 입금완료 처리 보류

                    //입금데이터와 비교하여 매칭이 되었을 경우 $resultArray['PCHK'] =  "OK";
                    //입금데이터와 비교하여 매칭이 되지 않았을 경우 $resultArray['PCHK'] =  "NO";

                    //========================== 인증키값 설정과 이 부분만 고쳐주세요. =======================
                }

                $resultArray['RCODE'] = $retRTP->RCODE;
            } else {
                $resultArray['RCODE'] = "300";
            }
        } else {
            if (!$_POST['regPkey']) {
                $_POST['regPkey'] = $RTPay->RTP_KEY;
                $RTPay->RTP_URL = "https://rtpay.net/CheckPay/setPurl.php";
                $retRTP = $RTPay->getRTPay();
            }
            $resultArray['RCODE'] = "400";
        }

        echo json_encode($resultArray);
    }

    //텔레그램 셋팅
    public function Telegram_setting(Request $request)
    {
        $telegram = new Api(env('TELEGRAM_TOKEN'));
        $updates = $telegram->getWebhookUpdates();

        $username = $updates['message']['chat']['username'];
        $userid = $updates['message']['chat']['id'];
        $text = $updates['message']['text'];
        if (substr($text, 0, 4) == "/set") {
            $key = substr($text, 5);
            //사용자가 존재하는지 확인
            if (!User::where('key', $key)->exists()) {
                return $telegram->sendMessage([
                    'chat_id' => $userid,
                    'text' => "등록되지 않은 유저 입니다.",
                ]);
            }
            //이미 등록을 했는지 확인
            if (User::where('key', $key)->value('telegram_id') != null || User::where('key', $key)->value('telegram_id') != "") {
                return $telegram->sendMessage([
                    'chat_id' => $userid,
                    'text' => "이미 등록한 사용자 입니다.",
                ]);
                //등록한적이 없다면 등록
            } else {
                $user_name = User::where('key', $key)->value('user_name');
                $company_key = User::where('key', $key)->value('company_key');
                $company_name = company::where('company_key', $company_key)->value('company_name');
                User::where('key', $key)->update(['telegram_id' => $userid]);
                return $telegram->sendMessage([
                    'chat_id' => $userid,
                    'text' => "사용자 '$user_name' 님 [$company_name] 소속으로 등록되었습니다.",
                ]);
            }
        } elseif (substr($text, 0, 7) == "/delete") {
            $key = substr($text, 8);
            //사용자가 존재하는지 확인
            if (!User::where('key', $key)->exists()) {
                return $telegram->sendMessage([
                    'chat_id' => $userid,
                    'text' => "등록되지 않은 유저 입니다.",
                ]);
            }
            //이미 등록을 했는지 확인
            if (User::where('key', $key)->value('telegram_id') != null || User::where('key', $key)->value('telegram_id') != "") {
                $user_name = User::where('key', $key)->value('user_name');
                $company_key = User::where('key', $key)->value('company_key');
                $company_name = company::where('company_key', $company_key)->value('company_name');
                User::where('key', $key)->update(['telegram_id' => ""]);
                return $telegram->sendMessage([
                    'chat_id' => $userid,
                    'text' => "사용자 '$user_name' 님 [$company_name] 알림이 해제되었습니다.",
                ]);
            } else {
                return $telegram->sendMessage([
                    'chat_id' => $userid,
                    'text' => "등록되지 않은 유저 입니다.",
                ]);
            }
        }
    }


}
