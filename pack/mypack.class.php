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
		
		$ignore = array();
		if(is_file($dir."/ignore")) {
			$ignore = file_get_contents($dir."/ignore");
			if(strlen($ignore)==0) return;
			$ignore = str_replace("\r", "", $ignore);
			$ignore = explode("\n", $ignore);
		}
		
		for($i=0,$m=count($this->file_ignore);$i<$m;$i++) {
			if(substr($dir, -(strlen($this->file_ignore[$i])))==$this->file_ignore[$i]) return;
		}
		
		if(is_dir($dir)) {
			$content = "dir".$separator.str_replace($this->pack_dir, "", $dir).$separator.filemtime($dir)."\n";
			fwrite($this->pack_fp, $content);
			$mydir = opendir($dir);
			while($file = readdir($mydir)){
				if(trim($file, ".") == "" || $file == "ignore" || array_search($file, $ignore)!==false) continue;
				$this->PackFile($dir."/".$file);
			}
			closedir($mydir);
		} elseif(is_file($dir)) {
			$content  =  "file".$separator.str_replace($this->pack_dir, "", $dir).$separator.filesize($dir).$separator.filemtime($dir)."\n";
			if(isset($this->charset['file_ext'])) {
				$file_content = GetFile($dir);
				$path_parts = pathinfo($dir);
				if(strpos($this->charset['file_ext'], $path_parts["extension"])!==false) {
					$file_content = str_ireplace(strtolower($this->charset['from']), strtolower($this->charset['to']), $file_content);
					$file_content = str_ireplace(strtoupper($this->charset['from']), strtoupper($this->charset['to']), $file_content);
					if(!empty($this->charset['lng_type'])) {
						$file_content = chg_lng_custom($file_content, $this->charset['lng_type'], $this->charset['from']);
					} else {
						if(strtolower($this->charset['to'])=="big5") {
							$file_content = chs2cht($file_content, $this->charset['from']);
						}
					}
					if(strpos($dir, "include/config.php")) {
						$file_content = preg_replace("/\\\$setting\['web'\]\['s_pass'\].+?;/", "\$setting['web']['s_pass'] = '';", $file_content);
						$file_content = preg_replace("/\\\$setting\['db'\]\['pass'\].+?;/", "\$setting['db']['pass'] = '';", $file_content);
						$file_content = preg_replace("/\\\$setting\['email'\]\['password'\].+?;/", "\$setting['email']['password'] = '';", $file_content);
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
?>