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
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['var'].'", "'.$info['plugin_se_detect'].'", 1, "'.$info['intro'].'", "'.$info['copyright'].'", 1)');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 7, '".$info['cat_name']."', 'se_detect.php', '../plugin/se_detect/', 0, 0, '".$info['cat_desc']."')");
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 5, '".$info['cat_name']."', 'se_detect.php?method=view', '../plugin/se_detect/', 0, 0, '".$info['cat_desc']."')");
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
			showInfo($setting['language']['plugin_install_done']);
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
			showInfo($setting['language']['plugin_uninstall_done']);
		}
	}
	
	public static function info() {
		$info = null;
		if(is_file(dirname(__FILE__)."/info.php")) include(dirname(__FILE__)."/info.php");
		return $info;
	}	
	
	public static function check() {
		//make some check for current plugin
		return "";
	}
	
	public static function setting() {
		$plugin_setting['se_detect'] = null;
		if(is_file(dirname(__FILE__)."/config.php")) include(dirname(__FILE__)."/config.php");
		return $plugin_setting['se_detect'];
	}
	
	public static function page_start() {
		global $db, $setting;
		$plugin_setting = self::setting();
		$ip = getIp();
		$ip2 = substr($ip, 0, strrpos($ip, ".")).".*";
		$record = $db->getSingleRecord("select * from ".$setting['db']['pre']."se_detect where ip='{$ip}' || ip='{$ip2}'");
		if($plugin_setting['counter']) $db->query("update ".$setting['db']['pre']."se_detect set `count`=`count`+1 where ip='".$record['ip']."'");
		
		if($counter = $db->GetSingleRecord("select * from ".$setting['db']['pre']."se_count where date=curdate()")) {
			$counter[$record['idx']] += 1;
		} else {
			$counter = array();
			$counter['date'] = date("Y-m-d");
			$counter[$record['idx']] = 1;
		}
		$db->Query($db->buildSQL($setting['db']['pre']."se_count", $counter, "replace"));
		
		if(strpos($plugin_setting['ban'], $record['idx'])!==false) {
			header("HTTP/1.1 404 Not Found");
			exit();
		}
		return;
	}
}
?>