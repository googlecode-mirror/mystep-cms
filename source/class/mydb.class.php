<?php
/********************************************
*                                           *
* Name    : MyDB Text Datebase              *
* Author  : Windy2000                       *
* Time    : 2005-09-15                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$mydb = new MyDB($DB_name, $DB_path, $DB_tlen)			// Set the Text DB Class
	$mydb->createTBL($setting)													// Create Text DB file in the specified directory
	$mydb->Error($str)																	// Handle the Errors
	$mydb->resetDB($DB_name, $DB_path, $DB_tlen)				// Set working db to another one
	$mydb->openTBL()																		// Open working db
	$mydb->closeTBL()																		// Close current db
	$mydb->lockTBL($mode)																// Lock/unlock current working db
	$mydb->createTBL($setting)													// create db
	$mydb->deleteTBL()																	// delete db
	$mydb->emptyTBL()																		// truncate db
	$mydb->insertDate($data, $mode)											// insert data to db
	$mydb->updateDate($data, $row, $mode)								// update db data
	$mydb->queryAll()																		// query all data from db
	$mydb->queryLine($row)															// query one record from some row
	$mydb->queryRnd($rows)															// query random record from db
	$mydb->queryDate($condition, $single, &$fp_pos, &$row_pos)	// query data with some condition
	$mydb->setOrder(&$result, $col, $asc)								// order the result record set
	$mydb->deleteDate($row)															// delete data in some row
	$mydb->getSetting()																	// get current db settings
	$mydb->checkTBL()																		// check if the working db can be used

	External Method : $mydb->MakeDir, $mydb->GetFile
--------------------------------------------------------------------------------------------------------------------*/

class MyDB extends class_common {
	private
		$DB_name	= "",
		$DB_path	= "",
		$DB_file	= "",
		$DB_fp	= null,
		$DB_err	= "",
		$DB_tlen	= 500,
		$DB_maxlen	= 10,
		$DB_separator	= "\0";

	public function init($DB_name, $DB_path="./", $DB_tlen=500) {
		$this->DB_name = $DB_name;
		$this->DB_path = $DB_path;
		$this->DB_tlen = $DB_tlen;
		$this->DB_file = $DB_path."/".$DB_name.".db";
		return;
	}

	public function resetDB($DB_name="", $DB_path="", $DB_tlen=500) {
		$this->closeTBL();
		if(!empty($DB_name)) $this->DB_name = $DB_name;
		if(!empty($DB_path)) $this->DB_path = $DB_path;
		$this->DB_file	= $this->DB_path."/".$this->DB_name.".db";
		$this->DB_err	= "";
		if(!empty($DB_tlen)) $this->DB_tlen = $DB_tlen;
		$this->DB_maxlen = 10;
		$this->DB_separator = "\0";
		return;
	}

	public function openTBL() {
		$this->setMode("r");
		return true;
	}

	public function closeTBL() {
		if($this->DB_fp!=null) {
			fclose($this->DB_fp);
			$this->DB_fp = null;
		}
	}

	public function setMode($mode) {
		$this->closeTBL();
		$this->DB_fp = fopen($this->DB_file, $mode);
		if($this->DB_fp===false) $this->Error("Cannot open file, check your power please!");
		return true;
	}

	public function lockTBL($mode=false) {
		if($this->DB_fp!=null) {
			return flock($this->DB_fp, $mode?LOCK_EX:LOCK_UN);
		}
		return false;
	}

	public function createTBL($setting) {
		if($this->checkTBL()) {
			$this->Error("The specified table already exist in the selected path!");
			return false;
		}
		$content = "";
		$record_max_len = 0;
		$max_count = count($setting);
		for($i=0; $i<$max_count; $i++) {
			if(is_array($setting[$i]) && count($setting[$i])==2 && preg_match("/^\w[\w\d]+$/", $setting[$i][0]) && preg_match("/^\d+$/", $setting[$i][1])) {
				if($setting[$i][1]>0){
					//if($setting[$i][1]>500) $setting[$i][1]=500;
					$record_max_len += $setting[$i][1]+1;
					$content .= $this->DB_separator.$setting[$i][0].":".$setting[$i][1];
				}
			}
		}
		if(strlen($content)==0) {
			$this->Error("Unuseable table setting!");
			return false;
		}
		$record_max_len += 1;
		$content = str_pad($this->DB_tlen+1, $this->DB_maxlen).$this->DB_separator.$record_max_len.$content;
		if(strlen($content)>$this->DB_tlen) {
			$this->Error("Beyond the max column limit!");
			return false;
		}

		$content = str_pad($content, $this->DB_tlen);

		$this->MakeDir(dirname($this->DB_file));
		$this->setMode("w");
		$this->lockTBL(1);
		$this->WriteFile($content."\n", 0);
		$this->lockTBL(0);
		$this->setMode("r");
		return true;
	}

