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
	$MySQL->GetStat()				// Get the Current Status of MySQL
	$MySQL->GetDBs()				// Get the Databases List of Current MySQL Server as an Array
	$MySQL->GetTabs($the_db)			// Get the Tables List of Current Selected Database as an Array
	$MySQL->GetIdx($the_tab) 			// Get the Indexes List of a Table as an Array
	$MySQL->GetTabSetting($the_tab)			// Get the Whole Struction of Current Selected Database as an Array
	$MySQL->GetTabData($the_tab)			// Get All of The Data of a Table
	$MySQL->GetTabFields($the_db, $the_tab)		// Get the Columns List of a Table as an Array
	$MySQL->GetQueryFields()			// Get the Columns List of Current Query
	$MySQL->GetInsertId()					// Return auto increment id generate by insert query
	$MySQL->buildSQL($table, $data, $mode = "insert", $addon = "") // Build SQL string for insert or update
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
		if(substr(mysql_get_server_info(),0,1)>=5) {
			mysql_query("SET CHARACTER SET '".$charset."'", $this->DB_conn);
			mysql_query("SET NAMES '".$charset."'", $this->DB_conn);
			if($charset_collate = $this->GetSingleRecord("SHOW CHARACTER SET LIKE '".$charset."'")) {
				mysql_query("SET COLLATION_CONNECTION='".$charset_collate["Default collation"]."'", $this->DB_conn);
			}
			if($this->CheckError())	$this->Error("Unknow CharSet Name");
		}
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
		$sql = str_replace("where (1=1) order", "order", $sql);
		$sql = str_replace("where (0=0) order", "order", $sql);
		if(strpos($sql, "1=")!==false) {
			$sql = str_replace("1=1 and", "", $sql);
			$sql = str_replace("and 1=1", "", $sql);
			$sql = str_replace("1=0 or", "", $sql);
			$sql = str_replace("or 1=0", "", $sql);
		}
		if(strpos($sql, "0=")!==false) {
			$sql = str_replace("0=0 and", "", $sql);
			$sql = str_replace("and 0=0", "", $sql);
			$sql = str_replace("0=1` or", "", $sql);
			$sql = str_replace("or 0=1", "", $sql);
		}
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
		$result = ($row_num>0 ? $this->GetResult(0) : "");
		$this->DB_Qtype = $DB_Qtype_org;
		$this->free();
		return $result;
	}
	
	public function GetRecord($sql){
		$result = array();
		$this->Query($sql);
		while($result[] = $this->GetRS()) {}
		array_pop($result);
		return $result;
	}

	public function GetSingleRecord($sql, $mode = true){
		$DB_Qtype_org = $this->DB_Qtype;
		$this->DB_Qtype = true;
		$row_num = $this->Query($sql);
		if($row_num>0) {
			$result = $this->GetRS();
		} else {
			$result = false;
		}
		$this->DB_Qtype = $DB_Qtype_org;
		$this->free();
		if($result===false) return false;
		return $mode?$result:array_values($result);
	}

	public function GetInsertId(){
		$the_id = mysql_insert_id($this->DB_conn);
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
			"MySQL server version" => mysql_get_server_info(),
			"MySQL protocol version" => mysql_get_proto_info(),
			"MySQL host info" => mysql_get_host_info(),
			"MySQL client info" => mysql_get_client_info(),
			"More info" => str_replace("  ","\n",mysql_stat($this->DB_conn)),
		);
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

	public function buildSQL($table, $data, $mode = "replace", $addon = "") {
		$fields = "";
		$values = "";
		$tmp = "||||||";
		$table = str_replace(".", "`.`", $table);
		
		switch($mode) {
			case "insert":
				$sql = "insert into `{$table}` ";
				break;
			case "update":
				$sql = "update LOW_PRIORITY `{$table}` set ";
				break;
			default:
				$sql = "replace into `{$table}` set ";
		}

		foreach($data as $key => $value) {
			$value = mysql_real_escape_string($value);
			if(strtolower($key) == 'submit') continue;
			if($mode=="insert" && $addon != "" && $value==="") continue;
			if(!preg_match("/^\w+\(\)$/", $value)) $value = "'{$value}'";
			if($mode=="insert") {
				$fields .= "`{$key}`, ";
				$values .= "{$value}, ";
			} else {
				$values .= "`{$key}` = {$value}, ";
			}
		}

		if($mode=="insert") {
			$fields .= $tmp;
			$fields = str_replace(", {$tmp}", "", $fields);
		}
		$values .= $tmp;
		$values = str_replace(", {$tmp}", "", $values);

		if($mode=="insert") {
			$sql .= "({$fields}) values ({$values})";
		} elseif($mode=="update") {
			if(empty($addon)) $addon= "1=1";
			$sql .= $values . " where {$addon}";
		} else {
			$sql .= $values;
		}
		return $sql;
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
				$theSQL = str_replace("`", "", $theSQL);
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
						preg_match("/^delete¨\s+from\s+(\w+).+/m", $theSQL, $theTBL);
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