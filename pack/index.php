<?php
set_time_limit(0);
ini_set('memory_limit', '512M');
ini_set('magic_quotes_runtime', 0);
require("../include/parameter.php");
require("../source/function/global.php");
require("mypack.class.php");
require("chs2cht.dic");
list($cs, $lng_type) = explode(",", $_SERVER["QUERY_STRING"]);
$pack_dir = str_replace("\\", "/", realpath(dirname(__FILE__)."/../"));
$result_dir = "mystep".(!empty($cs)?("_".$cs):"").(!empty($lng_type)?("_".$lng_type):"")."_v".$ms_version['ver'];

echo "Making setup pack, be patient...";

$log_file = "log.txt";
$log = array(
	'time' => date("Y-m-d H:i:s"),
	'ip' => getIp(),
	'agent' => $_SERVER['HTTP_USER_AGENT'],
);

if(strpos($log['agent'], "spider")!==false || strpos($log['agent'], "bot")!==false) {
	header("HTTP/1.0 404 Not Found");
	exit;
}

WriteFile($log_file, implode(",", $log)."\n", "ab");

if(!file_exists("build/".$result_dir.".zip")) {
	$pack_file = $result_dir."/"."mystep.pack";
	$target_file = $result_dir."/"."mystep.php";
	@unlink($target_file);
	MultiDel($result_dir);
	sleep(1);
	mkdir($result_dir);
	
	$mypack = new MyPack($pack_dir, $pack_file);
	$mypack->AddIgnore(basename(dirname(__FILE__)), ".svn", "web.config", "aspnet_client", "include/install.lock", "Thumbs.db", "bak", "xcache", "_test", "config_test.php", "config-bak.php", "cfna_mis");
	if(!empty($cs)) $mypack->setCharset("gbk", $cs, $lng_type, ".php,.tpl,.html,.htm,.sql");
	
	$mypack->DoIt();
	//echo $mypack->GetResult();
	
	$result = "";
	$result .= GetFile("mypack.class.php");
	$result .= "\n";
	$result .= GetFile("setup.php");
	$result = str_replace("?>\n<?php", "", $result);
	WriteFile($target_file, $result, "wb");
	unset($result);
	copy("intro.txt", $result_dir."/readme.txt");
	require("../source/class/myzip.class.php");
	rename($result_dir, "upload");
	zip("upload", "build/".$result_dir.".zip");
	MultiDel("upload");
}
?>
<script language="JavaScript">
location.href = "build/<?=$result_dir?>.zip";
</script>