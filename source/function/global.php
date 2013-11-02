<?php
/********************************************
*                                           *
* Name    : Functions 4 PHP                 *
* Author  : Windy2000                       *
* Time    : 2003-05-03                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*---------------------------------------String Functions Start-------------------------------------*/
function cutString($string) {
	//Coded By Windy2000 201201012 v1.0
	if(is_utf8($string)) {
		preg_match_all("/([\xE0-\xEF][\x80-\xBF]{2})|./", $string, $arr);
	} else {
		preg_match_all("/[\xa0-\xff]?./", $string, $arr);
	}
	return $arr[0];
}
function substrPro($string, $start, $length = 0, $mode = false) {
	//Coded By Windy2000 20020603 v3.0
	$arr = cutString($string);
	$m = $mode?count($arr):strlen($string);
	if($start<0) $start += $m;
	if($start<0) $start = 0;
	if($start>$m) return "";
	if($length<=0) $length += $m - $start;
	if($length<=0) return "";
	if($mode) return implode("", array_slice($arr, $start, $length));
	$str = "";
	$sub_start = false;
	for($i=0; $i<$m; $i++) {
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
function cut_words($string) {
	//Coded By Windy2000 20030805 v1.0
	$string = str_replace("\r\n","\n",trim($string));
	$string = preg_replace("/\s+/"," ",$string);
	$arr	= cutString($string);
	$result	= array();
	$n = 0;
	$max_count = count($arr);
	$flag = false;
	for($i=0; $i<$max_count; $i++) {
		if(ord($arr[$i])>=0xa0) {
			$result[++$n] = $arr[$i];
			$flag = false;
		} elseif(preg_match("/[a-z0-9]/i", $arr[$i])) {
			if($flag) {
				$result[$n] .= $arr[$i];
			} else {
				$result[++$n] = $arr[$i];
				$flag = true;
			}
		} else {
			$result[++$n] = $arr[$i];
			$flag = false;
		}
	}
	return $result;
}
function RndKey($length, $scope=1, $charset="gbk") {
	//Coded By Windy2000 20020501 v1.0
	$char_list	= array();
	$char_list[]	= "1234567890";
	$char_list[]	= "abcdefghijklmnopqrstuvwxyz";
	$char_list[]	= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$char_list[]	= "!@^()_:+\-";
	$Rnd_Key	= "";
	if($scope>0 && $scope<=count($char_list)) {
		for($i=1; $i<=$length; $i++) {
			$Rnd_Str  = $char_list[mt_rand(1,$scope) - 1];
			$Rnd_Key .= substr($Rnd_Str, mt_rand(0,strlen($Rnd_Str)-1), 1);
		}
	} else {
		for($i=1; $i<=$length; $i++) {
			$Rnd_Key .= chr(mt_rand(0xb0,0xf7)).chr(mt_rand(0xa0,0xfe));
		}
		if($charset!="gbk") $Rnd_Key = chg_charset($Rnd_Key, "gbk", $charset);
	}
	return($Rnd_Key);
}
function html_watermark($html, $rate=2, $scope=4, $str_append="", $charset="", $class_name="watermark", $tag_name="span", $jam_tag=false) {
	//Coded By Windy2000 20041202 v2.0
	/*
	Please make sure that the following style exist on your style sheet of the watermark page
	.{$class_name} {
		position:absolute;width:1px;height:1px;overflow:hidden;
	}
	*/
	if(strlen($html)>50000) return $html;
	if($scope>5 && empty($charset)) $charset = "utf-8";
	$result = "";
	$cur_tag = "";
	$rnd_str = "";
	preg_match_all("/(<(.+?)>)|(&([#\w]+);)/is", $html, $arr_tag);
	$arr_tag = $arr_tag[0];
	$html = str_replace($arr_tag, chr(0), $html);
	$arr_char = cutString($html);
	for($i=0,$m=count($arr_char); $i<$m; $i++) {
		if(ord($arr_char[$i])==0) {
			$cur_tag = array_shift($arr_tag);
			if(!empty($str_append) && preg_match("/<(\/(p|div))|(br( +\/)?)>/i", $cur_tag)) {
				$cur_tag = "<{$tag_name} class='{$class_name}'>".$str_append."</{$tag_name}>".$cur_tag;
			}
			$result .= $cur_tag;
		} elseif(mt_rand(1, 10)<$rate) {
			$rnd_str = RndKey(mt_rand(1, 2), $scope, $charset);
			if($jam_tag && mt_rand(1, 10)<6) {
				$rnd_str .= "<{$tag_name} class='".RndKey(mt_rand(3, 6),2)."'>".RndKey(mt_rand(1, 2), $scope, $charset)."</{$tag_name}>".RndKey(mt_rand(1, 2), $scope, $charset);
			}
			$result .= "<{$tag_name} class='{$class_name}'>".$rnd_str."</{$tag_name}>".$arr_char[$i];
		} else {
			$result .= $arr_char[$i];
		}
	}
	return $result;
}
function add_slash(&$str) {
	//Coded By Windy2000 20030805 v1.0
	if(is_array($str)) {
		foreach($str as $key => $value) {
			$str[$key] = add_slash($value);
		}
	} elseif(is_string($str)) {
		$str = addslashes($str);
	}
	return $str;
}
function strip_slash(&$str) {
	//Coded By Windy2000 20030805 v1.0
	if(is_array($str)) {
		foreach($str as $key => $value) {
			$str[$key] = strip_slash($value);
		}
	} elseif(is_string($str)) {
		$str = stripslashes($str);
	}
	return $str;
}
function arrayMerge($arr_1, $arr_2) {
	if(!is_array($arr_1)) return false;
	if(!is_array($arr_2)) {
		$arr_1[] = $arr_2;
	} else {
		foreach($arr_1 as $key => $value) {
			if(isset($arr_2[$key])) {
				if(is_array($arr_1[$key])) {
					if(is_array($arr_2[$key])) {
						$arr_1[$key] = arrayMerge($arr_1[$key], $arr_2[$key]);
					} else {
						$arr_1[$key][] = $arr_2[$key];
					}
				} else {
					if(is_array($arr_2[$key])) {
						$arr_1[$key] = arrayMerge(array($arr_1[$key]), $arr_2[$key]);
					} else {
						$arr_1[$key] = $arr_2[$key];
					}
				}
			}
		}
		foreach($arr_2 as $key => $value) {
			if(!isset($arr_1[$key])) {
				$arr_1[$key] = $arr_2[$key];
			}
		}
	}
	return $arr_1;
}
function HtmlTrans(&$str) {
	//Coded By Windy2000 20030805 v1.0
	$search = array("'", "\"", "<", ">", "  ", "\t");
	$replace = array("&#39;", "&quot;", "&lt;", "&gt;", "&nbsp; ", "&nbsp; &nbsp; ");
	if(is_array($str)) {
		foreach($str as $key => $value) {
			$str[$key] = HtmlTrans(&$value);
		}
	} elseif(is_string($str)) {
		$str = str_replace($search, $replace, $str);
	}
	return $str;
}
function modi_blank(&$str) {
	//Coded By Windy2000 20020503 v1.0
	if(is_array($str)) {
		foreach($str as $key => $value) {
			$str[$key] = modi_blank($value);
		}
	} elseif(is_string($str)) {
		$str = preg_replace("/(\s)+/", "\\1", trim($str));
	}
	return $str;
}
function txt2html($content) {
	//Coded By Windy2000 20020503 v1.0
	$content = str_replace("  ", "&nbsp; ", $content);
	$content = str_replace("\r\n", "\n", $content);
	$content = str_replace("\n", "<br />\n", $content);
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
function html2js($str) {
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
function encoding_detect($str) {
	if(function_exists("iconv")) {
		$cs_list = array("GBK","UTF-8","BIG5","ASCII");
		foreach ($cs_list as $item) {
			$sample = iconv($item, $item, $str);
			if (md5($sample) == md5($str)) return $item;
		}
	} elseif(function_exists("mb_detect_encoding")) {
		return mb_detect_encoding($content, array("ASCII","GB2312","GBK","BIG5","UTF-8","EUC-CN","ISO-8859-1","windows-1251","Shift-JIS"));
	}
	return null;
}
function chg_charset($content, $from="gbk", $to="utf-8") {
	if(strtolower($from)==strtolower($to)) return $content;
	$result = null;
	if(is_string($content)) {
		$result = iconv($from, $to.'//TRANSLIT//IGNORE', $content);
		if($result===false && function_exists("mb_detect_encoding")) {
			$encoding = encoding_detect($content);
			if($encoding!="" && strtolower($encoding)!=strtolower($to)) {
				$result = mb_convert_encoding($content, $to, $encoding);
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
	if(!is_file($file_src) || strtolower($from)==strtolower($to)) return;
	$content = file_get_contents($file_src);
	$content = iconv($from, $to.'//TRANSLIT//IGNORE',$content);
	return WriteFile($file_dst, $content, "wb");
}
function getSafeCode($str, $charset='UTF-8') {
	if(is_array($str)) {
		foreach($str as $key => $value) {
			$str[$key] = getSafeCode($value, $charset);
		}
		return $str;
	} else {
		$str_1 = $str;
		$str_2 = chg_charset($str_1, "utf-8", $charset);
		$str_3 = chg_charset($str_2, $charset, "utf-8");
		if(strlen($str_1) == strlen($str_3)) {
			return $str_2;
		} else {
			return $str_1;
		}
	}
}
function safeEncoding($str, $charset='UTF-8') {
	$encoding = "UTF-8";
	for($i=0; $i<strlen($str); $i++) {
		if(ord($str{$i})<128) {
			continue;
		} elseif((ord($str{$i})&224)==224) {
			$char = $str{++$i};
			if((ord($char)&128)==128) {
				$char = $str{++$i};
				if((ord($char)&128)==128) {
					$encoding = "UTF-8";
					break;
				}
			}
		} elseif((ord($str{$i})&192)==192) {
			$char = $str{++$i};
			if((ord($char)&128)==128) {
				$encoding = "GBK";
				break;
			}
		}
	}
	if(strtoupper($encoding) != strtoupper($charset)) {
		$str = chg_charset($str, $encoding, $charset);
	}
	return $str;
}
function md5_file_cs($file, $charset="", $encoding="") {
	if(empty($charset) || strtolower($charset)==strtolower($encoding) || strpos(GetFile($file,100), chr(0))!==false) return md5_file($file);
	$content = GetFile($file);
	if(empty($encoding)) $encoding = encoding_detect($content);
	if(!empty($encoding)) {
		$content = chg_charset($content, $encoding, $charset);
		return md5($content);
	}
	return md5_file($file);
}
function json_decode_js($json, $assoc = FALSE) {
	$json = str_replace(array("\n","\r"),"",$json);
	$json = preg_replace('/([{,])(\s*)([^"]+?)\s*:/','$1"$3":',$json);
	$json = str_replace("\\\"","&#34;",$json);
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
			//if($key=="item") $result .= "\n";
			$result .= "<{$key}>";
			//if($key=="item") $result .= "\n";
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
function strToHex($string) {
	$hex='';
	for ($i=0, $m=strlen($string); $i<$m; $i++) {
		$hex .= dechex(ord($string[$i]));
	}
	return $hex;
}
function hexToStr($hex) {
	$string='';
	for ($i=0, $m=strlen($hex)-1; $i<$m; $i+=2) {
		$string .= chr(hexdec($hex[$i].$hex[$i+1]));
	}
	return $string;
}
function is_utf8($string) {
	$string = preg_replace("/[\x20-\x7e]+/", "", $string);
	return preg_match('%^(?:
	[\x09\x0A\x0D\x20-\x7E] # ASCII
	| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
	| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
	| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
	| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
	| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
	| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
	| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
	)*$%xs', $string);
}
/*---------------------------------------String Functions End-------------------------------------*/


/*---------------------------------------Functions 4 File Start---------------------------------------*/
function GetRemoteContent($url, $header=array(), $method="GET", $data=array(), $timeout=10, $fake_ip="") {
	//Coded By Windy2000 20080320 v1.4
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
	if(!empty($fake_ip)) {
		$output .= "HTTP_X_FORWARDED_FOR:".$fake_ip."\r\n";
		$output .= "HTTP_CLIENT_IP:".$fake_ip."\r\n";
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
	
	$gzip = false;
	while(true) {
		$buffer = fgets($fp, 512);
		if(strpos($buffer, "Content-Encoding: gzip")!==false) $gzip = true;
		if(strlen($buffer)<3) break;
	}
	$content = stream_get_contents($fp);
	fclose($fp);
	if($gzip) {
		$content = preg_replace("/[\r\n]*\w{3}[\r\n]+/", "", $content);
		$content = gzdecode($content);
	}
	//if($gzip) $content = gzinflate(substr($content,10));
	return $content;
}
if(!function_exists('gzdecode')) {
	function gzdecode($data) {
		$flags = ord(substr($data, 3, 1 ));
		$headerlen = 10;
		$extralen = 0;
		$filenamelen = 0;
		if ($flags & 4) {
			$extralen = unpack('v', substr($data, 10, 2));
			$extralen = $extralen[1];
			$headerlen += 2 + $extralen;
		}
		if ($flags & 8) // Filename 
			$headerlen = strpos($data, chr(0), $headerlen) + 1;
		if ($flags & 16) // Comment 
			$headerlen = strpos($data, chr(0), $headerlen) + 1;
		if ($flags & 2) // CRC at end of file 
			$headerlen += 2;
		$unpacked = @gzinflate(substr($data, $headerlen));
		if ($unpacked === FALSE)
			$unpacked = $data;
		return $unpacked;
	}
}
function GetRemoteFile($remote_file, $local_file) {
	//Coded By Windy2000 20080402 v1.3
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
function getFileList($dir, $ext="", $base_dir="") {
	if(!is_dir($dir)) return;
	$ext = ",".$ext.",";
	if(empty($base_dir)) $base_dir = $dir;
	$file_list = array();
	$mydir	= dir($dir);
	if(!$mydir) return array();
	while(($file = $mydir->read()) !== false) {
		if($file=="." || $file==".." || strpos($ext, ",".$file.",")!==false) continue;
		$theFile = $dir."/".$file;
		if(is_dir($theFile)) {
			$file_list = array_merge($file_list, getFileList($theFile, $ext, $dir));
		} else {
			$file_list[] = str_replace($base_dir, "", $theFile);
		}
	}
	$mydir->close();
	return $file_list;
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
function MultiCopy($source, $destination, $overwrite = false) {
	//Coded By Windy2000 20131028 v1.0
	if(substr($source, -1)=="/" || substr($source, -1)=="\\") $destination = $destination."/".basename($source);
	if(is_dir($destination)) {
		if(is_file($source)) {
			$file_name = basename($source);
			if(is_file($destination."/".$file_name)) {
				if($overwrite) {
					unlink($destination."/".$file_name);
				} else {
					rename($destination."/".$file_name, $destination."/".$file_name.".".time());
				}
			}
		}
	} elseif(is_file($destination)) {
		if($overwrite) {
			unlink($destination);
		} else {
			rename($destination, $destination.".".time());
		}
	} else {
		if(is_file($source)) {
			$info = pathinfo($destination);
			if(isset($info['extension'])) {
				MakeDir($info['dirname'], 0777);
			} else {
				MakeDir($destination);
				$destination = $destination."/".basename($source);
			}
		} else {
			MakeDir($destination);
		}
	}
	
	if(is_file($source)) {
		copy($source, $destination);
	} elseif(is_dir($source)) {
		$handle=dir($source);
		while(false !== ($file=$handle->read())) {
			if($file=="." || $file=="..") continue;
			if(is_dir($source."/".$file)) {
				MultiCopy($source."/".$file, $destination."/".$file, $overwrite);
			} else {
				if(file_exists($destination."/".$file) && !$overwrite) {
					rename($destination."/".$file, $destination."/".$file.".".time());
				}
				copy($source."/".$file, $destination."/".$file);
			}
		}
	} else {
		return false;
	}
	return true;
}
function MultiDel($dir, $file_list="") {
	//Coded By Windy2000 20031001 v1.0
	if(is_dir($dir)) {
		$mydir = opendir($dir);
		while(($file = readdir($mydir)) !== false) {
			if($file!="." && $file!="..") {
				$the_name = $dir."/".$file;
				if(is_dir($the_name)) {
					if(empty($file_list) || strpos($file_list, $file)!==false) {
						MultiDel($the_name);
					} else {
						MultiDel($the_name, $file_list);
					}
				} else {
					if(empty($file_list) || strpos($file_list, $file)!==false) {
						@unlink($the_name);
					}
				}
				//is_dir($the_name) ? MultiDel($the_name) : @unlink($the_name);
			}
		}
		closedir($mydir);
		@rmdir($dir);
	}else{
		if(is_file($dir)) unlink($dir);
	}
	return;
}
function isWriteable($file) {
	if($file{strlen($file)-1}=='/') {
		if(!file_exists($file)) MakeDir($file);
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
	$img->SetErrorHandle("WriteError");
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
		$new_watermark = $watermark;
		$img_wm = new imageCreator_file;
		$img_wm->SetErrorHandle("WriteError");
		$img_wm->init($new_watermark);
		list($wm_width, $wm_height) = $img_wm->getSize();
		
		$rate = $para['rate'];
		if(is_null($rate)) $rate = 4;
		$alpha = $para['alpha'];
		if(is_null($alpha)) $alpha = 60;
		if($rate!=1) {
			$wm_rate = min($img->width/$rate/$wm_width, $img->height/$rate/$wm_height);
			$wm_width *= $wm_rate;
			$wm_height *= $wm_rate;
			$img_wm->resizeImage($wm_rate);
			$img_wm->setTransparent(array(0,0));
		}
		switch($position) {
			case 1: //right-bottom
				$pos = array($img->width - $wm_width, $img->height - $wm_height);
				break;
			case 2:	//right-top
				$pos = array($img->width - $wm_width, 0);
				break;
			case 3:	//left-bottom
				$pos = array(0, $img->height - $wm_height);
				break;
			case 4:	//left-top
				$pos = array(0, 0);
				break;
			case 5:	//left-middle
				$pos = array(0, ($img->height - $wm_height)/2);
				break;
			case 6:	//right-middle
				$pos = array($img->width - $wm_width, ($img->height - $wm_height)/2);
				break;
			case 7:	//middle-top
				$pos = array(($img->width - $wm_width)/2, 0);
				break;
			case 8:	//middle-bottom
				$pos = array(($img->width - $wm_width)/2, $img->height - $wm_height);
				break;
			default:	//middle
				if(is_numeric($position)) {
					$img_wm->rotateImage($position);
					$wm_width = $img_wm->width;
					$wm_height = $img_wm->height;
				}
				$pos = array(($img->width - $wm_width)/2, ($img->height - $wm_height)/2);
				break;
		}
		$img->pasteImage($img_wm->img, $pos, $alpha);
		$img->makeImage($dst_type, $img_dst);
		$img_wm->destroyImage();
		$img->destroyImage();
	} else {
		$alpha = isset($para['alpha']) ? $para['alpha'] : 100;
		$font = isset($para['font']) ? $para['font'] : "font.ttc";
		if(!file_exists($font)) $font = false;
		$fontsize = isset($para['fontsize']) ? $para['fontsize'] : (($position==5 || $position==6) ? $img->height/80 : $img->width/80);
		if($fontsize<12) $fontsize = 12;
		$fontcolor = isset($para['fontcolor']) ? $para['fontcolor'] : "white";
		$bgcolor = isset($para['bgcolor']) ? $para['bgcolor'] : null;
		if(preg_match("/(#)?[0-9a-f]{6}/i", $bgcolor)) $bgcolor = array_map("hexdec", str_split(str_replace("#","",$bgcolor), "2"));

		if($img->setFont($font)) {
			$font_size = $img->getFontSize($watermark, $fontsize);
			$font_size[0] += 10;
			$font_size[1] += 10;
			$img_txt = new imageCreator;
			$img_txt->SetErrorHandle("WriteError");
			$img_txt->init($font_size[0], $font_size[1]);
			$img_txt->createImage(true, $bgcolor);
			if(preg_match("/(#)?[0-9a-f]{6}/i", $fontcolor)) {
				$img_txt->setColor("fontcolor", array_map("hexdec", str_split(str_replace("#","",$fontcolor), "2")));
				$fontcolor = "fontcolor";
			}
			$img_txt->drawString($img_txt->transString($watermark), array(5,$font_size[1]-5), $fontcolor, $font, $fontsize);

			if($position==5) {
				$img_txt->rotateImage(270);
			} elseif($position==6) {
				$img_txt->rotateImage(90);
			}
			switch($position) {
				case 1:
				case 2:
				case 3:
				case 4:
				case 7:
				case 8:
					$width = $img->width;
					$height = $img->height + $font_size[1];
					break;
				case 5:
				case 6:
					$width = $img->width + $font_size[1];
					$height = $img->height;
					break;
				default:
					$width = $img->width;
					$height = $img->height;
					break;
			}
			$img_out = new imageCreator;
			$img_out->SetErrorHandle("WriteError");
			$img_out->init($width, $height);
			$img_out->createImage(true, $bgcolor);

			switch($position) {
				case 1: //right-bottom
					$img_out->pasteImage($img->img, array(0, 0));
					$img_out->pasteImage($img_txt->img, array($img->width - $img_txt->width, $img->height), $alpha);
					break;
				case 2:	//right-top
					$img_out->pasteImage($img->img, array(0, $font_size[1]));
					$img_out->pasteImage($img_txt->img, array($img->width - $img_txt->width, 0), $alpha);
					break;
				case 3:	//left-bottom
					$img_out->pasteImage($img->img, array(0, 0));
					$img_out->pasteImage($img_txt->img, array(0, $img->height), $alpha);
					break;
				case 4:	//left-top
					$img_out->pasteImage($img->img, array(0, $font_size[1]));
					$img_out->pasteImage($img_txt->img, array(0, 0), $alpha);
					break;
				case 5:	//left-middle
					$img_out->pasteImage($img->img, array($font_size[1], 0));
					$img_out->pasteImage($img_txt->img, array(0, ($img->height - $font_size[0])/2), $alpha);
					break;
				case 6:	//right-middle
					$img_out->pasteImage($img->img, array(0, 0));
					$img_out->pasteImage($img_txt->img, array($img->width, ($img->height - $font_size[0])/2), $alpha);
					break;
				case 7:	//middle-top
					$img_out->pasteImage($img->img, array(0, $font_size[1]));
					$img_out->pasteImage($img_txt->img, array(($img->width - $font_size[0])/2, 0), $alpha);
					break;
				case 8:	//middle-bottom
					$img_out->pasteImage($img->img, array(0, 0));
					$img_out->pasteImage($img_txt->img, array(($img->width - $font_size[0])/2, $img->height), $alpha);
					break;
				default:	//middle
					if(is_numeric($position)) {
						$img_txt->rotateImage($position);
						$font_size = array($img_txt->width, $img_txt->height);
					}
					$img_out->pasteImage($img->img, array(0, 0));
					$img_out->pasteImage($img_txt->img, array(($img->width - $font_size[0])/2, ($img->height - $font_size[1])/2), $alpha);
					break;
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
	$img->SetErrorHandle("WriteError");
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
	$img_out->SetErrorHandle("WriteError");
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
	$img->SetErrorHandle("WriteError");
	$img->setFont($font);
	list($img->width, $img->height) = $img->getFontSize($str, $fontsize);
	$img->width += $fontsize*2;
	$img->height += $fontsize;
	$img->createImage(true, array(255,255,255));
	$img->setColor("vertify", rand(220, 255), rand(220, 255), rand(220, 255));
	$img->setLine(1);
	$img->drawRectangle(array(0,0), $img->width-2, $img->height-2, "black", "vertify");
	$char_lst = cutString($str);
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
	$ip_org = $_SERVER["REMOTE_ADDR"];
	if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		$ip_list = explode(",", $ip);
		if(count($ip_list)>1) $ip = $ip_list[0];
	} elseif(isset($_SERVER["HTTP_CLIENT_IP"])) {
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	}
	if(preg_match("/[a-z]+/i", $ip)) $ip = "";
	if(!empty($ip) && $ip!=$ip_org) {
		$ip = $ip_org.",".$ip;
	} else {
		$ip = $ip_org;
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
function getDate_cn($date="") {
	if(empty($date)) $date=time();
	if(!is_numeric($date)) $date = strtotime($date);
	$the_year = (STRING)date("Y", $date);
	$the_month = (STRING)date("n", $date);
	$the_day = (STRING)date("j", $date);
	$num_cn = array();
	$num_cn[] = array("○","十","廿","卅");
	$num_cn[] = array("○","一","二","三","四","五","六","七","八","九");
	$result = "";
	for($i=0,$m=strlen($the_year);$i<$m;$i++) {
		$result .= $num_cn[1][$the_year[$i]];
	}
	$result .= "年";
	for($i=0,$m=strlen($the_month);$i<$m;$i++) {
		if($m==1 && $i==0) {
			$result .= $num_cn[1][$the_month[$i]];
			break;
		} else {
			$result .= $num_cn[$i][$the_month[$i]];
		}
	}
	$result .= "月";
	for($i=0,$m=strlen($the_day);$i<$m;$i++) {
		if($m==1 && $i==0) {
			$result .= $num_cn[1][$the_day[$i]];
			break;
		} else {
			$result .= $num_cn[$i][$the_day[$i]];
		}
	}
	$result .= "日";
	return $result;
}
function GetTinyUrl($url) {
	return file_get_contents("http://tinyurl.com/api-create.php?url=".urlencode($url));
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
/*---------------------------------------Misc Functions End------------------------------------------*/
?>