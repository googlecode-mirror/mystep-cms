<?php
$id = $_SERVER['QUERY_STRING'];
$show_thumb = (strpos($id, "_")===false);
$id = trim($id, "_");
if(!is_numeric($id) || empty($id)) {
	header("HTTP/1.0 404 Not Found");
	exit();
}

define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
if($setting['web']['close'] && !isset($_COOKIE['force'])) {
	header("HTTP/1.0 404 Not Found");
	exit();
}
include(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/etag.php");
include(ROOT_PATH."/source/function/global.php");
include(ROOT_PATH."/source/function/web.php");
include(ROOT_PATH."/source/class/abstract.class.php");
include(ROOT_PATH."/source/class/mystep.class.php");

$mystep = new MyStep();
$db = $mystep->getInstance("MySQL", $setting['db']['host'], $setting['db']['user'], $setting['db']['pass'], $setting['db']['charset']);
$cache = $mystep->getInstance("MyCache", $setting['web']['cache_mode']);

if($record=getData("select * from ".$setting['db']['pre']."attachment where id = ".$id, "record", 1800)) {
	$the_ext = ".".GetFileExt($record['file_name']);
	$the_path = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d", substr($record['file_time'],0, 10));
	$the_file = $record['file_time'].substr(md5($record['file_size']),0,5);
	if($show_thumb && file_exists($the_path."/preview/".$the_file.$the_ext)) {
		$the_file = $the_path."/preview/".$the_file;
	} else {
		$the_file = $the_path."/".$the_file;
	}
	if(file_exists($the_file.$the_ext)) {
		$the_file .= $the_ext;
	} elseif(file_exists(substr($the_file,0,-5).$the_ext)) {
		$the_file = substr($the_file,0,-5).$the_ext;
	} else {
		header("HTTP/1.0 404 Not Found");
		$db->close();
		unset($db);
		exit();
	}
	$db->Query("update ".$setting['db']['pre']."attachment set file_count = file_count + 1 where id = ".$id);
	$db->close();
	header("Content-type: ".$record['file_type']);
	header("Accept-Ranges: bytes");
	header("Accept-Length: ".$record['file_size']);
	header("Content-Disposition: attachment; filename=".getSafeCode($record['file_name'], "utf-8"));
	if(strpos($record['file_type'],"image")===0 && ($setting['watermark']['mode'] & 2)==2 && $record['watermark']==1) {
		img_watermark($the_file, ROOT_PATH."/".$setting['watermark']['img'], dirname($the_file)."/cache/".basename($the_file), 3, array('rate'=>4, 'alpha'=>50));
	} else {
		readfile($the_file);
	}
} else {
	$db->close();
	header("HTTP/1.0 404 Not Found");
}
unset($db);
?>