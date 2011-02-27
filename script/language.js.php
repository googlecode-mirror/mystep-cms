<?php
include("../include/config.php");
include("../source/language/default.php");
$org_lng = $language;
include("../source/language/".$setting['gen']['language'].".php");
$org_lng = array_merge($org_lng, $language);

function gbk2utf8($data){
	if(is_array($data)){
		return array_map('gbk2utf8', $data);
	}
	return iconv('gbk', 'utf-8',$data);
}

echo "var language = ".json_encode(array_map("gbk2utf8", $org_lng)).";";
?>