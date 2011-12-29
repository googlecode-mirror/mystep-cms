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
	'400' => '��������������޷���������',
	'401' => '��¼ʧ�ܣ��������������֤�����¼�����������֤�鲻ƥ��',
	'403' => '��������Ŀ¼��ֹ���',
	'404' => 'Web �������Ҳ�������������ļ���ű�',
	'405' => '������˷�����������������ʶ����Դ��������ʹ������������ָ���ķ���',
	'406' => '���ɽ��ܣ�����������ʶ����Դֻ��������������Ϊ�����ɽ��ܡ�����Ӧʵ��',
	'407' => '��Ҫ���������֤�����¼�������������Ȼ������',
	'408' => '����ʱ',
	'409' => 'ָ���ͻ',
	'412' => 'ǰ������ʧ�ܣ�������������ֶ�����������ǰ����������ΪFALSE��',
	'413' => '����ʵ�����',
	'414' => '�������URL̫�����������ܾ����������',
	'426' => '������',
	'429' => '����������',
	'431' => '�����ͷ�ֶι���',
	'450' => '�ѱ�windows�ҳ����Ƴ�������',
	'500' => '�ڲ�����������',
	'501' => 'Web ��������֧��ʵ�ִ���������Ĺ��ܣ�����URL�еĴ���',
	'502' => '���س���������������ͼʵ�ִ�����ʱ�����ʵ�upstream �������н�����Ч����Ӧ',
	'599' => '�������ӳ�ʱ',
);

if(isset($error[$errType])) {
	$errMsg = $error[$errType];
} else {
	$errMsg = "���ʱ����δ֪����";
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
<?=$errMsg?>�����ʵ���ӵĺϷ��ԣ�
<br /><br />
</div>
<div style="text-align:center;font-size:14px;">
<script language="javascript" type="text/javascript">
var url_req = document.location.toString();
document.writeln("�������ַ��: <a href=\"" + url_req + "\">" + url_req + "</a><br />");
var url_new = "http://<?=$_SERVER['HTTP_HOST']>";
Document.writeln("ϵͳ�Զ�ת��: <a href=\"" + url_new + "\">" + url_new + "</a><br />");
setTimeout("location.href='" + url_new +"'", 2000);
</script>
</div>
</body>
</html>