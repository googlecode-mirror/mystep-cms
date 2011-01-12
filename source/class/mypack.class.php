<?php
/********************************************
*                                           *
* Name    : Pack Manager                    *
* Author  : Windy2000                       *
* Time    : 2003-05-30                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$mypack = new MyTpl($pack_dir, $pack_file)	// Set the Class
	$mypack->AddIgnore()												// add files which will not be packed
	$mypack->DoIt($type = "pack", $encry_key = "", $compress_type = 1, $separator="|") // pack or unpack file(s)
	
--------------------------------------------------------------------------------------------------------------------*/

class myPack {
	protected
		$file_count		= 0,
		$file_ignore	= array(),		// ignore these files when packing
		$pack_file		= "pack.bin",		// the file name of packed file
		$pack_dir		= "./",			// the directory of pack or unpack to
		$pack_fp		= null,
		$pack_result	= null,
		$include_path	= "";

	public function __construct($pack_dir = "./", $pack_file = "pack.bin") {
		$this->pack_dir		= $pack_dir;
		$this->pack_file	= $pack_file;
		$this->AddIgnore($pack_file, basename(__FILE__), basename($_SERVER["PHP_SELF"]));
		return;
	}

	public function AddIgnore() {
		$args_list = func_get_args();
		$this->file_ignore += $args_list;
		return;
	}

	private function GetFile($file) {
		return is_file($file) ? file_get_contents($file) : "";
	}

	private function GetFileSize($filesize) {
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

	private function FileCompress($compress_type) {
		switch($compress_type) {
			case 1:
				if(function_exists('zip')) {
					zip($this->pack_file, $this->pack_file.".zip");
				}
				break;
			case 2:
				if (function_exists('gzencode')) {
					$fp = fopen($this->pack_file.".gz", "wb");
					fwrite($fp, gzencode($this->GetFile($this->pack_file)));
					fclose($fp);
				}
				break;
			case 3:
				if (function_exists('bzcompress')) {
					$fp = fopen($this->pack_file.".bz2", "wb");
					fwrite($fp, bzcompress($this->GetFile($this->pack_file)));
					fclose($fp);
				}
				break;
		}
		fclose($fp);
		unlink($this->pack_file);
		return;
	}

	public function PackFile($dir=".", $separator="|") {
		$dir = str_replace("//", "/", $dir);
		if(is_dir($dir)) {
			$content = "dir".$separator.$dir.$separator.filemtime($dir)."\n";
			fwrite($this->pack_fp, $content);
			$mydir = opendir($dir);
			while($file = readdir($mydir)){
				if(trim($file, ".") != "") $this->PackFile($dir."/".$file);
			}
			closedir($mydir);
		}elseif(file_exists($dir)) {
			if(stristr("|".join("|",$this->file_ignore)."|", "|".basename($dir)."|")) return;
			$content  =  "file".$separator.$dir.$separator.filesize($dir).$separator.filemtime($dir)."\n";
			$content .= $this->GetFile($dir);
			fwrite($this->pack_fp, $content);
			$this->file_count++;
			array_push($this->pack_result, "Packing File <font color='red'>$dir</font>, size: ".$this->GetFileSize(filesize($dir)));
		}
		return;
	}

	public function UnpackFile($outdir=".", $separator="|") {
		if(!is_dir($outdir)) mkdir($outdir, 0777);
		while(!feof($this->pack_fp)) {
			$data = explode($separator, fgets($this->pack_fp, 1024));
			if($data[0]=="dir") {
				if(trim($data[1], ".") != "") {
					$flag = mkdir($outdir."/".$data[1],0777);
					array_push($this->pack_result, "Build Directory <font color='red'>$outdir/$data[1]</font> ".($flag?"Successfully!":"failed!"));
				}
			}elseif($data[0]=="file") {
				$fp_w = fopen($outdir."/".$data[1],"wb");
				$flag = fwrite($fp_w, fread($this->pack_fp,$data[2]));
				$this->file_count++;
				array_push($this->pack_result, "Unpacking File <font color='red'>$outdir/$data[1]</font> ".($flag?"Successfully! size: ".$this->GetFileSize(filesize("$data[1]")):"failed!"));
			}
		}
		return;
	}

	public function GetResult() {
		return join("<br />\n", $this->pack_result);
	}

	public function DoIt($type = "pack", $encry_key = "", $compress_type = 1, $separator="|") {
		$this->pack_result = array();
		if(is_numeric($compress_type)) {
			if($compress_type > 3 || $compress_type < 0) $compress_type = 0;
		}else {
			$compress_type = 0;
		}
		if($type == "pack") {
			$this->pack_fp	= fopen($this->pack_file, "wb");
			if(!$this->pack_fp) die("Error Occurs In Creating Output File !");
			$time = $_SERVER['REQUEST_TIME'];
			$this->PackFile($this->pack_dir, $separator);
			fclose($this->pack_fp);
			if($_SERVER['REQUEST_TIME']-$time <= 1) sleep(1);
			if(!empty($encry_key)) encry::enc_file($this->pack_file, $encry_key);
			if(preg_match("/[1-3]/",$compress_type)) $this->FileCompress($compress_type);
		}else {
			if(!empty($encry_key)) encry::dec_file($this->pack_file, $encry_key);
			$this->pack_fp	= fopen($this->pack_file, "rb");
			if(!$this->pack_fp) die("Error Occurs In Reading Pack File !");
			$this->UnpackFile($this->pack_dir, $separator);
			fclose($this->pack_fp);
		}
		$extend_type	= array("", ".zip", ".gz", ".bz2");
		$filename	= $this->pack_file.($type=="pack"?$extend_type[$compress_type]:"");
		$filesize	= $this->GetFileSize(filesize($filename));
		array_push($this->pack_result,"<br />File Count: {$this->file_count}Files");
		array_push($this->pack_result,"Pack Size:  {$filesize}");
		if($type == "pack") array_push($this->pack_result,"Packed File:  <a href='{$filename}'>".basename($filename)."</a> <br />");
		return $filename;
	}
}


class encry {
	public static function keyED($txt, $encrypt_key) {
		$encrypt_key = md5($encrypt_key);
		$ctr=0;
		$tmp = "";
		for ($i=0;$i<strlen($txt);$i++) {
			if ($ctr==strlen($encrypt_key)) $ctr=0;
			$tmp.= substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1);
			$ctr++;
		}
		return $tmp;
	}
	
