<?php
$info_default = array(
	"name" => "�ƻ�������",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_crontab",
	"intro" => "��ʱִ�й涨������",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "�ƻ�����",
	"cat_desc" => "��ʱִ�й涨������",
	"description" => "<b>��������ڶ�ʱִ�й涨������</b>
��ϵͳΪ IIS FastCGI �����ܻ����ִ�г�ʱ���޷�˳��ʵ�ֹ��ܣ�����������ģʽִ������ָ���ע���޸�PHP·����
%windir%\system32\inetsrv\appcmd list config -section:system.webServer/fastCgi
%windir%\system32\inetsrv\appcmd set config -section:system.webServer/fastCgi /[fullPath='D:\server\php_cgi\php-cgi.exe'].activityTimeout:2592000
���޸� C:\Windows\System32\inetsrv\config\applicationHost.config �� activityTimeout Ϊ 2592000
���ɽ���ʱʱ���ӳ���30�죬�����ں������������񣨿ɲο�ִ��״̬��¼��
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