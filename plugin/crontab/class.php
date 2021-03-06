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
		global $db, $admin_cat;
		$strFind = array("{pre}", "{charset}");
		$strReplace = array($setting['db']['pre'], $setting['db']['charset']);
		$result = $db->ExeSqlFile(dirname(__FILE__)."/install.sql", $strFind, $strReplace);
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_crontab",1,$info['intro'],$info['copyright'],1,","));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,7,$info['cat_name'],'crontab.php', '../plugin/crontab/', 0, 0,$info['cat_desc']));
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
		$db->delete($setting['db']['pre']."crontab");
		$db->exec("drop","table",$setting['db']['pre']."crontab");
		$db->delete($setting['db']['pre']."admin_cat", array("file","=","crontab.php"));
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
			"/config.php",
			"/log.txt",
			"/status.txt",
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
	
	public static function page_end() {
		global $db, $setting, $plugin_setting;
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(strpos($agent, "spider")===false && strpos($agent, "bot")===false) return;
		$log_date = filemtime(dirname(__FILE__)."/log.txt");
		if((time()-$log_date)>$plugin_setting['crontab']['interval'] && !empty($GLOBALS['authority']) && file_get_contents(dirname(__FILE__)."/status.txt")=="run") {
			if($record = $db->record($setting['db']['pre']."crontab", "exe_date, next_date", array(array("next_date","f<","now()"),array("exe_date","!=","0000-00-00","and"),array(array("expire","=","0000-00-00"),array("expire","f>","now()","or"),"and")), array("order"=>"next_date","limit"=>"1"))) {
				$record['exe_date'] = strtotime($record['exe_date']);
				$record['next_date'] = strtotime($record['next_date']);
				if((time()-$log_date) > ($record['next_date']-$record['exe_date']+$plugin_setting['crontab']['interval'])) {
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