<?php
require("inc.php");

$method = $req->getServer("QUERY_STRING");
$log_info = "";
if($method=="update" && count($_POST)>0) {
	$log_info = $setting['language']['admin_web_rewrite_update'];
	$cur_setting = $setting;
	unset($setting);
	include(ROOT_PATH."/include/config.php");
	$setting['rewrite']['enable'] = ($_POST['rewrite']=="true");
	$setting['rewrite']['read'] = $_POST['read'];
	$setting['rewrite']['list'] = $_POST['list'];
	$setting['rewrite']['tag'] = $_POST['tag'];
	$rewrite_list = array();
	$max_count = count($_POST['rule']);
	for($i=0; $i<$max_count; $i++) {
		if(empty($_POST['rule'][$i])) continue;
		$rewrite_list[] = array($_POST['rule'][$i], $_POST['jump'][$i]);
	}
	$rewrite_list = var_export($rewrite_list, true);
	$expire_list = var_export($expire_list, true);
	$ignore_list = var_export($ignore_list, true);
	$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$rewrite_list = {$rewrite_list};
\$expire_list = {$expire_list};
\$ignore_list = {$ignore_list};
\$authority = "{$authority}";
?>
mystep;
	$content = str_replace("/*--settings--*/", makeVarsCode($setting, '$setting'), $content);
	WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
	if(!empty($_POST['rule_new'])) WriteFile(ROOT_PATH."/.htaccess", $_POST['rule_new'], "wb");
	unset($setting);
	$setting = $cur_setting;
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