	public function deleteTBL() {
		if(!$this->checkTBL()) return false;
		$this->closeTBL();
		unlink($this->DB_file);
		return true;
	}

	public function emptyTBL() {
		if(!$this->checkTBL()) return false;
		$str = $this->GetFile($this->DB_file, $this->DB_tlen+1)."\n";
		$this->setMode("w");
		$this->lockTBL(1);
		$this->WriteFile($str);
		$this->WriteFile(str_pad($this->DB_tlen+1,$this->DB_maxlen));
		$this->lockTBL(0);
		$this->setMode("r");
		return true;
	}

	public function insertDate($data, $mode=false) {
		if(!$this->checkTBL()) return false;
		$content = "";
		$setting = $this->getSetting(&$max_row);
		if(!$setting) return false;
		$i = 0;
		foreach($setting as $key => $value) {
			if($key == "mydb_max_length" || $key == "mydb_rec_length") continue;
			if($mode) {
				$content .= str_pad(isset($data[$key])?$data[$key]:"", (int)$value).$this->DB_separator;
			} else {
				$content .= str_pad(isset($data[$i])?$data[$i++]:"", (int)$value).$this->DB_separator;
			}
		}
		$this->setMode("r+");
		$this->lockTBL(1);
		$this->WriteFile($content."\n", $setting['mydb_max_length']);
		$setting['mydb_max_length'] += $setting['mydb_rec_length'];
		$this->WriteFile(str_pad($setting['mydb_max_length'],$this->DB_maxlen));
		$this->lockTBL(0);
		$this->setMode("r");
		return true;
	}

	public function updateDate($data, $row, $mode=false) {
		if(!$this->checkTBL()) return false;
		$content = "";
		$setting = $this->getSetting(&$max_row);
		if(!$setting) return false;
		$i = 0;
		foreach($setting as $key => $value) {
			if($key == "mydb_max_length" || $key == "mydb_rec_length") continue;
			if($mode) {
				$content .= str_pad(isset($data[$key])?$data[$key]:"", (int)$value).$this->DB_separator;
			} else {
				$content .= str_pad(isset($data[$i])?$data[$i++]:"", (int)$value).$this->DB_separator;
			}
		}
		$offset = ($this->DB_tlen + 1) + $setting['mydb_rec_length'] * ($row-1);
		$this->setMode("r+");
		$this->lockTBL(1);
		$this->WriteFile($content."\n", $offset);
		$this->lockTBL(0);
		$this->setMode("r");
		return true;
	}

	public function queryAll() {
		if(!$this->checkTBL()) return false;
		$setting = $this->getSetting(&$max_row);
		if(!$setting) return false;
		$offset = $this->DB_tlen + 1;
		$result = array();
		$tmp = array();
		if($this->DB_fp==null) $this->openTBL();
		fseek($this->DB_fp, $offset);
		while (!feof($this->DB_fp) && $setting['mydb_rec_length']>0) {
			$date = fgets($this->DB_fp, $setting['mydb_rec_length']);
			if(strlen(trim($date))<5) continue;
			//if(strlen($date)+1<$setting['mydb_rec_length']) continue;
			$date = explode($this->DB_separator, $date);
			$i = 0;
			foreach($setting as $key => $value) {
				if($key == "mydb_max_length" || $key == "mydb_rec_length") continue;
				$tmp[$key] = isset($date[$i])?trim($date[$i]):"";
				$i++;
			}
			$result[] = $tmp;
		}
		return count($result)==0?false:$result;
	}

