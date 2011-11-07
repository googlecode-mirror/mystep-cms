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
			preg_match_all("/(<(.+?)>)|(&([#\w]+);)/is", $file_line[$i], $arr_tag);
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
		$file_line[$i] = $this_str.((mt_rand(1, 10)>8 && !empty($url))?"<a href='{$url}' target='_blank' style='color:transparent;'>(HIT)</a>":"<span class=watermark>{$credit_str}</span>");
	}
	return join("<br />\n", $file_line);
}

function add_slash(&$para) {
	//Coded By Windy2000 20030805 v1.0
	if(is_array($para)) {
		foreach($para as $key => $value) {
			if(is_array($value)) {
				add_slash($value);
			} else {
				if(is_string($value)) $para[$key] = addslashes($value);
			}
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
			if(is_array($value)) {
				strip_slash($value);
			} else {
				if(is_string($value)) $para[$key] = stripslashes($value);
			}
		}
	} else {
		if(is_string($value)) $para = stripslashes($para);
	}
	return;
}

function arrayMerge($arr_1, $arr_2) {
	if(!is_array($arr_1)) return false;
	if(!is_array($arr_2)) {
		$arr_1[] = $arr_2;
	} else {
		foreach($arr_1 as $key => $value) {
			if(isset($arr_2[$key])) {
				if(is_array($arr_2[$key])) {
					$arr_1[$key] = arrayMerge($arr_1[$key], $arr_2[$key]);
				} else {
					$arr_1[$key] = $arr_2[$key];
				}
			}
		}
		foreach($arr_2 as $key => $value) {
			if(!isset($arr_1[$key])) {
				if(is_array($arr_1[$key])) {
					$arr_1[$key] = arrayMerge($arr_1[$key], $arr_2[$key]);
				} else {
					$arr_1[$key] = $arr_2[$key];
				}
			}
		}
	}
	return $arr_1;
}

