<?php
$errType = $_SERVER['QUERY_STRING'];
if(!preg_match("/\d+/", $errType)) $errType = "404";
$errUrl = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$errReferer = $_SERVER['HTTP_REFERER'];
$errTime = date("Y-m-d H:i:s");
$errIp = $_SERVER["REMOTE_ADDR"];
$errMethod = $_SERVER["REQUEST_METHOD"];
$errAgent = $_SERVER["HTTP_USER_AGENT"];
$ext = "";
if($errType=="404") {
	$ext = strtolower(strrchr($errUrl, "."));
	if(strpos(".jpeg.jpg.bmp.gif.png", $ext)!==false) {
		header("location: images/noimage.gif");
		exit;
	}
}
$errString = $errType.",".$errUrl.",".$errReferer.",".$errTime.",".$errIp.",".$errMethod.",".$errAgent"\n";
if($fp = fopen("err.csv", "ab")) {
	if(flock($fp, LOCK_EX)) {
		fwrite($fp, $errString);
		flock($fp, LOCK_UN);
	}
	fclose($fp);
}

$error = array(
	'400' => '请求出错，服务器无法理解此请求',
	'401' => '登录失败，传输给服务器的证书与登录服务器所需的证书不匹配',
	'403' => '您所连接目录禁止浏览',
	'404' => 'Web 服务器找不到您所请求的文件或脚本',
	'405' => '不允许此方法，对于请求所标识的资源，不允许使用请求行中所指定的方法',
	'406' => '不可接受，此请求所标识的资源只能生成内容特征为“不可接受”的响应实体',
	'407' => '需要代理身份验证，请登录到代理服务器，然后重试',
	'408' => '请求超时',
	'409' => '指令冲突',
	'412' => '前提条件失败，部分请求标题字段中所给定的前提条件估计为FALSE。',
	'413' => '请求实体过大',
	'414' => '所请求的URL太长，服务器拒绝服务此请求',
	'426' => '需升级',
	'429' => '请求数过多',
	'431' => '请求的头字段过大',
	'450' => '已被windows家长控制程序屏蔽',
	'500' => '内部服务器错误',
	'501' => 'Web 服务器不支持实现此请求所需的功能，请检查URL中的错误',
	'502' => '网关出错，服务器将从试图实现此请求时所访问的upstream 服务器中接收无效的响应',
	'599' => '网络连接超时',
);

if(isset($error[$errType])) {
	$errMsg = $error[$errType];
} else {
	$errMsg = "浏览时发生未知错误";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title><?=$errMsg?></title>
</head>
<body>
<div style="text-align:center;font-size:14px;padding:14px;color:blue;font-weight:blod;font-family:Arial">
<?=$errMsg?>，请核实链接的合法性！
<br /><br />
</div>
<div style="text-align:center;font-size:14px;">
<script language="javascript" type="text/javascript">
var url_req = document.location.toString();
document.writeln("您请求地址是: <a href=\"" + url_req + "\">" + url_req + "</a><br />");
var url_new = "http://<?=$_SERVER['HTTP_HOST']>";
Document.writeln("系统自动转向: <a href=\"" + url_new + "\">" + url_new + "</a><br />");
setTimeout("location.href='" + url_new +"'", 2000);
</script>
</div>
</body>
</html>