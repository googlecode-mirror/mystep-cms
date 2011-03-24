<?php
require("inc.php");

includeCache("plugin");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$idx = $req->getReq("idx");
$log_info = "";
$plugin_path = ROOT_PATH."/plugin/";

switch($method) {
	case "view":
	case "list":
	case "setting":
		if($method=="view" && ($plugin_info = getParaInfo("plugin", "idx", $idx))) {
			$goto_url = $setting['info']['self'];
		} else {
			build_page($method);
		}
		break;
	case "active":
		$log_info = $setting['language']['admin_web_plugin_active'];
		$db->Query("update ".$setting['db']['pre']."plugin set `active`=1-`active` where `idx`='".$idx."'");
		deleteCache("plugin");
		delTplCache($setting['gen']['template']);
		break;
	case "install":
	case "uninstall":
		include($plugin_path.$idx."/info.php");
		include($plugin_path.$idx."/class.php");
		if(isset($info['class'])) {
			$log_info = $method=="install"?$setting['language']['admin_web_plugin_install']:$setting['language']['admin_web_plugin_uninstall'];
			call_user_func(array($info['class'], $method));
		} else {
			$goto_url = $setting['info']['self'];
		}
		deleteCache("plugin");
		if($method=="install_ok") {
			foreach($_POST['plugin_setting'][$idx] as $key => $value) {
				if(is_array($value)) {
					$_POST['plugin_setting'][$idx][$key] = implode(",", $value);
				}
			}
			$result = <<<mystep
<?php
/*--settings--*/
?>
mystep;
			$result = str_replace("/*--settings--*/", makeVarsCode($_POST['plugin_setting'], '$plugin_setting'), $result);
			WriteFile($plugin_path.$idx."/config.php", $result, "w");
		}
		break;
	case "setting_ok":
		if(count($_POST) == 0 || !isset($_POST['plugin_setting'])) {
			$goto_url = $setting['info']['self'];
		} else {
			$log_info = $setting['language']['admin_web_plugin_setup'];
			foreach($_POST['plugin_setting'][$idx] as $key => $value) {
				if(is_array($value)) {
					$_POST['plugin_setting'][$idx][$key] = implode(",", $value);
				}
			}
			$result = <<<mystep
<?php
/*--settings--*/
?>
mystep;
			$result = str_replace("/*--settings--*/", makeVarsCode($_POST['plugin_setting'], '$plugin_setting'), $result);
			WriteFile($plugin_path.$idx."/config.php", $result, "w");
		}
		break;
	default:
		build_page("list");
}

if(!empty($log_info)) {
	write_log($log_info, "idx={$idx}");
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);


function build_page($method) {
	global $mystep, $req, $tpl, $tpl_info, $plugin, $setting, $idx, $plugin_path;

	$tpl_info['idx'] = "web_plugin_".$method;
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if($method == "list") {
		$fso = $mystep->getInstance("MyFSO");
		$plugin_list = $fso->Get_List($plugin_path);
		$max_count = count($plugin_list['dir']);
		$n = 0;
		for($i=0; $i<$max_count; $i++) {
			if(is_file($plugin_list['dir'][$i]."/info.php")) {
				include($plugin_list['dir'][$i]."/info.php");
				$info['id'] = ++$n;
				$info['install'] = "";
				$info['uninstall'] = "";
				if($plugin_info = getParaInfo("plugin", "idx", $info['idx'])) {
					$info['install'] = "none";
				} else {
					$info['uninstall'] = "none";
				}
				$info['active'] = $plugin_info['active']?$setting['language']['close']:$setting['language']['open'];
				$tpl_tmp->Set_Loop("plugin_list", $info);
			}
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_plugin_title']);
	} elseif($method=="setting") {
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_plugin_setup']);
		$plugin_info = getParaInfo("plugin", "idx", $idx);
		include($plugin_path.$idx."/info.php");
		if($plugin_info===false) {
			$tpl->Set_Variable('main', showInfo($setting['language']['admin_web_plugin_err'], 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		$info['description'] = nl2br($info['description']);
		$tpl_tmp->Set_Variable('idx', $plugin_info['idx']);
		$tpl_tmp->Set_Variable('name', $plugin_info['name']);
		$tpl_tmp->Set_Variable('description', $info['description']);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	} else {
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_plugin_install']);
		include($plugin_path.$idx."/info.php");
		$info['description'] = nl2br($info['description']);
		$tpl_tmp->Set_Variables($info);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting, $idx'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>