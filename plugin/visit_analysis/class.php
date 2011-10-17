<?php
class plugin_visit_analysis implements plugin {
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
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['ver'].'", "plugin_visit_analysis", 1, "'.$info['intro'].'", "'.$info['copyright'].'", 1)');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 7, '".$info['cat_name_1']."', 'visit_analysis.php?method=referer', '../plugin/visit_analysis/', 0, 0, '".$info['cat_desc_1']."')");
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 7, '".$info['cat_name_2']."', 'visit_analysis.php?method=keyword', '../plugin/visit_analysis/', 0, 0, '".$info['cat_desc_2']."')");
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
		$db->query("truncate table ".$setting['db']['pre']."visit_analysis");
		$db->query("drop table ".$setting['db']['pre']."visit_analysis");
		$db->query("truncate table ".$setting['db']['pre']."visit_keyword");
		$db->query("drop table ".$setting['db']['pre']."visit_keyword");
		$db->query("delete from ".$setting['db']['pre']."admin_cat where file like 'visit_analysis.php%'");
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
		return "";
	}
	
	public static function referer_analysis() {
		global $db, $setting, $req;
		$referer = $req->getServer("HTTP_REFERER");
		if(!empty($referer)) {
			$url_info = parse_url($referer);
			if($url_info['host']==$req->getServer("HTTP_HOST")) return;
			if($record = $db->getSingleRecord("select * from ".$setting['db']['pre']."visit_analysis where domain='".$url_info['host']."'")) {
				$db->Query("update ".$setting['db']['pre']."visit_analysis set `count`=`count`+1, `chg_date`=UNIX_TIMESTAMP() where domain='".$url_info['host']."'");
			} else {
				$db->Query("insert into ".$setting['db']['pre']."visit_analysis values(0, '".$url_info['host']."', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), 1)");
			}
			//keyword
		} else {
			$db->Query("update ".$setting['db']['pre']."visit_analysis set `count`=`count`+1, `chg_date`=UNIX_TIMESTAMP() where domain='None'");
		}
		return;
	}
}
?>