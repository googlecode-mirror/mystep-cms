<?php
$mid = $req->getReq("mid");
$record = false;
if(!empty($mid) && is_numeric($mid)) {
	$record = $db->record($setting['db']['pre']."custom_form","*",array("mid","n=",$mid));
}
if($record==false) {
	$goto_url = "/";
	$mystep->pageEnd(false);
}
if(!empty($record['expire']) && (strtotime($record['expire']) < $req->getServer("REQUEST_TIME"))) {
	$tpl_info['idx'] = "expire";
	$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/";
	$tpl = $mystep->getInstance("MyTpl", $tpl_info, false);
	$tpl->Set_Variable('expire_info', $setting['language']['plugin_custom_form_expire']);
	$mystep->show($tpl);
} else {
	if(count($_POST)>0) {
		if(isset($_COOKIE['cf_time'])) {
			if($req->getCookie("cf_done")>$req->getServer("REQUEST_TIME")) {
				echo '
				<script>
					alert("'.$setting['language']['plugin_custom_form_error_1'].'");
					history.go(-1);
				</script>
				';
			} else {
				$print = $_POST['print'];
				unset($_POST['mid'], $_POST['print']);
				//$_POST_org = $_POST;
				if(isset($_POST['append'])) {
					$append = $_POST['append'];
					unset($_POST['append']);
				}
				foreach($_POST as $key => $value) {
					if(is_array($value)) {
						if(is_numeric($value[0])) {
							$_POST[$key] = array_sum($value);
						} else {
							$_POST[$key] = implode(",", $value);
						}
					}
					if($setting['gen']['language']=="en") {
						if(strpos($key,"_en")>0) {
							$_POST[$key] = ucwords(strtolower($value));
						} else {
							$_POST[$key] = itemTrans($value, $key, 1, 0);
						}
					}
				}
				if(count($_FILES)>0) {
					$path_upload = dirname(__FILE__)."/setting/".$mid."/";
					MakeDir($path_upload);
					foreach($_FILES as $key => $value) {
						if($key=="append") {
							$m=count($_FILES['append']['name']);
							foreach($_FILES['append']['name'][0] as $k => $v) {
								for($i=0;$i<$m;$i++) {
									if(!empty($_FILES['append']['name'][$i][$k])) {
										$new_name = md5($_FILES['append']['name'][$i][$k].$_FILES['append']['type'][$i][$k].$_FILES['append']['size'][$i][$k]);
										@unlink($path_upload.$new_name);
										move_uploaded_file($_FILES['append']['tmp_name'][$i][$k], $path_upload.$new_name);
										$append[$i][$k] = $_FILES['append']['name'][$i][$k]."::".$_FILES['append']['type'][$i][$k]."::".$new_name;
									}
								}
							}
						} else {
							if(!empty($value['name'])) {
								$new_name = md5($value['name'].$value['type'].$value['size']);
								@unlink($path_upload.$new_name);
								move_uploaded_file($value['tmp_name'], $path_upload.$new_name);
								$_POST[$key] = $value['name']."::".$value['type']."::".$new_name;
							}
						}
					}
				}
				
				$_POST['add_date'] = date("Y-m-d H:i:s");
				$db->insert($setting['db']['pre']."custom_form_".$mid, $_POST, true);
				$_POST['id'] = $db->GetInsertID();
				if(isset($append)) {
					for($i=0,$m=count($append);$i<$m;$i++) {
						$flag = true;
						foreach($append[$i] as $key => $value) {
							if(empty($value)) {
								$flag = false;
								break;
							}
							if(isset($_POST[$key])) $_POST[$key] = $value;
						}
						if(!$flag) continue;
						$db->insert($setting['db']['pre']."custom_form_".$mid, $_POST, true);
					}
				}
				//$_POST = $_POST_org;
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
				$req->setCookie("cf_done", $req->getServer("REQUEST_TIME")+300, 300);
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
	
	$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
	$tpl_info['idx'] = $mid."_".$module."_".($setting['gen']['language']=="en"?"en":"cn");
	$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/setting/";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	$the_name = $db->result($setting['db']['pre']."custom_form", "name".($setting['gen']['language']=="en"?"_en":""), array("mid","n=",$mid));
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
		$count = $db->result($setting['db']['pre']."custom_form_".$mid, "count(*)");
		$tpl_tmp->Set_Variable('custom_form_count', $count);
		$tpl_tmp->Set_Variable('page_list', PageList($page, ceil($count/$page_size)));
		$limit = (($page-1)*$page_size).", ".$page_size;
		$GLOBALS['mid'] = $mid;
	} elseif($module=="cf_print") {
		global $para;
		unset($tpl_tmp);
		$GLOBALS['mid'] = $mid;
		$tpl->init($tpl_info, $cache_info, true);
		$tpl->Set_Variable('custom_form_name', $the_name);
		$tpl->Set_Variable('path_admin', $setting['path']['admin']);
		$setting['gen']['show_info'] = false;
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
}
?>