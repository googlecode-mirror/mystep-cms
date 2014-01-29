<?php
/********************************************
*                                           *
* Name    : MySQL Manager                   *
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
	$MySQL->init($host, $user, $pass, $charse)	// Set the Database Class
	$MySQL->Connect($pconnect = false)		// Build a Connection to MySQL to $MySQL->DB_conn
	$MySQL->ReConnect($pconnect = false)		// Rebuild a Connection to MySQL to $MySQL->DB_conn
	$MySQL->SelectDB($the_db)			// Select a Database of MySQL to $MySQL->DB_select (Must Build Connect First)
	$MySQL->Query($sql)				// Execute a Query of MySQL, Result into $MySQL->DB_resut
	$MySQL->ChangUser($user, $pass, $db="")		// Change the Database User (Unusable in some versoin of MySQL)
	$MySQL->OptimizeTab()				// Optimize the Tablses of Selected Database
	$MySQL->SeekData($line)				// Seek Data Row in the $MySQL->DB_resut ($MySQL->DB_Qtype Must Be Setted into True Before Query)
	$MySQL->GetResult($line, $field="")		// The Same Use as mysql_result ($MySQL->DB_Qtype Must Be Setted into True Before Query)
	$MySQL->GetRS()					// Return The Current Result as an Array and Set the Point of Result to the Next Result
	$MySQL->GetSingleResult($sql)			// Get the first single value of the first line of the recordset
	$MySQL->GetSingleRecord($sql, $mode)			// Get the first line of the recordset
	$MySQL->record()			// Get the first line of the recordset with the parameters of buildSel function
	$MySQL->result()			// Get the single value of the query with the parameters of buildSel function
	$MySQL->result()			// Get the single value of the query with the parameters of buildSel function
	$MySQL->GetStat()				// Get the Current Status of MySQL
	$MySQL->GetDBs()				// Get the Databases List of Current MySQL Server as an Array
	$MySQL->GetTabs($the_db)			// Get the Tables List of Current Selected Database as an Array
	$MySQL->GetIdx($the_tab) 			// Get the Indexes List of a Table as an Array
	$MySQL->GetTabSetting($the_tab)			// Get the Whole Struction of Current Selected Database as an Array
	$MySQL->GetTabData($the_tab)			// Get All of The Data of a Table
	$MySQL->GetTabFields($the_db, $the_tab)		// Get the Columns List of a Table as an Array
	$MySQL->GetQueryFields()			// Get the Columns List of Current Query
	$MySQL->GetInsertId()					// Return auto increment id generate by insert query
	$MySQL->buildCondition($condition, $col_prefix="") // Build query condition string with given parameter
	$MySQL->buildSel_normal($table, $col="*", $condition = array(), $opts = array())				// Build a simple select query according to the given parameter (eg: $condition=array(array("col1","=","value")), array("col2","like","value")), $opts=array("gropu"=>"col", "having"=>$condition,"order"=>"col","limit"=>"0,10"))
	$MySQL->buildSel_join($tab_info, $condition, $opts)		// Build a complicated select query (with join command) according to the given parameter (eg: $tab_info=array(array("name"=>"table_name","col"=>"<col list>","condition"=>$condition,"order"=>"col desc"),array("query"=>"select * from tab","mode"=>"left","join"=>array("col", "tab.col"))))
	$MySQL->buildSel()		// Build a select query with given parameter, combined buildSel_normal with buildSel_join function
	$MySQL->buildDel($table, $condition = array(), $order = "", $limit = "1")  // Build a delete query with given parameter
	$MySQL->buildUpdate($table, $data, $condition = array())  // Build a update query with given parameter
	$MySQL->buildIns($table, $data, $remove_empty = false, $replace = false)  // Build a insert query with given parameter
	$MySQL->buildSQL($table, $data, $mode, $addon = "") // Build any SQL string with given parameter combined all the query build function
	$MySQL->select()		// Build a select query with the parameters of buildSel function and execute it
	$MySQL->insert($table, $data, $remove_empty=false, $execute = true)		// Build a insert query with the parameters of buildIns function and execute it
	$MySQL->replace($table, $data, $execute = true)		// Build a replace query with the parameters of buildIns function and execute it
	$MySQL->update($table, $data, $condition=array(), $execute = true)		// Build a replace query with the parameters of buildIns function and execute it
	$MySQL->delete($table, $condition=array(), $execute = true)		// Build a delete query with the parameters of buildDel function and execute it
	$MySQL->ReadSqlFile($file)			// Read SQL File And Send Content of the File to HandleSQL($strSQL)
	$MySQL->ExeSqlFile($file)			// Read SQL File And Send Content of the File to HandleSQL($strSQL)
	$MySQL->HandleSQL($strSQL)			// Split the SQL Query String into a array from a whole String (Maybe Read from a File)
	$MySQL->BatchExec($ArrSQL)			// Execute Multi Query from an Array (Use HandleSQL First)
	$MySQL->Free()					// Free the $MySQL->DB_result in order to Release the System Resource
	$MySQL->Close(&$err_info = array())					// Close Current MySQL Link
	$MySQL->CheckError()			// Check if error occured
	$MySQL->Error($str)				// Handle the Errors
	$MySQL->GetError(&$err_info = array())				// Get Errors Information
	$MySQL->ClearError()				// Clear Errors Information

--------------------------------------------------------------------------------------------------------------------*/

define('CLIENT_MULTI_RESULTS', 131072);

class MySQL extends class_common {
	public $version = "";
	
	protected
		$DB_host	= "",
		$DB_user	= "",
		$DB_pass	= "",
		$DB_db	= "",
		$DB_conn	= NULL,
		$DB_select	= NULL,
		$DB_error	= false,
		$DB_error_description	= array(),
		$DB_qstr	= "",
		$DB_result	= NULL,
		$DB_count	= 0,
		$DB_RStype	= 1,
		$DB_Qtype	= false,
		$DB_charset	= "gbk";

	public function __construct() {
		$argList = func_get_args();
		if(count($argList)>0){
			call_user_func_array(array($this, "init"), $argList);
		}
		return;
	}

	public function init($host, $user, $pass, $charset="Latin1") {
		$this->DB_host = $host;
		$this->DB_user = $user;
		$this->DB_pass = $pass;
		if(strtolower($charset)=="utf-8") $charset = "utf8";
		$this->DB_charset = $charset;
		return;
	}

	public function Connect($pconnect = false, $the_db = "") {
		if($pconnect) {
			$this->DB_conn = mysql_pconnect($this->DB_host, $this->DB_user, $this->DB_pass);
		} else {
			$this->DB_conn = mysql_connect($this->DB_host, $this->DB_user, $this->DB_pass, true);
		}
		$this->DB_qstr = "none (Connect to MySQL Server)";
		if($this->CheckError())	$this->Error("Could not connect to MySQL Server", true);
		$this->version = mysql_get_server_info($this->DB_conn);
		if($this->version > '5.0.1') {
			@mysql_query("SET sql_mode=''", $this->DB_conn);
		}
		$this->setCharset();
		if(!empty($the_db)) $this->SelectDB($the_db);
		return;
	}

