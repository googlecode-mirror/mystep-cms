<?php
class plugin_email implements plugin {
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
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['ver'].'", "plugin_email", 1, "'.$info['intro'].'", "'.$info['copyright'].'", 1, ",")');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 7, '".$info['cat_name']."', 'email.php', '../plugin/email/', 0, 0, '".$info['cat_desc']."')");
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
		$db->query("truncate table ".$setting['db']['pre']."email");
		$db->query("drop table ".$setting['db']['pre']."email");
		$db->query("delete from ".$setting['db']['pre']."admin_cat where file='email.php'");
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
			"/send.log",
			"/attachment/",
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
		$plugin_setting['email'] = null;
		if(is_file(dirname(__FILE__)."/config.php")) include(dirname(__FILE__)."/config.php");
		return $plugin_setting['email'];
	}
}
?>