	public static function enc_str($txt, $key) {
		mt_srand((double)microtime()*1000000);
		$encrypt_key = md5(mt_rand(0,32000));
		$ctr=0;
		$tmp = "";
		for ($i=0;$i<strlen($txt);$i++) {
			if ($ctr==strlen($encrypt_key)) $ctr=0;
			$tmp.= substr($encrypt_key,$ctr,1) . (substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1));
			$ctr++;
		}
		return self::keyED($tmp,$key);
	}
	
	public static function enc_file($file, $key) {
		if(filesize($file)==0) {
			echo ("File $file Needn't Encrypt !");
			return;
		}
		$fp_r = fopen("$file","rb");
		$fp_w = fopen("enc_$file","wb");
		if(!$fp_r || !$fp_w) die("Cannot Read or Write File !");
		$enc_text = md5($key);
		fwrite($fp_w, $enc_text);
		while (!feof($fp_r)) {
			$data		= fread($fp_r, 1024);
			$enc_text	= self::enc_str($data, $key);
			fwrite($fp_w, $enc_text);
		}
		fclose($fp_r);
		fclose($fp_w);
		unlink($file);
		rename("enc_$file", $file);
		return;
	}
	
	public static function dec_str($txt,$key) {
		$txt = self::keyED($txt,$key);
		$tmp = "";
		for ($i=0;$i<strlen($txt);$i++) {
			$md5 = substr($txt,$i,1);
			$i++;
			$tmp.= (substr($txt,$i,1) ^ $md5);
		}
		return $tmp;
	}
	
	public static function dec_file($file, $key) {
		$fp_r = fopen("$file","rb");
		$fp_w = fopen("dec_$file","wb");
		if(!$fp_r || !$fp_w) die("Cannot Read or Write File !");
		$enc_key = md5($key);
		if($enc_key != fread($fp_r, strlen($enc_key))) {
			fclose($fp_r);
			fclose($fp_w);
			unlink("dec_$file");
			die("Wrong Decryption Key !");
		}
		while (!feof($fp_r)) {
			$data		= fread($fp_r, 1024);
			$dec_text	= self::dec_str($data, $key);
			fwrite($fp_w, $dec_text);
		}
		fclose($fp_r);
		fclose($fp_w);
		unlink($file);
		rename("dec_$file", $file);
		return;
	}
}

/*--------------------------------------------------------------------------------------------------------------------------------------*/

class MyZip extends ZipArchive {
 public function addDir($path) {
		$this->addEmptyDir($path);
		$nodes = glob($path . '/*');
		foreach($nodes as $node) {
			if(is_dir($node)) {
				$this->addDir($node);
			} else if(is_file($node))  {
				$this->addFile($node);
			}
		}
	}
	
	public function open($file) {
		return parent::open($file, ZIPARCHIVE::OVERWRITE);
	}
}
?>