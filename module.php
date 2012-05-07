<?php
require("inc.php");
$module = $req->getGet("m");
if($setting['gen']['cache']) {
	$cache_info = array(
			'idx' => md5($_SERVER["QUERY_STRING"]),
			'path' => $cache_path."/".$module."/",
			'expire' => getCacheExpire(),
			);
} else {
	$cache_info = false;
}
$setting['gen']['show_info'] = false;
$mystep->module($module);
$mystep->pageEnd($setting['gen']['show_info']);
?>