	public function ReConnect($pconnect = false, $the_db = "") {
		if($this->DB_conn != NULL) $this->Close();
		$this->Connect($pconnect, $the_db);
		return;
	}

	public function checkConnect($pconnect = true, $the_db = "") {
		if(mysql_ping($this->DB_conn)===false) {
			$this->ReConnect($pconnect, $the_db);
		}
		return;
	}
	
	public function setCharset($charset="") {
		if(empty($charset)) $charset = $this->DB_charset;
		if(strtolower($charset)=="utf-8") $charset = "utf8";
		if(function_exists("mysql_set_charset")) {
			mysql_set_charset($charset, $this->DB_conn);
		} else {
			mysql_query("SET CHARACTER SET '".$charset."'", $this->DB_conn);
			mysql_query("SET NAMES '".$charset."'", $this->DB_conn);
			if($charset_collate = $this->GetSingleRecord("SHOW CHARACTER SET LIKE '".$charset."'")) {
				mysql_query("SET COLLATION_CONNECTION='".$charset_collate["Default collation"]."'", $this->DB_conn);
			}
		}
		if($this->CheckError())	$this->Error("Unknow CharSet Name");
	}

	public function SelectDB($the_db) {
		if($this->DB_conn == NULL) return false;
		$this->DB_db	 = $the_db;
		$this->DB_select = mysql_select_db($the_db, $this->DB_conn);
		$this->DB_qstr	 = "none (Select Database)";
		if($this->CheckError())	$this->Error("Could not connect to the Database");
		return true;
	}

	public function Query($sql) {
		if($this->DB_conn == NULL) return false;
		$this->DB_count++;
		$this->Free();
		$sql = str_replace("  ", " ", $sql);
		$sql = str_replace("1=1 and", "", $sql);
		$sql = str_replace("where 1=1 order", "order", $sql);
		$sql = str_replace("where (1=1) order", "order", $sql);
		if($this->DB_Qtype) {
			$this->DB_result = mysql_query($sql, $this->DB_conn);
		} else {
			$this->DB_result = mysql_unbuffered_query($sql, $this->DB_conn);
		}
		$this->DB_qstr	= $sql;
		if(strstr("|selec|show |descr|expla|repai|check|optim", strtolower(substr(trim($sql), 0, 5))) && is_resource($this->DB_result)) {
			$num_rows = mysql_num_rows($this->DB_result);
		} elseif(is_resource($this->DB_conn)) {
			$num_rows = mysql_affected_rows($this->DB_conn);
			$this->Free();
		} else {
			$num_rows = 0;
		}
		if($this->CheckError())	{
			$this->Error("Error Occur in Query !");
			$num_rows = false;
		}
		return $num_rows;
	}

	public function ChangUser($user, $pass, $db="", $pconnect = false) {
		$this->DB_user = $user;
		$this->DB_pass = $pass;
		if(function_exists("mysql_change_user")) {
			if(empty($db)) {
				$result = mysql_change_user($user, $pass);
			} else {
				$result = mysql_change_user($user, $pass, $db);
			}
		} else {
			$this->ReConnect($pconnect, $db);
		}
		return $result;
	}

	public function OptimizeTab() {
		if($this->DB_select == NULL || $this->DB_conn == NULL) return false;
		if(func_num_args()==0) {
			$tabs = $this->GetTabs($this->DB_db);
		} else {
			$tabs = func_get_args();
		}
		$max_count = count($tabs);
		for($i=0; $i<$max_count; $i++) {
			$this->Query("OPTIMIZE TABLE ".$tabs[$i]);
		}
		$this->Free();
		return true;
	}

	public function SeekData($line) {
		if(!$this->DB_Qtype || $this->DB_result == NULL) return false;
		$flag = mysql_data_seek($this->DB_result, $line);
		if($this->CheckError())	$this->Error("Error Occur in Query !");
		return $flag;
	}

	public function GetResult($line, $field=""){
		if(!$this->DB_Qtype || $this->DB_result == NULL) return false;
		if(empty($field)) {
			$result = mysql_result($this->DB_result, $line);
		} else {
			$result = mysql_result($this->DB_result, $line, $field);
		}
		if($this->CheckError())	$this->Error("Error Occur in Query !");
		return $result;
	}
	
	public function GetSingleResult($sql){
		$DB_Qtype_org = $this->DB_Qtype;
		$this->DB_Qtype = true;
		$row_num = $this->Query($sql);
		$result = ($row_num>0 ? $this->GetResult(0) : false);
		$this->DB_Qtype = $DB_Qtype_org;
		$this->free();
		return $result;
	}
	
	public function result(){
		$sql = call_user_func_array(array($this, "buildSel"), func_get_args());
		return $this->GetSingleResult($sql);
	}
	
	public function GetRecord($sql){
		$result = array();
		$this->Query($sql);
		while($result[] = $this->GetRS()) {}
		array_pop($result);
		$this->free();
		return $result;
	}

	public function GetSingleRecord($sql, $mode = true){
		$DB_Qtype_org = $this->DB_Qtype;
		$this->DB_Qtype = true;
		$row_num = $this->Query($sql);
		if($row_num>0) {
			$result = $this->GetRS();
			if($mode==false) $result = array_values($result);
		} else {
			$result = false;
		}
		$this->DB_Qtype = $DB_Qtype_org;
		$this->free();
		return $result;
	}
	
	public function record(){
		$sql = call_user_func_array(array($this, "buildSel"), func_get_args());
		return $this->GetSingleRecord($sql);
	}

	public function GetInsertId(){
		$the_id = mysql_insert_id($this->DB_conn);
		if($the_id <= 0) $the_id = $this->GetSingleResult("SELECT last_insert_id()");
		return ($the_id?$the_id:0);
	}

	public function GetRS(){
		if($this->DB_result == NULL) return false;
		switch($this->DB_RStype){
			case 1:
				$flag = ($row = mysql_fetch_assoc($this->DB_result));
				break;
			case 2:
				$flag = ($row = mysql_fetch_row($this->DB_result));
				break;
			case 3:
				$flag = ($row = mysql_fetch_array($this->DB_result));
				break;
			default:
				$flag = ($row = mysql_fetch_assoc($this->DB_result));
		}
		$this->DB_qstr	= "none(Get Recordset)";
		if($this->CheckError())	$this->Error("Error Occur in Get Recordset !");
		return ($flag?$row:false);
	}

	public function GetStat() {
		if($this->DB_conn == NULL) return "";
		$result = array(
			"MySQL server version" => mysql_get_server_info($this->DB_conn),
			"MySQL protocol version" => mysql_get_proto_info($this->DB_conn),
			"MySQL host info" => mysql_get_host_info($this->DB_conn),
			"MySQL client info" => mysql_get_client_info($this->DB_conn),
			"More info" => str_replace("  ","\n",mysql_stat($this->DB_conn)),
			"Process list" => implode("\n", $this->GetProcesses()),
		);
		return $result;
	}
	
