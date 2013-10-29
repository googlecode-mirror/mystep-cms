<?php
/********************************************
*                                           *
* Name    : Upload Manager                  *
* Author  : Windy2000                       *
* Time    : 2003-05-10                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
  	$upload = new MyUploader();
  	$upload->init($upload_path, $upload_rename, $relative, $banlst);
  	$upload->doit();
  	
  That's all...

	External Method : $Upload_Manager->MakeDir, $Upload_Manager->GetMicrotime, $Upload_Manager->GetFileSize
--------------------------------------------------------------------------------------------------------------------*/

class MyUploader extends class_common {
	public 
		$upload_path	= "",
		$upload_counter	= 0,
		$upload_result	= array(),
		$upload_rename	= false,
		$upload_banlst	= "";

	public function init($upload_path = 'upload/', $upload_rename = false, $relative = false, $banlst="php,exe,com,bat,pif") {
		if(empty($_FILES)) $this->Error("No Upload Files Exist !");
		if($relative) $upload_path = realpath($upload_path);
		$upload_path .= "/";
		if(!$this->MakeDir($upload_path)) {
			$this->Error("Operation Failed in Creating Directory {$upload_path} ,Please Check Your Power!");
		};
		$this->upload_path	= $upload_path;
		$this->upload_rename	= $upload_rename;
		$this->upload_banlst	= $banlst;
		return;
	}
	
	public function doit($getsize = true) {
		foreach($_FILES as $key => $value) {
			if(is_array($value['name'])) {
				if(is_array($value['name'][0])) {
					$this->Error("Structure of FILE is too complex!");
					exit;
				}
				$max_count = count($value['name']);
				for($i=0; $i<$max_count; $i++) {
					if($value['error'][$i] == 4) continue;
					$this->upload_result[$this->upload_counter]		= array();
					$this->upload_result[$this->upload_counter]['name']	= $value['name'][$i];
					$this->upload_result[$this->upload_counter]['type']	= $value['type'][$i];
					$this->upload_result[$this->upload_counter]['tmp_name']	= $value['tmp_name'][$i];
					$this->upload_result[$this->upload_counter]['error']	= $value['error'][$i];
					$this->upload_result[$this->upload_counter]['size']	= $getsize?$this->GetFileSize($value['size'][$i]):$value['size'][$i];
					$this->UploadFile();
				}
			} else {
				if($value['error'] == 4) continue;
				$this->upload_result[$this->upload_counter]		= array();
				$this->upload_result[$this->upload_counter]['name']	= $value['name'];
				$this->upload_result[$this->upload_counter]['type']	= $value['type'];
				$this->upload_result[$this->upload_counter]['tmp_name']	= $value['tmp_name'];
				$this->upload_result[$this->upload_counter]['error']	= $value['error'];
				$this->upload_result[$this->upload_counter]['size']	= $getsize?$this->GetFileSize($value['size']):$value['size'];
				$this->UploadFile();
			}
		}
		return;
	}

	private function UploadFile() {
		switch($this->upload_result[$this->upload_counter]['error']) {
			case 0:
				$file_ext = strtolower(strrchr($this->upload_result[$this->upload_counter]['name'],"."));
				if(strpos($this->upload_banlst, str_replace(".", "", $file_ext))!==false) $file_ext .= ".upload";
				$this->upload_result[$this->upload_counter]['new_name'] = $this->upload_rename?($this->GetMicrotime().substr(md5($this->upload_result[$this->upload_counter]['size']),0,5).$file_ext):$this->upload_result[$this->upload_counter]['name'];
				if(file_exists($this->upload_path.$this->upload_result[$this->upload_counter]['new_name'])) {
					$this->upload_result[$this->upload_counter]['message']	= "The Same-name-file Has Existed In The Upload Path !";
					$this->upload_result[$this->upload_counter]['error'] = 8;
					unlink($this->upload_result[$this->upload_counter]['tmp_name']);
				} else {
					if(filesize($this->upload_result[$this->upload_counter]['tmp_name'])==0) {
						$this->upload_result[$this->upload_counter]['message'] = "Upload File Is Zero-length !";
						$this->upload_result[$this->upload_counter]['error'] = 9;
					} else {
						if(move_uploaded_file($this->upload_result[$this->upload_counter]['tmp_name'], $this->upload_path.$this->upload_result[$this->upload_counter]['new_name'])) {
							$this->upload_result[$this->upload_counter]['message'] = "Upload Succeeded !";
						} else {
							$this->upload_result[$this->upload_counter]['message'] = "Upload Failed In Moving File !";
							$this->upload_result[$this->upload_counter]['error'] = 10;
						}
					}
				}
				break;
			case 1:
				$this->upload_result[$this->upload_counter]['message']	= "You can only upload file within the size of ".ini_get('upload_max_filesize')." ( upload_max_filesize in php.ini ) !";
				break;
			case 2:
				$this->upload_result[$this->upload_counter]['message']	= "You can only upload file within the size of ".$_POST['MAX_FILE_SIZE']." Bytes (MAX_FILE_SIZE by the Supervisor)";
				break;
			case 3:
				$this->upload_result[$this->upload_counter]['message']	= "Upload finished incompletely !";
				break;
			case 4:
				$this->upload_result[$this->upload_counter]['message']	= "No File has been upload !";
				break;
			case 5:
				$this->upload_result[$this->upload_counter]['message']	= "Empty File !";
				break;
			case 6:
				$this->upload_result[$this->upload_counter]['message']	= "Tempory directory error !";
				break;
			case 7:
				$this->upload_result[$this->upload_counter]['message']	= "File cannot be writen !";
				break;
			default:
				$this->upload_result[$this->upload_counter]['message']	= "Unknown Error !";
		}
		$this->upload_counter++;
		return;
	}

	public function GetResult() {
		echo"<table width=700 border=0 align=center cellpadding=0 cellspacing=1 bgcolor=#000000>
				<tr align=center bgcolor=#dddddd>
				  <td><b>File Name (Rename)</b></td>
				  <td width=70><b>File Size</b></td>
				  <td width=160><b>File Type</b></td>
				  <td><b>Result</b></td>
				</tr>
				";
		$max_count = count($this->upload_result);
		for($i=0; $i<$max_count; $i++) {
			echo"
				<tr bgcolor=#eeeeee>
				  <td style='padding: 4px'><a href='".$this->upload_path.$this->upload_result[$i]['new_name']."' target='_blank'>".$this->upload_result[$i]['name'].($this->upload_rename?" (".$this->upload_result[$i]['new_name'].")":"")."</a></td>
				  <td style='padding: 4px'>".$this->upload_result[$i]['size']."</td>
				  <td style='padding: 4px'>".$this->upload_result[$i]['type']."</td>
				  <td style='padding: 4px'>".$this->upload_result[$i]['message']."</td>
				</tr>
				";
		}
		echo "</table>";
		return;
	}
}
?>