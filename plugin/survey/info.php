<?php
$info_default = array(
	"name" => "ͶƱ������",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_survey",
	"intro" => "����ͳ���Զ�������",
	"cat_name" => "ͶƱ����",
	"cat_desc" => "ͶƱ�������",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>��������Զ��岢���ɵ�ѡ���ѡģʽ���û�ͶƱ���������ʹϵͳ֧������ģ���ǩ��</b>
<b>survey: </b>������ʾ��ӦID��ͶƱ���ɿ����԰��� id, order, template ��
<b>survey_list: </b>������ʾ���е����б��ɿ����԰��� order, limit, condition ��",
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