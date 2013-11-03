<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__FILE__)."/../")));
require(ROOT_PATH."/include/config.php");
require(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/function/web.php");

if($_SERVER['QUERY_STRING']=="done") {
	MultiDel(ROOT_PATH."/error.log");
	MultiDel(ROOT_PATH."/".$setting['path']['cache']);
	MultiDel(dirname(__FILE__));
}
if(is_file("../include/install.lock")) {
	header("location: ../");
	exit();
}

header("Expires: Tue, 1 Jan 1980 00:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: text/html;charset=".$setting['gen']['charset']);

date_default_timezone_set("PRC");
set_time_limit(30);
ini_set('memory_limit', '32M');
ini_set('magic_quotes_runtime', 0);
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
		$setting['cookie']['prefix'] = "ms_";
		if(strtolower($_POST['setting']['db']['charset'])=="utf-8") $_POST['setting']['db']['charset'] = "utf8";
		$setting = arrayMerge($setting, $_POST['setting']);
		$setting['web']['s_pass'] = md5($setting['web']['s_pass']);
		unset($_POST);
		$rewrite_list = var_export($rewrite_list, true);
		$expire_list = var_export($expire_list, true);
		$result = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$rewrite_list = {$rewrite_list};
\$expire_list = {$expire_list};
\$authority = "{$authority}";
?>
mystep;
		$result = str_replace("/*--settings--*/", makeVarsCode($setting, '$setting'), $result);
		WriteFile(ROOT_PATH."/include/config.php", $result, "wb");
		WriteFile(ROOT_PATH."/include/config-default.php", $result, "wb");
		$link = @mysql_connect($setting['db']['host'], $setting['db']['user'], $setting['db']['pass']);
		if(!$link) {
			$step = 21;
		} else {
			mysql_close($link);
			$new_setting = $setting;
			unset(
				$new_setting['web']['s_user'],
				$new_setting['web']['s_pass'],
				$new_setting['web']['cache_mode'],
				
				$new_setting['db']['host'],
				$new_setting['db']['user'],
				$new_setting['db']['pass'],
				$new_setting['db']['pconnect'],
				$new_setting['db']['charset'],
				
				$new_setting['gen']['charset'],
				$new_setting['gen']['gzip_level'],
				$new_setting['gen']['cache'],
				$new_setting['gen']['cache_ext'],
				$new_setting['gen']['timezone'],
				$new_setting['gen']['update'],
				$new_setting['gen']['minify'],
				$new_setting['gen']['etag'],
				
				$new_setting['cookie']['path'],
				$new_setting['cookie']['prefix'],
				
				$new_setting['watermark']['position'],
				$new_setting['watermark']['img_rate'],
				$new_setting['watermark']['txt_font'],
				$new_setting['watermark']['txt_fontsize'],
				$new_setting['watermark']['txt_fontcolor'],
				$new_setting['watermark']['txt_bgcolor'],
				$new_setting['watermark']['alpha'],
				$new_setting['watermark']['credit'],
				
				$new_setting['rewrite'],
				$new_setting['email'],
				$new_setting['js'],
				$new_setting['list'],
				$new_setting['session'],
				$new_setting['path'],
				$new_setting['content'],
				$new_setting['memcache']
			);
			$result = <<<mystep
<?php
\$setting_sub = array();

/*--settings--*/
?>
mystep;
			$result = str_replace("/*--settings--*/", makeVarsCode($new_setting, '$setting_sub'), $result);
			WriteFile(ROOT_PATH."/include/config_main.php", $result, "w");
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
	<script language="JavaScript" src="../script/jquery.js"></script>
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
} elseif($step==5) {
	echo '<script language="javascript">location.replace("../");</script>';
} else {
	include("./step_0.php");
}

echo <<<mystep
	<DIV class=footer>&copy;2010 - 2014 <A href="http://www.mysteps.cn">Mysteps.cn</A></DIV>
</DIV>
</BODY>
</HTML>
mystep;

unset($mystep, $req);
?>