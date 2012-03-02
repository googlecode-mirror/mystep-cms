<?php
class myPack {
	protected
		$file_count		= 0,
		$file_ignore	= array(),		// ignore these files when packing
		$pack_file		= "pack.bin",		// the file name of packed file
		$file_list	= array(),		// only files in the list will be pack
		$pack_dir		= "./",			// the directory of pack or unpack to
		$pack_fp		= null,
		$pack_result	= array(),
		$charset = array();

	public function __construct($pack_dir = "./", $pack_file = "mypack.pkg") {
		$this->pack_dir		= str_replace("//", "/", $pack_dir);
		$this->pack_file	= $pack_file;
		return;
	}

	public function AddIgnore() {
		$args_list = func_get_args();
		$this->file_ignore += $args_list;
		return;
	}

	public function setCharset($from, $to, $lng_type="", $file_ext="") {
		$this->charset['from'] = $from;
		$this->charset['to'] = $to;
		$this->charset['lng_type'] = $lng_type;
		$this->charset['file_ext'] = $file_ext;
		return;
	}

	public function AddFile() {
		$args_list = func_get_args();
		$this->file_list += $args_list;
		return;
	}

	protected function PackFileList($separator="|") {
		for($i=0, $m=count($this->file_list); $i<$m; $i++) {
			$this->PackFile($file_list[$i], $separator);
		}
		return;
	}

	protected function PackFile($dir=".", $separator="|") {
		$dir = str_replace("//", "/", $dir);
		if(stristr("|".join("|",$this->file_ignore)."|", "|".basename($dir)."|")) return;
		if(is_dir($dir)) {
			$content = "dir".$separator.str_replace($this->pack_dir, "", $dir).$separator.filemtime($dir)."\n";
			fwrite($this->pack_fp, $content);
			$mydir = opendir($dir);
			while($file = readdir($mydir)){
				if(trim($file, ".") != "") $this->PackFile($dir."/".$file);
			}
			closedir($mydir);
		}elseif(file_exists($dir)) {
			$content  =  "file".$separator.str_replace($this->pack_dir, "", $dir).$separator.filesize($dir).$separator.filemtime($dir)."\n";
			if(isset($this->charset['file_ext'])) {
				$file_content = GetFile($dir);
				$path_parts = pathinfo($dir);
				if(strpos($this->charset['file_ext'], $path_parts["extension"])!==false) {
					$file_content = str_replace(strtolower($this->charset['from']), strtolower($this->charset['to']), $file_content);
					$file_content = str_replace(strtoupper($this->charset['from']), strtoupper($this->charset['to']), $file_content);
					if(!empty($this->charset['lng_type'])) {
						$file_content = chg_lng_custom($file_content, $this->charset['lng_type'], $this->charset['from']);
					} else {
						if(strtolower($this->charset['to'])=="big5") {
							$file_content = chs2cht($file_content, $this->charset['from']);
						}
					}
					$result = chg_charset($file_content, $this->charset['from'], $this->charset['to']);
					$content  =  "file".$separator.str_replace($this->pack_dir, "", $dir).$separator.strlen($result).$separator.filemtime($dir)."\n";
					$file_content = $result;
				}
				$content .= $file_content;
			} else {
				$content .= GetFile($dir);
			}
			fwrite($this->pack_fp, $content);
			$this->file_count++;
			array_push($this->pack_result, "<b>Packing File</b> <font color='blue'>$dir</font> (".GetFileSize($dir).")");
		}
		return;
	}

	protected function UnpackFile($outdir=".", $separator="|") {
		if(!is_dir($outdir)) mkdir($outdir, 0777);
		while(!feof($this->pack_fp)) {
			$data = explode($separator, fgets($this->pack_fp, 1024));
			if($data[0]=="dir") {
				if(trim($data[1], ".") != "") {
					$flag = mkdir($outdir."/".$data[1],0777);
					array_push($this->pack_result, "<b>Build Directory</b> $outdir/$data[1] ".($flag?"<font color='green'>Successfully!</font>":"<font color='red'>failed!</font>"));
				}
			}elseif($data[0]=="file") {
				$fp_w = fopen($outdir."/".$data[1],"wb");
				$flag = false;
				if($data[2]>0) $flag = fwrite($fp_w, fread($this->pack_fp,$data[2]));
				$this->file_count++;
				array_push($this->pack_result, "<b>Unpacking File</b> $outdir/$data[1] ".($flag?"<font color='green'>Successfully!</font>(".GetFileSize($this->pack_dir."/".$data[1]).")":"<font color='red'>failed!</font>"));
			}
		}
		return;
	}

	public function GetResult() {
		return join("<br />\n", $this->pack_result);
	}

	public function DoIt($type = "pack", $separator="|") {
		$this->pack_result = array();
		if($type == "pack") {
			$this->pack_fp	= fopen($this->pack_file, "wb");
			if(!$this->pack_fp) die("Error Occurs In Creating Output File !");
			$time = $_SERVER['REQUEST_TIME'];
			if(count($this->file_list)>0) {
				$this->PackFileList($separator);
			} else {
				$this->PackFile($this->pack_dir, $separator);
			}
			fclose($this->pack_fp);
			if($_SERVER['REQUEST_TIME']-$time <= 1) sleep(1);
			WriteFile($this->pack_file, gzcompress(GetFile($this->pack_file), 9));
		}else {
			WriteFile($this->pack_file, gzuncompress(GetFile($this->pack_file)));
			$this->pack_fp	= fopen($this->pack_file, "rb");
			if(!$this->pack_fp) die("Error Occurs In Reading Pack File !");
			$this->UnpackFile($this->pack_dir, $separator);
			fclose($this->pack_fp);
			unlink($this->pack_file);
		}
		$filename	= $this->pack_file;
		$filesize	= GetFileSize($filename);
		array_push($this->pack_result,"<br />File Count: {$this->file_count} File(s)");
		return $filename;
	}
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

function GetFileSize($file) {
	if(is_file($file)) {
		$filesize = filesize($file);
	} else {
		if(is_numeric($file)) {
			$filesize = $file;
		} else {
			return 0;
		}
	}
	if($filesize <1024){
		$filesize = (string)$filesize . " Bytes";
	}else if($filesize <(1024 * 1024)){
		$filesize = number_format((double)($filesize / 1024), 1) . " KB";
	}else if($filesize <(1024 * 1024 * 1024)){
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

function chg_charset($content, $from="gbk", $to="utf-8") {
	if(strtolower($from)==strtolower($to)) return $content;
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
?>