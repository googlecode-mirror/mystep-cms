<?php
$info_default = array(
	"name" => "电子邮件插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_email",
	"intro" => "电子邮件群发",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "电子邮件",
	"cat_desc" => "电子邮件群发",
	"description" => "<b>本插件用于电子邮件群发</b>"
);

if(isset($setting['gen']['language'])) {
	if(is_file(realpath(dirname(__FILE__))."/info/".$setting['gen']['language'].".php")) {
		include(realpath(dirname(__FILE__))."/info/".$setting['gen']['language'].".php");
		$info = array_merge($info_default, $info);
	} else {
		$info = $info_default;
	}
} else {
	$info = $info_default;
}
?>