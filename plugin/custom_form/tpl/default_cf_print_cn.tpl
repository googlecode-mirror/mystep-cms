<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--></title>
<meta http-equiv="Pragma" contect="no-cache">
<meta http-equiv="Expires" contect="-1">
<meta http-equiv="windows-Target" contect="_top">
<meta http-equiv="Content-Type" content="text/html; charset=<!--charset-->" />
<link rel="stylesheet" type="text/css" media="all" href="../../<!--path_admin-->/style.css" />
<script language="JavaScript" src="../../script/jquery.js"></script>
<script language="JavaScript" src="../../script/jquery.addon.js"></script>
<script language="JavaScript" src="../../script/global.js"></script>
<script language="JavaScript" src="../../script/admin.js"></script>
<script language="JavaScript" src="../../script/addon.js"></script>
<script language="JavaScript" src="../../script/jquery.jmpopups.js"></script>
</head>
<body>
<div id="page_ole">
	<div id="page_main">
		<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
			<!--custom_form_name-->
		</div>
		<hr />
		<br />
		<table width="780" border="0" class="cf_form" align="center" cellpadding="2" cellspacing="1">
<?php
global $para;
foreach($para as $key => $value) {
	if($value['manager']=='true') continue;
	if(empty($value['title_en']) && !empty($value['comment_en'])) continue;
	if(empty($value['title'])) continue;
	echo <<<mystep
			<tr>
				<td class="cat" width="80">{$value['title']}</td>
				<td class="row">
mystep;
	switch($value['type']) {
		case "text":
		case "textarea":
			echo $_POST[$key];
			break;
		case "radio":
		case "select":
			$_POST[$key] = (INT)$_POST[$key] - 1;
			for($i=0; $i<count($value['value']['cn']); $i++) {
				if($i!=$_POST[$key]) continue;
				echo $value['value']['cn'][$i];
			}
			break;
		case "checkbox":
			$_POST[$key] = ",".implode(",", $_POST[$key]).",";
			$theValue = array();
			for($i=0; $i<count($value['value']['cn']); $i++) {
				$curValue = ",".pow(2, $i).",";
				if(strpos($_POST[$key], $curValue)!==false) {
					$theValue[] = $value['value']['cn'][$i]."";
				}
			}
			echo implode(" | ", $theValue);
			break;
		case "file":
			if(!empty($_POST[$key])) {
				$cur_file = explode("::", $_POST[$key]);
				if(strpos($cur_file[1],"image")!==false) {
					echo '<img src="/plugin/custom_form/file.php?mid='.$mid.'&id='.$_POST['id'].'&f='.$key.'" width="200" alt="'.$cur_file[0].'" />';
				} else {
					echo $cur_file[0];
				}
			}
			break;
		default:
			break;
	}
	echo <<<mystep
					</td>
				</tr>
mystep;
}
?>
			<tr>
				<td colspan="2" style="padding: 20px" align="center"><input type="button" style="padding: 20px" value="��ӡ����" onclick="this.style.visibility='hidden';window.print();this.style.visibility='visible'"></td>
			</tr>
		</table>
	</div>
</div>
</body>
</html>