<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";

$id = $req->getReq("id");
$log_info = "";
switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['plug_admin_cat_delete'];
		$db->Query("delete from ".$setting['db']['pre']."admin_cat where id = '{$id}'");
		deleteCache("admin_cat");
		break;
	case "pos":
		$log_info = $setting['language']['plug_admin_cat_pos'];
		$$sql_list = array();
		$max_count = count($_POST['id']);
		for($i=0; $i<$max_count; $i++) {
			if(!is_numeric($_POST['order'][$i])) continue;
			$sql_list[] = "update ".$setting['db']['pre']."admin_cat set `order`='".$_POST['order'][$i]."' where id=".$_POST['id'][$i];
		}
		$db->BatchExec($sql_list);
		deleteCache("admin_cat");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			if($method=="add_ok") {
				$log_info = $setting['language']['plug_admin_cat_add'];
				$str_sql = $db->buildSQL($setting['db']['pre']."admin_cat", $_POST, "insert", "a");
			} else {
				$log_info = $setting['language']['plug_admin_cat_edit'];
				$str_sql = $db->buildSQL($setting['db']['pre']."admin_cat", $_POST, "update", "id={$id}");
			}
			$db->Query($str_sql);
			deleteCache("admin_cat");
		}
		break;
	default:
		$goto_url = $setting['info']['self'];
}

if(!empty($log_info)) {
	write_log($log_info, "id=".$id);
	includeCache("admin_cat");
	$admin_cat = json_encode(chg_charset($admin_cat, $setting['gen']['charset'], "utf-8"));
	echo <<<mystep
<script language="javascript">
try{
	parent.admin_cat = {$admin_cat};
	parent.setNav();
} catch(e){}
location.href="{$setting['info']['self']}";
</script>
mystep;
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $id;

	$tpl_info = array(
		"idx" => ($method=="list"?"list":"input"),
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$max_count = count($GLOBALS['admin_cat']);
		for($i=0; $i<$max_count; $i++) {
			switch($GLOBALS['admin_cat'][$i]['web_id']) {
				case "0":
					$GLOBALS['admin_cat'][$i]['web_id'] = $setting['language']['plug_admin_cat_panle'];
					break;
				case "255":
					$GLOBALS['admin_cat'][$i]['web_id'] = $setting['language']['plug_admin_cat_allsub'];
					break;
				default:
					$webInfo = getParaInfo("website", "web_id", $GLOBALS['admin_cat'][$i]['web_id']);
					$GLOBALS['admin_cat'][$i]['web_id'] = $webInfo['name'];
					break;
			}
			$tpl->Set_Loop('record', $GLOBALS['admin_cat'][$i]);
			$max_count2 = count($GLOBALS['admin_cat'][$i]['sub']);
			for($j=0; $j<$max_count2; $j++) {
				switch($GLOBALS['admin_cat'][$i]['sub'][$j]['web_id']) {
					case "0":
						$GLOBALS['admin_cat'][$i]['sub'][$j]['web_id'] = $setting['language']['plug_admin_cat_panle'];
						break;
					case "255":
						$GLOBALS['admin_cat'][$i]['sub'][$j]['web_id'] = $setting['language']['plug_admin_cat_allsub'];
						break;
					default:
						$GLOBALS['admin_cat'][$i]['sub'][$j]['web_id'] = $GLOBALS['website'][$GLOBALS['admin_cat'][$i]['sub'][$j]['web_id']];
						break;
				}
				$GLOBALS['admin_cat'][$i]['sub'][$j]['name'] = "&nbsp; &nbsp; ".$GLOBALS['admin_cat'][$i]['sub'][$j]['name'];
				$tpl->Set_Loop('record', $GLOBALS['admin_cat'][$i]['sub'][$j]);
			}
		}
		$tpl->Set_Variable('admin_path', $setting['path']['admin']);
		$tpl->Set_Variable('title', $setting['language']['plug_admin_cat_title']);
	} else {
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."admin_cat where id='{$id}'");
			$record  = $db->GetRS();
			$db->Free();
			if(!$record) {
				$tpl->Set_Variable('main', showInfo($setting['language']['plug_admin_cat_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			$web_id = $record['web_id'];
			HtmlTrans(&$record);
		} else {
			$record = array();
			$record['id'] = 0;
			$record['pid'] = 0;
			$record['name'] = "";
			$record['file'] = "";
			$record['path'] = "";
			$record['web_id'] = "0";
			$record['order'] = "0";
			$record['comment'] = "";
		}
		$tpl->Set_Variables($record);
		
		$tpl->Set_Variable('title', ($method=='add'?$setting['language']['plug_admin_cat_add']:$setting['language']['plug_admin_cat_edit']));
		$tpl->Set_Variable('method', $method);
		$tpl->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
		$max_count = count($GLOBALS['website']);
		for($i=0; $i<$max_count; $i++) {
			$tpl->Set_Loop("website", $GLOBALS['website'][$i]);
		}
		$max_count = count($GLOBALS['admin_cat']);
		for($i=0; $i<$max_count; $i++) {
			$tpl->Set_Loop("cat", array("id"=>$GLOBALS['admin_cat'][$i]['id'], "name"=>$GLOBALS['admin_cat'][$i]['name'], "selected"=>($GLOBALS['admin_cat'][$i]['id']==$record['pid']?"selected":"")));
		}
	}
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$db->Free();
	$mystep->show($tpl);
	return;
}
?>