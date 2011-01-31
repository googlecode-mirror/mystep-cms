<?php
require("inc.php");

$method = $req->getGet("method");
$err_file = ROOT_PATH."/error.log";
$log_info = "";

if($method=="clear") {
	unlink($err_file);
	$log_info = "���������Ϣ";
	$goto_url = $self;
} elseif($method=="download") {
	$log_info = "���ش�����Ϣ";
	$content = GetFile($err_file);
	if(!empty($content)) {
		if(ob_get_length()!==false) ob_end_clean();
		$content = preg_replace("/\n+/", "\n", $content);
		$content = str_replace("\n", "\r\n", $content);
		header("Content-type: text/plain");
		header("Accept-Ranges: bytes");
		header("Accept-Length: ".strlen($content));
		header("Content-Disposition: attachment; filename=".date("Ymd")."_err.txt");
		echo $content;
	}
}

if(!empty($log_info)) {
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"], $log_info);
	$mystep->pageEnd(false);
}

$tpl_info['idx'] = "info_err";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

$err_output = "";
if(!is_file($err_file)) {
	$err_msg = "Ŀǰ���޳����¼��";
	$err_output = "disabled";
} else {
	$err_content= GetFile($err_file);
	if($err_content=="") {
		$err_msg = "Ŀǰ���޳����¼��";
	} else {
		$err_lst = preg_split("/\n+[\-]{20,}\n+/",$err_content);
		array_pop($err_lst);
		$err_msg = "Ŀǰ���� ".count($err_lst)." �������¼��";
		for($i=count($err_lst)-1; $i>=0; $i--) {
			$err_lst[$i] = preg_replace("/\n+/", "\n", $err_lst[$i]);
			$err_lst[$i] = str_replace("\n", "\n<br />\n", $err_lst[$i]);
			$err_lst[$i] = preg_replace("/^([\w ]+:)/m", '<b>\1</b>', $err_lst[$i]);
			$class = $i%2 ? "cat" : "row";
			$tpl_tmp->Set_Loop('err', array("content"=>$err_lst[$i], "class"=>$class));
		}
	}
}

$tpl_tmp->Set_Variable('title', '��վ������Ϣ');
$tpl_tmp->Set_Variable('err_output', $err_output);
$tpl_tmp->Set_Variable('err_msg', $err_msg);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);

$mystep->show($tpl);
$mystep->pageEnd(false);
?>