	public function GetProcesses($mode=0, $time_limit=0) {
		if($this->DB_conn == NULL) return "";
		$result = array();
		$rs = mysql_list_processes($this->DB_conn);
		while ($row = mysql_fetch_assoc($rs)) {
			if($row["Time"]<$time_limit) continue;
			if($mode==1){
				$result[] = $row;
			} elseif($mode==2) {
				$result[] = $row['Id'];
			} else {
				$result[] = sprintf("%s - %s (%s)", $row["Id"], empty($row["Info"])?$row["Command"]:$row["Info"], $row["Time"]);
			}
		}
		return $result;
	}

	public function GetDBs() {
		$this->Free();
		$dbs = array();
		$this->DB_result = mysql_list_dbs($this->DB_conn);
		$this->DB_qstr	 = "none (List Databases)";
		if ($this->CheckError()) $this->Error("Could not List Databases");
		$dbs = array();
		$num_dbs = mysql_num_rows($this->DB_result);
		for ($i = 0; $i < $num_dbs; $i++) {
			$dbs[] = mysql_dbname($this->DB_result, $i);
		}
		$this->Free();
		return $dbs;
	}

	public function GetTabs($the_db, $pattern="") {
		$this->Free();
		$this->DB_qstr	 = "SHOW TABLES FROM $the_db".(empty($pattern)?"":" like '%{$pattern}%'");
		$this->DB_result = mysql_query($this->DB_qstr);
		if ($this->CheckError()) $this->Error("Could not List Tables");
		$tabs = array();
		$num_tabs = mysql_num_rows($this->DB_result);
		for ($i = 0; $i < $num_tabs; $i++) {
			$tabs[] = mysql_tablename($this->DB_result, $i);
		}
		$this->Free();
		return $tabs;
	}

	public function GetIdx($the_tab) {
		$this->Free();
		$this->DB_qstr	 = "SHOW INDEX FROM $the_tab";
		$this->DB_result = mysql_query($this->DB_qstr);
		if ($this->CheckError()) $this->Error("Could not List Table's Setting");
		$idxes = array();
		while($row = mysql_fetch_array($this->DB_result)){
			if($row["Key_name"] != "PRIMARY") {
				$tmp = "`".$row["Column_name"]."`";
				if($row["Sub_part"] != "") $tmp .= "(".$row["Sub_part"].")";
				if($row["Seq_in_index"] == 1) {
					if(count($idxes) != 0)
						$idxes[count($idxes)-1] .= ")";
					$idxes[] = "INDEX `".$row["Key_name"]."` (".$tmp;
				} else {
					$idxes[count($idxes)-1] .= ", $tmp";
				}
			}
		}
		if(count($idxes) != 0)
			$idxes[count($idxes)-1] .= ")";
		$this->Free();
		return $idxes;
	}

	public function GetPri($the_tab) {
		$this->Free();
		$this->DB_qstr	 = "SHOW FIELDS FROM $the_tab";
		$this->DB_result = mysql_query($this->DB_qstr);
		if ($this->CheckError()) $this->Error("Could not List Table's Setting");
		$keys	= "";
		while($row = mysql_fetch_assoc($this->DB_result)) {
			if($row["Key"] == "PRI" || $row["Key"] == "MUL")
				$keys[]	= $row["Field"];
		}
		$this->Free();
		return $keys;
	}

	public function GetTabSetting($the_tab, $the_db="") {
		if(empty($the_db)) $the_db = $this->DB_db;
		$this->DB_qstr	 = "SHOW TABLE STATUS FROM `{$the_db}` LIKE '{$the_tab}'";
		$this->DB_result = mysql_query($this->DB_qstr);
		if ($this->CheckError()) $this->Error("Could not List Table's Setting");
		$row = mysql_fetch_assoc($this->DB_result);
		$result = "#Table Name: ".$row["Name"]."\n# Create Time: ".$row["Create_time"]."\n# Update Time: ".$row["Update_time"]."\n";
		$this->Free();
		$tblInfo = array_values($this->getSingleRecord("show create table `".$the_db."`.`".$the_tab."`"));
		$result .= $tblInfo[1].";\n";
		$result .= "truncate table `".$the_tab."`;\n";
		return $result;
	}
	
	public function GetTabData($the_tab) {
		$this->Free();
		$the_tab = str_replace(".", "`.`", $the_tab);
		$the_tab = "`".str_replace("``", "`", $the_tab)."`";
		$this->DB_qstr	 = "SELECT * FROM ".$the_tab;
		$this->DB_result = mysql_query($this->DB_qstr);
		if ($this->CheckError()) $this->Error("Could not List Table's Setting");
		$result = "";
		while($row = mysql_fetch_row($this->DB_result)) {
			$result .= "INSERT INTO `{$the_tab}` VALUES (";
			$max_count = count($row);
			for($i=0; $i<$max_count; $i++) {
				//if(!is_numeric($row[$i])) $row[$i] = "0x".strToHex($row[$i]);
				//$result .= $row[$i].", ";
				$row[$i] = str_replace("\\", "\\\\", $row[$i]);
				$row[$i] = str_replace("\r", "\\r", $row[$i]);
				$row[$i] = str_replace("\n", "\\n", $row[$i]);
				$row[$i] = str_replace("'", "\\'", $row[$i]);
				$result .= "'".$row[$i]."', ";
			}
			$result .= ");\n";
		}
		//$result = str_replace(", );",");",$result);
		$result = str_replace("', );","');",$result);
		return $result;
	}

	public function GetTabFields($the_db, $the_tab) {
		$this->Free();
		$this->DB_result = mysql_list_fields($the_db, $the_tab, $this->DB_conn);
		$this->DB_qstr	 = "none (List Fields of $the_tab)";
		if ($this->CheckError()) $this->Error("Could not List Fields");
		$fields = array();
		$columns = mysql_num_fields($this->DB_result);
		for ($i = 0; $i<$columns; $i++) {
			$fields[] = mysql_field_name($this->DB_result, $i);
		}
		$this->Free();
		return $fields;
	}

	public function GetQueryFields() {
		if($this->DB_result == NULL) return false;
		$fields = array();
		$columns = mysql_num_fields($this->DB_result);
		for ($i = 0; $i<$columns; $i++) {
			$fields[] = mysql_field_name($this->DB_result, $i);
		}
		return $fields;
	}
	
