<?php
/********************************************
*                                           *
* Name    : Functions 4 PHP                 *
* Author  : Windy2000                       *
* Time    : 2003-05-03                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*---------------------------------------String Functions Start-------------------------------------*/
function substrPro($Modi_Str, $start, $length, $mode = false){
	//Coded By Windy2000 20020603 v3.0
	/*
	if(function_exists("mb_substr") && $mode==false) {
		mb_internal_encoding("gb2312");
		return mb_substr($Modi_Str, $start, $length);
	}
	*/
	preg_match_all("/[\xa0-\xff]?./", $Modi_Str, $arr);
	$arr	= $arr[0];
	if($mode && $start>0) return implode("", array_slice($arr, $start, $length));
	if($start<0) $start += strlen($Modi_Str);
	if($length<0) $length += strlen($Modi_Str) - $start;
	$str = "";
	$sub_start = false;
	$max_count = count($arr);
	for($i=0; $i<$max_count; $i++) {
		if(strlen($str)>=$start && $sub_start==false) {
			$str = $arr[$i];
			$sub_start = true;
		} else {
			$str .= $arr[$i];
		}
		if($sub_start && strlen($str)>=$length) break;
	}
	return $str;
}

function cut_words($str) {
	//Coded By Windy2000 20030805 v1.0
	$str = str_replace("\r\n","\n",trim($str));
	$str = preg_replace("/\s+/"," ",$str);
	preg_match_all("/[\xa0-\xff]?./", $str, $arr);
	$arr	= $arr[0];
	$result	= array();
	$n = 0;
	$max_count = count($arr);
	for($i=0; $i<$max_count; $i++) {
		if(ord($arr[$i])>=0xa0) {
			$result[++$n] = $arr[$i];
		} elseif(preg_match("/[a-z0-9]/i", $arr[$i])) {
			$result[$n] .= $arr[$i];
		} else {
		$result[++$n] = $arr[$i];
			$result[++$n] = "";
		}
	}
	return $result;
}

function RndKey($lng, $scope=1){
	//Coded By Windy2000 20020501 v1.0
	$char_list	= array();
	$char_list[]	= "1234567890";
	$char_list[]	= "abcdefghijklmnopqrstuvwxyz";
	$char_list[]	= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$char_list[]	= "!@^()_:+\-";
	$Rnd_Key	= "";
	if($scope>0 && $scope<count($char_list)) {
		for($i=1; $i<=$lng; $i++){
			$Rnd_Str  = $char_list[mt_rand(1,$scope) - 1];
			$Rnd_Key .= substr($Rnd_Str, mt_rand(0,strlen($Rnd_Str)-1), 1);
		}
	} else {
		$args_num = func_num_args();
		for($i=1; $i<=$lng; $i++){
			if($args_num >= 3) {
				$Rnd_Key .= mt_rand(1, 10)>9 ? func_get_arg(mt_rand(3, $args_num)) : chr(mt_rand(0xb0,0xe0)).chr(mt_rand(0xa0,0xff));
			} else {
				$Rnd_Key .= chr(mt_rand(0xb0,0xe0)).chr(mt_rand(0xa0,0xff));
			}
		}
	}
	return($Rnd_Key);
}

function txt_watermark($code, $mode=true, $credit_str=" - Text Watermark By Windy2000", $url=""){
	//Coded By Windy2000 20041202 v2.0
	/*
	Please make sure that the following style exist on your style sheet of the watermark page
	.watermark {
		position:absolute;width:0px;height:1px;overflow:hidden;
	}
	*/
	$file_line = preg_split("/<br( +\/)?>/", $code);
	$max_count = count($file_line);
	for($i=0; $i<$max_count; $i++) {
		$this_str = "";
		if($mode && strlen($code)<50000) {
			preg_match_all("/(<(.+?)>)|(&([a-z]+);)/is", $file_line[$i], $arr_tag);
			$arr_tag = $arr_tag[0];
			$file_line[$i] = str_replace($arr_tag, chr(0), $file_line[$i]);
			preg_match_all("/[\x80-\xff]?./", $file_line[$i], $arr_char);
			$arr_char = $arr_char[0];
			$max_count2 = count($arr_char);
			for($j=0; $j<$max_count2; $j++) {
				if(ord($arr_char[$j])==0) {
					$this_str .= array_shift($arr_tag);
				} elseif(mt_rand(1, 10)>8) {
					$this_str .= "<span class=watermark>".RndKey(mt_rand(1, 2),0)."</span>".$arr_char[$j];
				} else {
					$this_str .= $arr_char[$j];
				}
			}
		} else {
			$this_str = $file_line[$i]."<span class=watermark>".RndKey(mt_rand(1, 10),0)." </span>";
		}
		$file_line[$i] = $this_str.((mt_rand(1, 10)>8 && !empty($url))?"<a href='{$url}' target='_blank'>(HIT)</a>":"<span class=watermark>{$credit_str}</span>");
	}
	return join("<br />\n", $file_line);
}

