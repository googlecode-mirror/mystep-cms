<?php
$info_default = array(
	"name" => "脚本前置执行代码",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_front_code",
	"intro" => "在页面脚本执行前所执行的代码",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "前置代码",
	"cat_desc" => "前置执行代码",
	"description" => "<b>本插件可以在制定页面脚本执行前执行指定代码，无可用模板标签</b>"
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