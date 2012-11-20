<?php
/********************************************
*                                           *
* Name    : MSSQL Manager                   *
* Author  : Windy2000                        *
* Time    : 2005-04-14                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT PLEASE HOLD THIS ITEM.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$MSSQL = new MSSQL($host, $user, $pass, $charse)	// Set the Database Class
	$MSSQL->ReadSqlFile($file)			// Read SQL File And Send Content of the File to HandleSQL($strSQL)
	$MSSQL->HandleSQL($strSQL)			// Split the SQL Query String into a array from a whole String (Maybe Read from a File)
	$MSSQL->BatchExec($ArrSQL)			// Execute Multi Query from an Array (Use HandleSQL First)
	$MSSQL->Connect($pconnect = false)		// Build a Connection to MSSQL to $MSSQL->DB_conn
	$MSSQL->SelectDB($the_db)			// Select a Database of MSSQL to $MSSQL->DB_select (Must Build Connect First)
	$MSSQL->Query($sql)				// Execute a Query of MSSQL, Result into $MSSQL->DB_resut
	$MSSQL->SeekData($line)				// Seek Data Row in the $MSSQL->DB_resut
	$MSSQL->GetResult($line, $field="")		// The Same Use as mssql_result
	$MSSQL->GetRS()					// Return The Current Result as an Array and Set the Point of Result to the Next Result
	$MSSQL->GetSingleResult($sql)			// Get the first single value of the first line of the recordset
	$MSSQL->GetSingleRecord($sql, $mode)			// Get the first line of the recordset
	$MSSQL->GetDBs()				// Get the Databases List of Current MySQL Server as an Array
	$MSSQL->GetTabs($the_db)			// Get the Tables List of Current Selected Database as an Array
	$MSSQL->GetQueryFields()			// Get the Columns List of Current Query
	$MSSQL->buildSQL($table, $data, $mode = "insert", $addon = "") // Build SQL string for insert or update
	$MSSQL->ConvertLimit($sql)					// convert sql query string include limit grammar of mysql to mssql sql query string
	$MSSQL->Free()					// Free the $MSSQL->DB_result in order to Release the System Resource
	$MSSQL->Close()					// Close Current MSSQL Link
	$MSSQL->Error($str)				// Handle the Errors

--------------------------------------------------------------------------------------------------------------------*/

class MSSQL extends class_common {
	private
		$DB_host	= "",
		$DB_user	= "",
		$DB_pass	= "",
		$DB_db	= "",
		$DB_conn	= NULL,
		$DB_select	= NULL,
		$DB_error	= false,
		$DB_qstr	= "",
		$DB_result	= NULL,
		$DB_count	= 0,
		$DB_RStype	= 1;


	public function init($host, $user, $pass) {
		$this->DB_host = $host;
		$this->DB_user = $user;
		$this->DB_pass = $pass;
		return;
	}

	public function Connect($pconnect = false, $the_db = "") {
		if($pconnect) {
			$this->DB_conn = mssql_pconnect($this->DB_host, $this->DB_user, $this->DB_pass);
		} else {
			$this->DB_conn = mssql_connect($this->DB_host, $this->DB_user, $this->DB_pass);
		}
		$this->DB_qstr = "none (Connect to MSSQL Server)";
		if($this->GetErrorCode() != 0)	$this->Error("Could not connect to MSSQL Server");
		mssql_query( "SET TEXTSIZE 1024000", $this->DB_conn);
		if(!empty($the_db)) $this->SelectDB($the_db);
		return;
	}

	public function SelectDB($the_db) {
		if($this->DB_conn == NULL) return false;
		$this->DB_db	 = $the_db;
		$this->DB_select = mssql_select_db($the_db, $this->DB_conn);
		$this->DB_qstr	 = "none (Select Database)";
		if($this->GetErrorCode() != 0)	$this->Error("Could not connect to the Database");
		return true;
	}

	public function Query($sql) {
		if($this->DB_conn == NULL) return false;
		$this->DB_count++;
		$this->Free();
		$ifsel = strstr("select", strtolower(substr(trim($sql), 0, 6)));
		$this->DB_result = mssql_query($sql, $this->DB_conn);
		$this->DB_qstr	= $sql;
		if($ifsel) {
			$num_rows = mssql_num_rows($this->DB_result);
		} else {
			$num_rows = mssql_rows_affected($this->DB_conn);
			/*
			$rsRows = mssql_query("select @@rowcount as rows", $this->DB_conn); 
			$num_rows = mssql_result($rsRows, 0, "rows"); 
			mssql_free_result($rsRows);
			*/
			$this->Free();
		}
		if($this->GetErrorCode() != 0)	$this->Error("Error Occur in Query !");
		return $num_rows;
	}