function add_slash(&$para) {
	//Coded By Windy2000 20030805 v1.0
	if(is_array($para)) {
		foreach($para as $key => $value) {
			if(is_string($value)) $para[$key] = addslashes($value);
		}
	} elseif(is_string($para)) {
		$para = addslashes($para);
	}
	return;
}

function strip_slash(&$para) {
	//Coded By Windy2000 20030805 v1.0
	if(is_array($para)) {
		foreach($para as $key => $value) {
			$para[$key] = stripslashes($value);
		}
	} else {
		$para = stripslashes($para);
	}
	return;
}

function HtmlTrans(&$para) {
	//Coded By Windy2000 20030805 v1.0
	$search  = array("'",		"\"",		"<",	">",	"  ",		"\t");
	$replace = array("&#39;",	"&quot;",	"&lt;",	"&gt;",	"&nbsp; ",	"&nbsp; &nbsp; ");
	if(is_array($para)) {
		foreach($para as $key => $value) {
			$para[$key] = str_replace($search, $replace, $value);
		}
	} else {
		$para = str_replace($search, $replace, $para);
	}
	return;
}

function modi_blank($str){
	//Coded By Windy2000 20020503 v1.0
	return preg_replace("/(\s)+/", "\\1", trim($str));
}

function txt2html($content) {
	//Coded By Windy2000 20020503 v1.0
	$content = str_replace("  ", "&nbsp; ", $content);
	$content = str_replace("\r\n", "<br />\n", $content);
	$content = str_replace("\r", "<br />\n", $content);
	$content = str_replace("\t", " &nbsp; &nbsp; &nbsp; &nbsp;", $content);
	return $content;
}

function str2any($var) {
	if($var=="true") {
		$var = true;
	} elseif($var="false") {
		$var = false;
	} elseif(is_numeric($var)) {
		$var = (INT)$var;
	} else {
		$var = (STRING)$var;
	}
	return $var;
}

function any2str($var) {
	if(is_bool($var)) {
		$var = $var?"true":"false";
	} elseif(is_numeric($var)) {
		$var = "{$var}";
	} elseif(is_array($var)) {
		$var = implode(",", $var);
	} else {
		$var = (STRING)$var;
	}
	return $var;
}

function html2js($str){
	//Coded By Windy2000 20080721 v1.0
	$result = "";
	$str = str_replace("\r", "", $str);
	$lines = explode("\n",$str);
	$max_count = count($lines);
	for($i=0; $i<$max_count; $i++) {
		$result .= "document.writeln(\"".addslashes($lines[$i])."\");\n";
	}
	return $result;
}

function chg_charset($content, $from="gbk", $to="utf-8") {
	$result = null;
	if(is_string($content)){
		$result = iconv($from, $to.'//TRANSLIT//IGNORE',$content);
	} elseif(is_array($content)) {
		foreach($content as $key => $value) {
			$result[$key] = chg_charset($value, $from, $to);
		}
	}
	return $result;
}

/*---------------------------------------String Functions End-------------------------------------*/


/*---------------------------------------Functions 4 File Start---------------------------------------*/
function remove_header($content) {
	//Coded By Windy_sk 20070420 v1.1
	$content = preg_replace("/^.+?\r\n\r\n/s", "", $content);
	return $content;
}

