<?php

namespace App\Fucntions;

class RTPay
{
    var $RTP_KEY;
    var $RTP_URL;

    //Curl 채크
    function checkCURL() {
        if (extension_loaded('curl')) {
            return true;
        } else {
            return false;
        }
    }

    //데이터전송
    function getRTPay()
    {
        $post_field_string = http_build_query($_POST, '', '&');
        $curlObj = curl_init();
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        curl_setopt($curlObj, CURLOPT_URL, $this->RTP_URL);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $post_field_string);
        curl_setopt($curlObj, CURLOPT_POST, true);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_REFERER, $actual_link);
        curl_setopt($curlObj, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/x-www-form-urlencoded'));

        $res = curl_exec($curlObj);
        curl_close($curlObj);

        return json_decode($res);
    }
}
