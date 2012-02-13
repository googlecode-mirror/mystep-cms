<?php
$info_default = array(
	"name" => "计划任务插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_crontab",
	"intro" => "定时执行规定的任务",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "计划任务",
	"cat_desc" => "定时执行规定的任务",
	"description" => "<b>本插件用于定时执行规定的任务</b>
如系统为 IIS FastCGI ，可能会造成执行超时，无法顺利实现功能，可在命令行模式执行以下指令：（注意修改PHP路径）
%windir%\system32\inetsrv\appcmd list config -section:system.webServer/fastCgi
%windir%\system32\inetsrv\appcmd set config -section:system.webServer/fastCgi /[fullPath='D:\server\php_cgi\php-cgi.exe'].activityTimeout:2592000
或修改 C:\Windows\System32\inetsrv\config\applicationHost.config 中 activityTimeout 为 2592000
即可将超时时间延长至30天，但过期后仍需重启服务（可参考执行状态记录）
"
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