<?php

namespace App\Http\Controllers;

use App\Models\company_bank_data;
use App\Models\transaction_history;
use App\Models\withdraw;
use App\Models\User;
use Illuminate\Http\Request;

class Transaction_Controller extends Controller
{

    //인덱스 최근 거래내역 및 요약 차트
    public function Index_data(Request $request){

        $company_key = User::where('key',$request->user()->key)->value('company_key');
        $arr_money = []; //입금 금액 0번키 가 7일전임 순서으로 ~ 당일
        $arr_date = []; // 7일전 까지의 날짜
        $arr_withdraw = []; //출금 금액 0번키 가 7일전임 순서으로 ~ 당일
        //관리자 요청일 경우
        if ($request->user()->tokenCan('Auth:admin')) {
            //입금 금액 배열 생성
            for ($i=6; $i>0; $i--){
                $data = date("Y-m-d", strtotime(date('Y-m-d')." -$i day"));
                $pu_arr_sum = transaction_history::where('date_ymd',$data)->sum('transaction_money');
                array_push($arr_money,$pu_arr_sum);
                array_push($arr_date,$data);
            }
            $today_money = transaction_history::where('date_ymd',date('Y-m-d'))->sum('transaction_money');
            array_push($arr_money,$today_money);

            //출금 금액 배열 생성
            for ($i=6; $i>0; $i--){
                $data = date("Y-m-d", strtotime(date('Y-m-d')." -$i day"));
                $pu_arr_withdraw = withdraw::where('date_ymd',$data)->sum('money');
                array_push($arr_withdraw,$pu_arr_withdraw);
            }
            $today_withdraw_money = withdraw::where('date_ymd',date('Y-m-d'))->sum('money');
            array_push($arr_withdraw,$today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date,date('Y-m-d')); //당일 일자 넣기
        }

        //본사 요청
        else if ($request->user()->tokenCan('Auth:head')) {
            //입금 금액 배열 생성
            for ($i=6; $i>0; $i--){
                $data = date("Y-m-d", strtotime(date('Y-m-d')." -$i day"));
                $pu_arr_sum = transaction_history::where('date_ymd',$data)->where('head_key',$company_key)->sum('transaction_money');
                array_push($arr_money,$pu_arr_sum);
                array_push($arr_date,$data);
            }
            $today_money = transaction_history::where('date_ymd',date('Y-m-d'))->where('head_key',$company_key)->sum('transaction_money');
            array_push($arr_money,$today_money);

            //출금 금액 배열 생성
            for ($i=6; $i>0; $i--){
                $data = date("Y-m-d", strtotime(date('Y-m-d')." -$i day"));
                $pu_arr_withdraw = withdraw::where('date_ymd',$data)->where('head_key',$company_key)->sum('money');
                array_push($arr_withdraw,$pu_arr_withdraw);
            }
            $today_withdraw_money = withdraw::where('date_ymd',date('Y-m-d'))->where('head_key',$company_key)->sum('money');
            array_push($arr_withdraw,$today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date,date('Y-m-d')); //당일 일자 넣기
        }

        //지사 요청
        else if ($request->user()->tokenCan('Auth:branch')) {
            //입금 금액 배열 생성
            for ($i=6; $i>0; $i--){
                $data = date("Y-m-d", strtotime(date('Y-m-d')." -$i day"));
                $pu_arr_sum = transaction_history::where('date_ymd',$data)->where('branch_key',$company_key)->sum('transaction_money');
                array_push($arr_money,$pu_arr_sum);
                array_push($arr_date,$data);
            }
            $today_money = transaction_history::where('date_ymd',date('Y-m-d'))->where('branch_key',$company_key)->sum('transaction_money');
            array_push($arr_money,$today_money);

            //출금 금액 배열 생성
            for ($i=6; $i>0; $i--){
                $data = date("Y-m-d", strtotime(date('Y-m-d')." -$i day"));
                $pu_arr_withdraw = withdraw::where('date_ymd',$data)->where('company_key',$company_key)->sum('money');
                array_push($arr_withdraw,$pu_arr_withdraw);
            }
            $today_withdraw_money = withdraw::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->sum('money');
            array_push($arr_withdraw,$today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date,date('Y-m-d')); //당일 일자 넣기
        }

        //총판 요청
        else if ($request->user()->tokenCan('Auth:distributor')) {
            //입금 금액 배열 생성
            for ($i=6; $i>0; $i--){
                $data = date("Y-m-d", strtotime(date('Y-m-d')." -$i day"));
                $pu_arr_sum = transaction_history::where('date_ymd',$data)->where('distributor_key',$company_key)->sum('transaction_money');
                array_push($arr_money,$pu_arr_sum);
                array_push($arr_date,$data);
            }
            $today_money = transaction_history::where('date_ymd',date('Y-m-d'))->where('distributor_key',$company_key)->sum('transaction_money');
            array_push($arr_money,$today_money);

            //출금 금액 배열 생성
            for ($i=6; $i>0; $i--){
                $data = date("Y-m-d", strtotime(date('Y-m-d')." -$i day"));
                $pu_arr_withdraw = withdraw::where('date_ymd',$data)->where('company_key',$company_key)->sum('money');
                array_push($arr_withdraw,$pu_arr_withdraw);
            }
            $today_withdraw_money = withdraw::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->sum('money');
            array_push($arr_withdraw,$today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date,date('Y-m-d')); //당일 일자 넣기
        }

        //가맹점 요청
        else if ($request->user()->tokenCan('Auth:franchisee')) {
            //입금 금액 배열 생성
            for ($i=6; $i>0; $i--){
                $data = date("Y-m-d", strtotime(date('Y-m-d')." -$i day"));
                $pu_arr_sum = transaction_history::where('date_ymd',$data)->where('company_key',$company_key)->sum('transaction_money');
                array_push($arr_money,$pu_arr_sum);
                array_push($arr_date,$data);
            }
            $today_money = transaction_history::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->sum('transaction_money');
            array_push($arr_money,$today_money);

            //출금 금액 배열 생성
            for ($i=6; $i>0; $i--){
                $data = date("Y-m-d", strtotime(date('Y-m-d')." -$i day"));
                $pu_arr_withdraw = withdraw::where('date_ymd',$data)->where('company_key',$company_key)->sum('money');
                array_push($arr_withdraw,$pu_arr_withdraw);
            }
            $today_withdraw_money = withdraw::where('date_ymd',date('Y-m-d'))->where('company_key',$company_key)->sum('money');
            array_push($arr_withdraw,$today_withdraw_money); //당일 금액 배열넣기
            array_push($arr_date,date('Y-m-d')); //당일 일자 넣기
        }

        return Return_json(0000,200,'정상처리',200,['dates'=>$arr_date,'arr_money'=>$arr_money,'arr_withdraw'=>$arr_withdraw]);
    }


