<?php
include_once(dirname(__FILE__)."/../../include/config.php");
include_once(dirname(__FILE__)."/default.php");
include_once(dirname(__FILE__)."/".$setting['gen']['language'].".php");

function gbk2utf8($data){
	if(is_array($data)){
		return array_map('gbk2utf8', $data);
	}
	return iconv('gbk','utf-8',$data);
}

echo "var lang = ".json_encode(array_map("gbk2utf8", $language)).";";

?>