function HtmlTrans(&$para) {
	//Coded By Windy2000 20030805 v1.0
	$search = array("'", "\"", "<", ">", "  ", "\t");
	$replace = array("&#39;", "&quot;", "&lt;", "&gt;", "&nbsp; ", "&nbsp; &nbsp; ");
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

function getSafeCode($value, $charset) { 
	$value_1 = $value; 
	$value_2 = chg_charset($value_1, "utf-8", $charset); 
	$value_3 = chg_charset($value_2, $charset, "utf-8"); 
	if(strlen($value_1) == strlen($value_3)) { 
		return $value_2; 
	} else { 
		return $value_1; 
	} 
}

function chg_charset($content, $from="gbk", $to="utf-8") {
	$result = null;
	if(is_string($content)){
		$result = iconv($from, $to.'//TRANSLIT//IGNORE', $content);
		if($result===false && function_exists("mb_detect_encoding")) {
			$encode = mb_detect_encoding($content, array("ASCII","GB2312","GBK","BIG5","UTF-8","EUC-CN","ISO-8859-1"));
			$content = str_replace(chr(0x0A), chr(0x20), $content); 
			if($encode!="" && strtolower($encode)!=strtolower($to)) {
				$result = mb_convert_encoding($content, $to, $encode);
			} else {
				$result = $content;
			}
		}
	} elseif(is_array($content)) {
		foreach($content as $key => $value) {
			$result[$key] = chg_charset($value, $from, $to);
		}
	} else {
		$result = $content;
	}
	return $result;
}

function chg_charset_file($file_src, $file_dst, $from="gbk", $to="utf-8") {
	if(!is_file($file_src) || $from==$to) return;
	$content = file_get_contents($file_src);
	$content = iconv($from, $to.'//TRANSLIT//IGNORE',$content);
	return WriteFile($file_dst, $content, "wb");
}

function json_decode_js($json, $assoc = FALSE){
	$json = str_replace(array("\n","\r"),"",$json);
	$json = preg_replace('/([{,])(\s*)([^"]+?)\s*:/','$1"$3":',$json);
	return json_decode($json, $assoc);
}

function toJson($var, $charset="") {
	if(!empty($charset)) $var = chg_charset($var, $charset, "utf-8");
	return json_encode($var);
}

function toXML($var) {
	$result = "";
	if(is_array($var)) {
		foreach($var as $key => $value) {
			if(is_numeric($key)) $key = "item";
			if($key=="item") $result .= "\n";
			$result .= "<{$key}>";
			if($key=="item") $result .= "\n";
			$result .= toXML($value);
			$result .= "</{$key}>";
			$result .= "\n";
		}
	} else {
		if(preg_match("/[<>&\r\n]+/", $var)) {
			$result = "<![CDATA[".$var."]]>";
		} else {
			$result = $var;
		}
	}
	return $result;
}

function toString($var) {
	$result = "";
	switch(true) {
		case is_string($var):
			$result = $var;
			break;
		case is_numeric($var):
			$result = (STRING)$var;
			break;
		case is_bool($var):
			$result = $var?"true":"false";
			break;
		/*
		case is_array($var):
			$result = join(",", $var);
			break;
		case is_object($var):
			$result = (STRING)$var;
			break;
		*/
		default:
			$result = serialize($var);
			break;
	}
	return $result;
}
/*---------------------------------------String Functions End-------------------------------------*/


/*---------------------------------------Functions 4 File Start---------------------------------------*/
function RemoveHeader($content) {
	//Coded By Windy_sk 20070420 v1.1
	$content = preg_replace("/^.+?\r\n\r\n/s", "", $content);
	$content = preg_replace("/^\w+[\r\n]+/", "", $content);
	return $content;
}

function GetRemoteContent($url, $header=array(), $method="GET", $data=array(), $timeout=10) {
	//Coded By Windy_sk 20080320 v1.4
	$errno = "";
	$errmsg = "";
	extract(parse_url($url), EXTR_SKIP);
	if(!is_null($query)) $path .= "?".$query;
	if(!isset($port)) $port = 80;
	$fp = @fsockopen($host, $port, $errno, $errmsg, $timeout);
	if($fp===false) return false;
	stream_set_blocking($fp, true);
	stream_set_timeout($fp, $timeout);
	if($method!="POST") $method="GET";

	$output = sprintf("%s /%s HTTP/1.1\r\n", $method, $path);
	$output .= sprintf("Host:%s\r\n", $host);
	$output .= "Accept: */*\r\n";
	$output .= "Accept-Encoding: gzip, deflate\r\n";
	if(isset($header['Referer'])) {
		$output .= "Referer:".$header['Referer']."\r\n";
	} else {
		$output .= "Referer:http://{$host}\r\n";
	}
	if(isset($header['User-Agent'])) {
		$output .= "User-Agent:".$header['User-Agent']."\r\n";
	} else {
		$output .= "User-Agent:Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.204 Safari/534.16\r\n";
	}
	if($method=="POST") $output .= "Content-Type:application/x-www-form-urlencoded\r\n";
	if(is_string($header) && strlen($header)>0) {
		$output .= $header;
	} elseif(is_array($header) && count($header)>0) {
		foreach($header as $key => $value) {
			$output .= $key.":".$value."\r\n";
		}
	}
	$post_data = "";
	if(is_string($data) && strlen($data)>0) {
		$post_data .= $data."\r\n";
		$output .= "Content-length:".strlen($post_data)."\r\n";
	} elseif(is_array($data) && count($data)>0) {
		foreach($data as $key => $value) {
			$post_data .= $key."=".$value."&";
		}
		$post_data = substr($post_data, 0, -1);
		$output .= "Content-length:".strlen($post_data)."\r\n";
	}
	$output .= "Cache-Control:no-cache\r\n";
	$output .= "Connection:Close\r\n";
	$output .= "\r\n";
	if(!empty($post_data)) $output .= $post_data."\r\n";
	$output .= "\r\n";
	fputs($fp, $output);
	$status = stream_get_meta_data($fp);
	if($status['timeout']) return false;
	$content = stream_get_contents($fp);
	fclose($fp);
	$gzip = (strpos($content, "Content-Encoding: gzip")!==false);
	$content = RemoveHeader($content);
	if($gzip) $content = gzinflate(substr($content,10));
	return $content;
}

function decode_gzip($h,$d,$rn="\r\n"){ 
if (isset($h['Transfer-Encoding'])){ 
 $lrn = strlen($rn); 
 $str = ''; 
 $ofs=0; 
 do{ 
    $p = strpos($d,$rn,$ofs); 
    $len = hexdec(substr($d,$ofs,$p-$ofs)); 
    $str .= substr($d,$p+$lrn,$len); 
     $ofs = $p+$lrn*2+$len; 
 }while ($d[$ofs]!=='0'); 
 $d=$str; 
} 
if (isset($h['Content-Encoding'])) $d = gzinflate(substr($d,10)); 
return $d; 
} 


function GetRemoteFile($remote_file, $local_file) {
	//Coded By Windy_sk 20080402 v1.3
	MakeDir(dirname($local_file));
	$fp_r = @fopen($remote_file, "rb");
	$fp_w = @fopen($local_file, "wb");
	if($fp_w!==false) {
		if($fp_r===false) {
			$content = GetRemoteContent($remote_file);
			$fp_r = !empty($content) && (strpos($content, "404 Not Found")===false);
			if($fp_r) fwrite($fp_w, $content);
		} else {
			while(!feof($fp_r)) {
				fwrite($fp_w, fread($fp_r, 4096));
			}
			fclose($fp_r);
		}
		fclose($fp_w);
		if($fp_r===false) unlink($local_file);
	}
	return $fp_r && $fp_w;
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
		$dir_list = explode("/", $dir);
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
		if(is_file($dir)) unlink($dir);
	}
	return;
}

function isWriteable($file){
	//will work in despite of Windows ACLs bug
	//see http://bugs.php.net/bug.php?id=27609
	//see http://bugs.php.net/bug.php?id=30931
	if($file{strlen($file)-1}=='/') {
		return isWriteable($file.uniqid(mt_rand()).'.tmp');
	} else if(is_dir($file)) {
		return isWriteable($file.'/'.uniqid(mt_rand()).'.tmp');
	} else {
		$rm = file_exists($file);
		$f = @fopen($file, 'a');
		if($f===false) return false;
		fclose($f);
		if(!$rm) unlink($file);
		return true;
	}
}
/*---------------------------------------Functions 4 File End---------------------------------------*/


/*---------------------------------------Functions 4 Picture Start----------------------------------*/
function img_watermark($img_src, $watermark, $img_dst="", $position=1, $para=array()) {
	if(!class_exists("imageCreator_file")) {
		if(!empty($img_dst)) copy($img_src, $img_dst);
		readfile($img_src);
		return;
	}
	if(file_exists($img_dst)) {
		readfile($img_dst);
		return;
	} else {
		MakeDir(dirname($img_dst));
	}
	$img = new imageCreator_file;
	$img->init($img_src);
	if(!$img->img) {
		readfile($img_src);
		return false;
	}
	if($img->width<100 || $img->height<100) {
		readfile($img_src);
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
		$img_wm = new imageCreator_file;
		$img_wm->init($new_watermark);
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
		if(is_null($font)) $font = realpath("font.ttc");
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
	if(file_exists($img_dst)) readfile($img_dst);
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

function vertify_img($str, $font = "font.ttc", $fontsize = 16) {
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