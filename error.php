<?php
$errType = $_SERVER['QUERY_STRING'];
if(preg_match("/\d+/", $errType)) $errType = "404";
$errUrl = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$errReferer = $_SERVER['HTTP_REFERER'];
$errTime = date("Y-m-d H:i:s");
$errIp = $_SERVER["REMOTE_ADDR"];
$errMethod = $_SERVER["REQUEST_METHOD"];
$errUser = $_REQUEST["username"];
$errMsg = "";
$ext = "";

if($errType=="404") {
	$ext = strtolower(strrchr($errUrl, "."));
	if(strpos(".jpeg.jpg.bmp.gif.png", $ext)!==false) {
		header("location: images/noimage.gif");
		exit;
	}
}


$errString = $errUrl.",".$errReferer.",".$errTime.",".$errIp.",".$errMethod.",".$errUser."\n";

function WriteFile($file_name, $content, $mode="ab") {
	//Coded By Windy200020040410 v1.0
	$fp = fopen($file_name, $mode);
	if(flock($fp, LOCK_EX)) {
		fwrite($fp, $content);
		flock($fp, LOCK_UN);
	} else {
		fwrite($fp, $content);
	}
	fclose($fp);
	return;
}

WriteFile("err_".$errType.".csv", $errString, "a");


switch($errType) {
	case "403":
		$errMsg = "您所连接目录禁止浏览";
		break;
	case "404":
		$errMsg = "您所请求页面并不存在";
		break;
	case "500":
		$errMsg = "程序执行出错";
		break;
	default:
		$errMsg = "浏览时发生未知错误";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php
echo $errMsg
?></title>
</head>

<body>
<div style="text-align:center;font-size:14px;padding:14px;color:blue;font-weight:blod;font-family:Arial">
<?php
echo $errMsg
?>，请核实链接的合法性！
<br /><br />
</div>
<div style="text-align:center;font-size:14px;">
<script language="javascript" type="text/javascript">
var url_req = document.location.toString();
document.writeln("您请求地址是: <a href=\"" + url_req + "\">" + url_req + "</a><br />");
var url_new = "/";
url_new = url_req.replace(/^(http(s)?:\/\/[^\/]+)/(.+)$/i, $1);
document.writeln("系统自动转向: <a href=\"" + url_new + "\">" + url_new + "</a><br />");
setTimeout("location.href='" + url_new +"'", 2000);
</script>
</div>
</body>
</html>
