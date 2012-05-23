<?php
$mid = $req->getReq("mid");

if(count($_POST)>0) {
	if(isset($_COOKIE['cf_time'])) {
		if($req->getCookie("cf_done")>time()) {
			echo '
			<script>
				alert("'.$setting['language']['plugin_custom_form_error_1'].'");
				history.go(-1);
			</script>
			';
		} else {
			unset($_POST['mid']);
			foreach($_POST as $key => $value) {
				if(is_array($value)) {
					if(is_numeric($value[0])) {
						$value = array_sum($value);
					} else {
						$value = implode(",", $value);
					}
				}
			}
			$_POST['add_date'] = date("Y-m-d H:i:s");
			$str_sql = $db->buildSQL($setting['db']['pre']."custom_form_".$mid, $_POST, "insert", "a");
			$db->Query($str_sql);
			echo '
			<script>
				alert("'.$setting['language']['plugin_custom_form_done'].'");
				location.href="/";
			</script>
			';
			unset($_COOKIE['cf_time']);
			$req->setCookie("cf_done", time()+300, 300);
			$mystep->pageEnd(false);
		}
	} else {
		echo '
		<script>
			alert("'.$setting['language']['plugin_custom_form_error_2'].'");
			history.go(-1);
		</script>
		';
	}
}

if(!empty($mid) && is_numeric($mid)) {
	$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
		
	$tpl_info['idx'] = $mid."_".$module."_".($setting['gen']['language']=="en"?"en":"cn");
	$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/setting/";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($module=="cf_submit") {
		$tpl_tmp->allow_script = true;
		global $para;
		include("setting/{$mid}.php");
	} elseif($module=="cf_list") {
		global $limit;
		$page = $req->getGet("page");
		if(!is_numeric($page) || $page < 1) $page = 1;
		$page_size = $setting['list']['txt'];
		$count = $db->getSingleResult("select count(*) from ".$setting['db']['pre']."custom_form_".$mid);
		$tpl_tmp->Set_Variable('custom_form_count', $count);
		$tpl_tmp->Set_Variable('page_list', PageList($page, ceil($count/$page_size)));
		$tpl_tmp->Set_Variable('title', $setting['web']['title']);
		$limit = (($page-1)*$page_size).", ".$page_size;
		$GLOBALS['mid'] = $mid;
	}
	
	$GLOBALS['web_id'] = $setting['info']['web']['web_id'];
	$tpl_tmp->Set_Variable('mid', $mid);
	$tpl_tmp->Set_Variable('custom_form_name', $db->GetSingleResult("select name".($setting['gen']['language']=="en"?"_en":"")." from ".$setting['db']['pre']."custom_form where mid=".$mid));
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting,$db,$para'));
	unset($tpl_tmp);
	
	$mystep->show($tpl);
} else {
	$goto_url = "/";
}

$mystep->pageEnd();
?>