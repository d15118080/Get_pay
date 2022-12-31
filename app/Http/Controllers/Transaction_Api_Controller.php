<?php

namespace App\Http\Controllers;

use App\Models\calculate;
use App\Models\User;
use Illuminate\Http\Request;

class Transaction_Api_Controller extends Controller
{
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
}
