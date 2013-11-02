<?php
require("inc.php");

$method = $req->getServer("QUERY_STRING");
$log_info = "";
if($method=="update" && count($_POST)>0) {
	$log_info = $setting['language']['admin_web_rewrite_update'];

	$setting_new = array();
	$setting_new['rewrite'] = array();
	$setting_new['rewrite']['enable'] = ($_POST['rewrite']=="true");
	$setting_new['rewrite']['read'] = $_POST['read'];
	$setting_new['rewrite']['list'] = $_POST['list'];
	$setting_new['rewrite']['tag'] = $_POST['tag'];
	$para_new = array();
	$para_new["rewrite"] = array();
	$max_count = count($_POST['rule']);
	for($i=0; $i<$max_count; $i++) {
		if(empty($_POST['rule'][$i])) continue;
		$para_new["rewrite"][] = array($_POST['rule'][$i], $_POST['jump'][$i]);
	}
	changeSetting($setting_new, $para_new);
	if(!empty($_POST['rule_new'])) {
		if($_POST['write_type']=="IIS7") {
			if(is_file(ROOT_PATH."/web.config")) {
				$iis_setting = GetFile(ROOT_PATH."/web.config");
				if(preg_match("/<rewrite>.+<\/rewrite>/ism",$iis_setting,$match)) {
					$iis_setting = str_replace($match[0], $_POST['rule_new'], $iis_setting);
				} else {
					$iis_setting = str_replace("</system.webServer>", $_POST['rule_new']."</system.webServer>", $iis_setting);
				}
				WriteFile(ROOT_PATH."/web.config", $iis_setting, "wb");
			}
		} else {
			WriteFile(ROOT_PATH."/.htaccess", $_POST['rule_new'], "wb");
		}
	}
} else {
	$tpl_info['idx'] = "web_rewrite";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	$tpl_tmp->allow_script = true;
	$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_rewrite_title']);
	for($i=0,$m=count($rewrite_list);$i<$m;$i++) {
		$tpl_tmp->Set_Loop("rewrite", array("idx"=>$i+1, "rule"=>$rewrite_list[$i][0], "jump"=>$rewrite_list[$i][1]));
	}
	$tpl_tmp->Set_Variable('rewrite_1', $setting['rewrite']['enable']?"checked":"");
	$tpl_tmp->Set_Variable('rewrite_2', $setting['rewrite']['enable']?"":"checked");
	$tpl_tmp->Set_Variable('rewrite_read', $setting['rewrite']['read']);
	$tpl_tmp->Set_Variable('rewrite_list', $setting['rewrite']['list']);
	$tpl_tmp->Set_Variable('rewrite_tag', $setting['rewrite']['tag']);
	
	includeCache("plugin");
	$cnt = 1;
	for($i=0,$m=count($plugin);$i<$m;$i++) {
		$the_file = ROOT_PATH."/plugin/".$plugin[$i]['idx']."/info.php";
		if(file_exists("$the_file")) {
			include($the_file);
			if(isset($rewrite)) {
				for($j=0,$n=count($rewrite);$j<$n;$j++) {
					$tpl_tmp->Set_Loop("rewrite_plugin", array("idx"=>$cnt++, "rule"=>$rewrite[$j][0], "jump"=>$rewrite[$j][1], "plugin"=>$plugin[$i]['idx']));
				}
				unset($rewrite);
			}
		}
	}
	
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
}
if(!empty($log_info)) {
	write_log($log_info);
	$goto_url = $setting['info']['self'];	
}
$mystep->pageEnd(false);
?>