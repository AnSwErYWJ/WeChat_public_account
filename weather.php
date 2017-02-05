<?php

	function weather($n)
    {
        $code=check($n);
    	if(!empty($code)){
        	$json=file_get_contents("http://mobile.weather.com.cn/data/sk/{$code}.html");
        	return json_decode($json);
    	} else {
        	return null;
    	}
	}
	
    
	//根据城市名获取编码
   	function check($str){
		include("weather_id.php");
		if (in_array($str, $arr)) {
			return array_search($str, $arr);
		}else {
            //默认北京天气
			return 101190401;
		}
	}

	function test($str){
		$location = "suzhou"; // 除拼音外，还可以使用 v3 id、汉语等形式
		$key = "konue37m5gsk7tn6"; // 测试用 key，请更换成您自己的 Key
		$uid = "U998C50C5F"; // 测试用 用户ID，请更换成您自己的用户ID
		// 获取当前时间戳，并构造验证参数字符串
		$keyname = "ts=".time()."&ttl=30&uid=".$uid;
		
		// 使用 HMAC-SHA1 方式，以 API 密钥（key）对上一步生成的参数字符串（raw）进行加密
		$sig = base64_encode(hash_hmac('sha1', $keyname, $key, true));
		
		// 将上一步生成的加密结果用 base64 编码，并做一个 urlencode，得到签名sig
		$signedkeyname = $keyname."&sig=".urlencode($sig);
		// 最终构造出可由前端进行调用的 url
		$url = "https://api.thinkpage.cn/v3/weather/now.json?location=".$location."&".$signedkeyname;
		
		//$json = file_get_contents($url);
		//echo $json;

		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
		$json = curl_exec($ch);
		return json_decode($json);
	}
?>