	public function queryLine($row=0) {
		if(!$this->checkTBL()) return false;
		$setting = $this->getSetting(&$max_row);
		if(!$setting) return false;
		if($max_row<1) return false;
		if(!is_numeric($row)) $rows = 1;
		if($row<0) $row = mt_rand(1, $max_row);
		if($row>$max_row) $row=$max_row;
		$offset = ($this->DB_tlen+1) + $setting['mydb_rec_length']*($row-1) ;
		if($this->DB_fp==null) $this->openTBL();
		fseek($this->DB_fp, $offset);
		$date = fgets($this->DB_fp, $setting['mydb_rec_length']);
		$date = explode($this->DB_separator, $date);
		$i = 0;
		foreach($setting as $key => $value) {
			if($key == "mydb_max_length" || $key == "mydb_rec_length") continue;
			$tmp[$key] = trim($date[$i]);
			$i++;
		}
		return $tmp;
	}

	public function queryRnd($rows=1) {
		if(!$this->checkTBL()) return false;
		$setting = $this->getSetting(&$max_row);
		if(!$setting) return false;
		if($max_row<1) return false;
		if(!is_numeric($rows)) $rows=1;
		if($rows>$max_row) $rows=$max_row;
		$row_list = ":";
		$result = array();
		while($rows>0) {
			$rnd = mt_rand(1, $max_row);
			if(strpos($row_list, ":{$rnd}:")===false) {
				$row_list .= "{$rnd}:";
				$rows--;
				$result[] = $this->queryLine($rnd);
			}
		}
		return $result;
	}

	public function queryDate($condition, $single=true, &$fp_pos, &$row_pos) {
		if(!$this->checkTBL()) return false;
		$condition = explode("&", $condition);
		$max_count = count($condition);
		for($i=0; $i<$max_count; $i++) {
			if(strpos($condition[$i], ">=")>0) {
				$condition[$i] = explode(">=", $condition[$i]);
				$condition[$i][2] = ">=";
			} elseif(strpos($condition[$i], "<=")>0) {
				$condition[$i] = explode("<=", $condition[$i]);
				$condition[$i][2] = "<=";
			} elseif(strpos($condition[$i], "=")>0) {
				$condition[$i] = explode("=", $condition[$i]);
				$condition[$i][2] = "=";
			} elseif(strpos($condition[$i], ">")>0) {
				$condition[$i] = explode(">", $condition[$i]);
				$condition[$i][2] = ">";
			} elseif(strpos($condition[$i], "<")>0) {
				$condition[$i] = explode("<", $condition[$i]);
				$condition[$i][2] = "<";
			} elseif(strpos($condition[$i], "%")>0) {
				$condition[$i] = explode("%", $condition[$i]);
				$condition[$i][2] = "%";
			}
		}
		$setting = $this->getSetting(&$max_row);
		if(!$setting) return false;
		$fp_pos = $this->DB_tlen + 1;
		if($this->DB_fp==null) $this->openTBL();
		fseek($this->DB_fp, $fp_pos);
		$result = array();
		$tmp = array();
		$row_pos = 1;
		while (!feof($this->DB_fp)) {
			$date = fgets($this->DB_fp, $setting['mydb_rec_length']);
			if(strlen($date)+1<$setting['mydb_rec_length']) continue;
			$date = explode($this->DB_separator, $date);
			$i = 0;
			foreach($setting as $key => $value) {
				if($key == "mydb_max_length" || $key == "mydb_rec_length") continue;
				$tmp[$key] = trim($date[$i]);
				$i++;
			}
			$flag = true;
			$max_count = count($condition);
			for($i=0; $i<$max_count; $i++) {
				$flag &= isset($tmp[$condition[$i][0]]) && (
							($condition[$i][2]=="=" && $tmp[$condition[$i][0]]==$condition[$i][1]) ||
							($condition[$i][2]==">" && $tmp[$condition[$i][0]]>$condition[$i][1]) ||
							($condition[$i][2]==">=" && $tmp[$condition[$i][0]]>=$condition[$i][1]) ||
							($condition[$i][2]=="<" && $tmp[$condition[$i][0]]<$condition[$i][1]) ||
							($condition[$i][2]=="<=" && $tmp[$condition[$i][0]]<=$condition[$i][1]) ||
							($condition[$i][2]=="%" && strpos($tmp[$condition[$i][0]],$condition[$i][1])!==false)
						);
				if(!$flag) break;
			}
			if($flag) {
				if($single) {
					return $tmp;
				} else {
					$tmp['db_row_pos'] = $row_pos;
					$result[] = $tmp;
				}
			}
			$row_pos++;
			$fp_pos = ftell($this->DB_fp);
		}
		$fp_pos = ftell($this->DB_fp);
		$row_pos = false;
		return count($result)==0?false:$result;
	}

