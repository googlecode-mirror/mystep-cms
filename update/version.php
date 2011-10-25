<?php
$version = array(
	'0' => array(
		'info' => '',
		'sql' => array(),
		'file' => array()
	),
	'0.98.12' => array(
		'info' => '
				V0.98.12
				1.JavaScript Parameter Settings added
				2.Online update module added
				3.Some other adjusts...
			',
		'sql' => array(
				'alter table `{pre}news_show` drop `ctype`',
			),
		'file' => array(
				'admin/art_content.php',
				'admin/func_backup.php',
				'admin/info.php',
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/update.php',
				'include/config-bak.php',
				'include/config-default.php',
				'include/config.php',
				'include/config/chs.php',
				'include/config/default.php',
				'include/config/en.php',
				'include/parameter.php',
				'install/install.sql',
				'plugin/news_snatch/tpl/rule_input.tpl',
				'plugin/news_visit/class.php',
				'read.php',
				'script/global.js',
				'script/setting.js.php',
				'source/class/myzip.class.php',
				'source/function/global.php',
				'template/admin/art_catalog_input.tpl',
				'template/admin/info_main.tpl',
				'update/index.php',
				'update/version.php',
			)
	),
);
?>