<?php
$version = array(
	'1' => array(
		'info' => '',
		'sql' => array(),
		'file' => array(),
		'setting' => array(),
		'code' => '',
	),
	'1.0.1' => array(
		'info' => '
				1.修正了一个后台样式错误
				2.增加了 BootStrap V3 的插件，并作了样例
				3.将手动更新检测调整为自动更新检测并给出提示
				4.将每个大版本的更新设立单独的文件，用户需要先更新到主版本后，才能更新至最新的子版本
				5.加设了一个标志变量，并可以通过 checkSign 函数判断并控制一些代码的执行
				一些其他调整……
			',
		'file' => array(
				'admin/style.css',
				'ajax.php',
				'api.php',
				'files/index.php',
				'include/parameter.php',
				'plugin/bootstrap3',
				'plugin/bootstrap3/bootstrap.html',
				'plugin/bootstrap3/class.php',
				'plugin/bootstrap3/config',
				'plugin/bootstrap3/config.php',
				'plugin/bootstrap3/config/chs.php',
				'plugin/bootstrap3/config/default.php',
				'plugin/bootstrap3/config/en.php',
				'plugin/bootstrap3/css',
				'plugin/bootstrap3/css/bootstrap.css',
				'plugin/bootstrap3/css/bootstrap_hack.css',
				'plugin/bootstrap3/css/github.css',
				'plugin/bootstrap3/css/icon_search.png',
				'plugin/bootstrap3/css/test.css',
				'plugin/bootstrap3/fish.html',
				'plugin/bootstrap3/fonts',
				'plugin/bootstrap3/fonts/glyphicons-halflings-regular.eot',
				'plugin/bootstrap3/fonts/glyphicons-halflings-regular.svg',
				'plugin/bootstrap3/fonts/glyphicons-halflings-regular.ttf',
				'plugin/bootstrap3/fonts/glyphicons-halflings-regular.woff',
				'plugin/bootstrap3/index.php',
				'plugin/bootstrap3/info',
				'plugin/bootstrap3/info.php',
				'plugin/bootstrap3/info/chs.php',
				'plugin/bootstrap3/info/en.php',
				'plugin/bootstrap3/js',
				'plugin/bootstrap3/js/bootstrap.js',
				'plugin/bootstrap3/js/highlight.js',
				'plugin/bootstrap3/js/holder.js',
				'plugin/bootstrap3/js/html5shiv.js',
				'plugin/bootstrap3/js/jquery.js',
				'plugin/bootstrap3/js/respond.min.js',
				'plugin/bootstrap3/js/test.js',
				'plugin/bootstrap/config/en.php',
				'plugin/bootstrap/index.php',
				'script/language.js.php',
				'script/setting.js.php',
				'source/class/mystep.class.php',
				'source/class/session.class.php',
				'source/function/web.php',
				'source/merge.php',
				'template/admin/info_main.tpl',
				'template/admin/web_template.tpl',
				'vcode.php'
			),
	),
);
?>