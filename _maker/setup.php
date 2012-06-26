<?php
$tmp_file = tempnam("./", "mystep");
if($fp = fopen($tmp_file, "w")) {
	fclose($fp);
	unlink($tmp_file);
} else {
	die("Current directory cannot be writen!");
}
set_time_limit(0);
ini_set('memory_limit', '512M');
ini_set('magic_quotes_runtime', 0);
$pack_file = "mystep.pack";
$unpack_dir = "./";
$mypack = new MyPack($unpack_dir, $pack_file);
$mypack->DoIt("unpack");
echo $mypack->GetResult();
unset($mypack);
mkdir("./cache");
mkdir("./template/cache");
@unlink($pack_file);
@unlink(__FILE__);
?>
<script language="JavaScript">
location.href = "<?=$unpack_dir?>";
</script>