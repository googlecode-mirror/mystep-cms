<?php
$info_default = array(
	"name" => "����Ŀ¼ά�����",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_admin_cat",
	"intro" => "����Ŀ¼��ӡ��޸ġ�ɾ��������",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "����Ŀ¼",
	"cat_desc" => "����Ŀ¼ά��",
	"description" => "<b>��������ڹ����̨����Ŀ¼����ӡ��޸ġ�ɾ���������ά���������޿����ò���</b>"
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