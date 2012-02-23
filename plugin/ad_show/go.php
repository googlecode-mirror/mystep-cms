<?php
$id = $req->getGet("id");
$agent = strtolower($req->getServer('HTTP_USER_AGENT'));
if(is_numeric($id) && strpos($agent, "spider")===false && strpos($agent, "bot")===false) {
	$goto_url = $db->GetSingleResult("select ad_url from ".$setting['db']['pre']."ad_show where id='{$id}'");
	if(!empty($goto_url)) {
		$if_click = $req->getCookie("img_click_".$id);
		if(!empty($if_click)) {
			$new_ip = 0;
		} else {
			$req->setCookie("img_click_".$id, "Y", 3600*24);
			WriteFile(dirname(__FILE__)."/ipdata/{$id}.csv", "click,".GetIp().",".date("Y-m-d H:i:s")."\n", "ab");
			$new_ip = 1;
		}
		$db->query("update ".$setting['db']['pre']."ad_show set click=click+1, ip_click=ip_click+{$new_ip} where id='{$id}'");
	} else {
		$goto_url = "/";
	}
} else {
	$goto_url = "/";
}
$mystep->pageEnd();
?>