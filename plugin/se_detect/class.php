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
		global $db, $admin_cat;
		$strFind = array("{pre}", "{charset}");
		$strReplace = array($setting['db']['pre'], $setting['db']['charset']);
		$result = $db->ExeSqlFile(dirname(__FILE__)."/install.sql", $strFind, $strReplace);
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_se_detect",1,$info['intro'],$info['copyright'],1,""));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,7,$info['cat_name_1'],'se_detect.php', '../plugin/se_detect/', 0, 0,$info['cat_desc_1']));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,5,$info['cat_name_2'],'se_detect.php?method=view', '../plugin/se_detect/', 0, 0,$info['cat_desc_2']));
		deleteCache("admin_cat");
		deleteCache("plugin");
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_install']."
			<br />
			<pre>
			".join("\n------------------------\n", $err)."
			</pre>
			");
		} else {
			includeCache("admin_cat");
			$admin_cat = toJson($admin_cat, $setting['gen']['charset']);
			echo <<<mystep
<script language="javascript">
parent.admin_cat = {$admin_cat};
parent.setNav();
</script>
mystep;
			buildParaList("plugin");
			echo showInfo($setting['language']['plugin_install_done'], false);
		}
	}
	
	public static function uninstall() {
		global $db, $setting, $admin_cat;
		$info = self::info();
		$db->delete($setting['db']['pre']."se_detect");
		$db->exec("drop","table",$setting['db']['pre']."se_detect");
		$db->delete($setting['db']['pre']."se_count");
		$db->exec("drop","table",$setting['db']['pre']."se_count");
		$db->delete($setting['db']['pre']."admin_cat", array("file","like","se_detect.php"));
		$db->delete($setting['db']['pre']."plugin", array("idx","=",$info['idx']));
		deleteCache("admin_cat");
		deleteCache("plugin");
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_uninstall']."
			<br />
			<pre>
			".join("\n------------------------\n", $err)."
			</pre>
			");
		} else {
			includeCache("admin_cat");
			$admin_cat = toJson($admin_cat, $setting['gen']['charset']);
			echo <<<mystep
<script language="javascript">
parent.admin_cat = {$admin_cat};
parent.setNav();
</script>
mystep;
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
		$error = false;
		foreach($theList as $cur) {
			if(isWriteable(dirname(__FILE__).$cur)) {
				$result .= $cur . ' - <span style="color:green">Writable</span><br />';
			} else {
				$result .= $cur . ' - <span style="color:red">Readonly</span><br />';
				$error = true;
			}
		}
		if($error) $result .= '<span id="error"></span>';
		return $result;
	}
	
	public static function setting() {
		$plugin_setting['se_detect'] = null;
		if(is_file(dirname(__FILE__)."/config.php")) include(dirname(__FILE__)."/config.php");
		return $plugin_setting['se_detect'];
	}
	
	public static function page_start() {
		if(checkSign(255)) return;
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
				if($record = $db->record($setting['db']['pre']."se_detect","*",array(array("ip","=",$ip),array("ip","=",$ip2,"or")))) {
					$record['count'] += 1;
				} else {
					$record = array();
					$record['idx'] = $key;
					$record['ip'] = $ip;
					$record['count'] = 1;
				}
				$db->replace($setting['db']['pre']."se_detect", $record);
				
				$theDate = date("Y-m-d");
				if($record = $db->record($setting['db']['pre']."se_count","*",array("date","=",$theDate))) {
					$record[$key] += 1;
				} else {
					$record = array();
					$record['date'] = $theDate;
					$record[$key] = 1;
				}
				$db->replace($setting['db']['pre']."se_count", $record);
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
			if($record = $db->record($setting['db']['pre']."se_count","*",array("date","=",$theDate))) {
				if(isset($record[$setting['language']['etc']]))	$record[$setting['language']['etc']] += 1;
			} else {
				$record = array();
				$record['date'] = $theDate;
				$record[$setting['language']['etc']] = 1;
			}
			$db->replace($setting['db']['pre']."se_count", $record);
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