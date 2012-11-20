<?php
$filename = $req->getGet("f");
$content = "";
$error = true;
if(empty($filename)) {
	if($setting['rewrite']['enable']) {
		$content = "Current Plugin cannot be run under rewrite mode!";
	} else {
		$filename = parse_url($req->getServer("HTTP_REFERER"));
		if($filename['host']!=$req->getServer("HTTP_HOST")) {
			$content = "Only the source code of current site can be shown!";
			$filename = $req->getServer("HTTP_REFERER");
		} else {
			$filename = $filename['path'];
			if(substr($filename,-1,1)=="/") $filename .= "index.php";
		}
	}
}
if(empty($content)) {
	$the_file = ROOT_PATH . "/" . $filename;
	if(is_file($the_file) && stripos($filename, "config.php")===false) {
		$content = GetFile($the_file);
		$content = htmlspecialchars($content);
		$error = false;
	} else {
		$content = "File cannot be found!";
	}
}
if($error) $content = "&nbsp;&nbsp;".$content;
$setting['gen']['show_info'] = false;

$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
$tpl_info['idx'] = "show";
$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$tpl_tmp->Set_Variable('file', $filename);
$tpl_tmp->Set_Variable('source', $content);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content());
unset($tpl_tmp);
$mystep->show($tpl);
?>