<?php
class plugin_se_detect implements plugin {
	public static function install() {
		global $setting;
		$info = self::info();
		if($plugin_info = getParaInfo("plugin", "idx", $info['idx'])) {
			showInfo(sprintf($setting['language']['plugin_err_dup'], $info['name']));
		}
		if($plugin_info = getParaInfo("plugin", "class", $info['class'])) {
			showInfo(sprintf($setting['language']['plugin_err_classname'], $info['name']));
		}
		global $db, $setting, $admin_cat;
		$strFind = array("{pre}", "{charset}");
		$strReplace = array($setting['db']['pre'], $setting['db']['charset']);
		$result = $db->ExeSqlFile(dirname(__FILE__)."/install.sql", $strFind, $strReplace);
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['ver'].'", "plugin_se_detect", 1, "'.$info['intro'].'", "'.$info['copyright'].'", 1, "")');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 7, '".$info['cat_name_1']."', 'se_detect.php', '../plugin/se_detect/', 0, 0, '".$info['cat_desc_1']."')");
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 5, '".$info['cat_name_2']."', 'se_detect.php?method=view', '../plugin/se_detect/', 0, 0, '".$info['cat_desc_2']."')");
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_install']."
			<br />
			<pre>
			".join("\n------------------------\n", $err)."
			</pre>
			");
		} else {
			deleteCache("admin_cat");
			includeCache("admin_cat");
			$admin_cat = toJson($admin_cat, $setting['gen']['charset']);
			echo <<<mystep
<script language="javascript">
parent.admin_cat = {$admin_cat};
parent.setNav();
</script>
mystep;
			deleteCache("plugin");
			buildParaList("plugin");
			echo showInfo($setting['language']['plugin_install_done'], false);
		}
	}
	
	public static function uninstall() {
		global $db, $setting, $admin_cat;
		$info = self::info();
		$db->query("truncate table ".$setting['db']['pre']."se_detect");
		$db->query("drop table ".$setting['db']['pre']."se_detect");
		$db->query("truncate table ".$setting['db']['pre']."se_count");
		$db->query("drop table ".$setting['db']['pre']."se_count");
		$db->query("delete from ".$setting['db']['pre']."admin_cat where file like 'se_detect.php%'");
		$db->query("delete from ".$setting['db']['pre']."plugin where idx='".$info['idx']."'");
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_uninstall']."
			<br />
			<pre>
			".join("\n------------------------\n", $err)."
			</pre>
			");
		} else {
			deleteCache("admin_cat");
			includeCache("admin_cat");
			$admin_cat = toJson($admin_cat, $setting['gen']['charset']);
			echo <<<mystep
<script language="javascript">
parent.admin_cat = {$admin_cat};
parent.setNav();
</script>
mystep;
			deleteCache("plugin");
			buildParaList("plugin");
			echo showInfo($setting['language']['plugin_uninstall_done'], false);
		}
	}
	
	public static function info() {
		$info = null;
		if(is_file(dirname(__FILE__)."/info.php")) include(dirname(__FILE__)."/info.php");
		return $info;
	}	
	
	public static function check() {
		$result = "";
		$theList = array(
			"/agent.php",
			"/agent.txt",
		);
		foreach($theList as $cur) {
			if(isWriteable(dirname(__FILE__).$cur)) {
				$result .= $cur . ' <span style="color:green">Writable</span><br />';
			} else {
				$result .= $cur . ' <span style="color:red">Readonly</span><br />';
			}
		}
		return $result;
	}
	
	public static function setting() {
		$plugin_setting['se_detect'] = null;
		if(is_file(dirname(__FILE__)."/config.php")) include(dirname(__FILE__)."/config.php");
		return $plugin_setting['se_detect'];
	}
	
	public static function page_start() {
		global $db, $setting;
		$plugin_setting = self::setting();
		include(dirname(__FILE__)."/agent.php");
		$agent_cur = strtolower($_SERVER['HTTP_USER_AGENT']);
		$ip = getIp();
		if(strpos($ip,",")>0) $ip = substr($ip, 0, strrpos($ip, ","));
		$ip2 = substr($ip, 0, strrpos($ip, ".")).".*";
		$GLOBALS['se_bot'] = "";
		foreach($agent as $key => $value) {
			if(strpos($agent_cur, strtolower($value))!==false) {
				if($record = $db->getSingleRecord("select * from ".$setting['db']['pre']."se_detect where ip='{$ip}' || ip='{$ip2}'")) {
					$record['count'] += 1;
				} else {
					$record = array();
					$record['idx'] = $key;
					$record['ip'] = $ip;
					$record['count'] = 1;
				}
				$db->Query($db->buildSQL($setting['db']['pre']."se_detect", $record, "replace"));
				
				$theDate = date("Y-m-d");
				if($record = $db->GetSingleRecord("select * from ".$setting['db']['pre']."se_count where date='".$theDate."'")) {
					$record[$key] += 1;
				} else {
					$record = array();
					$record['date'] = $theDate;
					$record[$key] = 1;
				}
				$db->Query($db->buildSQL($setting['db']['pre']."se_count", $record, "replace"));
				if(strpos($plugin_setting['ban'], $key)!==false) {
					header("HTTP/1.1 404 Not Found");
					exit();
				}
				$GLOBALS['se_bot'] = $key;
				break;
			}
		}
		if(empty($GLOBALS['se_bot']) && (strpos($agent_cur, "spider")!==false || strpos($agent_cur, "bot")!==false)) {
			$theDate = date("Y-m-d");
			if($record = $db->GetSingleRecord("select * from ".$setting['db']['pre']."se_count where date='".$theDate."'")) {
				if(isset($record['其他']))	$record['其他'] += 1;
			} else {
				$record = array();
				$record['date'] = $theDate;
				$record[$setting['language']['etc']] = 1;
			}
			$db->Query($db->buildSQL($setting['db']['pre']."se_count", $record, "replace"));
			WriteFile(dirname(__FILE__)."/agent.txt", $agent_cur."\n");
		}
		return;
	}
	
	public static function page_end() {
		global $req;
		if(!empty($GLOBALS['se_bot'])) {
			$req->setSession("username", $GLOBALS['se_bot']);
		}
	}
}
?>