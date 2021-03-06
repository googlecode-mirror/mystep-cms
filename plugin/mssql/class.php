<?php
class plugin_mssql implements plugin {
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
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_mssql",1,$info['intro'],$info['copyright'],1,""));
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
			buildParaList("plugin");
			echo showInfo($setting['language']['plugin_install_done'], false);
		}
	}
	
	public static function uninstall() {
		global $db, $setting, $admin_cat;
		$info = self::info();
		$db->delete($setting['db']['pre']."plugin", array("idx","=",$info['idx']));
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
		return;
	}

	public static function setting() {
		$plugin_setting['mssql'] = null;
		if(is_file(dirname(__FILE__)."/config.php")) include(dirname(__FILE__)."/config.php");
		return $plugin_setting['mssql'];
	}
	
	public static function page_start() {
		global $mystep, $mssql;
		$plugin_setting = self::setting();
		if($plugin_setting['host']=="127.0.0.1" || $plugin_setting['host']=="localhost") {
			ini_set("mssql.secure_connection", "On");
		} else {
			ini_set("mssql.secure_connection", "Off");
		}
		$mssql = $mystep->getInstance("MSSQL", $plugin_setting['host'], $plugin_setting['user'], $plugin_setting['pass']);
		$mssql->Connect($plugin_setting['pconn'], $plugin_setting['name']);
		return;
	}
	
	public static function page_end() {
		global $mssql;
		$mssql->Close();
		return;
	}
}
?>