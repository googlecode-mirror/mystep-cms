<?php
require("inc.php");

includeCache("plugin");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$idx = $req->getReq("idx");
$log_info = "";
$plugin_path = ROOT_PATH."/plugin/";

switch($method) {
	case "list":
	case "setting":
		build_page($method);
		break;
	case "install":
	case "uninstall":
		include($plugin_path.$idx."/info.php");
		include($plugin_path.$idx."/class.php");
		if(isset($info['class'])) {
			$log_info = $method=="install"?"安装插件":"卸载插件";
			call_user_func(array($info['class'], $method));
		} else {
			$goto_url = $self;
		}
		deleteCache("plugin");
		break;
	case "setting_ok":
		if(count($_POST) == 0) {
			$goto_url = $self;
		} else {
			$log_info = "编辑插件设置";
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
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"]."&idx={$idx}", $log_info);
	$goto_url = $self;
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
				$tpl_tmp->Set_Loop("plugin_list", $info);
			}
		}
		$tpl_tmp->Set_Variable('title', '插件管理');
	} else {
		$tpl_tmp->Set_Variable('title', "插件参数设定");
		$plugin_info = getParaInfo("plugin", "idx", $idx);
		if(!is_file($plugin_path.$idx."/config.php") || !is_file($plugin_path.$idx."/config-detail.php") || $plugin_info===false) {
			$tpl->Set_Variable('main', showInfo("当前插件无可用设置信息！", 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		$tpl_tmp->Set_Variable('idx', $plugin_info['idx']);
		$tpl_tmp->Set_Variable('name', $plugin_info['name']);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting, $idx'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>