	public function deleteDate() {
		if(!$this->checkTBL()) return false;
		$row_list = func_get_args();
		if(count($row_list)==0) return false;
		if(count($row_list)==1 && is_array($row_list[0])) $row_list = $row_list[0];
		$setting = $this->getSetting(&$max_row);
		if(!$setting) return false;
		$this->setMode("r+");
		$this->lockTBL(1);
		$max_count = count($row_list);
		for($i=0; $i<$max_count; $i++) {
			if(!is_numeric($row_list[$i]) || $row_list[$i]<1) continue;
			$row = $row_list[$i]-1;
			if($max_row<=$row) continue;
			$offset = ($this->DB_tlen + 1) + $setting['mydb_rec_length'] * $row;
			$this->WriteFile(str_pad("", $setting['mydb_rec_length']-1, " "), $offset);
			$setting['mydb_max_length'] -= $setting['mydb_rec_length'];
		}
		$this->WriteFile(str_pad($setting['mydb_max_length'],$this->DB_maxlen));
		$this->lockTBL(0);
		$content = $this->GetFile($this->DB_file);
		$content = preg_replace("/\n\s+\n/","\n", $content);
		$this->setMode("w");
		$this->lockTBL(1);
		$this->WriteFile($content);
		$this->lockTBL(0);
		$this->setMode("r");
		return true;
	}
	
	public function setOrder(&$result, $col="rand", $desc=false) {
		if(!is_array($result)) return;
		function cmp_asc($a, $b) {
			$a = $a[$GLOBALS['col_name']];
			$b = $b[$GLOBALS['col_name']];
			if ($a == $b) return 0;
			return ($a < $b) ? -1 : 1;
		}
		function cmp_desc($a, $b) {
			$a = $a[$GLOBALS['col_name']];
			$b = $b[$GLOBALS['col_name']];
			if ($a == $b) return 0;
			return ($a > $b) ? -1 : 1;
		}
		function cmp_rand($a, $b) {
			$a = rand();
			$b = rand();
			return ($a > $b) ? -1 : 1;
		}
		if(!isset($result[0][$col])) $col = "rand";
		if($col=="rand") {
			usort($result, "cmp_rand");
		} else {
			$GLOBALS['col_name'] = $col;
			usort($result, $desc?"cmp_desc":"cmp_asc");
			unset($GLOBALS['col_name']);
		}
		return;
	}

	public function getSetting(&$max_row) {
		if(!$this->checkTBL()) return false;
		$str = trim($this->GetFile($this->DB_file, $this->DB_tlen));
		$str = explode($this->DB_separator, $str);
		$setting = array();
		$max_count = count($str);
		for($i=2; $i<$max_count; $i++) {
			$tmp = explode(":", $str[$i]);
			if(count($tmp)==2) $setting[$tmp[0]] =  $tmp[1];
		}
		if(count($str) < 2) return false;
		$setting['mydb_max_length'] = (int)trim($str[0]);
		$setting['mydb_rec_length'] = (int)trim($str[1]);
		if($setting['mydb_rec_length']==0) {
			$max_row = 0;
		} else {
			$max_row = ($setting['mydb_max_length'] - ($this->DB_tlen + 1)) / $setting['mydb_rec_length'];
		}
		return $setting;
	}

	public function checkTBL() {
		if(!file_exists($this->DB_file)) {
			return false;
		} else {
			return true;
		}
	}
	
	public function WriteFile($content, $offset=0) {
		if($this->DB_fp==null) $this->openTBL();
		fseek($this->DB_fp, $offset);
		fwrite($this->DB_fp, $content);
		return true;
	}
}
?>