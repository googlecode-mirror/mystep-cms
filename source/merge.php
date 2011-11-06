<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
$etag_expires = 604800;
require(ROOT_PATH."/include/config.php");
require(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/etag.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/function/web.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/mystep.class.php");
require(ROOT_PATH."/source/class/minify.class.php");
$mystep = new MyStep();
$mystep->pageStart(true);
$type = $req->GetServer("QUERY_STRING");
$result = "";
$cache = ROOT_PATH."/".$setting['path']['cache']."script/".$setting['info']['web']['idx']."_cache.".$type;
$header = array(
    'js' => 'Content-Type: application/x-javascript',
    'css' => 'Content-Type: text/css',
    'jpg' => 'Content-Type: image/jpg',
    'gif' => 'Content-Type: image/gif',
    'png' => 'Content-Type: image/png',
    'jpeg' => 'Content-Type: image/jpeg',
    'swf' => 'Content-Type: application/x-shockwave-flash'
);
if(isset($header[$type])) header($header[$type]);
if(file_exists($cache) && (filemtime($cache)+$etag_expires)<($setting['info']['time_start']/1000)) {
	$result = GetFile($cache);
} else {
	switch($type) {
		case "css":
			$css = $mystep->getCSS();
			for($i=0,$m=count($css);$i<$m;$i++) {
				$result .= CSSMin::minify(GetFile($css[$i]));
			}
			break;
		case "js":
			$js = $mystep->getJS();
			for($i=0,$m=count($js);$i<$m;$i++) {
				$result .= JSMin::minify(GetFile($js[$i]));
			}
			break;
		default:
			break;
	}
	if(!empty($result)) WriteFile($cache, $result, "wb");
}
header("Accept-Ranges: bytes");
header("Accept-Length: ".strlen($result));
echo $result;
$mystep->pageEnd(false);
?>