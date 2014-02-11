<?php
define('ROOT_PATH', str_replace("\\", "/", realpath(dirname(__file__)."/../../")));
require(ROOT_PATH."/include/config.php");
require(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/etag.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/function/web.php");
require(ROOT_PATH."/source/function/admin.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/mystep.class.php");

$mystep = new MyStep();
$mystep->getLanguage(dirname(ROOT_PATH.$_SERVER['PHP_SELF'])."/language/");
$mystep->pageStart(true);
$db->Reconnect(true, $setting['db']['name']);

$method = $req->getGet("method");
if(empty($method)) $method = "list";

$mid = $req->getReq("mid");
$id = $req->getReq("id");
$field = $req->getReq("f");
if(empty($field) || empty($id)) {
	header("HTTP/1.0 404 Not Found");
	$db->close();
	unset($db, $req);
	exit();
}
if($data = $db->result($setting['db']['pre']."custom_form_".$mid,$field,array("id","n=",$id))) {
	$data = explode("::", $data);
	$the_file = dirname(__FILE__)."/setting/".$mid."/".$data[2];
	if(file_exists($the_file)) {
		header("Content-type: ".$data[1]);
		header("Accept-Ranges: bytes");
		header("Accept-Length: ".filesize($the_file));
		header("Content-Disposition: attachment; filename=".$data[0]);
		readfile($the_file);
		exit();
	}
}
$goto_url = "noPhoto.jpg";
$mystep->pageEnd(false);
?>