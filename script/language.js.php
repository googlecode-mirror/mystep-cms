<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/source/function/global.php");
include(ROOT_PATH."/source/function/web.php");
include(ROOT_PATH."/source/language/default.php");

$org_lng = $language;
unset($language);
include(ROOT_PATH."/source/language/".$setting['gen']['language'].".php");
$org_lng = array_merge($org_lng, $language);
unset($language);

if(checkCache('plugin')) {
	includeCache("plugin");
	$max_count = count($GLOBALS['plugin']);
	for($i=0; $i<$max_count; $i++) {
		$dir = ROOT_PATH."/plugin/".$plugin[$i]['idx']."/language";
		if(is_file($dir."/default.php")) {
			include($dir."/default.php");
			if(isset($language)) $org_lng = array_merge($org_lng, $language);
			unset($language);
		}
		if(is_file($dir."/".$setting['gen']['language'].".php")) {
			include($dir."/".$setting['gen']['language'].".php");
			if(isset($language)) $org_lng = array_merge($org_lng, $language);
			unset($language);
		}
	}
}

function gbk2utf8($data){
	if(is_array($data)){
		return array_map('gbk2utf8', $data);
	}
	return iconv('gbk', 'utf-8',$data);
}

echo "var language = ".json_encode(array_map("gbk2utf8", $org_lng)).";";
?>