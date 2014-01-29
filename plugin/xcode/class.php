<?php
class plugin_xcode implements plugin {
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
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_xcode",1,$info['intro'],$info['copyright'],99,","));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,7,$info['cat_name'],'xcode.php', '../plugin/xcode/', 0, 0,$info['cat_desc']));
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
		global $db, $setting, $admin_cat, $mystep;
		$info = self::info();
		$db->delete($setting['db']['pre']."admin_cat", array("file","=","xcode.php"));
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
			$mydb = $mystep->getInstance("MyDB", "code", dirname(__FILE__));
			$record = $mydb->queryAll();
			for($i=0; $i<count($record); $i++) {
				unlink(dirname(__FILE__)."/code/".$record[$i]['idx'].".php");
			}
			$mydb->emptyTBL();
			unset($mydb);
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
			"/",
			"/code/",
			"/code.db",
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
	
	public static function page_start() {
		global $mystep, $setting, $req;
		if(strpos($req->getserver("PHP_SELF"),"/plugin/")!==false && $setting['info']['self']!="show.php") return;
		$mydb = $mystep->getInstance("MyDB", "code", dirname(__FILE__));
		if($mydb->checkTBL()) {
			if($record = $mydb->queryDate("page=".$setting['info']['self'], false, &$fp_pos, &$row_pos)) {
				for($i=0, $m=count($record); $i<$m; $i++) {
					if($record[$i]["position"]==0) include(dirname(__FILE__)."/code/".$record[$i]["idx"].".php");
				}
			}
			if($record = $mydb->queryDate("page=", false, &$fp_pos, &$row_pos)) {
				for($i=0, $m=count($record); $i<$m; $i++) {
					if($record[$i]["position"]==0) include(dirname(__FILE__)."/code/".$record[$i]["idx"].".php");
				}
			}
		}
		return;
	}
	
	public static function page_end() {
		global $mystep, $setting, $req;
		if(strpos($req->getserver("PHP_SELF"),"/plugin/")!==false && $setting['info']['self']!="show.php") return;
		$mydb = $mystep->getInstance("MyDB", "code", dirname(__FILE__));
		if($mydb->checkTBL()) {
			if($record = $mydb->queryDate("page=".$setting['info']['self'], false, &$fp_pos, &$row_pos)) {
				for($i=0, $m=count($record); $i<$m; $i++) {
					if($record[$i]["position"]==1) include(dirname(__FILE__)."/code/".$record[$i]["idx"].".php");
				}
			}
			if($record = $mydb->queryDate("page=", false, &$fp_pos, &$row_pos)) {
				for($i=0, $m=count($record); $i<$m; $i++) {
					if($record[$i]["position"]==1) include(dirname(__FILE__)."/code/".$record[$i]["idx"].".php");
				}
			}
		}
		return;
	}
}
?>