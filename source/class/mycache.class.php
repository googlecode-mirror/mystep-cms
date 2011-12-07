<?php
/********************************************
*										                        *
* Name	  : My Cache					             	*
* Author  : Windy2000					              *
* Time	  : 2010-12-12					            *
* Email   : windy2006@gmail.com	            *
* HomePage: None (Maybe Soon)			          *
* Notice  : U Can Use & Modify it freely,   *
*		        BUT HOLD THIS ITEM PLEASE.	    *
*										                        *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------
  How To Use:
	$mycache->init($mode, $setting)	// Set the Template Class
	$mycache->set($key, $value = "", $ttl = 300)
	$mycache->get($key)
	$mycache->remove($key)
	$mycache->clean()
--------------------------------------------------------------------------------------------------------------------*/

class MyCache extends class_common {
	protected $obj = "";

	public function init($mode = ""){
		global $setting;
		$flag = true;
		switch($mode) {
			case "memcache":
				$this->obj = new MemoryCache();
				$flag = $this->obj->init($setting['memcache']);
				break;
			case "eaccelerator":
				$this->obj = new eAccelerator();
				$flag = $this->obj->init();
				break;
			case "xcache":
				$this->obj = new xCache();
				$flag = $this->obj->init();
				break;
			case "mysql":
				$this->obj = new MyCache_MySQL();
				$flag = $this->obj->init($setting['db']);
				break;
			default:
				$this->obj = new MyCache_File();
				$this->obj->init(ROOT_PATH."/".$setting['path']['cache']."/data/");
				break;
		}
		if(!$flag) {
			$this->obj = new MyCache_File();
			$this->obj->init(ROOT_PATH."/".$setting['path']['cache']."/data/");
		}
	}
	
	public function set($key, $value = "", $ttl = 600) {
		$this->obj->set($key, $value, $ttl);
	}
	
	public function get($key) {
		return $this->obj->get($key);
	}
	
	public function remove($key) {
		return $this->obj->remove($key);
	}
	
	public function clean() {
		$this->obj->clean();
		return;
	}
}

/*-------------------------------------------MyCache_File--------------------------------------------------*/

class MyCache_File extends class_common {
	protected $thePath = "";
	
	public function init($path) {
		$this->thePath = $path.date("/Ymd/");
	}
	
	public function set($key, $value = "", $ttl = 600) {
		$new_key = substr(md5($key), 0, 8);
		//$the_path = $this->thePath.implode("/", str_split($new_key, "2"))."/";
		$the_path = $this->thePath.substr($new_key, 0, 2)."/";
		if(empty($value)) {
			@unlink($the_path.$new_key);
		} else {
			$result = array(
					"expire" => $_SERVER["REQUEST_TIME"]+$ttl,
					"value" => $value,
			);
			$this->MakeDir($the_path);
			$this->WriteFile($the_path.$new_key, serialize($result), "wb");
		}
	}
	
	public function get($key) {
		$new_key = substr(md5($key), 0, 8);
		//$the_path = $this->thePath.implode("/", str_split($new_key, "2"))."/";
		$the_path = $this->thePath.substr($new_key, 0, 2)."/";
		if(is_file($the_path.$new_key)) {
			$result = unserialize($this->GetFile($the_path.$new_key));
			if($result['expire']>$_SERVER["REQUEST_TIME"]) {
				return $result['value'];
			} else {
				@unlink($the_path.$new_key);
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function remove($key) {
		$new_key = substr(md5($key), 0, 8);
		//$the_path = $this->thePath.implode("/", str_split($new_key, "2"))."/";
		$the_path = $this->thePath.substr($new_key, 0, 2)."/";
		@unlink($the_path.$new_key);
	}
	
	public function clean() {
		$thePath = array_shift(pathinfo($this->thePath))."/";
		if ($handle = opendir($thePath)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") MultiDel($thePath.$file);
			}
			closedir($handle);
			return true;
		}
		return false;
	}
}

/*-------------------------------------------MyCache_MySQL--------------------------------------------------*/

class MyCache_MySQL extends class_common {
	protected $cnt;
	
	public function init($setting) {
		$result = false;
		if ($this->cnt = mysql_connect($setting['host'], $setting['user'], $setting['pass'])) {
			mysql_select_db($setting['name'], $this->cnt);
			$str_sql = "
CREATE TABLE IF NOT EXISTS `my_cache` (
	`key` char(32) NOT NULL,
	`expiration` int(10) NOT NULL,
	`value` text NOT NULL,
	PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
			$result = mysql_query($sql, $this->cnt);
		}
		return $result;
	}
	
	public function set($key, $value = "", $ttl = 300) {
		$new_key = md5($key);
		if(empty($value)) {
			return mysql_query("delete from my_cache where key='{$new_key}'", $this->cnt);
		} else {
			$expiration = $_SERVER["REQUEST_TIME"] + $ttl;
			$value = mysql_real_escape_string(serialize($value));
			return mysql_query("REPLACE INTO my_cache (key, expiration, value) VALUES ('{$new_key}', {$expiration} , '{$value}')", $this->cnt);
		}
	}
	
	public function get($key) {
		$new_key = md5($key);
		if($result = mysql_query("SELECT value FROM my_cache WHERE key = '{$new_key}' AND expiration > UNIX_TIMESTAMP()", $this->cnt)) {
			if(mysql_num_rows($result)) {
				$record = mysql_fetch_assoc($result);
				return unserialize($record['value']);
			}
		}
		return false;
	}
	
	public function remove($key) {
		$new_key = md5($key);
		return mysql_query("delete from my_cache where key='{$new_key}'", $this->cnt);
	}
	
	public function clean() {
		return mysql_query("DELETE FROM my_cache WHERE expiration < UNIX_TIMESTAMP()", $this->cnt);
	}
}
?>