<?php
$info_default = array(
	"name" => "Դ������ʾ���",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_source",
	"intro" => "��ʾҳ��Դ����",
	"copyright" => "��Ȩ���� 2012 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>��ʾָ��ҳ���Ԫ����</b>"
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