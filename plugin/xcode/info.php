<?php
$info_default = array(
	"name" => "扩展代码",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_xcode",
	"intro" => "在页面脚本的开始或末尾执行指定代码",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "扩展代码",
	"cat_desc" => "执行附加代码",
	"description" => "<b>本插件可以在指定页面脚本的开始或末尾执行指定代码，无可用模板标签</b>"
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