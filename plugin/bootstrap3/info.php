<?php
$info_default = array(
	"name" => "BootStrap v3 插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_bootstrap",
	"intro" => "使用BootStrap3.0框架替代系统默认框架",
	"copyright" => "版权所有 2013 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "使用BootStrap3.0框架替代系统默认框架，具体使用方法请参照 <a href='/plugin/bootstrap3/bootstrap.html' target='_blank'>bootstrap.html</a>"
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