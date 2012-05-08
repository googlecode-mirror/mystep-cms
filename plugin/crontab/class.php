<?php
class plugin_crontab implements plugin {
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
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['ver'].'", "plugin_crontab", 1, "'.$info['intro'].'", "'.$info['copyright'].'", 1, ",")');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 7, '".$info['cat_name']."', 'crontab.php', '../plugin/crontab/', 0, 0, '".$info['cat_desc']."')");
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
		$db->query("truncate table ".$setting['db']['pre']."crontab");
		$db->query("drop table ".$setting['db']['pre']."crontab");
		$db->query("delete from ".$setting['db']['pre']."admin_cat where file='crontab.php'");
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
			"/config.php",
			"/log.txt",
			"/status.txt",
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
	
	public static function page_end() {
		global $db, $setting, $plugin_setting;
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(strpos($agent, "spider")===false && strpos($agent, "bot")===false) return;
		$log_date = filemtime(dirname(__FILE__)."/log.txt");
		if((time()-$log_date)>$plugin_setting['crontab']['interval'] && !empty($GLOBALS['authority']) && file_get_contents(dirname(__FILE__)."/status.txt")=="run") {
			if($record = $db->GetSingleRecord("select exe_date, next_date from ".$setting['db']['pre']."crontab where next_date<now() and exe_date!='0000-00-00' and (expire='0000-00-00' || expire>now()) order by next_date limit 1")) {
				$record['exe_date'] = strtotime($record['exe_date']);
				$record['next_date'] = strtotime($record['next_date']);
				if((time()-$log_date) > ($record['next_date']-$record['exe_date']+300)) {
					if($fp = @fopen("http://".$_SERVER["HTTP_HOST"].str_replace(ROOT_PATH, "", str_replace("\\", "/", dirname(__file__)))."/run.php?".$GLOBALS['authority']."=".urlencode($plugin_setting['crontab']['s_pass']), "r")) {
						$buffer = fgets($fp, 4096);
						fclose($fp);
					}
				}
			}
		}
	}
}
?>