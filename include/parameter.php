<?php
$class_list = array(
	"MyStep" => "mystep.class.php",
	"class_common" => "abstract.class.php",
	"imageCreator" => "image.class.php",
	"imageCreator_file" => "image.class.php",
	"coordinateMaker" => "image.class.php",
	"MagickWand" => "magickwand.class.php",
	"MemoryCache" => "memcache.class.php",
	"MyAjax" => "myajax.class.php",
	"MyFSO" => "myfso.class.php",
	"MSSQL" => "mssql.class.php",
	"MyDB" => "mydb.class.php",
	"MySQL" => "mysql.class.php",
	"MyTpl" => "mytpl.class.php",
	"MyReq" => "myreq.class.php",
	"MyUploader" => "myupload.class.php",
	"MyPack" => "mypack.class.php",
	"MyXls" => "myxls.class.php",
	"MyZip" => "myzip.class.php",
	"sess_mystep" => "session.class.php",
	"sess_mysql" => "session.class.php",
	"sess_file" => "session.class.php",
	"HTC_Parser" => "htc_parser.class.php",
	"HTC_Parser_Highlight" => "htc_parser.class.php",
	"HTC_Parser_Append" => "htc_parser.class.php",
);

$sess_handle = array(
	array($setting['session']['mode'], "sess_open"),
	array($setting['session']['mode'], "sess_close"), 
	array($setting['session']['mode'], "sess_read"), 
	array($setting['session']['mode'], "sess_write"), 
	array($setting['session']['mode'], "sess_destroy"), 
	array($setting['session']['mode'], "sess_gc")
);

$setting['cookie']['prefix'] .= substr(md5($_ENV["USERNAME"].$_ENV["COMPUTERNAME"].$_ENV["OS"]), 0, 4)."_";
?>
