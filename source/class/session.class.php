<?php
class sess_mystep {
	public static $cnt;
	public static $skip;
	public static function sess_open($sess_path, $sess_name) {
		self::$skip = false;
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(strpos($agent, "spider")!==false || strpos($agent, "bot")!==false) self::$skip = true;
	}
	public static function sess_close() {
		if(self::$skip) return true;
		self::sess_gc();
	  return;
	}
	
	public static function sess_read($sid) {
		if(self::$skip) return "";
		global $setting;
		if($result = mysql_query("SELECT * FROM ".$setting['db']['pre']."user_online WHERE sid = '{$sid}' AND reflash > ".($_SERVER["REQUEST_TIME"]-($setting['session']['expire']*60)))) {
			if (mysql_num_rows($result)) {
				$record = mysql_fetch_assoc($result);
				$record['userinfo'] = unserialize($record['userinfo']);
				return MyReq::sessEncode($record);
			}
		} else {
			return "";
		}
	}
	
	public static function sess_write($sid, $sess_data) {
		if(self::$skip) return true;
		
		$sess_data = MyReq::sessDecode($sess_data);
		$sess_data['ip'] = mysql_escape_string($sess_data['ip']);
		$sess_data['userinfo'] = mysql_escape_string(serialize($sess_data['userinfo']));
		extract($sess_data);
		
		$file_list = array("ajax.php", "merge.php", "vcode.php","language.js.php", "setting.js.php");
		$file_this = array_shift(explode('?', basename($url)));
		if(array_search($file_this, $file_list)!==false) return true;
		
		include(ROOT_PATH."/include/config.php");
		$reflash = $_SERVER["REQUEST_TIME"];
		if(empty($username)) $username = "Guest";
		if(empty($usertype)) $usertype = 1;
		if(empty($usergroup)) $usergroup = 0;
		self::$cnt = mysql_connect($setting['db']['host'], $setting['db']['user'], $setting['db']['pass']);
		mysql_query("SET NAMES '".$setting['db']['charset']."'", self::$cnt);
		mysql_select_db($setting['db']['name']);
		$result = mysql_query("REPLACE INTO ".$setting['db']['pre']."user_online (sid, ip, username, usertype, usergroup, reflash, url, userinfo) VALUES ('{$sid}', '{$ip}', '{$username}', '{$usertype}', '{$usergroup}', '{$reflash}', '{$url}', '{$userinfo}')", self::$cnt);
		return $result;
	}
	
	public static function sess_destroy($sid) {
		if(self::$skip) return true;
		global $setting;
		return mysql_query("DELETE FROM ".$setting['db']['pre']."user_online WHERE sid='".$sid."'");
	}
	
	public static function sess_gc() {
		if(self::$skip) return true;
		include(ROOT_PATH."/include/config.php");
		if(is_resource(self::$cnt)) {
			mysql_query("DELETE FROM ".$setting['db']['pre']."user_online WHERE reflash < " . ($_SERVER["REQUEST_TIME"] - $setting['session']['expire'] * 60), self::$cnt);
			mysql_close(self::$cnt);
		}
		unset($setting);
		return;
	}
}

/*--------------------------------------------------------------------*/

class sess_mysql {
	private static $cnt;
	public static function sess_open($sess_path, $sess_name) {
		global $setting;
		$result = false;
		if (self::$cnt = mysql_connect($setting['db']['host'], $setting['db']['user'], $setting['db']['pass'])) {
			mysql_select_db($setting['db']['name']);
			$str_sql = "
CREATE TABLE IF NOT EXISTS `my_session` (
	`SID` char(32) NOT NULL,
	`expiration` int(10) NOT NULL,
	`value` text NOT NULL,
	PRIMARY KEY (`SID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;	
";
			$result = mysql_query($sql);
		}
		return $result;
	}
	
	public static function sess_close() {
		self::sess_gc(ini_get('session.gc_maxlifetime')); 
		return true;
	}
	
	public static function sess_read($sid) {
		if($result = mysql_query("SELECT value FROM my_session WHERE SID = '{$sid}' AND expiration > ".$_SERVER["REQUEST_TIME"], self::$cnt)) {
			if (mysql_num_rows($result)) {
				$record = mysql_fetch_assoc($result);
				return $record['value'];
			}
		} else {
			return "";
		}
	}
	
	public static function sess_write($sid, $sess_data) {
		global $setting;
		$expiration = $_SERVER["REQUEST_TIME"] + $setting['session']['expire'] * 60;
		$sess_data = mysql_real_escape_string($sess_data);
		$result = mysql_query("REPLACE INTO my_session (SID, expiration, value) VALUES ('{$sid}', {$expiration} , '{$sess_data}')", self::$cnt);
		return $result;
	}
	
	public static function sess_destroy($sid) {
		return mysql_query("DELETE FROM my_session WHERE SID=".$sid, self::$cnt);
	}
	
	public static function sess_gc($maxlifetime) {
		return mysql_query("DELETE FROM my_session WHERE expiration < " . ($_SERVER["REQUEST_TIME"] - $maxlifetime), self::$cnt);
	}
}

/*---------------------------------------------------------------------*/

class sess_file {
	public static function sess_open($sess_path, $sess_name) {
		MakeDir($sess_path);
		return true;
	}
	
	public static function sess_close() {
		self::sess_gc(ini_get('session.gc_maxlifetime')); 
		return true;
	}
	
	public static function sess_read($sid) {
		global $setting;
		return GetFile($setting['session']['path']."/sess_".$sid);
	}
	
	public static function sess_write($sid, $sess_data) {
		global $setting;
		return WriteFile($setting['session']['path']."/sess_".$sid, $sess_data, "w");
	}
	
	public static function sess_destroy($sid) {
		global $setting;
		return unlink($setting['session']['path']."/sess_".$sid);
	}
	
	public static function sess_gc($maxlifetime) {
		global $setting;
		$mydir = opendir($setting['session']['path']);
		while($file = readdir($mydir)) {
			if($file!="." && $file!="..") {
				$the_file = $setting['session']['path']."/".$file;
				if(filemtime($the_file)+$maxlifetime<$_SERVER["REQUEST_TIME"]) {
					unlink($the_file);
				}
			}
		}
		return true;
	}
}
?>