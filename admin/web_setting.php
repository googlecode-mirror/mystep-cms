<?php
require("inc.php");

$method = $req->getServer("QUERY_STRING");
$log_info = "";

if($method=="update") {
	$log_info = $setting['language']['admin_web_setting_update'];
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
	$expire_list = var_export($expire_list, true);
	
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
	$log_info = $setting['language']['admin_web_setting_restore'];
	if(is_file(ROOT_PATH."include/config-default.php")) {
		unlink(ROOT_PATH."include/config.php");
		copy(ROOT_PATH."include/config-default.php", ROOT_PATH."include/config.php");
	}
}

if(!empty($log_info)) {
	write_log($log_info);
	$goto_url = $setting['info']['self'];
} else {
	$tpl_info['idx'] = "web_setting";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_setting_title']);
	
	include(ROOT_PATH."/include/config-detail.php");
	foreach($setting_comm as $key => $value) {
		if(substr($key, -5)=="_comm") {
			$tpl_tmp->Set_Loop("anchor", array("pos"=>str_replace("_comm", "", $key), "name"=>$value));
		}
	}
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content());
	unset($tpl_tmp);
	$mystep->show($tpl);
}
$mystep->pageEnd(false);
?>