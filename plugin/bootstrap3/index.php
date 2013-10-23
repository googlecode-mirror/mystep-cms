<?php
require(dirname(__FILE__)."/class.php");

$cur_path = str_replace(ROOT_PATH, "", str_replace("\\", "/", dirname(__FILE__)));
$js_new = array();
if($plugin_setting['bootstrap3']['cms_jquery']===false) {
	$mystep->removeJS("script/jquery.js");
	$js_new[] = $cur_path."/js/jquery.js";
}
if($plugin_setting['bootstrap3']['cms_jquery_addon']===false) {
	$mystep->removeJS("script/jquery.addon.js");
}
$js_org = $mystep->getJS();
$js_new = array_merge($js_new, $js_org);
$mystep->clearJS();
foreach($js_new as $value) {
	$mystep->addJS(str_replace(ROOT_PATH, "", $value));
}

$css_new = array();
if($plugin_setting['bootstrap3']['cms_css']===false) {
	$mystep->removeCSS("images/style.css");
}
$css_new[] = $cur_path."/css/bootstrap.css";
$css_new[] = $cur_path."/css/bootstrap_hack.css";
$css_org = $mystep->getCSS();
$css_new = array_merge($css_new, $css_org);
$mystep->clearCSS();
foreach($css_new as $value) {
	$mystep->addCSS(str_replace(ROOT_PATH, "", $value));
}

$mystep->setAddedContent("start", '
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"
	<!--[if lt IE 9]>
		<script src="'.$cur_path.'/js/html5shiv.js"></script>
		<script src="'.$cur_path.'/js/respond.min.js"></script>
	<![endif]-->
');
?>