	public function buildCondition($condition, $col_prefix="") {
		if(is_string($condition)) {
			if(strpos($condition,'$')!==false) return $condition;
			if(!empty($col_prefix)) {
				$condition = str_replace("`", "", $condition);
				$condition = preg_replace("/([a-z]\w+)/i", "`\\1`", $condition);
				$condition = str_ireplace("`or`", "or", $condition);
				$condition = str_ireplace("`and`", "and", $condition);
				$condition = preg_replace("/`(\w+)`\(/", "\\1", $condition);
				$condition = preg_replace("/\s`/", " `".$col_prefix."`.`", $condition);
				$condition = preg_replace("/\(`/", "(`".$col_prefix."`.`", $condition);
				$condition = preg_replace("/`(\w+)`\s+`(\w+)`\s+/", "`\\1` \\2 ", $condition);
			} else {
				if(strpos($condition, "`")===false) {
					$condition = preg_replace("/([a-z]\w+)/i", "`\\1`", $condition);
					$condition = str_ireplace("`or`", "or", $condition);
					$condition = str_ireplace("`and`", "and", $condition);
					$condition = preg_replace("/`(\w+)`\(/", "\\1(", $condition);
					$condition = preg_replace("/`(\w+)`\s+`(\w+)`\s+/", "`\\1` \\2 ", $condition);
				}
			}
			return "(".$condition.")";
		}
		if(is_string($condition[0])) {
			$condition = array($condition);
		}
		$result = " (";
		for($i=0,$m=count($condition);$i<$m;$i++) {
			if(is_array($condition[$i][0])) {
				$mode = array_pop($condition[$i]);
				if(is_array($mode)) {
					$condition[$i][] = $mode;
					$mode = "and";
				}
				if($i>0) {
					$result .= " ".$mode." ";
				}
				$result .= $this->buildCondition($condition[$i], $col_prefix);
				continue;
			}
			if(count($condition[$i])==2) {
				$condition[$i][2] = $condition[$i][1];
				$condition[$i][1] = "=";
			}
			if($i>0) $result .= " ".(isset($condition[$i][3]) ? $condition[$i][3] : "and")." ";
			$func_col = "";
			if(!empty($col_prefix)) $prefix = "`".$col_prefix."`.";
			if(is_array($condition[$i][0])) {
				$func_col = $condition[$i][0][1];
				$condition[$i][0] = $condition[$i][0][0];
			}
			//$condition[$i][0] = preg_replace("/[".preg_quote("\"'`~!@#$%^&*[]{};:<>?\\")."]/", "", $condition[$i][0]);
			if(strpos($condition[$i][0],"(")===false) {
				$condition[$i][0] = "`".str_replace(".", "`.`", $condition[$i][0])."`";
			} else {
				$condition[$i][0] = preg_replace("/\((\w+)\)/", "(`\\1`)", $condition[$i][0]);
			}
			if(strpos($condition[$i][2], '$')!==false) {
				$condition[$i][1] = preg_replace("/^(n|f)(.{1,2})$/", '\2', $condition[$i][1]);
				$result .= $prefix.$condition[$i][0]." ".$condition[$i][1];
				if(stripos($condition[$i][1], 'like')!==false) {
					$result .= " %".$condition[$i][2]."%";
				} else {
					$result .= " (".$condition[$i][2].")";
				}
			} else {
				switch(strtolower(trim($condition[$i][1]))) {
					case "=":
					case "<":
					case "<=":
					case ">":
					case ">=":
					case "<>":
					case "!=":
						if(!empty($func_col)) {
							if(preg_match("/([ymdqwh])(\+|\-)(\d+)/i",$func_col,$match)) {
								if(!preg_match("/^\w+$/", $condition[$i][2])) $condition[$i][2] = "'".preg_replace("/[^\d\-]+/", "", $condition[$i][2])."'";
								switch(strtolower($match[1])) {
									case "y": $match[1] = "YEAR"; break;
									case "m": $match[1] = "MONTH"; break;
									case "d": $match[1] = "DAY"; break;
									case "q": $match[1] = "QUARTER"; break;
									case "w": $match[1] = "WEEK"; break;
									default: $match[1] = "HOUR";
								}
								if($match[1]=="-") {
									$result .= "DATE_SUB(".$prefix.$condition[$i][0].",INTERVAL ".$match[3]." ".$match[1].") ".$condition[$i][1]." ".$condition[$i][2];
								} else {
									$result .= "DATE_ADD(".$prefix.$condition[$i][0].",INTERVAL ".$match[3]." ".$match[1].") ".$condition[$i][1]." ".$condition[$i][2];
								}
							} else {
								$result .= $prefix.$condition[$i][0]." ".$condition[$i][1]." '".mysql_real_escape_string($condition[$i][2])."'";
							}
						} else {
							$result .= $prefix.$condition[$i][0]." ".$condition[$i][1]." '".mysql_real_escape_string($condition[$i][2])."'";
						}
						break;
					case "n=":
					case "n<":
					case "n<=":
					case "n>":
					case "n>=":
					case "n<>":
					case "n!=":
						$condition[$i][1] = str_replace("n", "", $condition[$i][1]);
						$result .= $prefix.$condition[$i][0].$condition[$i][1].intval($condition[$i][2]);
						break;
					case "f=":
					case "f<":
					case "f<=":
					case "f>":
					case "f>=":
					case "f<>":
					case "f!=":
						$condition[$i][1] = str_replace("f", "", $condition[$i][1]);
						$result .= $prefix.$condition[$i][0].$condition[$i][1].$condition[$i][2];
						break;
					case "like":
					case "like binary":
					case "not like":
					case "not like binary":
						$result .= $prefix.$condition[$i][0]." ".$condition[$i][1];
						$condition[$i][2] = mysql_real_escape_string($condition[$i][2]);
						if(strpos($condition[$i][2], "%")!==false) {
							$result .= " '".$condition[$i][2]."'";
						} else {
							$result .= " '%".$condition[$i][2]."%'";
						}
						break;
					case "rlike":
					case "regexp":
					case "rlike binary":
					case "regexp binary":
					case "not rlike":
					case "not regexp":
					case "not rlike binary":
					case "not regexp binary":
						$result .= $prefix.$condition[$i][0]." ".$condition[$i][1]." '".$condition[$i][2]."'";
						break;
					case "in":
					case "nin":
					case "not in":
					case "not nin":
						if(is_string($condition[$i][2])) {
							$condition[$i][2] = str_replace("'", "", $condition[$i][2]);
							$condition[$i][2] = str_replace("\"", "", $condition[$i][2]);
							$condition[$i][2] = str_replace(", ", ",", $condition[$i][2]);
							$condition[$i][2] = explode(",", $condition[$i][2]);
						}
						if(strlen($condition[$i][1])==2 || strlen($condition[$i][1])==6) {
							$condition[$i][2] = array_map("mysql_real_escape_string", $condition[$i][2]);
							$condition[$i][2] = "'".implode("','", $condition[$i][2])."'";
						} else {
							$condition[$i][2] = array_map("intval", $condition[$i][2]);
							$condition[$i][2] = implode(",", $condition[$i][2]);
						}
						$condition[$i][1] = str_replace("nin", "in", $condition[$i][1]);
						$result .= $prefix.$condition[$i][0]." ".$condition[$i][1]." (".$condition[$i][2].")";
						break;
					case "is":
					case "is not":
						if(is_null($condition[$i][2])) $condition[$i][2] = "NULL";
						$result .= $prefix.$condition[$i][0]." ".$condition[$i][1]." ".$condition[$i][2];
						break;
					default:
						$result .= $prefix.$condition[$i][0]." = '".mysql_real_escape_string($condition[$i][2])."'";
						break;
				}
			}
		}
		$result .= ") ";
		if(strlen($result)<5)  $result = " true ";
		return $result;
	}
	
