<?php
$id = $_SERVER['QUERY_STRING'];
$show_thumb = (strpos($id, "_")===false);
$id = trim($id, "_");
if(!is_numeric($id) || empty($id)) {
	header("HTTP/1.0 404 Not Found");
	exit();
}

define('ROOT_PATH', str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
if($setting['web']['close'] && !isset($_COOKIE['force'])) {
	header("HTTP/1.0 404 Not Found");
	exit();
}
include(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/global.php");
include(ROOT_PATH."/source/function/web.php");
include(ROOT_PATH."/source/class/abstract.class.php");
include(ROOT_PATH."/source/class/mystep.class.php");

$mystep = new MyStep();
$mystep->pageStart(false);
ob_end_clean();
set_time_limit(1200);

if($record=getData("select a.*, b.view_lvl from ".$setting['db']['pre']."attachment a left join ".$setting['db']['pre']."news_show b on a.web_id=b.web_id and a.news_id=b.news_id where id = ".$id, "record", 1800)) {
	if($record['view_lvl']>$setting['info']['user']['type']['view_lvl']) {
		$db->close();
		header("location: ".getUrl("read", $record['news_id'], 1, $record['web_id']));
		exit();
	}
	if(strpos($record['file_type'],"image")===0) include(ROOT_PATH."/source/function/etag.php");
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
	
	if(isset($_SERVER['HTTP_RANGE'])) {
		preg_match("/^bytes=(\d*)-(\d*)$/i", $_SERVER['HTTP_RANGE'], $match);
		$pos_start = $match[1];
		$pos_end = $match[2];
		$pos_current = $pos_start;
		$block_size = 4096;
		$buffer = "";
		if(empty($pos_end) || $pos_end>$record['file_size']-1) $pos_end = $record['file_size']-1;
		if(empty($pos_start)) $pos_start = $record['file_size']-1-$pos_end;
	}
	
	if($pos_start>0 && $pos_start<$record['file_size'] && $pos_start<$pos_end) {
		header("HTTP /1.1 206 Partial Content");
		header("Cache-control: public");
		header("Pragma: public");
		Header("Content-Length: ".($pos_end-$pos_start+1));
		header('Content-Range: bytes '.$pos_start.'-'.$pos_end.'/'.$record['file_size']);
		header("Content-type: ".$record['file_type']);
		header("Content-Disposition: attachment; filename=".getSafeCode($record['file_name'], "utf-8"));
		$fp = fopen($the_file,'rb');
		fseek($fp, $pos_start);
		while(!feof($fp)) {
			$buffer = stream_get_contents($fp, $block_size);
			$pos_current += $block_size;
			if($pos_current>=$pos_end) {
				echo substr($buffer, 0, $block_size-($pos_current-$pos_end));
				break;
			} else {
				echo $buffer;
			}
		}
		fclose($fp);
	} else {
		header("HTTP/1.1 200 OK");
		header("Content-type: ".$record['file_type']);
		header("Accept-Ranges: bytes");
		header("Accept-Length: ".$record['file_size']);
		header("Content-Disposition: attachment; filename=".getSafeCode($record['file_name'], "utf-8"));
		if(strpos($record['file_type'],"image")===0 && ($setting['watermark']['mode'] & 2)==2 && $record['watermark']==1) {
			img_watermark($the_file, ROOT_PATH."/".$setting['watermark']['img'], dirname($the_file)."/cache/".basename($the_file), $setting['watermark']['position'], array(
				'rate'=>$setting['watermark']['img_rate'],
				'alpha'=>$setting['watermark']['alpha'],
				'font'=>ROOT_PATH."/".$setting['watermark']['txt_font'],
				'fontsize'=>$setting['watermark']['txt_fontsize'],
				'fontcolor'=>$setting['watermark']['txt_fontcolor'],
				'bgcolor'=>$setting['watermark']['txt_bgcolor'],
			));
		} else {
			readfile($the_file);
		}
	}
} else {
	$db->close();
	header("HTTP/1.0 404 Not Found");
}
unset($db);
?>