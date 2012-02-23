<?php
if(!isset($etag_expires)) $etag_expires = 604800;
if(!isset($setting)) include("../../include/config.php");
if(!isset($ms_version)) include("../../include/parameter.php");
header("Pragma: public");
header("Cache-Control: private, max-age=".$etag_expires);
header("Last-Modified: ".gmdate('D, d M Y H:i:s')." GMT");
header("Expires: ".gmdate('D, d M Y H:i:s', time()+$etag_expires)." GMT");
$etag = md5($_SERVER["REQUEST_URI"].implode(",", $ms_version).$setting['gen']['etag']);
if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $etag) {
	header('Etag:'.$etag, true, 304);
	exit();
} else {
	header('Etag:'.$etag);
}
?>