function GetRemoteContent($host, $page="", $header="", $port=80, $timeout=60) {
	//Coded By Windy_sk 20080320 v1.4
	$errno = "";
	$errmsg = "";
	$fp = fsockopen($host, $port, $errno, $errmsg, $timeout);
	if (!$fp) return false;

	$out = sprintf("GET /%s HTTP/1.1\r\n", $page);
	$out .= sprintf("Host: %s\r\n", $host);
	$out .= "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\n";
	$out .= "Referer: http://{$host}\r\n";
	$out .= "Connection: Keep-Alive\r\n";
	$out .= $header;
	$out .= "\r\n";

	fputs($fp, $out);
	$content = "";
	while (!feof($fp)) $content .= fgets($fp, 255);
	fclose($fp);

	return remove_header($content);
}

function GetRemoteFile($remote_file, $local_file) {
	//Coded By Windy_sk 20080402 v1.3
	MakeDir(dirname($local_file));
	$fp_r = fopen($remote_file, "rb");
	$fp_w = fopen($local_file, "wb");
	if($fp_w!==false) {
		if($fp_r===false) {
			$urlArray = parse_url($remote_file);
			$content = GetRemoteContent($urlArray['host'],$urlArray['path']);
			$fp_r = !empty($content) && (strpos($content, "404 Not Found")===false);
			if($fp_r) fwrite($fp_w, $content);
		} else {
			while(!feof($fp_r)) {
				fwrite($fp_w, fgets($fp_r, 4096));
			}
			fclose($fp_r);
		}
		fclose($fp_w);
	}
	return $fp_r && $fp_w;
}

function GetFile($file, $length=0, $offset=0) {
	//Coded By Windy2000 20020503 v1.5
	if(!is_file($file)) return "";
	if($length==0) return file_get_contents($file);
	$fp = fopen($file, "rb");
	fseek($fp, $offset);
	$data = fgets($fp, $length);
	fclose($fp);
	return $data;
}

function GetFileExt($file) {
	return strtolower(pathinfo($file, PATHINFO_EXTENSION));
	//return strtolower(str_replace(".", "", strrchr($file, ".")));
}

function WriteFile($file_name, $content, $mode="ab") {
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
		chmod($file_name, 0777);
	}
	return $fp;
}

