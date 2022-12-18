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
                $pu_arr_withdraw = calculate::where('date_ymd', $data)->where('state','완료')->sum('calculate_money');
                array_push($arr_withdraw, $pu_arr_withdraw);
            }
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('state','완료')->sum('calculate_money');
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
                $pu_arr_withdraw = calculate::where('date_ymd', $data)->where('head_key', $company_key)->where('state','완료')->sum('calculate_money');
                array_push($arr_withdraw, $pu_arr_withdraw);
            }
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('head_key', $company_key)->where('state','완료')->sum('calculate_money');
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
                $pu_arr_withdraw = calculate::where('date_ymd', $data)->where('company_key', $company_key)->where('state','완료')->sum('calculate_money');
                array_push($arr_withdraw, $pu_arr_withdraw);
            }
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('company_key', $company_key)->where('state','완료')->sum('calculate_money');
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
                $pu_arr_withdraw = calculate::where('date_ymd', $data)->where('company_key', $company_key)->where('state','완료')->sum('calculate_money');
                array_push($arr_withdraw, $pu_arr_withdraw);
            }
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('company_key', $company_key)->where('state','완료')->sum('calculate_money');
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
                $pu_arr_withdraw = calculate::where('date_ymd', $data)->where('company_key', $company_key)->where('state','완료')->sum('calculate_money');
                array_push($arr_withdraw, $pu_arr_withdraw);
            }
            $today_withdraw_money = calculate::where('date_ymd', date('Y-m-d'))->where('company_key', $company_key)->where('state','완료')->sum('calculate_money');
            array_push($arr_withdraw, $today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date, date('Y-m-d')); //당일 일자 넣기
        }

        return Return_json(0000, 200, '정상처리', 200, ['dates' => $arr_date, 'arr_money' => $arr_money, 'arr_withdraw' => $arr_withdraw]);
    }

    //페이투스 가상계좌 1원 발급 (본사 키로 연결하여 데이터 가져옴)
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
            return Return_json('9999', 1, "$bank_check_response_data->message", 200, null);
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
            if(account_list::where('account_number',$bank_check_response_data->response->bankAcctNo)->exists()){
                account_list::where('account_number',$bank_check_response_data->response->bankAcctNo)->delete();
            }
            account_list::insert([
                'company_key'=>$company_key,
                'account_number'=>$bank_check_response_data->response->bankAcctNo,
                'user_name'=>$user_name,
                'account_state'=>"임시계좌",
                'date_ymd'=>date('Y-m-d'),
                'date_time'=>date('H:i:s')
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
            if(account_list::where('account_number',$bank_check_response_data->response->bankAcctNo)->exists()){
                account_list::where('account_number',$bank_check_response_data->response->bankAcctNo)->delete();
            }
            account_list::insert([
                'company_key'=>$company_key,
                'account_number'=>$bank_check_response_data->response->bankAcctNo,
                'user_name'=>$user_name,
                'account_state'=>"영구계좌",
                'date_ymd'=>date('Y-m-d'),
                'date_time'=>date('H:i:s')
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
                $count = calculate::where('state','완료')->whereBetween('date_ymd',
                    [
                        $request->input('start_date'),
                        $request->input('end_date'),
                    ])
                    ->count();
                $sum = calculate::where('state','완료')->whereBetween('date_ymd',
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
                $count = calculate::where('company_key', $company_key)->where('state','완료')->whereBetween('date_ymd',
                    [
                        $request->input('start_date'),
                        $request->input('end_date'),
                    ])
                    ->count();
                $sum = calculate::where('company_key', $company_key)->where('state','완료')->whereBetween('date_ymd',
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

}
