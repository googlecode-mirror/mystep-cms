<?php
if(is_file("../include/install.lock")) {
	header("location: ../");
	exit();
}
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
require_once(ROOT_PATH."/include/config.php");
require_once(ROOT_PATH."/include/parameter.php");
require_once(ROOT_PATH."/source/function/global.php");
require_once(ROOT_PATH."/source/function/web.php");

header("Expires: Tue, 1 Jan 1980 00:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: text/html;charset=".$setting['gen']['charset']);

date_default_timezone_set("PRC");
set_magic_quotes_runtime(0);
set_time_limit(30);
ini_set('memory_limit', '32M');
error_reporting(E_ALL ^ E_NOTICE);

$mystep = new MyStep();
$req = $mystep->getInstance("MyReq", $setting['cookie'], $setting['session']);
$step = $req->getReq("step");

switch($step) {
	case 1:
		break;
	case 2:
		break;
	case 3:
		$setting = arrayMerge($setting, $_POST['setting']);
		$setting['web']['s_pass'] = md5($setting['web']['s_pass']);
		unset($_POST);
		$result = <<<mystep
<?php
\$setting = array();

/*--settings--*/

\$expire_list = array(
	"default" => 60*10,
	"index" => 60*30,
	"list" => 60*60,
	"tag" => 60*60*24,
	"read" => 60*60*24*7,
);
?>
mystep;
		$result = str_replace("/*--settings--*/", makeVarsCode($setting, '$setting'), $result);
		$link = @mysql_connect($setting['db']['host'], $setting['db']['user'], $setting['db']['pass']);
		if(!$link) {
			$step = 21;
		} else {
			mysql_close($link);
			WriteFile(ROOT_PATH."/include/config.php", $result, "w");
			WriteFile(ROOT_PATH."/include/config-default.php", $result, "w");
		}
		break;
	case 4:
		WriteFile("../include/install.lock", date("Y-m-d H:i:s"));
		break;
	default:
		break;
}

echo <<<mystep
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	<TITLE>MyStep 安装向导</TITLE>
	<META content="text/html; charset=gbk" http-equiv=Content-Type>
	<LINK rel=stylesheet type=text/css href="style.css" media=all>
	<META name=Copyright content="Windy2006@gmail.com">
	<script language="JavaScript" src="../script/global.js"></script>
	<script language="JavaScript" src="../script/checkForm.js"></script>
</HEAD>
<BODY>
<DIV class=container>
	<DIV class=header>
		<H1>MyStep 安装向导</H1><SPAN>V{$ms_version['ver']} ({$ms_version['charset']}/{$ms_version['language']}) {$ms_version['date']}</SPAN>
	</DIV>
mystep;

if(is_file("./step_{$step}.php")) {
	include("./step_{$step}.php");
} else {
	include("./step_0.php");
}

echo <<<mystep
	<DIV class=footer>&copy;2010 - 2011 <A href="mailto:windy2006@gmail.com">Windy2000</A></DIV>
</DIV>
</BODY>
</HTML>
mystep;

unset($mystep, $req);
?>