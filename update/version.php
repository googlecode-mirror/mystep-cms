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
	'1.0.2' => array(
		'info' => '
				1.增加了更新回滚功能，本功能独立于系统，位于 admin/rollback/
				2.修正了附件功能的两处错误
				3.修正了codemirror的一处显示问题
				4.增加了 MultiCopy 函数，用于目录复制
				5.修正了两处在线更新的小问题
				一些其他调整……
			',
		'file' => array(
				'admin/rollback',
				'admin/rollback/index.php',
				'admin/update.php',
				'files/index.php',
				'include/config.php',
				'include/parameter.php',
				'script/jquery.codemirror.js',
				'source/class/myuploader.class.php',
				'source/function/global.php',
			),
	),
	'1.0.3' => array(
		'info' => '
				1.修正了忽略模式（主要用于安装包和校验文件生成），不希望包含的目录只要放一个空的名为“ignore”的文件即可，若只是忽略某些文件，则只要在“ignore”文件中注明
				2.修正了官方插件中一处标志判断代码
				3.增加了主机端下载记录及查看
				一些其他调整……
			',
		'file' => array(
				'ignore',
				'admin/update.php',
				'cache/ignore',
				'files/ignore',
				'include/ignore',
				'include/parameter.php',
				'plugin/offical/class.php',
				'source/class/mypack.class.php',
				'source/function/admin.php',
				'template/admin/info_main.tpl',
				'template/ignore',
			),
	),
	'1.0.4' => array(
		'info' => '
				1.服务器端文件校验增加了多字符集校验
				2.修正了rewrite功能的一个bug，并可以直接写入iis或apache的配置文件
				3.增加了一些字符集相关的函数，避免乱码
				一些其他调整……
			',
		'file' => array(
				'admin/update.php',
				'admin/web_rewrite.php',
				'ignore',
				'include/config.php',
				'include/parameter.php',
				'plugin/visit_analysis/class.php',
				'source/function/admin.php',
				'source/function/global.php',
				'template/admin/info_main.tpl',
				'template/admin/web_rewrite.tpl',
			),
	),
	'1.0.5' => array(
		'info' => '
				1.修正了安装包生成的几个错误
				2.修正了基类里的一个错误
				一些其他调整……
			',
		'file' => array(
				'include/config.php',
				'include/ignore',
				'include/parameter.php',
				'source/class/abstract.class.php',
			),
	),
);
?>