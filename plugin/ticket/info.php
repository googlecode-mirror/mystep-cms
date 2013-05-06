<?php
$info_default = array(
	"name" => "�û����齻�����",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_ticket",
	"intro" => "����վ����Ա�ύ������⣬���ȴ�����",
	"cat_name" => "�û�����",
	"cat_desc" => "�ÿ�����վ����Ա�ύ�������",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => '<b>�������Ҫ���ڷÿ�����վ����Ա�ύ������⣬���ȴ�����</b>'
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