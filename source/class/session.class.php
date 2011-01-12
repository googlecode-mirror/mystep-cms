<?php
class sess_mystep {
	private static $cnt;
	public static function sess_open($sess_path, $sess_name) {
		global $setting;
		return self::$cnt = mysql_pconnect($setting['db']['host'], $setting['db']['user'], $setting['db']['pass']);
	}
	
	public static function sess_close() {
		self::sess_gc(ini_get('session.gc_maxlifetime'));
		mysql_close(self::$cnt);
	  return(true);
	}
	
	public static function sess_read($sid) {
		global $setting;
		if($result = mysql_query("SELECT * FROM ".$setting['db']['pre']."user_online WHERE sid = '{$sid}' AND reflash > ".(time()-($setting['session']['expire']*60)), self::$cnt)) {
			if (mysql_num_rows($result)) {
				$record = mysql_fetch_assoc($result);
				return MyReq::sessEncode($record);
			}
		} else {
			return "";
		}
	}
	
	public static function sess_write($sid, $sess_data) {
		global $setting;
		extract(MyReq::sessDecode($sess_data));
		$reflash = time();
		if(empty($usertype)) $usertype = 2;
		$result = mysql_query("REPLACE INTO ".$setting['db']['pre']."user_online (sid, ip, username, usertype, reflash, url) VALUES ('{$sid}', '{$ip}', '{$useranme}', '{$usertype}', '{$reflash}', '{$url}')", self::$cnt);
		return $result;
	}
	
	public static function sess_destroy($sid) {
		return mysql_query("DELETE FROM ".$setting['db']['pre']."user_online WHERE sid=".$sid, self::$cnt);
	}
	
	public static function sess_gc($maxlifetime) {
		global $setting;
		return mysql_query("DELETE FROM ".$setting['db']['pre']."user_online WHERE reflash < " . (time() - ($setting['session']['expire']*60) - $maxlifetime), self::$cnt);
	}
}

/*--------------------------------------------------------------------*/

class sess_mysql {
	private static $cnt;
	public static function sess_open($sess_path, $sess_name) {
		global $setting;
		$result = false;
		if (self::$cnt = mysql_connect($setting['db']['host'], $setting['db']['user'], $setting['db']['pass'])) {
			mysql_select_db($setting['db']['name'], self::$cnt);
			$str_sql = "
CREATE TABLE IF NOT EXISTS `my_session` (
	`SID` char(32) NOT NULL,
	`expiration` int(10) NOT NULL,
	`value` text NOT NULL,
	PRIMARY KEY (`SID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;	
";
			$result = mysql_query($sql, self::$cnt);
		}
		return($result);
	}
	
	public static function sess_close() {
		self::sess_gc(ini_get('session.gc_maxlifetime')); 
		return(true);
	}
	
	public static function sess_read($sid) {
		if($result = mysql_query("SELECT value FROM my_session WHERE SID = '{$sid}' AND expiration > ".time(), self::$cnt)) {
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
		$expiration = time() + $setting['session']['expire'] * 60;
		$sess_data = mysql_real_escape_string($sess_data);
		$result = mysql_query("REPLACE INTO my_session (SID, expiration, value) VALUES ('{$sid}', {$expiration} , '{$sess_data}')", self::$cnt);
		return $result;
	}
	
	public static function sess_destroy($sid) {
		return mysql_query("DELETE FROM my_session WHERE SID=".$sid, self::$cnt);
	}
	
	public static function sess_gc($maxlifetime) {
		return mysql_query("DELETE FROM my_session WHERE expiration < " . (time() - $maxlifetime), self::$cnt);
	}
}

/*---------------------------------------------------------------------*/

class sess_file {
	public static function sess_open($sess_path, $sess_name) {
		MakeDir($sess_path);
		return(true);
	}
	
	public static function sess_close() {
		self::sess_gc(ini_get('session.gc_maxlifetime')); 
		return(true);
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
		return(unlink($setting['session']['path']."/sess_".$sid));
	}
	
	public static function sess_gc($maxlifetime) {
		global $setting;
		$mydir = opendir($setting['session']['path']);
		while($file = readdir($mydir)) {
			if($file!="." && $file!="..") {
				$the_file = $setting['session']['path']."/".$file;
				if(filemtime($the_file)+$maxlifetime<time()) {
					unlink($the_file);
				}
			}
		}
		return true;
	}
}
?>