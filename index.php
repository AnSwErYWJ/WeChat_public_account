<?php
header('Content-type:text');

include "util/handle_config.php";

/* 有echostr参数说明为签名校验操作 */
if (!isset($_GET['echostr'])) {
    responseMsg();
}else{
    checkSignature();
}

//响应消息
function responseMsg()
{
    $postStr = file_get_contents('php://input');
    if (!empty($postStr)){
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $RX_TYPE = trim($postObj->MsgType);

        include "wechatApi/wechat_api.php";
        $wechatObj = new wechatCallback();

        include "util/http.php";
        
        //消息类型分离
        switch ($RX_TYPE)
        {
            case "event":
                $result = $wechatObj->receiveEvent($postObj);
                break;
            case "text":
            	$hc = new handleConfig();
            	$wechatObj->wechat_access_token = $hc->get_config("config.json", "wechat","AccessToken");
				$wechatObj->wechat_expires = $hc->get_config("config.json", "wechat","Expires");
				$wechatObj->wechat_AppId = $hc->get_config("config.json", "wechat","AppID");
				$wechatObj->wechat_AppSecret = $hc->get_config("config.json", "wechat","AppSecret");
				$wechatObj->xiaoi_AppSecret = $hc->get_config("config.json", "xiaoi","AppSecret");
				$wechatObj->xiaoi_AppKey = $hc->get_config("config.json", "xiaoi","AppKey");
                $result = $wechatObj->receiveText($postObj);
                break;
            case "image":
                $result = $wechatObj->receiveImage($postObj);
                break;
            case "location":
                $result = $wechatObj->receiveLocation($postObj);
                break;
            case "voice":
                $result = $wechatObj->receiveVoice($postObj);
                break;
            case "video":
			case "shortvideo":
                $result = $wechatObj->receiveVideo($postObj);
                break;
            case "link":
                $result = $wechatObj->receiveLink($postObj);
                break;
            default:
                $result = "unknown msg type: ".$RX_TYPE;
                break;
        }
        echo $result;
    }else {
        echo "";
        exit;
    }
}

//验证签名
function checkSignature()
{
	$hc = new handleConfig();

	$echoStr = $_GET["echostr"];
	$signature = $_GET["signature"];
	$timestamp = $_GET["timestamp"];
	$nonce = $_GET["nonce"]; //随机数
	$wechat_token = $hc->get_config("config.json", "wechat","TOKEN");
	$tmpArr = array($wechat_token, $timestamp, $nonce);
	sort($tmpArr, SORT_STRING); //字典排序
	$tmpStr = implode($tmpArr); //拼接成一个字符串
	$tmpStr = sha1($tmpStr); //sha1加密
	/* 验证成功原样返回 */
	if($tmpStr == $signature){
	    echo $echoStr;
	    exit;
	}
}

?>