function MakeDir($dir) {
	//Coded By Windy2000 20031001 v1.0
	$dir = str_replace("\\", "/", $dir);
	$dir = preg_replace("/\/+/", "/", $dir);
	$flag = true;
	if(!is_dir($dir)) {
		$dir_list = split("/", $dir);
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

function MultiDel($dir){
	//Coded By Windy2000 20031001 v1.0
	if(empty($dir)) return;
	if(is_dir($dir)){
		$mydir = opendir($dir);
		while(($file = readdir($mydir)) !== false) {
			if($file!="." && $file!="..") {
				$the_name = $dir."/".$file;
				is_dir($the_name) ? MultiDel($the_name) : unlink($the_name);
			}
		}
		closedir($mydir);
		rmdir($dir);
	}else{
		unlink($dir);
	}
	return;
}

function iswriteable($file){
	if(is_dir($file)){
		$dir = $file;
		$writeable = false;
		$tmpFile = tempnam($dir, "tmp");
		if($fp = @fopen($tmpFile, 'w')){
		 @fclose($fp);
		 @unlink($tmpFile);
		 $writeable = true;
		}
	} else {
		$writeable = is_writable($file);
	}
	return $writeable;
}
/*---------------------------------------Functions 4 File End---------------------------------------*/


/*---------------------------------------Functions 4 Picture Start----------------------------------*/
function img_watermark($img_src, $watermark, $img_dst="", $position=1, $para=array()) {
	if(!class_exists("imageCreator_file")) {
		if(!empty($img_dst)) copy($img_src, $img_dst);
		header("location: {$img_src}");
		return;
	}
	if(file_exists($img_dst)) {
		header("location: {$img_dst}");
		exit();
	} else {
		MakeDir(dirname($img_dst));
	}
	$img = new imageCreator_file;
	$img->init($img_src);
	if(!$img->img) {
		header("location: {$img_src}");
		return false;
	}
	if($img->width<100 || $img->height<100) {
		header("location: {$img_src}");
		return false;
	}
	$dst_type = "jpg";
	if(!empty($img_dst)) $dst_type = GetFileExt($img_dst);

	if(file_exists($watermark)) {
		if($img->width>1024) {
			$new_watermark = dirname($watermark)."/4_".basename($watermark);
		} elseif($img->width>600) {
			$new_watermark = dirname($watermark)."/3_".basename($watermark);
		} elseif($img->width>400) {
			$new_watermark = dirname($watermark)."/2_".basename($watermark);
		} elseif($img->width>200) {
			$new_watermark = dirname($watermark)."/1_".basename($watermark);
		} else {
			$new_watermark = $watermark;
		}
		if(!file_exists($new_watermark)) $new_watermark = $watermark;
		$img_wm = new imageCreator_file($new_watermark);
		list($wm_width, $wm_height) = $img_wm->getSize();
		
		list($alpha, $rate) = $para;
		if(is_null($alpha)) $alpha = 60;
		if(is_null($rate)) $rate = 10;
		if($new_watermark==$watermark) {
			if($rate!=1) {
				$wm_rate = max($img->width/$rate/$wm_width, $img->height/$rate/$wm_height);
				$wm_width *= $wm_rate;
				$wm_height *= $wm_rate;
				$img_wm->resizeImage($wm_rate);
				$img_wm->setTransparent(array(0,0));
			}
		}
		
		switch($position) {
			case 1:
				$pos = array($img->width - $wm_width, $img->height - $wm_height);
				break;
			case 2:
				$pos = array($img->width - $wm_width, 0);
				break;
			case 3:
				$pos = array(0, $img->height - $wm_height);
				break;
			case 4:
				$pos = array(0, 0);
				break;
			default:
				$pos = array(($img->width - $wm_width)/2, ($img->height - $wm_height)/2);
				brak;
		}
		$img->pasteImage($img_wm->img, $pos, $alpha);
		$img->makeImage($dst_type, $img_dst);
		$img_wm->destroyImage();
		$img->destroyImage();
	} else {
		list($font, $fontsize, $fontcolor, $bgcolor) = $para;
		if(is_null($font)) $font = realpath("./simsun.ttc");
		if(is_null($fontsize)) $fontsize = ($position<=2 ? $img->width/80 : $img->height/80);
		if($fontsize<9) $fontsize = 9;
		if(is_null($fontcolor)) $fontcolor = "white";
		if(is_null($bgcolor)) $bgcolor = array(0x00,0x00,0x00);

		if($img->setFont($font)) {
			$font_size = $img->getFontSize($watermark, $fontsize);
			$font_size[0] += 10;
			$font_size[1] += 10;
			$img_txt = new imageCreator;
			$img_txt->init($font_size[0], $font_size[1]);
			$img_txt->createImage(true, $bgcolor);
			$img_txt->drawString($img_txt->transString($watermark), array(5,$font_size[1]-5), $fontcolor, $font, $fontsize);

			if($position==3) {
				$img_txt->img = $img_txt->rotateImage(90, $img_txt->img);
			} elseif($position==4) {
				$img_txt->img = $img_txt->rotateImage(270, $img_txt->img);
			}

			switch($position) {
				case 1:
				case 2:
					$width = $img->width;
					$height = $img->height + $font_size[1];
					break;
				case 3:
				case 4:
					$width = $img->width + $font_size[1];
					$height = $img->height;
					break;
				default:
					$width = $img->width;
					$height = $img->height;
					brak;
			}
			$img_out = new imageCreator;
			$img_out->init($width, $height);
			$img_out->createImage(true, $bgcolor);

			switch($position) {
				case 1:
					$img_out->pasteImage($img->img, array(0, 0));
					$img_out->pasteImage($img_txt->img, array($img->width - $img_txt->width, $img->height));
					break;
				case 2:
					$img_out->pasteImage($img->img, array(0, $font_size[1]));
					$img_out->pasteImage($img_txt->img, array(0, 0));
					break;
				case 3:
					$img_out->pasteImage($img->img, array(0, 0));
					$img_out->pasteImage($img_txt->img, array($img->width, 0));
					break;
				case 4:
					$img_out->pasteImage($img->img, array($font_size[1], 0));
					$img_out->pasteImage($img_txt->img, array(0, 0));
					break;
				default:
					$img_out->pasteImage($img->img, array(0, 0));
					$img_out->pasteImage($img_txt->img, array($img->width - $img_txt->width, $img->height));
					brak;
			}
			$img_out->makeImage($dst_type, $img_dst);
			$img->destroyImage();
			$img_txt->destroyImage();
			$img_out->destroyImage();
		} else {
			$img->drawString($watermark, array(0,0), $fontcolor, $font, $fontsize);
			$img->makeImage($dst_type, $img_dst);
			$img->destroyImage();
		}
	}
	if(file_exists($img_dst)) {
		header("location: {$img_dst}");
		exit();
	}
	return;
}

function img_thumb($img_src, $dstW, $dstH, $img_dst="") {
	if(!class_exists("imageCreator_file")) {
		if(!empty($img_dst)) copy($img_src, $img_dst);
		header("location: {$img_src}");
		return;
	}
	$img = new imageCreator_file;
	$img->init($img_src);
	if(!$img->img) return false;

	$dst_type = "jpg";
	if(!empty($img_dst)) {
		$dst_type = GetFileExt($img_dst);
	} else {
		MakeDir(dirname($img_dst));
	}

	$srcW = $img->width;
	$srcH = $img->height;
	$rate = min($dstW/$srcW, $dstH/$srcH);
	$img->resizeImage($rate);

	$img_out = new imageCreator;
	$img_out->init($dstW, $dstH);
	$img_out->createImage(true, array(0xff,0xff,0xff));
	$img_out->setTransparent("white");
	$img_out->pasteImage($img->img, array(($dstW-$srcW*$rate)/2, ($dstH-$srcH*$rate)/2));

	$img_out->makeImage($dst_type, $img_dst);
	$img->destroyImage();
	$img_out->destroyImage();
	return;
}

function vertify_img($str, $font = "simsun.ttc", $fontsize = 16) {
	if(!class_exists("imageCreator")) return;
	$img = new imageCreator();
	$img->setFont($font);
	list($img->width, $img->height) = $img->getFontSize($str, $fontsize);
	$img->width += $fontsize*2;
	$img->height += $fontsize;
	$img->createImage(true, array(255,255,255));
	$img->setColor("vertify", rand(220, 255), rand(220, 255), rand(220, 255));
	$img->setLine(1);
	$img->drawRectangle(array(0,0), $img->width-2, $img->height-2, "black", "vertify");
	preg_match_all("/[\xa0-\xff]?./", $str, $char_lst);
	$char_lst = $char_lst[0];
	$top = 0;
	$left = 0;
	$max_count = count($char_lst);
	for($i=0; $i<$max_count; $i++) {
		$char = $char_lst[$i];
		if($char=="\r") {
			$top += $fontsize+$fontsize/2;
			$left = 0;
			continue;
		}
 		$randsize = ceil(rand($fontsize-$fontsize/6,$fontsize+$fontsize/6));
 		$randAngle = rand(-15,15);
 		$x = $fontsize/3 + rand($left-$fontsize/6, $left+$fontsize/6);
 		$y = $fontsize + rand(0, $fontsize/2);
 		$img->drawString($img->transString($char), array($x, $top + $y), "black", $font, $randsize, $randAngle);
		$left += $fontsize * strlen($char) - $fontsize/6;
	}
	$img->addNoise(max($img->width, $img->height)*2);
	$img->makeImage("jpg");
	return;
}

/*--------------------------------Functions 4 Picture End---------------------------------------*/

/*---------------------------------------Misc Functions Start-------------------------------------*/
function GetIp() {
	//Modified By Windy2000 20020601
	if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} elseif(isset($_SERVER["HTTP_CLIENT_IP"])) {
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	} else {
		$ip = $_SERVER["REMOTE_ADDR"];
	}
	return $ip;
}

function GetMicrotime($rate = 3) {
	//Modified By Windy2000 20020601
	if(function_exists("microtime")) {
		list($usec, $sec) = explode(" ",microtime());
		$time = (string)$sec.substr($usec,2,$rate);
		return $time;
	} else {
		return $_SERVER['REQUEST_TIME'];
	}
}

function GetTimeDiff($time_start, $decimal = 3, $micro = true) {
	//Coded By Windy2000 20020503 v1.0
	$time_end = GetMicrotime();
	$time = ($time_end - $time_start);
	if($micro) $time *= 1000;
	$time = preg_replace("/^([\d]+.[\d]{".$decimal."})[\d]*$/","\\1",(string)$time);
	return $time;
}

function debug() {
	//Coded By Windy2000 20040410 v1.5
	echo "<pre>";
	for($i = 0; $i < func_num_args(); $i++) {
		var_dump(func_get_arg($i));
	}
	echo "</pre>";
	exit;
}
/*---------------------------------------Misc Functions Endt------------------------------------------*/
?>