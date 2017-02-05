<?php

class handleConfig
{
	function get_config($file, $k1 = NULL, $k2 = NULL, $k3 = NULL){
		if(!file_exists($file)) return false;
		$js_str = file_get_contents($file);
		
		$data = json_decode($js_str);

		$output = $data;
				
		if(isset($k3)){
			$output = $data->$k1->$k2->$k3;
		}elseif(isset($k2)){
			$output = $data->$k1->$k2;
		}elseif (isset($k1)) {
			$output = $data->$k1;
		}		
		
		return $output;
	} 

	function update_config($file, $value, $k1 = null, $k2 = null, $k3 = null){ 
		if(!file_exists($file)) return false; 
		$js_str = file_get_contents($file); 
		$data = json_decode($js_str);

		if(isset($k3)){
			$data->$k1->$k2->$k3 = $value;
		}elseif(isset($k2)){
			$data->$k1->$k2 = $value;
		}elseif (isset($k1)) {
			$data->$k1 = $value;
		} 
		
		file_put_contents($file, json_encode($data)); 
	} 
}
?>