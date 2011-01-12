<?php
$id = $_SERVER['QUERY_STRING'];
$show_thumb = (strpos($id, "_")===false);
$id = trim($id, "_");
if(!is_numeric($id) || empty($id)) header("HTTP/1.0 404 Not Found");

$root_path = "../";
require("{$root_path}/include/config.php");
require("{$root_path}/module/functions.inc.php");
require("{$root_path}/module/abstract.class.php");
require("{$root_path}/module/mysql.class.php");
require("{$root_path}/module/request.class.php");

error_reporting(E_ALL ^ E_NOTICE);
set_magic_quotes_runtime(0);
set_time_limit(30);
date_default_timezone_set("PRC");
set_error_handler("ErrorHandler");
set_magic_quotes_runtime(0);
ini_set('memory_limit', '32M');

$db = new MySQL($db_host, $db_user, $db_pass,"Latin1");
$db->Connect($db_pconnect);
$db->SelectDB($db_name);

$req = new reqObj("/", $cookie_domain, $charset);
$id = preg_replace("/[^\d]/", "", $id);
if($record=$db->GetSingleRecord("select * from attachment where id = '{$id}'")) {
	$the_ext = strtolower(strrchr($record['file_name'],"."));
	$the_path = date("Y/m/d", substr($record['file_time'],0, 10));
	$the_file = $record['file_time'];
	if($show_thumb && strpos($record['file_type'], "gif")===false && file_exists($the_path."/preview/".$the_file.$the_ext)) {
		$the_file = $the_path."/preview/".$the_file;
	} else {
		$the_file = $the_path."/".$the_file;
	}
	if(file_exists($the_file.$the_ext)) {
		$the_file .= $the_ext;
	} elseif(file_exists($the_file.strtoupper($the_ext))) {
		$the_file .= strtoupper($the_ext);
	} else {
		header("HTTP/1.0 404 Not Found");
		$db->close();
		exit();
	}
	$db->Query("update attachment set file_count = file_count + 1 where id = '{$id}'");
	$db->close();
	header("Content-type: ".$record['file_type']);
	header("Accept-Ranges: bytes");
	header("Accept-Length: ".$record['file_size']);
	if(strpos($record['file_type'],"image")===0 && ($watermark_use & 2) && $record['watermark']==1) {
		require("{$root_path}/module/image.class.php");
		img_watermark($the_file, "{$root_path}/{$watermark_pic}", "{$root_path}/{$path_cache}/{$the_file}");
	} else {
		header("Content-Disposition: attachment; filename=".$record['file_name']);
		readfile($the_file);
	}
} else {
	$db->close();
	header("HTTP/1.0 404 Not Found");
}
?>