<?php
include("info.php");
$sql_list = array(
	'alter table `{pre}custom_form` add `expire` DATE COMMENT '过期日期',
);
$file_list = array(
	'file.php',
	'info.php',
	'show.php',
	'class.php',
	'config.php',
	'index.php',
	'custom_form.php',
	'tpl/add.tpl',
	'tpl/default_cf_submit_cn.tpl',
	'tpl/default_cf_submit_en.tpl',
	'tpl/default_mail_cn.tpl',
	'tpl/default_mail_en.tpl',
	'tpl/edit.tpl',
	'tpl/edit_data.tpl',
	'tpl/expire.tpl',
	'tpl/sample_cf_submit_cn_mutil.tpl',
	'language/chs.php',
	'language/default.php',
	'language/en.php',
);
?>