	public function GetSingleResult($sql){
		$row_num = $this->Query($sql);
		$result = ($row_num>0 ? $this->GetResult(0) : "");
		$this->free();
		return $result;
	}

	public function GetSingleRecord($sql, $mode = true){
		$row_num = $this->Query($sql);
		if($row_num>0) {
			$result = $this->GetRS();
		} else {
			$result = false;
		}
		$this->free();
		if($result===false) return false;
		return $mode?$result:array_values($result);
	}

	public function SeekData($line) {
		if($this->DB_result == NULL) return false;
		$flag = mssql_data_seek($this->DB_result, $line);
		if($this->GetErrorCode() != 0)	$this->Error("Error Occur in Query !");
		return $flag;
	}

	public function GetResult($line, $field=0){
		if($this->DB_result == NULL) return false;
		eval("\$result = mssql_result(\$this->DB_result, $line".($field===''?"":(is_numeric($field)?", $field":", '$field'")).");");
		if($this->GetErrorCode() != 0)	$this->Error("Error Occur in Query !");
		return $result;
	}

	public function GetInsertId($tbl){
		$rsID = mssql_query("SELECT IDENT_CURRENT('{$tbl}') as new_id", $this->DB_conn); 
		$new_id = mssql_result($rsID, 0, "new_id"); 
		mssql_free_result($rsID);
		return ($new_id?$new_id:0);
	}

	public function GetRS(){
		if($this->DB_result == NULL) return false;
		switch($this->DB_RStype){
			case 1:
				$flag = ($row = mssql_fetch_assoc($this->DB_result));
				break;
			case 2:
				$flag = ($row = mssql_fetch_row($this->DB_result));
				break;
			case 3:
				$flag = ($row = mssql_fetch_array($this->DB_result));
				break;
			default:
				$flag = ($row = mssql_fetch_assoc($this->DB_result));
		}
		$this->DB_qstr	= "none(Get Recordset)";
		if($this->GetErrorCode() != 0)	$this->Error("Error Occur in Get Recordset !");
		return ($flag?$row:false);
	}

	public function GetDBs() {
		$this->Free();
		$this->DB_qstr	 = "SELECT name FROM master.dbo.sysdatabases where dbid > 5 ORDER BY dbid DESC";
		//EXEC sp_databases
		$this->DB_result = mssql_query($this->DB_qstr, $this->DB_conn);
		if ($this->GetErrorCode() != 0) $this->Error("Could not List Databases, List Only For Databases Master");
		$dbs = array();
		while($row = $this->GetRS()) {
			$dbs[] = $row['name'];
		}
		$this->Free();
		return $dbs;
	}

	public function GetTabs($the_db) {
		$this->Free();
		$this->DB_qstr	 = "SELECT b.name+'.'+a.name as name FROM [{$the_db}].dbo.sysobjects a left join [{$the_db}].dbo.sysusers b on a.uid=b.uid where a.xtype='u' and a.status>0 order by a.name asc";
		//EXEC sp_tables [%], [%], [{$the_db}], ['TABLE']
		$this->DB_result = mssql_query($this->DB_qstr, $this->DB_conn);
		if ($this->GetErrorCode() != 0) $this->Error("Could not List Tables, List Only For Databases Master");
		$tabs = array();
		while($row = $this->GetRS()) {
			$tabs[] = str_replace("dbo.", "", $row['name']);
		}
		$this->Free();
		return $tabs;
	}

	public function GetQueryFields() {
		if($this->DB_result == NULL) return false;
		$fields = array();
		$columns = mssql_num_fields($this->DB_result);
		for ($i = 0; $i<$columns; $i++) {
			$fields[] = mssql_field_name($this->DB_result, $i);
		}
		return $fields;
	}

	public function ReadSqlFile($file) {
		return is_file($file)?$this->HandleSQL(join("",file($file))):"";
	}

