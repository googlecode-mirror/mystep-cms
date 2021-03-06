<?php
require("inc.php");
if($setting['gen']['cache']) {
	$cache_info = array(
			'idx' => 'index',
			'path' => $cache_path,
			'expire' => getCacheExpire(),
			);
} else {
	$cache_info = false;
}
$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
$web_id = $setting['info']['web']['web_id'];
if($tpl->Is_Cached()) {
	echo $tpl->Get_Content();
	$mystep->pageEnd($setting['gen']['show_info']);
}
$tpl_info['idx'] = "index";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_temp);

$mystep->show($tpl);
$mystep->pageEnd($setting['gen']['show_info']);
?>