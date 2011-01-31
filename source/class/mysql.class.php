<?php
/********************************************
*                                           *
* Name    : MySQL Manager                   *
* Author  : Windy2000                       *
* Time    : 2003-05-10                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
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
		$this->DB_charset = $charset;
		return;
	}

	public function Connect($pconnect = false) {
		if($pconnect) {
			$this->DB_conn = mysql_pconnect($this->DB_host, $this->DB_user, $this->DB_pass, CLIENT_MULTI_RESULTS);
		} else {
			$this->DB_conn = mysql_connect($this->DB_host, $this->DB_user, $this->DB_pass, CLIENT_MULTI_RESULTS);
		}
		$this->DB_qstr = "none (Connect to MySQL Server)";
		if($this->CheckError())	$this->Error("Could not connect to MySQL Server");
		if(substr(mysql_get_server_info(),0,1)>=5) {
			mysql_query("SET NAMES '".$this->DB_charset."'", $this->DB_conn);
			mysql_query("SET CHARACTER SET '".$this->DB_charset."'", $this->DB_conn);
			$charset = array(
				"latin1" => "latin1_swedish_ci",
				"gbk" => "gbk_chinese_ci",
				"gb2312" => "gb2312_chinese_ci",
				"utf8" => "utf8_general_ci"
			);
			if(isset($charset[$this->DB_charset])) {
				mysql_query("SET COLLATION_CONNECTION='".$charset[$this->DB_charset]."'", $this->DB_conn);
			}
			if($this->CheckError())	$this->Error("Unknow CharSet Name");
		}
		return;
	}

	public function ReConnect($pconnect = false) {
		if($this->DB_conn != NULL) $this->Close();
		$this->Connect($pconnect);
		return;
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
		$ifsel = strstr("|selec|show |descr|expla|", strtolower(substr(trim($sql), 0, 5)));
		if($this->DB_Qtype) {
			$this->DB_result = mysql_query($sql, $this->DB_conn);
		} else {
			$this->DB_result = mysql_unbuffered_query($sql, $this->DB_conn);
		}
		$this->DB_qstr	= $sql;
		if($ifsel && is_resource($this->DB_result)) {
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

	public function ChangUser($user, $pass, $db="") { // Maybe doesn't work !
		eval("\$result = mysql_change_user('$user', '$pass'".($db==""?"":", '$db'").");");
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
		eval("\$result = mysql_result(\$this->DB_result, $line".(empty($field)?"":(is_numeric($field)?", $field":", '$field'")).");");
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

	public function GetTabSetting($the_tab) {
		$this->DB_qstr	 = "SHOW TABLE STATUS FROM `{$this->DB_db}` LIKE '{$the_tab}'";
		$this->DB_result = mysql_query($this->DB_qstr);
		if ($this->CheckError()) $this->Error("Could not List Table's Setting");
		$row = mysql_fetch_assoc($this->DB_result);
		$result = "#Table Name: ".$row["Name"]."\n# Create Time: ".$row["Create_time"]."\n# Update Time: ".$row["Update_time"]."\n";
		$this->Free();
		$tblInfo = array_values($this->getSingleRecord("show create table ".$the_tab));
		$result .= $tblInfo[1].";\n";
		return $result;
	}
/*
	public function GetTabSetting($the_tab) {
		$this->Free();
		$this->DB_qstr	 = "SHOW FIELDS FROM {$the_tab}";
		$this->DB_result = mysql_query($this->DB_qstr);
		if ($this->CheckError()) $this->Error("Could not List Table's Setting");
		$result = "CREATE TABLE `$the_tab` (\n";
		$P_key	= "";
		while($row = mysql_fetch_assoc($this->DB_result)) {
			$string = "	`".$row["Field"]."` ".$row["Type"]." ";
			if($row["Null"] == "")		$string .= "NOT NULL ";
			if($row["Default"] != "")	$string .= "Default \"".$row["Default"]."\" ";
			if($row["Key"] == "PRI")	$P_key	.= "	PRIMARY KEY (`".$row["Field"]."`) ,\n";
			if($row["Key"] == "UNI")	$P_key	.= "	UNIQUE KEY (`".$row["Field"]."`) ,\n";
			//elseif($row["Key"] == "MUL")	$P_key	.= "	KEY `".$row["Field"]."` (`".$row["Field"]."`) ,\n";
			$string .= $row["Extra"].",\n";
			$result .= $string;
		}
		$result .= $P_key;
		$idxes   = $this->GetIdx($the_tab);
		$max_count = count($idxes);
		for($i=0; $i<$max_count; $i++) {
			$the_idx = preg_replace("/INDEX `([^`]+)` \(.*\)/", "\\1", $idxes[$i]);
			if(strpos($P_key, $the_idx)===false) $result .= "	".$idxes[$i]." ,\n";
		}
		$result .= ")";
		$result = str_replace(" ,\n)", "\n)", $result);
		$this->Free();
		$this->DB_qstr	 = "SHOW TABLE STATUS FROM `{$this->DB_db}` LIKE '{$the_tab}'";
		$this->DB_result = mysql_query($this->DB_qstr);
		if ($this->CheckError()) $this->Error("Could not List Table's Setting");
		$row = mysql_fetch_assoc($this->DB_result);
		$result .= " TYPE=".$row["Engine"];
		if($row["Auto_increment"] != NULL) $result .= " AUTO_INCREMENT=".$row["Auto_increment"];
		if($row["Comment"] != NULL) $result .= " COMMENT='".$row["Comment"]."'";
		$result .= ";\n";
		$result = "#Table Name: ".$row["Name"]."\n# Create Time: ".$row["Create_time"]."\n# Update Time: ".$row["Update_time"]."\n".$result;
		$this->Free();
		return $result;
	}
*/
	public function GetTabData($the_tab) {
		$this->Free();
		$this->DB_qstr	 = "SELECT * FROM $the_tab";
		$this->DB_result = mysql_query($this->DB_qstr);
		if ($this->CheckError()) $this->Error("Could not List Table's Setting");
		$result = "";
		while($row = mysql_fetch_row($this->DB_result)) {
			$result .= "INSERT INTO `$the_tab` VALUES (";
			$max_count = count($row);
			for($i=0; $i<$max_count; $i++) {
				$row[$i] = str_replace("\\", "\\\\", $row[$i]);
				$row[$i] = str_replace("\r", "\\r", $row[$i]);
				$row[$i] = str_replace("\n", "\\n", $row[$i]);
				$row[$i] = str_replace("'", "\\'", $row[$i]);
				$result .= "'".$row[$i]."', ";
			}
			$result .= ");\n";
		}
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
		
		switch($mode) {
			case "insert":
				$sql = "insert into `{$table}` ";
				break;
			case "update":
				$sql = "update `{$table}` set ";
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
				$theSQL = str_replace("`", "",  $theSQL);
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
		$strSQL	= preg_replace("/\r\n/",  "\n", $strSQL);
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
		return($result);
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
		if($this->DB_result != NULL)
			$this->Free();
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
		$msg_ext  = "";
		$msg_ext .= "Query String: ".$this->DB_qstr."\n";
		$msg_ext .= "MySQL Message: ".mysql_errno()." - ".mysql_error();
		parent::Error($str, $msg_ext, $exit);
		return;
	}
}
?>