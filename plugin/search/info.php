<?php
$info_default = array(
	"name" => "�������ݼ������",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.5",
	"class" => "plugin_search",
	"intro" => "ͨ���������������������վ����",
	"cat_name_1" => "���¼���",
	"cat_desc_1" => "���������������",
	"cat_name_2" => "�����ؼ���",
	"cat_desc_2" => "�ÿͼ����ؼ��ֹ���",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => '
<b>�������Ҫ����ͨ���ؼ��ּ�������վ������£�Ҳ���Ե���������������</b>

�����Ҫ��վ��������Ϊ�����վ����һ�� seach.tpl ģ�棬���������±�ǩ��

<font color="red">&lt;!--news limit=\'$limit\' show_date="1" show_catalog="1" condition=\'$condition\' loop=\'20\'--&gt;</font>
'
);
$rewrite = array(
	array("search/([^\.]+?)(/(\d+))?", "module.php?m=search&k=$1&page=$3"),
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