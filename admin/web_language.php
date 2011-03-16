<?php
require("inc.php");

$method = $req->getServer("QUERY_STRING");
$cur_lng = $req->getReq("cur_lng");
$log_info = "";

$language_info = array(
	"author" => "Windy2000",
	"email" => "windy2006@gmail.com",
	"update" => "",
	"for" => "Current Version"
);
$lng_dir = ROOT_PATH."/source/language/";
include($lng_dir."/default.php");
$new_lng = $language;
if(!empty($cur_lng) && is_file($lng_dir."/{$cur_lng}.php")) {
	include($lng_dir."/{$cur_lng}.php");
}
$new_lng = array_merge($new_lng, $language);
if(is_null($cur_lng)) $cur_lng = $setting['gen']['language'];

if($method=="update" && count($_POST)>0) {
	$log_info = $setting['language']['admin_web_language_update'];
	if(empty($cur_lng)) $cur_lng = "default";
	if(empty($_POST['lng_new_idx'])) {
		$setting['gen']['language'] = $cur_lng;
		$setting['cookie']['prefix'] = str_replace(substr(md5($_ENV["USERNAME"].$_ENV["COMPUTERNAME"].$_ENV["OS"]), 0, 4)."_", "", $setting['cookie']['prefix']);
		$expire_list = var_export($expire_list, true);
		$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$expire_list = {$expire_list};
?>
mystep;
		$content = str_replace("/*--settings--*/", makeVarsCode($setting, '$setting'), $content);
		WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
	} else {
		$cur_lng = $_POST['lng_new_idx'];
		$language_info = array(
			"author" => $_POST['lng_new_author'],
			"email" => $setting['web']['email'],
			"update" => date("Y-m-d"),
			"for" => $mystep_ver
		);
	}
	$language_info = var_export($language_info, true);
	strip_slash($_POST['language']);
	$language = var_export($_POST['language'], true);
	$content = <<<mystep
<?php
\$language_info = {$language_info};

\$language = {$language};
?>
mystep;
	WriteFile($lng_dir.$cur_lng.".php", $content, "wb");

	write_log($log_info, "cur_lng=".$cur_lng);
	$goto_url = $setting['info']['self'];
} else {
	$tpl_info['idx'] = "web_language";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_language_title']);
	$i=1;
	foreach($new_lng as $key => $value) {
		$value = htmlspecialchars($value);
		$tpl_tmp->Set_Loop("language", array("idx"=>$i++, "key"=>$key, "value"=>$value));
	}
	if($handle = opendir($lng_dir)) {
		while (false !== ($file = readdir($handle))) {
			$file = strtolower($file);
			if(is_file($lng_dir.$file) && GetFileExt($file)=="php" && basename($file)!="default.php") {
				$tpl_tmp->Set_Loop("lng", array("name"=>str_replace(".php", "", basename($file)), "selected"=>((basename($file)==($cur_lng.".php"))?"selected":"")));
			}
		}
		closedir($handle);
	}
	$tpl_tmp->Set_Variables($language_info, "lng_info");
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
}
$mystep->pageEnd(false);
?>