<?php
$info_default = array(
	"name" => "�ٷ����",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.9",
	"class" => "plugin_offical",
	"intro" => "�ٷ������ͬʱҲ����ʹ��������",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>�������ʹϵͳ֧������ģ���ǩ��</b>
<b>News: </b>����չʾ��վ���£���Ӧ���ݿ��е� news_show ���ɿ����԰��� web_id, cat_id, order, setop, show_image, css1, css2, limit, loop, show_catalog, show_date, tag, template ��
<b>Info: </b>������ʾ�Զ��峬�ı����ݣ���Ӧ���ݿ��е� info_show ���ɿ����԰��� id, title ��
<b>Link: </b>������ʾ��վ���ӣ���Ӧ���ݿ��е� link ���ɿ����԰��� type, limit, idx ��
<b>Tag: </b>������ʾ��վ��ǩ����Ӧ���ݿ��е� news_tag ���ɿ����԰��� template, limit, order ��
<b>Menu: </b>������ʾ����Ŀ¼�ṹ����Ӧ���ݿ��е� news_cat ���ɿ����԰��� web_id, cat_id, deep ��
<b>Include: </b>������ָ��λ��Ƕ�������ļ����ɿ������� file"
);

$rewrite = array(
	array("offical/login","module.php?m=offical&f=login_show"),
	array("offical/password","module.php?m=offical&f=password"),
	array("offical/login_check","module.php?m=offical&f=login"),
	array("offical/logout","module.php?m=offical&f=logout"),
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