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
			$print = $_POST['print'];
			unset($_POST['mid'], $_POST['print']);
			$_POST_org = $_POST;
			foreach($_POST as $key => $value) {
				if(is_array($value)) {
					if(is_numeric($value[0])) {
						$_POST[$key] = array_sum($value);
					} else {
						$_POST[$key] = implode(",", $value);
					}
				}
			}
			$_POST['add_date'] = date("Y-m-d H:i:s");
			$str_sql = $db->buildSQL($setting['db']['pre']."custom_form_".$mid, $_POST, "insert", "a");
			$db->Query($str_sql);
			$_POST = $_POST_org;
			//debug($_POST);
			if(empty($print)) {
				echo '
				<script>
					alert("'.$setting['language']['plugin_custom_form_done'].'");
					location.href="/";
				</script>
				';
			} else {
				$module = "cf_print";
			}
			unset($_COOKIE['cf_time']);
			$req->setCookie("cf_done", time()+300, 300);
			if(empty($print)) $mystep->pageEnd(false);
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
	
	$the_name = $db->GetSingleResult("select name".($setting['gen']['language']=="en"?"_en":"")." from ".$setting['db']['pre']."custom_form where mid=".$mid);
	HtmlTrans($the_name);
	$setting['web']['title'] = $the_name."_".$setting['web']['title'];
	
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
		$limit = (($page-1)*$page_size).", ".$page_size;
		$GLOBALS['mid'] = $mid;
	} elseif($module=="cf_print") {
		unset($tpl_tmp);
		$tpl->init($tpl_info, $cache_info, true);
		$tpl->Set_Variable('custom_form_name', $the_name);
		$tpl->Set_Variable('path_admin', $setting['path']['admin']);
		$setting['gen']['show_info'] = false;
		global $para;
		include("setting/{$mid}.php");
	}
	
	$GLOBALS['web_id'] = $setting['info']['web']['web_id'];
	if(isset($tpl_tmp)) {
		$tpl_tmp->Set_Variable('mid', $mid);
		$tpl_tmp->Set_Variable('custom_form_name', $the_name);
		$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting,$db,$para'));
		unset($tpl_tmp);
	}
	
	$mystep->show($tpl);
} else {
	$goto_url = "/";
}
?>