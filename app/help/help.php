<?php

//사용자 식별값 생성
function get_uuid_v4()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff));
}

function get_uuid_v3()
{
    return "PO_".sprintf('%04x%04x-%04x-%04x-%04x-%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),);
}


//계좌생성 일때 씀
function get_uuid_v1()
{
    return sprintf('%04x-%02x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff));
}

function base_64_end_code_en($str, $secret_key = 'secret key', $secret_iv = 'secret iv')
{
    $base_64_str = base64_encode($str);
    return str_replace(
        "=",
        "",
        base64_encode(
            openssl_encrypt($base_64_str, "AES-256-CBC", $secret_key, 0, $secret_iv)
        )
    );
}
const _key_ = 'f8e50d75d101fc4bf4e1dc9cee5d6687ed827a0ca177d8eb76ed5a76bab1c8cb';
const _iv_ = 'e3b6449021144a6d';
function base_64_end_code_de($str, $secret_key = 'secret key', $secret_iv = 'secret iv')
{
    $sah256_de = openssl_decrypt(
        base64_decode($str),
        "AES-256-CBC",
        $secret_key,
        0,
        $secret_iv
    );
    return base64_decode($sah256_de);
}

function Return_json($code = "", $info = "", $msg = "", $state = "", $data = "")
{
    if ($info == 1) {$resultMsg = "Error";} else { $resultMsg = "success";}
    if ($data == null) {
        return response()->json(['result' => [
            "resultCd" => $code,
            "resultMsg" => $resultMsg,
            "advanceMsg" => $msg,
            "create" => date('YmdHis'),
        ],
        ], $state);
    } else {

        return response()->json(['result' => [
            "resultCd" => $code,
            "resultMsg" => $resultMsg,
            "advanceMsg" => $msg,
            "create" => date('YmdHis'),
        ],
            'data' => $data,
        ], $state);
    }
}

function Telegram_send($chat_id,$msg){
    $mes_data = array('chat_id' => $chat_id, 'text' => "$msg", "parse_mode" => "markdown");
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.telegram.org/bot5789475794:AAHvr7CoRUqHktPQkNh_6Kp-0sO3uXUabcs/sendmessage',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $mes_data,
    ));
    $response = curl_exec($curl);
    curl_close($curl);
}

