<?php
/********************************************
*                                           *
* Name    : File System Object              *
* Author  : Windy2000                       *
* Time    : 2003-09-12                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

class MyFSO extends class_common {
	public function Get_Attrib($file_att){
		if(strlen($file_att)!=3) return "Error";
		$att_list	= array("---", "--x", "-w-", "-wx", "r--", "r-x", "rw-", "rwx");
		$the_attrib	= "";
		for($i=0; $i<3; $i++) {
			$this_char=(int)substr($file_att,$i,1);
			if($this_char > 7 || $this_char < 0)  return "Error";
			$the_attrib .= $att_list[$this_char];
		}
		return $the_attrib;
	}

	public function Get_Size($file_size) {
		if($file_size < 1024){
			$file_size = (string)$file_size . " Bytes";
		}else if($file_size < (1024 * 1024)){
			$file_size = number_format((double)($file_size / 1024), 1) . " KB";
		}else if($file_size < (1024 * 1024 * 1024)){
			$file_size = number_format((double)($file_size / (1024 * 1024)), 1) . " MB";
		}else{
			$file_size = number_format((double)($file_size / (1024 * 1024 * 1024)), 1) . " GB";
		}
		return $file_size;
	}

	public function Judge_Child($dir, $only_dir = true){
		$mydir	= dir($dir);
		if(!$mydir) return false;
		while(($file = $mydir->read()) !== false){
			if($file!="." && $file!=".."){
				if($only_dir) {
					if(is_dir($dir."/".$file)) return true;
				} else {
					return true;
				}
			}
		}
		$mydir->close();
		return false;
	}

	public function Multi_Del($dir){
		if(!file_exists($dir)) return;
		if(is_dir($dir)){
			$mydir = opendir($dir);
			while(($file = readdir($mydir))!==false) {
				if($file!="." && $file!="..") {
					$the_name = $dir."/".$file;
					is_dir($the_name) ? self::Multi_Del($the_name) : unlink($the_name);
				}
			}
			closedir($mydir);
			rmdir($dir);
		}else{
			unlink($dir);
		}
		return;
	}

	public function Make_Dir($dir) {
		$dir = preg_replace("/[\\\/]+/", "/", $dir);
		if(!is_dir($dir)) {
			$dir_list = split("/", $dir);
			$cur_dir = "";
			$oldumask=umask(0);
			$max_count = count($dir_list);
			for($i=0; $i<$max_count; $i++) {
				if(empty($dir_list[$i])) continue;
				$cur_dir .= $dir_list[$i]."/";
				if(is_dir($cur_dir)) {
					continue;
				} else {
					mkdir($cur_dir, 0777, true);
					chmod($cur_dir, 0777);
				}
			}
			umask($oldumask);
		}
		return is_dir($dir);
	}

	public function Rename_File($file, $newname) {
		if(file_exists($file)) {
			if(file_exists($newname)) {
				$this->Error("File {$newname} already exist !");
			} else {
				$this->Make_Dir(dirname($newname));
				rename($file, $newname) or $this->Error("Operation Failed in Renaming {$file} £¬Please Check Your Power!");
			}
		} else {
			$this->Error("Cannot Find File {$file} !");
		}
		return;
	}

	public function Copy_File($file_1, $file_2) {
		if(!is_file($file_1)) {
			$this->Error("File {$file_1} Cannot Be Found!");
		} elseif(is_file($file_2)) {
			$this->Error("File {$file_2} Has Already Existed!");
		} else  {
			$this->Make_Dir(dirname($file_2));
			copy($file_1, $file_2) or $this->Error("File Copy Failed.");
		}
		return;
	}

	public function Move_File($file, $dir) {
		$this->Make_Dir(dirname($dir));
		$this->Rename_File($file, str_replace("//", "/", $dir."/".basename($file)));
		return;
	}
	
	public function Get_File($file, $length=0, $offset=0) {
		if(!is_file($file)) return "";
		if($length==0) return file_get_contents($file);
		$fp = fopen($file, "rb");
		fseek($fp, $offset);
		$data = fgets($fp, $length);
		fclose($fp);
		return $data;
	}
	
	public function Get_File_Ext($file) {
		return str_replace(".", "", strrchr($file, "."));
	}

	public function Write_File($file, $content) {
		if(file_exists($file)) {
			$this->Set_Attrib($file, 0777);
		} else {
			$this->Make_Dir(dirname($file));
		}
		if($fp = fopen($file,"w")) {
			flock($fp,LOCK_EX);
			fputs($fp,$content);
			flock($fp, LOCK_UN);
			fclose($fp);
		} else {
			$this->Error("Cannot Create File {$file} !");
		}
		return;
	}

	public function Set_Attrib($file, $attrib) {
		if(file_exists($file)) {
			chmod($file, $attrib) or $this->Error("Operation Failed in Setting Attrib of {$file} , Please Check Your Power!");
		} else {
			$this->Error("Cannot Find File {$file} !");
		}
		return;
	}

	public function Search_File($dir, $keyword="", $inc_word="", $recursive=false, $html=false, $php=false) {
		$mydir	= dir($dir);
		if(!$mydir) return false;
		$result = array();
		while(($file = $mydir->read()) !== false) {
			$the_name = str_replace("//","/",$dir."/".$file);
			if(is_dir($the_name)) {
				if(strpos(strtolower(basename($the_name)), strtolower($keyword))!==false || empty($keyword)) {
					$result[] = $the_name;
				}
				if($recursive && $file!="." && $file!=".."){
					$result = self::Search_File($the_name, $keyword, $inc_word, true, $html, $php);
				}
			} else {
				if(strpos(strtolower(basename($the_name)), strtolower($keyword))!==false || empty($keyword)) {
					if(!empty($inc_word)) {
						if($this->Search_File_Content($the_name, $inc_word, $html, $php)) $result[] = $the_name;
					} else {
						$result[] = $the_name;
					}
				}
			}
		}
		$mydir->close();
		return $result;
	}

	public function Search_File_Content($file, $inc_word, $html, $php) {
		$str = $this->Get_File($file);
		if(!$php) $str = preg_replace("/<\?(php)?.*\?>/isU", "", $str);
		if(!$html) {
			$str = preg_replace("/<head>(.*)<\/head>/isU", "", $str);
			$str = preg_replace("/<script([^>]*)>(.*)<\/script>/isU", "", $str);
			$str = preg_replace("/<style([^>]*)>(.*)<\/style>/isU", "", $str);
			$str = preg_replace("/<.*>/isU", "", $str);
		}
		return (stripos($str, $inc_word) !== false);
	}

	public function Get_List($dir, $filetype = ""){
		$mydir	= dir($dir);
		if(!$mydir) return false;
		$file_list = array("dir" => array(), "file" => array(), "custom" => array());
		while(($file = $mydir->read()) !== false){
			if($file!="."  && $file!=".."){
				$string = str_replace("//","/",$dir."/".$file);
				if(is_dir($string)){
					$file_list["dir"][] = $string;
				}else{
					$file_list["file"][] = $string;
					if(!empty($filetype)) {
						$ext = Get_File_Ext($string);
						if(strpos($filetype, $ext)!==false) $file_list["custom"][] = $string;
					}
				}
			}
		}
		$mydir->close();
		sort($file_list["dir"]);
		sort($file_list["file"]);
		sort($file_list["custom"]);
		return $file_list;
	}

	public function Get_Tree($dir, $recursive = false, $filter = ""){
		$tree = array();
		$mydir	= dir($dir);
		if(!$mydir) return array();
		while(($file = $mydir->read()) !== false){
			if($file=="." || $file=="..") continue;
			if(!empty($filter) && strpos($file, $filter)===false) continue;
			$theFile = $dir."/".$file;
			if(is_dir($theFile)){
				if($recursive) $tree[$file]["sub"] = $this->Get_Tree($dir."/".$file, true);
				$tree[$file]["size"] = "---";
			} else {
				$tree[$file]["size"] = $this->Get_Size(filesize($theFile));
			}
			$tree[$file]["attr"] = $this->Get_Attrib(substr(DecOct(fileperms($theFile)),-3));
			$tree[$file]["time"] = date("Y/d/y H:i:s", filemtime($theFile));
		}
		$mydir->close();
		return $tree;
	}
}
?>