	public function HandleSQL($strSQL) {
		$strSQL	= trim($strSQL);
		$strSQL	= preg_replace("/^#[^\n]*\n?$/m", "", $strSQL);
		$strSQL	= preg_replace("/\r\n/",  "\n", $strSQL);
		$strSQL	= preg_replace("/[\n]+/", "\n", $strSQL);
		$strSQL	= preg_replace("/[\t ]+/", " ", $strSQL);
		$strSQL	= preg_replace("/\/\*[^(\*\/)]*\*\//", "", $strSQL);
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
		$max_count = count($ArrSQL);
		for($i=0; $i<$max_count; $i++) {
			mssql_query($ArrSQL[$i], $this->DB_conn);
			$this->DB_qstr = $ArrSQL[$i];
			if($this->GetErrorCode() != 0)	$this->Error("Error Occur in Batch Query");
		}
		return true;
	}

	public function buildSQL($table, $data, $mode = "insert", $addon = "") {
		$fields = "";
		$values = "";
		$tmp = "||||||";
		$table = str_replace(".", "].[", $table);
		
		switch($mode) {
			case "insert":
				$sql = "insert into [{$table}] ";
				break;
			case "update":
				$sql = "update [{$table}] set ";
				break;
			default:
				$sql = "update [{$table}] set ";
		}

		foreach($data as $key => $value) {
			$value = str_replace("\\r\\n", "'+char(13)+char(10)+'", $value);
			$value = str_replace("\\\'", "''", $value);
			$value = str_replace("\'", "''", $value);
			$value = str_replace("'''", "''", $value);
			if(strtolower($key) == 'submit') continue;
			if($mode=="insert" && $addon != "" && $value==="") continue;
			if(!preg_match("/^\w+\(\)$/", $value)) $value = "'{$value}'";
			if($mode=="insert") {
				$fields .= "[{$key}], ";
				$values .= "{$value}, ";
			} else {
				$values .= "[{$key}] = {$value}, ";
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
		} else {
			if(empty($addon)) $addon= "1=1";
			$sql .= $values . " where {$addon}";
		}
		return $sql;
	}
	
	public function ConvertLimit($sql, $the_order="id") {
		if(stripos($sql, "select")!==0 || stripos($sql, "limit")!==false) {
			if(preg_match("/limit\s+(\d+)$/i", $sql, $matches)) {
				$sql = preg_replace("/limit\s+(\d+)$/i", "", $sql);
				$sql = str_ireplace("select", "select top ".$matches[1], $sql);
			} elseif(preg_match("/limit\s+(\d+)[\s,]+(\d+)$/i", $sql, $matches)) {
				$start = $matches[1]+1;
				$size = $matches[2];
				if(preg_match("/order by\s+(.+?)\s+limit/i", $sql, $matches)) {
					$the_order = $matches[1];
					$the_order = preg_replace("/\s*,\s*/", ",", $the_order);
					$order_list = explode(",", $the_order);
					for($i=0,$m=count($order_list);$i<$m;$i++) {
						if(strpos($order_list[$i], " ")===false) $order_list[$i] .= " asc";
					}
					$the_order = implode(",", $order_list);
					$the_order_2 = str_ireplace("desc", "[xxxx]", $the_order);
					$the_order_2 = str_ireplace("asc", "desc", $the_order_2);
					$the_order_2 = str_ireplace("[xxxx]", "asc", $the_order_2);
				} else {
					$the_order_2 = $the_order." desc";
				}
				$sql = preg_replace("/limit\s+(\d+)[\s,]+(\d+)$/i", "", $sql);
				$sql = str_ireplace("select", "select top ".($start+$size), $sql);
				$sql = "select top ".$size." * from (".$sql.") order by ".$the_order_2;
				$sql = "select * from (".$sql.") order by ".$the_order;
			}
		}
		return $sql;
	}

	public function Free() {
		if($this->DB_result != null) mssql_free_result($this->DB_result);
		$this->DB_result = NULL;
		return;
	}

	public function Close() {
		if($this->DB_result != NULL)
			$this->Free();
		if($this->DB_conn != NULL)
			mssql_close($this->DB_conn);
		if($this->DB_select != NULL)
			$this->DB_select = NULL;
		return $this->DB_count;
	}

	public function GetErrorCode() {
		if($this->DB_conn == NULL) return 0;
		$rsCode = mssql_query("select @@ERROR as code", $this->DB_conn);
		$code   = mssql_result($rsCode, 0, "code"); 
		mssql_free_result($rsCode);
		return $code;
	}
   
	protected function Error($str, $exit=false) {
		$str .= "\n";
		$str .= "Query String: ".$this->DB_qstr."\n";
		$str .= "MSSQL Message: ".$this->GetErrorCode()." - ".mssql_get_last_message();
		parent::Error($str, $exit);
		return;
	}
}
?>