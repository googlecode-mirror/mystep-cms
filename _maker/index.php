<?php
function debug() {
	//Coded By Windy2000 20040410 v1.5
	echo "<pre>";
	for($i = 0; $i < func_num_args(); $i++) {
		var_dump(func_get_arg($i));
	}
	echo "</pre>";
	exit;
}
set_time_limit(0);
ini_set('memory_limit', '512M');
ini_set('magic_quotes_runtime', 0);
require("mypack.php");
require("chs2cht.dic");
list($cs, $lng_type) = explode(",", $_SERVER["QUERY_STRING"]);
$pack_dir = str_replace("\\", "/", realpath(dirname(__FILE__)."/../"));
$pack_file = "mystep.pack";
$target_file = "mystep".(!empty($cs)?("_".$cs):"").(!empty($lng_type)?("_".$lng_type):"").".php";

@unlink($pack_file);
$mypack = new MyPack($pack_dir, $pack_file);
$mypack->AddIgnore(basename(dirname(__FILE__)), ".svn", "_bak", "cache", "update", "install.lock", "2011", "article", "pic", "tmp", "colorway", "ciguang","news_show", "web.config", "aspnet_client","config_main.php","config_test.php","config-bak.php");
if(!empty($cs)) $mypack->setCharset("gbk", $cs, $lng_type,".php,.tpl,.html,.htm,.sql");

$mypack->DoIt();
echo $mypack->GetResult();

$content = GetFile($pack_file);
@unlink($pack_file);
@unlink($target_file);

$result = '<?php
$content = <<<mystep
'.chunk_split(base64_encode($content)).'
mystep;
?>';
$result .= "\n";
$result .= GetFile("mypack.php");
$result .= "\n";
$result .= GetFile("setup.php");
$result = str_replace("?>\n<?php", "", $result);
WriteFile($target_file, $result, "wb");
unset($result, $content);
?>