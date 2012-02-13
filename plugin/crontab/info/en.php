<?php
$info = array(
	"name" => "Cron Table",
	"intro" => "Execute specified program in schedule",
	"copyright" => "Copyright 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "Cron Table",
	"cat_desc" => "Execute the specified program in schedule",
	"description" => "<b>You can execute specified program in schedule with this plugin</b>
Command needed in IIS FastCGI mode (Change the php path to yours)
%windir%\system32\inetsrv\appcmd list config -section:system.webServer/fastCgi
%windir%\system32\inetsrv\appcmd set config -section:system.webServer/fastCgi /[fullPath='D:\server\php_cgi\php-cgi.exe'].activityTimeout:2592000
or
Edit C:\Windows\System32\inetsrv\config\applicationHost.config change activityTimeout to 2592000
"
);
?>