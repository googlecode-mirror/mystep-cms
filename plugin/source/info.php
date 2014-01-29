<?php
$info_default = array(
	"name" => "源代码显示插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_source",
	"intro" => "显示页面源代码",
	"copyright" => "版权所有 2012 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>显示指定页面的元代码</b>"
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