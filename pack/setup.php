<?php

function WriteFile($file_name, $content, $mode="wb") {
	//Coded By Windy2000 20040410 v1.0
	MakeDir(dirname($file_name));
	if($fp = fopen($file_name, $mode)) {
		if(flock($fp, LOCK_EX)) {
			fwrite($fp, $content);
			flock($fp, LOCK_UN);
		} else {
			fwrite($fp, $content);
		}
		fclose($fp);
		@chmod($file_name, 0777);
	}
	return $fp;
}
function MakeDir($dir) {
	//Coded By Windy2000 20031001 v1.0
	$dir = str_replace("\\", "/", $dir);
	$dir = preg_replace("/\/+/", "/", $dir);
	$flag = true;
	if(!is_dir($dir)) {
		$dir_list = explode("/", $dir);
		if($dir_list[0]=="") $dir_list[0]="/";
		$this_dir = "";
		$oldumask=umask(0);
		$max_count = count($dir_list);
		for($i=0; $i<$max_count; $i++) {
			if(empty($dir_list[$i])) continue;
			$this_dir .= $dir_list[$i]."/";
			if(!is_dir($this_dir)) {
				if(!mkdir($this_dir,0777)) {
					$flag = false;
				}
			}
		}
		umask($oldumask);
	}
	return $flag;
}
function GetFile($file, $length=0, $offset=0) {
	//Coded By Windy2000 20020503 v1.5
	if(!is_file($file)) return "";
	if($length==0 && $offset==0) {
		$data = file_get_contents($file);
	} else {
		if($length==0) $length = 8192;
		$fp = fopen($file, "rb");
		fseek($fp, $offset);
		$data = fread($fp, $length);
		fclose($fp);
	}
	if(get_magic_quotes_runtime()) $data = stripcslashes($data);
	return $data;
}
function GetFileSize($para) {
	if(is_file($para)) {
		$filesize = filesize($para);
	} elseif(is_numeric($para)) {
		$filesize = $para;
	} else {
		$para = strtoupper($para);
		$para = str_replace(" ","",$para);
		switch(substr($para,-1)) {
			case "G":
				$filesize = ((int)str_replace("G","",$para)) * 1024 * 1024 * 1024;
				break;
			case "M":
				$filesize = ((int)str_replace("M","",$para)) * 1024 * 1024;		
				break;
			case "K":
				$filesize = ((int)str_replace("K","",$para)) * 1024;
				break;
			default:
				$filesize = 0;
				break;
		}
		return $filesize;
	}
	if($filesize <1024) {
		$filesize = (string)$filesize . " Bytes";
	}else if($filesize <(1024 * 1024)) {
		$filesize = number_format((double)($filesize / 1024), 1) . " KB";
	}else if($filesize <(1024 * 1024 * 1024)) {
		$filesize = number_format((double)($filesize / (1024 * 1024)), 1) . " MB";
	}else{
		$filesize = number_format((double)($filesize / (1024 * 1024 * 1024)), 1) . " GB";
	}
	return $filesize;
}

$tmp_file = tempnam("./", "mystep");
if($fp = fopen($tmp_file, "w")) {
	fclose($fp);
	unlink($tmp_file);
} else {
	die("Current directory cannot be writen!");
}
set_time_limit(0);
ini_set('memory_limit', '512M');
ini_set('magic_quotes_runtime', 0);
$pack_file = "mystep.pack";
$unpack_dir = "./";
$mypack = new MyPack($unpack_dir, $pack_file);
$mypack->DoIt("unpack");
echo $mypack->GetResult();
unset($mypack);
mkdir("./template/cache");
@unlink($pack_file);
@unlink(__FILE__);
?>
<script language="JavaScript">
location.href = "<?=$unpack_dir?>";
</script>