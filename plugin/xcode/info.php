<?php
$info_default = array(
	"name" => "��չ����",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_xcode",
	"intro" => "��ҳ��ű��Ŀ�ʼ��ĩβִ��ָ������",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "��չ����",
	"cat_desc" => "ִ�и��Ӵ���",
	"description" => "<b>�����������ָ��ҳ��ű��Ŀ�ʼ��ĩβִ��ָ�����룬�޿���ģ���ǩ</b>"
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