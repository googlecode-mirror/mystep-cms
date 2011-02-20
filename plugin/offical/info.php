<?php
$info_default = array(
	"name" => "官方插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_offical",
	"intro" => "官方插件，同时也包含使用样例。",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
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