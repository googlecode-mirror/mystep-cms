<?php
require(dirname(__FILE__)."/class.php");

$cur_path = str_replace(ROOT_PATH, "", str_replace("\\", "/", dirname(__FILE__)));
$js_new = array();
$mystep->removeJS("script/jquery.js");
if($plugin_setting['bootstrap']['cms_jquery']) {
	$js_new[] = "script/jquery.js";
} else {
	$js_new[] = $cur_path."/js/jquery.js";
}
unset($plugin_setting['bootstrap']['cms_jquery']);
if($plugin_setting['bootstrap']['cms_jquery_addon']===false) {
	$mystep->removeJS("script/jquery.addon.js");
}
unset($plugin_setting['bootstrap']['cms_jquery_addon']);
$js_new[] = $cur_path."/js/bootstrap-transition.js";
foreach($plugin_setting['bootstrap'] as $key => $value) {
	if($value) {
		$js_new[] = $cur_path."/js/bootstrap-".$key.".js";
	}
}
$js_org = $mystep->getJS();
$js_new = array_merge($js_new, $js_org);
$mystep->clearJS();
foreach($js_new as $value) {
	$mystep->addJS(str_replace(ROOT_PATH, "", $value));
}

$css_new = array();
$mystep->removeCSS("images/style.css");
$css_new[] = $cur_path."/css/bootstrap.css";
$css_new[] = $cur_path."/css/bootstrap-responsive.css";
$css_org = $mystep->getCSS();
$css_new = array_merge($css_new, $css_org);
$mystep->clearCSS();
foreach($css_new as $value) {
	$mystep->addCSS(str_replace(ROOT_PATH, "", $value));
}
$css= $mystep->getCSS();
?>