	public function buildSel_normal($table, $col="*", $condition = array(), $opts = array()) {
		$result = "select ";
		if(empty($col)) $col = "*";
		if($col != "*") {
			if(is_string($col)) $col = explode(",", str_replace(", ", ",", $col));
			$col_func = create_function('$item', '
				if(is_array($item)) {
					$item[0] = trim($item[0]);
					if(stripos($item[0],"distinct")!==false) {
						$item[0] = preg_replace("/(\w+)$/", "`\\\\1`", $item[0]);
					} elseif(strpos($item[0],"(")===false) {
						$item[0] = "`".str_replace(".", "`.`", $item[0])."`";
					} else {
						$item[0] = preg_replace("/\((\w+)\)/", "(`\\\\1`)", $item[0]);
					}
					$item = $item[0]." as `".$item[1]."`";
				} else {
					if(stripos($item,"distinct")!==false) {
						$item = preg_replace("/(\w+)$/", "`\\\\1`", $item);
					} elseif(strpos($item,"(")===false) {
						$item = "`".str_replace(".", "`.`", $item)."`";
						$item = preg_replace("/\s+as\s+/i", "` as `", $item);
					} else {
						$item = preg_replace("/\((\w+)\)/", "(`\\\\1`)", $item);
						$item = preg_replace("/\s+as\s+(\w+)/i", " as `\\\\1`", $item);
					}
				}
				return $item;
			');
			$col = array_map($col_func, $col);
			$col_list = implode(", ", $col);
		} else {
			$col_list = "*";
		}
		if(strpos($table, "`")===false) {
			$table = str_replace(" as ", " ", $table);
			$table = str_replace(" ", "` `", $table);
			$table = str_replace(".", "`.`", $table);
			$table = "`".$table."`";
		}
		$result .= $col_list." from ".$table." ";
		if(!empty($condition)) {
			if(is_array($condition)) $condition = $this->buildCondition($condition);
			$result .= "where ".$condition;
		}
		if(isset($opts['condition']) && !empty($opts['condition'])) {
			if(strpos($result, "where")==false) {
				$result .= " where ".$this->buildCondition($opts['condition']);
			} else {
				$result .= " and ".$this->buildCondition($opts['condition']);
			}
		}
		if(isset($opts['group'])) {
			$opts['group'] = preg_replace("/[^\w,]/", "", $opts['group']);
			$result .= " group by `".str_replace(",","`,`",$opts['group'])."`";
			if(isset($opts['having'])) {
				$result .= " having ".$this->buildCondition($opts['having']);
			}
		}
		if(isset($opts['order'])) {
			if(is_array($opts['order'])) $opts['order'] = implode(",", $opts['order']);
			$opts['order'] = preg_replace("/[^\/,\(\)\w\s]/", "", $opts['order']);
			$opts['order'] = preg_replace("/(\w+)/", "`\\1`", $opts['order']);
			$opts['order'] = preg_replace("/`(\w+)`\(/", "\\1(", $opts['order']);
			$opts['order'] = preg_replace("/\s+`((de|a)sc)`/i", " \\1", $opts['order']);
			$result .= " order by ".$opts['order'];
		}
		if(isset($opts['limit']) && !empty($opts['limit'])) {
			if(strpos($opts['limit'], '$')===false) $opts['limit'] = preg_replace("/[^,\d]/", "", $opts['limit']);
			$result .= " limit ".$opts['limit'];
		}
		return $result;
	}
	
	public function buildSel_join($tab_info, $condition = array(), $opts = array()) {
		$tab_list = "";
		$col_list = array();
		$condition_list = "";
		$order_list = "";
		for($i=0,$m=count($tab_info); $i<$m; $i++) {
			if(!isset($tab_info[$i]['idx'])) $tab_info[$i]['idx'] = "t".$i;
			//for join			
			if($i==0) {
				if(isset($tab_info[$i]['query'])) {
					$tab_list = " from (".$tab_info[$i]['query'].")";
				} else {
					$tab_list = " from `".str_replace(".", "`.`", $tab_info[$i]['name'])."`";
				}
				$tab_list .= " as `".$tab_info[$i]['idx']."`";
			} else {
				if(!isset($tab_info[$i]['mode'])) $tab_info[$i]['mode'] = "left";
				$tab_list .= " ".$tab_info[$i]['mode']." join ";
				if(isset($tab_info[$i]['query'])) {
					$tab_list .= "(".$tab_info[$i]['query'].")";
				} else {
					$tab_list .= "`".str_replace(".", "`.`", $tab_info[$i]['name'])."`";
				}
				$tab_list .= " as `".$tab_info[$i]['idx']."` on ";
				if(is_string($tab_info[$i]['join'])) {
					if(strpos($tab_info[$i]['join'], ",")!=false) {
						$tab_info[$i]['join'] = explode(",", $tab_info[$i]['join']);
						for($j=0,$n=count($tab_info[$i]['join']);$j<$n;$j++) {
							if($j>0) $tab_list .= " and ";
							$tab_list .= "`".$tab_info[0]['idx']."`.`".$tab_info[$i]['join'][$j]."` = `".$tab_info[$i]['idx']."`.`".$tab_info[$i]['join'][$j]."`";
						}
					} else {
						$tab_list .= "`".$tab_info[0]['idx']."`.`".$tab_info[$i]['join']."` = `".$tab_info[$i]['idx']."`.`".$tab_info[$i]['join']."`";
					}
				} else {
					if(!is_array($tab_info[$i]['join'][0])) $tab_info[$i]['join'] = array($tab_info[$i]['join']);
					for($j=0,$n=count($tab_info[$i]['join']);$j<$n;$j++) {
						if($j>0) $tab_list .= " and ";
						$tab_list .= "`".$tab_info[$i]['idx']."`.`".$tab_info[$i]['join'][$j][0]."` = `".str_replace(".", "`.`", $tab_info[$i]['join'][$j][1])."`";
					}
				}
			}
			//for column
			if(!isset($tab_info[$i]['col']) || empty($tab_info[$i]['col'])) {
				//dummy
			} elseif($tab_info[$i]['col']=="*") {
				$col_list[] = $tab_info[$i]['idx'].".*";
			} else {
				if(is_string($tab_info[$i]['col'])) {
					$tab_info[$i]['col'] = str_replace(", ", ",", $tab_info[$i]['col']);
					$tab_info[$i]['col'] = explode(",", $tab_info[$i]['col']);
				}
				for($j=0,$n=count($tab_info[$i]['col']);$j<$n;$j++) {
					if(strpos($tab_info[$i]['col'][$j],"(")===false) {
						$tab_info[$i]['col'][$j] = "`".$tab_info[$i]['idx']."`.`".$tab_info[$i]['col'][$j]."`";
						$tab_info[$i]['col'][$j] = str_replace("`*`","*",$tab_info[$i]['col'][$j]);
						$tab_info[$i]['col'][$j] = str_replace(" as ","` as `",$tab_info[$i]['col'][$j]);
					} else {
						$tab_info[$i]['col'][$j] = preg_replace("/\((\w+)\)/", "(`".$tab_info[$i]['idx']."`.`\\1`)", $tab_info[$i]['col'][$j]);
					}
				}
				$col_list = array_merge($col_list, $tab_info[$i]['col']);
			}
			if($col_flag && $i<$m-1) $col_list .= ",";
			//for condition
			if(isset($tab_info[$i]['condition']) && !empty($tab_info[$i]['condition'])) {
				if(!empty($condition_list)) $condition_list .= " and ";
				$condition_list .= $this->buildCondition($tab_info[$i]['condition'], $tab_info[$i]['idx']);
			}
			//for order
			if(isset($tab_info[$i]['order'])) {
				if(!empty($order_list)) $order_list .= " , ";
				if(is_string($tab_info[$i]['order'])) {
					$tab_info[$i]['order'] = str_replace(", ", ",", $tab_info[$i]['order']);
					$tab_info[$i]['order'] = explode(",", $tab_info[$i]['order']);
				}
				for($j=0,$n=count($tab_info[$i]['order']);$j<$n;$j++) {
					$tab_info[$i]['order'][$j] = str_replace("`", "", trim($tab_info[$i]['order'][$j]));
					if(strpos($tab_info[$i]['order'][$j],"(")===false) {
						$tab_info[$i]['order'][$j] = $tab_info[$i]['idx'].".`".$tab_info[$i]['order'][$j]."`";
						$tab_info[$i]['order'][$j] = preg_replace("/\s+(\w*)`$/", "` \\1", $tab_info[$i]['order'][$j]);
					} else {
						$tab_info[$i]['order'][$j] = preg_replace("/\((\w+)\)/", "(".$tab_info[$i]['idx'].".`\\1`)", $tab_info[$i]['order'][$j]);
					}
				}
				$order_list .= implode(", ", $tab_info[$i]['order']);
			}
		}
		
		if(!empty($condition)) {
			if(is_array($condition)) $condition = $this->buildCondition($condition);
			if(empty($condition_list)) {
				$condition_list = $condition;
			} else {
				$condition_list .= " and (".$condition.")";
			}
		}
		if(!empty($condition_list)) $condition_list = " where ".$condition_list;
		
		if(isset($opts['condition']) && !empty($opts['condition'])) {
			if(empty($condition_list)) {
				$condition_list .= " where ".$this->buildCondition($opts['condition']);
			} else {
				$condition_list .= " and ".$this->buildCondition($opts['condition']);
			}
		}
		if(isset($opts['order'])) {
			if(is_array($opts['order'])) $opts['order'] = implode(",", $opts['order']);
			$opts['order'] = preg_replace("/[^\/,\.\w\s\(\)]/", "", $opts['order']);
			$opts['order'] = preg_replace("/(\w+)/", "`\\1`", $opts['order']);
			$opts['order'] = preg_replace("/`(\w+)`\(/", "\\1(", $opts['order']);
			$opts['order'] = preg_replace("/\s+`((de|a)sc)`/i", " \\1", $opts['order']);
			if(!empty($order_list)) {
				$order_list .= ", ".$opts['order'];
			} else {
				$order_list = $opts['order'];
			}
		}
		if(!empty($order_list)) $order_list = " order by ".$order_list;

		$limit = "";
		if(isset($opts['limit']) && !empty($opts['limit'])) {
			$limit = $opts['limit'];
			if(strpos($opts['limit'], '$')===false) $limit = preg_replace("/[^,\d]/", "", $opts['limit']);
			$limit = " limit ".$limit;
		}
		return "select ".implode(",", $col_list).$tab_list.$condition_list.$order_list.$limit;
	}
	
	public function buildSel() {
		$args = func_get_args();
		if(is_array($args[0])) {
			$sql = call_user_func_array(array($this, "buildSel_join"), $args);
		} else {
			$sql = call_user_func_array(array($this, "buildSel_normal"), $args);
		}
		return $sql;
	}
	
	public function buildDel($table, $condition = array(), $order = "", $limit = "1") {
		$result = "";
		if(!empty($condition)) {
			if(is_array($condition)) $condition = $this->buildCondition($condition);
		}
		if(is_string($table)) {
			if(strpos("`",$table)===false) {
				$table = "`".str_replace(".","`.`",$table)."`";
			}
			if(empty($condition) && empty($order)) {
				$result = "truncate table ".$table;
			} else {
				$result = "delete LOW_PRIORITY from ".$table." where ".$condition;
				if(!empty($order)) $result .= " order by ".$order." limit ".$limit;
			}
		} else {
			$tab_list = "";
			$idx_list = array();
			$condition_list = "";
			for($i=0,$m=count($table);$i<$m;$i++) {
				if(!isset($table[$i]['del'])) $table[$i]['del'] = true;
				if(!isset($table[$i]["idx"])) $table[$i]["idx"] = "t".$i;
				if($table[$i]['del']) $idx_list[] = "`".$table[$i]['idx']."`";
				if($i==0) {
					$tab_list = " from `".str_replace(".", "`.`", $table[$i]['name'])."` as ".$table[$i]['idx'];
				} else {
					if(!isset($table[$i]['mode'])) $table[$i]['mode'] = "left";
					$tab_list .= " ".$table[$i]['mode']." join `".$table[$i]['name']."` as ".$table[$i]['idx']." on ";
					if(is_string($table[$i]['join'])) {
						if(strpos($table[$i]['join'], ",")!=false) {
							$table[$i]['join'] = explode(",", $table[$i]['join']);
							for($j=0,$n=count($table[$i]['join']);$j<$n;$j++) {
								if($j>0) $tab_list .= " and ";
								$tab_list .= "`".$table[0]['idx']."`.`".$table[$i]['join'][$j]."` = `".$table[$i]['idx']."`.`".$table[$i]['join'][$j]."`";
							}
						} else {
							$tab_list .= "`".$table[0]['idx']."`.`".$table[$i]['join']."` = `".$table[$i]['idx']."`.`".$table[$i]['join']."`";
						}
					} else {
						if(!is_array($table[$i]['join'][0])) $table[$i]['join'] = array($table[$i]['join']);
						for($j=0,$n=count($table[$i]['join']);$j<$n;$j++) {
							if($j>0) $tab_list .= " and ";
							$tab_list .= "`".$table[$i]['idx']."`.`".$table[$i]['join'][$j][0]."` = `".str_replace(".", "`.`", $table[$i]['join'][$j][1])."`";
						}
					}
				}
				if(isset($table[$i]['condition']) && !empty($table[$i]['condition'])) {
					if(!empty($condition_list)) $condition_list .= " and ";
					$condition_list .= $this->buildCondition($table[$i]['condition'], $table[$i]["idx"]);
				}
			}
			$result = "delete ".implode(",", $idx_list).$tab_list;
			if(!empty($condition)) {
				if(empty($condition_list)) {
					$condition_list = $condition;
				} else {
					$condition_list .= " and (".$condition.")";
				}
				$result .= "where ".$condition_list;
			}
			if(!empty($order)) $result .= " order by ".$order." limit ".$limit;
		}
		return $result;
	}
	
	public function buildUpdate($table, $data, $condition = array()) {
		$result = "update LOW_PRIORITY ";
		$condition_list = "";
		if(!empty($condition)) {
			if(is_array($condition)) $condition = $this->buildCondition($condition);
		}
		if(count($data)==2 && is_string($data[0])) $data = array($data[0]=>$data[1]);
		if(is_string($table)) {
			$result .= "`".str_replace(".", "`.`", $table)."`";
		} else {
			for($i=0,$m=count($table);$i<$m;$i++) {
				if(!isset($table[$i]["idx"])) $table[$i]["idx"] = "t".$i;
				if($i==0) {
					$result .= "`".str_replace(".", "`.`", $table[$i]['name'])."` as ".$table[$i]['idx'];
				} else {
					if(!isset($table[$i]['mode'])) $table[$i]['mode'] = "left";
					$result .= " ".$table[$i]['mode']." join `".$table[$i]['name']."` as ".$table[$i]['idx']." on ";
					if(is_string($table[$i]['join'])) {
						if(strpos($table[$i]['join'], ",")!=false) {
							$table[$i]['join'] = explode(",", $table[$i]['join']);
							for($j=0,$n=count($table[$i]['join']);$j<$n;$j++) {
								if($j>0) $result .= " and ";
								$result .= "`".$table[0]['idx']."`.`".$table[$i]['join'][$j]."` = `".$table[$i]['idx']."`.`".$table[$i]['join'][$j]."`";
							}
						} else {
							$result .= "`".$table[0]['idx']."`.`".$table[$i]['join']."` = `".$table[$i]['idx']."`.`".$table[$i]['join']."`";
						}
					} else {
						if(!is_array($table[$i]['join'][0])) $table[$i]['join'] = array($table[$i]['join']);
						for($j=0,$n=count($table[$i]['join']);$j<$n;$j++) {
							if($j>0) $result .= " and ";
							$result .= "`".$table[$i]['idx']."`.`".$table[$i]['join'][$j][0]."` = `".str_replace(".", "`.`", $table[$i]['join'][$j][1])."`";
						}
					}
				}
				if(isset($table[$i]['condition']) && !empty($table[$i]['condition'])) {
					if(!empty($condition_list)) $condition_list .= " and ";
					$condition_list .= $this->buildCondition($table[$i]['condition'], $table[$i]["idx"]);
				}
			}
		}
			
		$values = array();
		foreach($data as $key => $value) {
			if(strtolower($key) == 'submit') continue;
			if(strpos($key, "`")===false) {
				$key = "`".str_replace(".", "`.`", $key)."`";
			}
			if(is_null($value) || strtolower($value)=="null") {
				$value = "NULL";
			} elseif(preg_match("/^(\+|\-)(\d+)$/", $value, $match)) {
				$value = $key.$match[1].$match[2];
			} elseif(preg_match("/^\(\w+\.\w+\)$/", $value)) {
				$value = "`".preg_replace("/^\((\w+)\.(\w+)\)$/", "`\\1`.`\\2`", $value)."`";
			} elseif(preg_match("/^\(\(.+\)\)$/", $value)) {
				if(strpos($value, "`")===false) {
					$value = preg_replace("/(\w+)/", "`\\1`", $value);
					$value = preg_replace("/`(\d+)`/", "\\1", $value);
				}
			} elseif(!is_numeric($value) && !preg_match("/^\w{3,15}\(.*\)$/", $value)) {
				$value = "'".mysql_real_escape_string($value)."'";
			}
			$values[] = $key." = ".$value;
		}
		$result .= " set ".implode(",", $values);
		
		if(!empty($condition)) {
			if(empty($condition_list)) {
				$condition_list = $condition;
			} else {
				$condition_list .= " and (".$condition.")";
			}
			$result .= " where ".$condition_list;
		}
		return $result;
	}
	
	public function buildIns($table, $data, $remove_empty = false, $replace = false) {
		$fields = array();
		$values = array();
		$table = str_replace(".", "`.`", $table);
		$result = $replace?"replace":"insert";
		$result .= " LOW_PRIORITY into `{$table}` ";
		foreach($data as $key => $value) {
			if(strtolower($key) == 'submit') continue;
			if(!is_numeric($key) && $remove_empty && $value=="") continue;
			$key = preg_replace("/[".preg_quote("\"'`~!@#$%^&*[]{};:<>?\\")."]/", "", $key);
			if(is_null($value) || strtolower($value)=="null") {
				$value = "NULL";
			} elseif(!is_numeric($value) && !preg_match("/^\w{3,15}\(.*\)$/", $value)) {
				$value = "'".mysql_real_escape_string($value)."'";
			}
			if(!is_numeric($key)) $fields[] = "`".$key."`";
			$values[] = $value;
		}
		if(!empty($fields)) $result .= "(".implode(",",$fields).")";
		$result .= " values (".implode(",",$values).")";
		return $result;
	}

	public function buildSQL($table, $data, $mode, $addon = "") {
		$result = "";
		switch($mode) {
			case "insert":
				$result = $this->buildIns($table, $data, $addon);
				break;
			case "replace":
				$result = $this->buildIns($table, $data, $addon, true);
				break;
			case "update":
				$result = $this->buildUpdate($table, $data, $addon);
				break;
			case "select":
				if(is_string($table)) {
					if(!isset($addon['col'])) $addon['col'] = "*";
					$result = $this->buildSel($table, $addon['col'], $data, $addon);
				} else {
					$result = $this->buildSel($table, $data, $addon);
				}
				break;
			case "delete":
				$result = $this->buildDel($table, $data);
				break;
			default:
				break;
		}
		return $result;
	}
	
	public function buildQuery($func, $obj, $name, $method="", $opt="") {
		$name = "`".$name."`";
		return implode(" ", func_get_args());
	}
	
	public function exec() {
		$sql = call_user_func_array(array($this, "buildQuery"), func_get_args());
		return $this->Query($sql);
	}
	
	public function select() {
		if(func_num_args()==2 && func_get_arg(1)===true) {
			$sql = func_get_arg(0);
		} else {
			$sql = call_user_func_array(array($this, "buildSel"), func_get_args());
		}
		return $this->Query($sql);
	}
	
	public function insert($table, $data, $remove_empty = false, $execute = true) {
		$sql = $this->buildIns($table, $data, $remove_empty);
		return $execute ? $this->Query($sql) : $sql;
	}
	
	public function replace($table, $data, $execute = true) {
		$sql = $this->buildIns($table, $data, false, true);
		return $execute ? $this->Query($sql) : $sql;
	}
	
	public function update($table, $data, $condition=array(), $execute = true) {
		$sql = $this->buildUpdate($table, $data, $condition);
		return $execute ? $this->Query($sql) : $sql;
	}
	
	public function delete($table, $condition=array(), $execute = true) {
		$sql = $this->buildDel($table, $condition);
		return $execute ? $this->Query($sql) : $sql;
	}

	public function ReadSqlFile($file) {
		return is_file($file)?$this->HandleSQL(file_get_contents($file)):"";
	}
	
	public function ExeSqlFile($file, $strFind = "", $strReplace = "") {
		if($this->DB_conn == NULL) return false;
		if(is_file($file)) {
			$result = array();
			$ArrSQL = $this->HandleSQL(file_get_contents($file));
			$max_count = count($ArrSQL);
			for($i=0; $i<$max_count; $i++) {
				if(!empty($strFind)) $ArrSQL[$i] = str_replace($strFind, $strReplace, $ArrSQL[$i]);
				$theSQL = $ArrSQL[$i];
				$theSQL = strtolower($theSQL);
				$theSQL = str_replace("if not exists", "", $theSQL);
				$theSQL = str_replace("if exists", "", $theSQL);
				$return = $this->Query($ArrSQL[$i]);
				switch(true) {
					case strpos($theSQL, "select")===0:
						if(preg_match("/^select.+into\s+(\w+).+/", $theSQL, $theTBL)) {
							$result[] = array("table", "select", $theTBL[1], $return);
						} else {
							continue;
						}
						break;
					case strpos($theSQL, "create")===0:
						preg_match("/^create\s+(\w+)\s+(\w+)/m", $theSQL, $theTBL);
						$result[] = array($theTBL[1], "create", $theTBL[2], $return);
						break;
					case strpos($theSQL, "drop")===0:
						preg_match("/^drop\s+(\w+)\s+(\w+).*/m", $theSQL, $theTBL);
						$result[] = array($theTBL[1], "drop", $theTBL[2], $return);
						break;
					case strpos($theSQL, "alter"===0):
						preg_match("/^alter\s+table\s+(\w+).+/m", $theSQL, $theTBL);
						$result[] = array("table", "alter", $theTBL[1], $return);
						break;
					case strpos($theSQL, "delete")===0:
						preg_match("/^delete\s+from\s+(\w+).+/m", $theSQL, $theTBL);
						$result[] = array("table", "delete", $theTBL[1], $return);
						break;
					case strpos($theSQL, "truncate")===0:
						preg_match("/^truncate\s+(table\s+)?(\w+).+/m", $theSQL, $theTBL);
						$result[] = array("table", "truncate", $theTBL[1], $return);
						break;
					case strpos($theSQL, "insert")===0:
						preg_match("/^insert\s+into\s+(\w+).+/m", $theSQL, $theTBL);
						$result[] = array("table", "insert", $theTBL[1], $return);
						break;
					case strpos($theSQL, "update")===0:
						preg_match("/^update\s+(\w+).+/m", $theSQL, $theTBL);
						$result[] = array("table", "update", $theTBL[1], $return);
						break;
					case strpos($theSQL, "show")===0:
						preg_match("/^show\s+(.+?)\s*($|like.+$)/", $theSQL, $theTBL);
						$result[] = array("other", "show", $theTBL[1], $return);
						break;
					case strpos($theSQL, "use")===0:
						break;
					default:
						//echo $theSQL."<br />";
						continue;
				}
			}
			return $result;
		}
		return false;
	}

	public function HandleSQL($strSQL) {
		$strSQL	= trim($strSQL);
		$strSQL	= preg_replace("/^#[^\n]*\n?$/m", "", $strSQL);
		$strSQL	= preg_replace("/\r\n/", "\n", $strSQL);
		$strSQL	= preg_replace("/[\n]+/", "\n", $strSQL);
		$strSQL	= preg_replace("/[\t ]+/", " ", $strSQL);
		$strSQL	= preg_replace("/\/\*.*\*\//sU", "", $strSQL);
		$temp	= preg_split("/;\s*\n/",$strSQL);
		$result	= array();
		$max_count = count($temp);
		for($i=0; $i<$max_count; $i++) {
			if(str_replace("\n","",$temp[$i]) != "") {
				$result[] = preg_replace("/^\n*(.*)\n*$/m","\\1",$temp[$i]);
			}
		}
		return $result;
	}

	public function BatchExec($ArrSQL){
		if($this->DB_select == NULL || $this->DB_conn == NULL) return false;
		if(is_string($ArrSQL)) {
			$tmp = $ArrSQL;
			$ArrSQL = array();
			$ArrSQL[0] = $tmp;
		}
		$max_count = count($ArrSQL);
		for($i=0; $i<$max_count; $i++) {
			if(empty($ArrSQL[$i])) continue;
			mysql_unbuffered_query($ArrSQL[$i], $this->DB_conn);
			$this->DB_count++;
			$this->DB_qstr = $ArrSQL[$i];
			if($this->CheckError())	$this->Error("Error Occur in Batch Query");
		}
		return true;
	}

	public function Free() {
		if($this->DB_result!=NULL && is_resource($this->DB_result)) mysql_free_result($this->DB_result);
		$this->DB_result = NULL;
		return;
	}

	public function Close(&$err_info = array()) {
		if($this->DB_result != NULL) $this->Free();
		if($this->DB_conn!=NULL && is_resource($this->DB_conn)) mysql_close($this->DB_conn);
		if($this->DB_select!=NULL) $this->DB_select = NULL;
		return $this->DB_count;
	}

	public function CheckError() {
		return (mysql_errno()!=0);
	}

	public function GetError(&$err_info = array()) {
		$err_info = $this->DB_error_description;
		return $this->DB_error;
	}

	public function clearError() {
		$this->DB_error = false;
		$this->DB_error_description = array();
		return;
	}

	protected function Error($str, $exit=false) {
		if(mysql_errno()===false || mysql_errno()===0) return;
		$this->DB_error	= true;
		$this->DB_error_description[]	= mysql_errno()." - ".mysql_error()." ({$str})";
		$str .= "\nQuery String: ".$this->DB_qstr."\n";
		$str .= "MySQL Message: ".mysql_errno()." - ".mysql_error();
		parent::Error($str, $exit);
		return;
	}
}
?>