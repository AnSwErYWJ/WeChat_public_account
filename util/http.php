<?php

//if method is post,header and postfields is neccessary
function httpRequest($url, $ssl = TRUE, $method = "get", $header = "", $rawdata = "")
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    if (!strcasecmp($method,"post")) 
    {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $rawdata);
    }  

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $ssl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
    
    $output = curl_exec($ch);
    if ($output === FALSE){
        return "cURL Error: ". curl_error($ch);
    }

    $info = curl_getinfo($ch);
    //echo 'URL:'. $info['url'] . '  time:'. $info['total_time'] . 's';

    curl_close($ch);

    return $output;
}

?>