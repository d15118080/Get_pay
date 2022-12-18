<?php

namespace App\Http\Controllers;

use App\Models\account_list;
use App\Models\calculate;
use App\Models\company;
use App\Models\company_bank_data;
use App\Models\transaction_history;
use App\Models\withdraw;
use App\Models\User;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

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
                'date_ymd' => date('Y-m-d'),
                'date_time' => date('H:i:s')
            ]);
            return Return_json('0000', 200, "정상", 200, ['bank_no' => $bank_check_response_data->response->bankAcctNo]);
        } else {
            return Return_json('9999', 1, "$bank_check_response_data->message", 422, null);
        }
    }

    //거래내역 가져오기
    public function Transaction_history_data(Request $request)
    {
        if (!$request->user()->tokenCan('Auth:admin')) {
            $company_key = User::where('key', $request->user()->key)->value('company_key');
        }
        //관리자 요청일 경우
        if ($request->user()->tokenCan('Auth:admin')) {
            //데이터가 있을때
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
            //본사 요청시
        } else if ($request->user()->tokenCan('Auth:head')) {
            //데이터가 있을때
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
            //지사 요청시
        } else if ($request->user()->tokenCan('Auth:branch')) {
            //데이터가 있을때
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
            //총판 요청시
        } else if ($request->user()->tokenCan('Auth:distributor')) {
            //데이터가 있을때
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
        //관리자 호출시
        if ($request->user()->tokenCan('Auth:admin')) {
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
            //그외 호출시
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

    //계좌 발급 페이지
    public function Account_add_view(Request $request, $route_id, $company_id)
    {
        return view('account_add', ['route_id' => $route_id, 'company_id' => $company_id]);
    }

    //입금 노티
    public function Deposit_notification(Request $request, $route_id)
    {
        if (!account_list::where('account_number', $request->input('bankAcctNo'))->exists()) {
            //관리자로 텔레 발송 DB에 없는 계좌가 입금되었음
        }
        $company_key = account_list::where('account_number', $request->input('bankAcctNo'))->value('company_key');

        $company_data = company::where('company_key', $company_key)->first();//가맹점 정보
        $distributor_data = company::where('company_key', $company_data->distributor_key)->first(); //총판 정보
        $branch_data = company::where('company_key', $company_data->branch_key)->first(); //지사 정보
        $head_data = company::where('company_key', $company_data->head_key)->first(); //본사 정보
        $amount = $request->input('amount'); //입금 금액
        $clientNm = $request->input('clientNm'); //입금자 이름
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

        $head_user_telegrams_get = User::where('company_key', $company_data->branch_key)->get(); //본사와 연결된 계정 전부 가져오기

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
            'franchisee_fee' => number_format($company_fee),
            'franchisee_money' => number_format($company_actual_amount),
            'route_key' => $route_id,
            'date_ymd' => date('Y-m-d'),
            'date_time' => date('H:i:s')
        ]);
        return response()->json(['code' => "0000", 'message' => "정상"], 200);
    }

    //텔레그램 셋팅
    public function Telegram_setting(Request $request)
    {
        $telegram = new Api('5789475794:AAHvr7CoRUqHktPQkNh_6Kp-0sO3uXUabcs');
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
