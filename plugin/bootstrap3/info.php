<?php
$info_default = array(
	"name" => "BootStrap v3 ���",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_bootstrap",
	"intro" => "ʹ��BootStrap3.0������ϵͳĬ�Ͽ��",
	"copyright" => "��Ȩ���� 2013 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "ʹ��BootStrap3.0������ϵͳĬ�Ͽ�ܣ�����ʹ�÷�������� <a href='/plugin/bootstrap3/bootstrap.html' target='_blank'>bootstrap.html</a>"
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