    //페이투스 가상계좌 1원 발급 (본사 키로 연결하여 데이터 가져옴)
    public function Won_shipment(Request $request,$route_id){
        if(!company_bank_data::where('route_id',$route_id)->exists()){
            return Return_json('9999', 1, "허용되지 않은 접근입니다.", 422, null);
        }
        $data = company_bank_data::where('route_id',$route_id)->first();
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
                'Authorization: Basic '.$data->basic_auth,
                'Content-Type: application/json'
            ),
        ));
        $bank_check_response = curl_exec($curl);
        curl_close($curl);
        $bank_check_response_data = json_decode($bank_check_response);

        if ($bank_check_response_data->code == "0000") {
            $return_data =[
                'verifyTrDt' => $bank_check_response_data->response->verifyTrDt,
                'verifyTrNo' => $bank_check_response_data->response->verifyTrNo,
                'acctNo' => $bank_number,
                'custNm' => $user_name,
                'bankCode' => $bank_code
            ];
            return Return_json('0000', 200, "정상처리", 200, $return_data);

        } else {
            return Return_json('9999', 1,$bank_check_response_data, 200, null);
        }
    }

    //페이투스 가상계좌 1원 인증 (본시 키로 연결하여 데이터 가져옴)
    public function Won_shipment_check(Request $request,$route_id){
        $verifyVal = $request->input('verifyVal');
        $verifyTrDt = $request->input('verifyTrDt');
        $verifyTrNo = $request->input('verifyTrNo');
        if ($verifyVal == "") {
            return Return_json('9999', 1, "필수값을 입력해주세요.", 422, null);
        }
        if(!company_bank_data::where('route_id',$route_id)->exists()){
            return Return_json('9999', 1, "허용되지 않은 접근입니다.", 422, null);
        }
        $data = company_bank_data::where('route_id',$route_id)->first();
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
                'Authorization: Basic '.$data->basic_auth,
                'Content-Type: application/json'
            ),
        ));
        $bank_check_response = curl_exec($curl);
        curl_close($curl);
        $bank_check_response_data = json_decode($bank_check_response);


        if ($bank_check_response_data->code == "0000") {
            return Return_json('0000', 200, "인증완료", 200, null);
        } else {
            return Return_json('9999', 1, "인증 문자가 일치하지 않습니다.", 422, null);
        }

    }
}
