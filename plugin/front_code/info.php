<?php
$info_default = array(
	"name" => "�ű�ǰ��ִ�д���",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_front_code",
	"intro" => "��ҳ��ű�ִ��ǰ��ִ�еĴ���",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "ǰ�ô���",
	"cat_desc" => "ǰ��ִ�д���",
	"description" => "<b>������������ƶ�ҳ��ű�ִ��ǰִ��ָ�����룬�޿���ģ���ǩ</b>"
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