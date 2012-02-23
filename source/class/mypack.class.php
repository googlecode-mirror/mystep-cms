<?php
/********************************************
*                                           *
* Name    : Pack Manager                    *
* Author  : Windy2000                       *
* Time    : 2003-05-30                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$mypack = new MyPack($pack_dir, $pack_file)	// Set the Class
	$mypack->AddIgnore()												// add files which will not be packed
	$mypack->DoIt($type = "pack", $encry_key = "", $separator="|") // pack or unpack file(s)
	
	External Method : $mypack->GetFile, $mypack->GetFileSize, $mypack->WriteFile
	
--------------------------------------------------------------------------------------------------------------------*/

class myPack extends class_common {
	protected
		$file_count		= 0,
		$file_ignore	= array(),		// ignore these files when packing
		$file_list	= array(),		// only files in the list will be pack
		$pack_file		= "pack.bin",		// the file name of packed file
		$pack_dir		= "./",			// the directory of pack or unpack to
		$pack_fp		= null,
		$pack_result	= array();

	public function init($pack_dir = "./", $pack_file = "mypack.pkg") {
		$this->pack_dir		= str_replace("//", "/", $pack_dir);
		$this->pack_file	= $pack_file;
		$this->AddIgnore($pack_file);
		return;
	}

	public function AddIgnore() {
		$args_list = func_get_args();
		$this->file_ignore += $args_list;
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

	protected function PackFile($dir=".", $separator="|", $no_folder=true) {
		$main_dir = $this->pack_dir;
		if($no_folder) $main_dir = dirname($this->pack_dir)."/";
		$dir = str_replace("//", "/", $dir);
		if(stristr("|".join("|",$this->file_ignore)."|", "|".basename($dir)."|")) return;
		if(is_dir($dir)) {
			$content = "dir".$separator.str_replace($main_dir, "", $dir).$separator.filemtime($dir)."\n";
			fwrite($this->pack_fp, $content);
			$mydir = opendir($dir);
			while($file = readdir($mydir)){
				if(trim($file, ".") != "") $this->PackFile($dir."/".$file);
			}
			closedir($mydir);
		}elseif(file_exists($dir)) {
			$content  =  "file".$separator.str_replace($main_dir, "", $dir).$separator.filesize($dir).$separator.filemtime($dir)."\n";
			$content .= $this->GetFile($dir);
			fwrite($this->pack_fp, $content);
			$this->file_count++;
			array_push($this->pack_result, "<b>Packing File</b> <font color='blue'>$dir</font> (".$this->GetFileSize($dir).")");
		}
		return;
	}

	protected function UnpackFile($outdir=".", $separator="|") {
		if(!is_dir($outdir)) mkdir($outdir, 0777);
		$n = 0;
		while(!feof($this->pack_fp)) {
			$data = explode($separator, fgets($this->pack_fp, 1024));
			$n++;
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
				array_push($this->pack_result, "<b>Unpacking File</b> $outdir/$data[1] ".($flag?"<font color='green'>Successfully!</font>(".$this->GetFileSize($this->pack_dir."/".$data[1]).")":"<font color='red'>failed!</font>"));
			} else {
				$n--;
			}
		}
		return $n;
	}

	public function GetResult() {
		return join("<br />\n", $this->pack_result);
	}

	public function DoIt($type = "pack", $encry_key = "", $separator="|") {
		$this->pack_result = array();
		if($type == "pack") {
			$this->pack_fp	= fopen($this->pack_file, "wb");
			if(!$this->pack_fp) {
				$this->Error("Error Occurs In Creating Output File !");
				return false;
			}
			$time = $_SERVER['REQUEST_TIME'];
			if(count($this->file_list)>0) {
				$this->PackFileList($separator);
			} else {
				$this->PackFile($this->pack_dir, $separator);
			}
			fclose($this->pack_fp);
			if($_SERVER['REQUEST_TIME']-$time <= 1) sleep(1);
			$this->WriteFile($this->pack_file, gzcompress($this->GetFile($this->pack_file), 9));
			if(!empty($encry_key)) encry::enc_file($this->pack_file, $encry_key);
		}else {
			if(!empty($encry_key)) encry::dec_file($this->pack_file, $encry_key);
			$this->WriteFile($this->pack_file, gzuncompress($this->GetFile($this->pack_file)));
			$this->pack_fp	= fopen($this->pack_file, "rb");
			if(!$this->pack_fp) {
				$this->Error("Error Occurs In Reading Pack File !");
				return false;
			}
			$n = $this->UnpackFile($this->pack_dir, $separator);
			fclose($this->pack_fp);
			unlink($this->pack_file);
			if($n<=0) return false;
		}
		$filename	= $this->pack_file;
		$filesize	= $this->GetFileSize($filename);
		array_push($this->pack_result,"<br />File Count: {$this->file_count} File(s)");
		if($type == "pack") {
			array_push($this->pack_result,"Pack Size: {$filesize}");
			array_push($this->pack_result,"Packed File: <a href='{$filename}'>".basename($filename)."</a> <br />");
		}
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
?>