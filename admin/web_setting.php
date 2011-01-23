<?php
require("inc.php");

$method = $req->getServer("QUERY_STRING");
$log_info = "";

if($method=="update") {
	$log_info = "更新设置";
	$_POST['setting']['watermark']['mode'] = array_sum($_POST['setting']['watermark']['mode']);
	if(empty($_POST['setting']['web']['s_pass'])) {
		$_POST['setting']['web']['s_pass'] = $setting['web']['s_pass'];
	} else {
		$_POST['setting']['web']['s_pass'] = md5($_POST['setting']['web']['s_pass']);
	}
	if(empty($_POST['setting']['db']['pass'])) {
		$_POST['setting']['db']['pass'] = $setting['db']['pass'];
	}
	unset($_POST['setting']['web']['s_pass_r'], $_POST['setting']['db']['pass_r']);
	$expire_list = var_export($expire_list);
	
	$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$expire_list = {$expire_list};
?>
mystep;
	$content = str_replace("/*--settings--*/", makeVarsCode($_POST['setting'], '$setting'), $content);
	WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
	if(isset($_POST['set_default'])) {
		WriteFile(ROOT_PATH."/include/config-default.php", $content, "wb");
	}
} elseif($method=="restore") {
	$log_info = "恢复设置";
	if(is_file(ROOT_PATH."include/config-default.php")) {
		unlink(ROOT_PATH."include/config.php");
		copy(ROOT_PATH."include/config-default.php", ROOT_PATH."include/config.php");
	}
}

if(!empty($log_info)) {
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"], $log_info);
	$goto_url = $self;
} else {
	$tpl_info['idx'] = "web_setting";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	$tpl_tmp->Set_Variable('title', "网站参数设置");
	$setting['watermark']['mode'] = array($setting['watermark']['mode']&1==1, $setting['watermark']['mode']&2==2);
	
	include(ROOT_PATH."/include/config-detail.php");
	foreach($setting_comm as $key => $value) {
		if(substr($key, -5)=="_comm") {
			$tpl_tmp->Set_Loop("anchor", array("pos"=>str_replace("_comm", "", $key), "name"=>$value));
		}
	}
	$setting['cookie']['prefix'] = str_replace(substr(md5($_ENV["USERNAME"].$_ENV["COMPUTERNAME"].$_ENV["OS"]), 0, 4)."_", "", $setting['cookie']['prefix']);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_temp);
	$mystep->show($tpl);
}
$mystep->pageEnd(false);
?>