<?php

	function weather($n)
    {
        $code=$this->check($n);
    	if(!empty($code)){
        	$json=file_get_contents("http://mobile.weather.com.cn/data/sk/{$code}.html");
        	return json_decode($json);
    	} else {
        	return null;
    	}
	}
	
    
	//根据城市名获取编码
   	private function check($str){
		include("weather_id.php");
		if (in_array($str, $arr)) {
			return array_search($str, $arr);
		}else {
            //默认北京天气
			return 101190401;
		}
	}
?>