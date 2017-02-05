<?php

function getXiaoiInfo($openid, $app_key, $app_secret, $content)
{

    //签名算法
    $realm = "xiaoi.com";
    $method = "POST";
    $uri = "/robot/ask.do";
    $nonce = "";
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    for ($i = 0; $i < 40; $i++) {
        $nonce .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
    $HA1 = sha1($app_key.":".$realm.":".$app_secret);
    $HA2 = sha1($method.":".$uri);
    $sign = sha1($HA1.":".$nonce.":".$HA2);

    $url = "http://nlp.xiaoi.com/robot/ask.do";
    $ssl = TRUE;
    $method = "post";
    $header = 'X-Auth:    app_key="'.$app_key.'", nonce="'.$nonce.'", signature="'.$sign.'"';
    $rawdata = "question=".urlencode($content)."&userId=".$openid."&platform=custom&type=0";

    $output = httpRequest($url,$ssl,$method,$header,$rawdata);
    
    return trim($output);
}

?>