<?php
require("inc.php");

$method = $req->getReq("method");
$table_name = $req->getReq("table");
set_time_limit(300);
ini_set('memory_limit', '128M');
$log_info = "";

if(count($_POST)>0) {
	$content = "";
	if($method=="import") {
		$log_info = "导入数据";
		$path_upload = ROOT_PATH."/".$setting['path']['upload']."/tmp/";
		$upload = $mystep->getInstance("MyUploader", $path_upload, true);
		$upload->DoIt(false);
		if(count($upload->upload_result)>0) {
			if($upload->upload_result[0]['error']==0) {
				if($upload->upload_result[0]['type']=="application/x-zip-compressed") {
					require(ROOT_PATH."/source/class/myzip.class.php");
					$dir = $path_upload.date("/Ymd_").rand(1000,9999)."/";
					unzip($path_upload.$upload->upload_result[0]['new_name'], $dir);
					$result_exe = array();
					if($handle = opendir($dir)) {
						while (false !== ($file = readdir($handle))) {
							if(is_file($file) && GetFileExt($file)=="sql") {
								$result_exe += $db->ExeSqlFile($file);
							}
						}
						closedir($handle);
					}
					$result = count($result_exe)>0?"成功批量导入数据":"数据库未更新！";
					MultiDel($dir);
				} else {
					$result_exe = $db->ExeSqlFile($path_upload.$upload->upload_result[0]['new_name']);
					$result = count($result_exe)>0?"成功更新数据库！":"数据库未更新！";
				}
				unlink($path_upload.$upload->upload_result[0]['new_name']);
			} else {
				$result = "上传失败：".$upload->upload_result[0]['message'];
			}
		} else {
			$result = "上传失败：上传文件不存在！";
		}
		unset($upload);
	} elseif($method=="export") {
		$log_info = "导出数据";
		$dir = ROOT_PATH."/".$setting['path']['upload']."/tmp/";
		if($table_name == "all") {
			require(ROOT_PATH."/source/class/myzip.class.php");
			$zipfile = $dir.date("Ymd")."_db_all.zip";
			$dir = $dir.date("Ymd")."_db_all/";
			$tbl_list = $db->GetTabs($setting['db']['name']);
			$max_count = count($tbl_list);
			$files = array();
			for($i=0; $i<$max_count; $i++) {
				$content = "DROP TABLE IF EXISTS `{$tbl_list[$i]}`;\n\n";
				$content .= $db->GetTabSetting($tbl_list[$i])."\n".$db->GetTabData($tbl_list[$i]);
				WriteFile($dir.$tbl_list[$i].".sql", $content);
				$files[] = $dir.$tbl_list[$i].".sql";
			}
			zip($files, substr($dir,0,-1).".zip");
			header("Content-type: application/zip");
			header("Accept-Ranges: bytes");
			header("Accept-Length: ".filesize($zipfile));
			header("Content-Disposition: attachment; filename=".$zipfile);
			$content = GetFile($zipfile);
			MultiDel($dir);
			unlink($zipfile);
		} else {
			$content = "DROP TABLE IF EXISTS `{$table_name}`;\n\n";
			$content .= $db->GetTabSetting($table_name)."\n".$db->GetTabData($table_name);
			header("Content-type: text/plain");
			header("Accept-Ranges: bytes");
			header("Accept-Length: ".strlen($content));
			header("Content-Disposition: attachment; filename=".date("Ymd")."_db_{$table_name}.sql");
		}
		echo $content;
	}
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"], $log_info);
	if($method=="export") $mystep->pageEnd(false);
}


$tpl_info['idx'] = "func_backup";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$Max_size = ini_get('upload_max_filesize');
$tpl_tmp->Set_Variable('max_size', $Max_size);
switch(strtoupper(substr($Max_size,-1))){
	case "M":
		$Max_size = ((int)str_replace("M","",$Max_size)) * 1024 * 1024;
		break;
	case "K":
		$Max_size = ((int)str_replace("K","",$Max_size)) * 1024;
		break;
	default:
		$Max_size = 1024 * 1024;
		break;
}
$import_info = "";
if(isset($result_exe)) {
	$max_count = count($result_exe);
	for($i=0;$i<$max_count;$i++) {
		switch($result_exe[$i][1]){
				case "select":
					$import_info .=  ($i+1) . " - 数据表 {$result_exe[$i][2]} 已生成！<br />\n";
					break;
				case "create":
					$import_info .= ($i+1) . " - 数据".($result_exe[$i][0]=="table"?"表":"库")." {$result_exe[$i][2]} 已生成！<br />\n";
					break;
				case "drop":
					$import_info .= ($i+1) . " - 数据".($result_exe[$i][0]=="table"?"表":"库")." {$result_exe[$i][2]} 已删除！<br />\n";
					break;
				case "alter":
					$import_info .= ($i+1) . " - 数据表 {$result_exe[$i][2]} 已变更！<br />\n";
					break;
				case "delete":
					$import_info .= ($i+1) . " - 数据表 {$result_exe[$i][2]} 已删除 {$result_exe[$i][3]} 条数据！<br />\n";
					break;
				case "truncate":
					$import_info .= ($i+1) . " - 数据表 {$result_exe[$i][2]} 已被清空！<br />\n";
					break;
				case "insert":
					$import_info .= ($i+1) . " - 数据表 {$result_exe[$i][2]} 已添加 {$result_exe[$i][3]} 条数据！<br />\n";
					break;
				case "update":
					$import_info .= ($i+1) . " - 数据表 {$result_exe[$i][2]} 已更新 {$result_exe[$i][3]} 条数据！<br />\n";
					break;
				default:
					$import_info .= ($i+1) . " - 数据表 {$result_exe[$i][2]} 执行了操作（{$result_exe[$i][1]}）！<br />\n";
					break;
		}
	}
}

$tbl_list = $db->GetTabs($setting['db']['name']);
$max_count = count($tbl_list);
for($i=0; $i<$max_count; $i++) {
	$tpl_tmp->Set_Loop('tbls', array("name"=>$tbl_list[$i]));
}
if(empty($result)) $result = "请选择需要的操作";
$tpl_tmp->Set_Variable('title', "数据库备份");
$tpl_tmp->Set_Variable('upload_max_filesize', $Max_size);
$tpl_tmp->Set_Variable('result', $result);
$tpl_tmp->Set_Variable('import_info', $import_info);
$db->Free();

$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
$mystep->show($tpl);

$mystep->pageEnd(false);
?>