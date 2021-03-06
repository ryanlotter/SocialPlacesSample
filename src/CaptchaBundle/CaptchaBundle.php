<?php
namespace App\CaptchaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

//As a sample - the bundle will
class CaptchaBundle extends Bundle {

    function captchaverify($recaptcha){
      //Would normally use CURL - but was having issues with the SSL certificates
      /*    $url = "https://www.google.com/recaptcha/api/siteverify";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array("secret"=>"6LeTXQgUAAAAALExcpzgCxWdnWjJcPDoMfK3oKGi","response"=>$recaptcha));
            $response = curl_exec($ch);
            curl_close($ch);
        */
        $arrContextOptions=array("ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false));
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdLynEUAAAAADOIbz1tP73flCR5CxA9Mjk_0Y-S&response=".$recaptcha, false, stream_context_create($arrContextOptions));
        $data = json_decode($response);
        if (isset($data->success)) {
          return $data->success;
        } else {
          return false;
        }
    }
}