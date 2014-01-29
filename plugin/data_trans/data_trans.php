<?php
require("../inc.php");

$method = $req->getReq("method");
includeCache("news_cat");

$log_info = "";
switch($method) {
	case "trans":
		$cat_id = $req->getReq("cat_id");
		$org_id = $_POST['web_id_org'];
		$dst_id = $_POST['web_id_dst'];
		$log_info = $setting['language']['plugin_data_trans_title'];
		$setting_org = getSubSetting($org_id);
		$setting_dst = getSubSetting($dst_id);
		$pre_org = "{$setting_org['db']['name']}.{$setting_org['db']['pre']}";
		$pre_dst = "{$setting_dst['db']['name']}.{$setting_dst['db']['pre']}";
		if($pre_org==$pre_dst) {
			showInfo($setting['language']['plugin_data_trans_error']);
		}
		
		$db2 = new MySQL;
		$db2->init($setting['db']['host'], $setting['db']['user'], $setting['db']['pass'], $setting['db']['charset']);
		$db2->Connect(false, $setting['db']['name']);
		$db->ReConnect(true);
		
		if($cat_id==0) {
			foreach($GLOBALS['news_cat'] as $cur_cat) {
				if($cur_cat['web_id']!=$org_id) continue;
				if($org_id!=$dst_id) {
					$db->update($setting['db']['pre']."news_cat", array("web_id"=>$dst_id), array("cat_id","n=",$cur_cat['cat_id']));
				}
				$db->select($pre_org."news_show","*",array("cat_id","n=",$cur_cat['cat_id']),array("order"=>"news_id asc"));
				$id_list = array();
				while($record = $db->GetRS()) {
					$the_id = array();
					$the_id['old'] = $record['news_id'];
					$record['news_id'] = 0;
					$record['web_id'] = $dst_id;
					$db2->insert($pre_dst."news_show", $record, true);
					$the_id['new'] = $db2->GetInsertId();
					$id_list[] = $the_id;
				}
				for($i=0,$m=count($id_list);$i<$m;$i++) {
					if($id_list[$i]['new']==0) break;
					$db->select($pre_org."news_detail","*",array("news_id","n=",$id_list[$i]['old']),array("order"=>"news_id asc, page asc"));
					while($record = $db->GetRS()) {
						$record['id'] = 0;
						$record['news_id'] = $id_list[$i]['new'];
						$db2->insert($pre_dst."news_detail", $record, true);
					}
					$db->delete($pre_org."news_show",array("news_id","n=",$id_list[$i]['old']));
					$db->delete($pre_org."news_detail",array("news_id","n=",$id_list[$i]['old']));
				}
			}
		} else {
			$start_layer = 0;
			foreach($GLOBALS['news_cat'] as $cur_cat) {
				if($cur_cat['web_id']!=$org_id) continue;
				if($start_layer>0 && $cur_cat['cat_layer']<=$start_layer) {
					break;
				}
				if($cur_cat['cat_id']==$cat_id) {
					$start_layer = $cur_cat['cat_layer'];
					$cur_cat['cat_main'] = 0;
				}
				if($start_layer>0) {
					$cur_cat['web_id'] = $dst_id;
					$cur_cat['cat_layer'] = $cur_cat['cat_layer']-($start_layer-1);
					//unset($cur_cat['cat_id']);
					$db->update($setting['db']['pre']."news_cat", $cur_cat, array("cat_id","n=",$cur_cat['cat_id']));
					$db->select($pre_org."news_show","*",array("cat_id","n=",$cur_cat['cat_id']));
					$id_list = array();
					while($record = $db->GetRS()) {
						$the_id = array();
						$the_id['old'] = $record['news_id'];
						$record['news_id'] = 0;
						$record['web_id'] = $dst_id;
						$db2->insert($pre_dst."news_show", $record, true);
						$the_id['new'] = $db2->GetInsertId();
						$id_list[] = $the_id;
					}
					for($i=0,$m=count($id_list);$i<$m;$i++) {
						if($id_list[$i]['new']==0) break;
						$db->select($pre_org."news_detail","*",array("news_id","n=",$id_list[$i]['old']),array("order"=>"news_id asc, page asc"));
						while($record = $db->GetRS()) {
							$record['id'] = 0;
							$record['news_id'] = $id_list[$i]['new'];
							$db2->insert($pre_dst."news_detail", $record, true);
						}
						$db->delete($pre_org."news_show",array("news_id","n=",$id_list[$i]['old']));
						$db->delete($pre_org."news_detail",array("news_id","n=",$id_list[$i]['old']));
					}
				}
			}
		}
		deleteCache("news_cat");
		break;
	default:
		build_page();
}
if(!empty($log_info)) {
	write_log($log_info, "cat_id={$cat_id}");
	$goto_url = $req->getServer("PHP_SELF");
}
$mystep->pageEnd(false);

function build_page() {
	global $mystep, $req, $db, $setting;

	$tpl_info = array(
		"idx" => "trans",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	$max_count = count($GLOBALS['website']);
	for($i=0; $i<$max_count; $i++) {
		$tpl->Set_Loop("website", $GLOBALS['website'][$i]);
	}
	$max_count = count($GLOBALS['news_cat']);
	for($i=0; $i<$max_count; $i++) {
		$GLOBALS['news_cat'][$i]['cat_name'] = str_repeat("&nbsp; ", $GLOBALS['news_cat'][$i]['cat_layer']-1).$GLOBALS['news_cat'][$i]['cat_name'];
		$tpl->Set_Loop("cat", $GLOBALS['news_cat'][$i]);
	}
	
	$tpl->Set_Variable('title', $setting['language']['plugin_data_trans_title']);
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$db->Free();
	$mystep->show($tpl);
	return;
}
?>