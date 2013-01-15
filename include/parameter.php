<?php
$ms_version = array(
	'ver' => '0.99.9.9.9',
	'date' => '2013-1-14',
	'charset' => 'GBK',
	'language' => 'CHS',
);

$class_list = array(
	"class_common" => "abstract.class.php",
	"MyStep" => "mystep.class.php",
	"MyApi" => "myapi.class.php",
	"MyAjax" => "myajax.class.php",
	"MyCache" => "mycache.class.php",
	"MyEmail" => "myemail.class.php",
	"MyFSO" => "myfso.class.php",
	"MSSQL" => "mssql.class.php",
	"MyDB" => "mydb.class.php",
	"MySQL" => "mysql.class.php",
	"MyTpl" => "mytpl.class.php",
	"MyReq" => "myreq.class.php",
	"MyUploader" => "myuploader.class.php",
	"MyPack" => "mypack.class.php",
	"MyXls" => "myxls.class.php",
	"MyZip" => "myzip.class.php",
	"MagickWand" => "magickwand.class.php",
	"MemoryCache" => "memcache.class.php",
	"imageCreator" => "image.class.php",
	"imageCreator_file" => "image.class.php",
	"coordinateMaker" => "image.class.php",
	"eAccelerator" => "eaccelerator.class.php",
	"xCache" => "xcache.class.php",
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
?>