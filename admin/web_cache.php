<?php
require("inc.php");

$method = $req->getServer("QUERY_STRING");
$log_info = "";

if($method=="update" && count($_POST)>0) {
	$log_info = $setting['language']['admin_web_cache_update'];
	$cur_setting = $setting;
	unset($setting);
	include(ROOT_PATH."/include/config.php");
	$setting['gen']['cache'] = ($_POST['cache']=="true");
	$setting['web']['cache_mode'] = $_POST['cache_mode'];
	$expire_list = array();
	$max_count = count($_POST['page']);
	for($i=0; $i<$max_count; $i++) {
		if($i==0) $_POST['page'][0] = "default";
		if(empty($_POST['page'][$i])) continue;
		eval('$value = '.$_POST['expire'][$i].';');
		$expire_list[$_POST['page'][$i]] = $value;
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
	unset($setting);
	$setting = $cur_setting;
} elseif($method=="clean") {
	ignore_user_abort("on");
	set_time_limit(0);
	$log_info = $setting['language']['admin_web_cache_clean'];
	$ccList = $req->getReq("list");
	if(empty($ccList)) $ccList = implode(",", $req->getPost('ccache'));
	$ccList = ",".$ccList.",";
	
	if(strpos($ccList, ",1,")!==false) {
		$cache_path = ROOT_PATH."/".$setting['path']['template']."/cache/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
	}
	if(strpos($ccList, ",2,")!==false) {
		$cache_path = ROOT_PATH."/".$setting['path']['cache']."/para/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
	}
	if(strpos($ccList, ",3,")!==false) {
		$cache_path = ROOT_PATH."/".$setting['path']['cache']."/script/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
	}
	if(strpos($ccList, ",4,")!==false) {
		$cache_path = ROOT_PATH."/".$setting['path']['cache']."/plugin/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
	}
	if(strpos($ccList, ",5,")!==false) {
		$cache_path = ROOT_PATH."/".$setting['path']['cache']."/session/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
	}
	if(strpos($ccList, ",6,")!==false) {
		MultiDel(ROOT_PATH."/".$setting['path']['upload'], "cache");
	}
	if(strpos($ccList, ",7,")!==false) {
		$cache_path = ROOT_PATH."/".$setting['path']['cache']."/html/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
	}
	if(strpos($ccList, ",8,")!==false) {
		$cache->clean();
		$cache_path = ROOT_PATH."/".$setting['path']['upload']."/tmp/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
	}
	$goto_url = $setting['info']['self'];
} else {
	$tpl_info['idx'] = "web_cache";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	$tpl_tmp->allow_script = true;
	$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_cache_title']);
	$i=1;
	foreach($expire_list as $key => $value) {
		$tpl_tmp->Set_Loop("expire", array("idx"=>$i++, "page"=>$key, "expire"=>$value));
	}
	$tpl_tmp->Set_Variable('cache_1', $setting['gen']['cache']?"checked":"");
	$tpl_tmp->Set_Variable('cache_2', $setting['gen']['cache']?"":"checked");
	
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