<?php
$info_default = array(
	"name" => "用户调查交互插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_ticket",
	"intro" => "向网站管理员提交意见问题，并等待回馈",
	"cat_name" => "用户交互",
	"cat_desc" => "访客向网站管理员提交意见问题",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => '<b>本插件主要用于访客向网站管理员提交意见问题，并等待回馈</b>'
);
$rewrite = array(
	array("ticket/([^\.]+)", "module.php?m=ticket&idx=$1"),
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