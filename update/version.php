<?php
$version = array(
	'0' => array(
		'info' => '',
		'sql' => array(),
		'file' => array(),
		'setting' => array(),
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
				'read.php',
				'admin/art_content.php',
				'admin/func_backup.php',
				'admin/info.php',
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/update.php',
				'include/config/chs.php',
				'include/config/default.php',
				'include/config/en.php',
				'include/parameter.php',
				'install/install.sql',
				'plugin/news_snatch/tpl/rule_input.tpl',
				'plugin/news_visit/class.php',
				'script/global.js',
				'script/setting.js.php',
				'source/class/myzip.class.php',
				'source/function/global.php',
				'template/admin/art_catalog_input.tpl',
				'template/admin/info_main.tpl',
				'update/index.php',
				'update/version.php',
			),
		'setting' => array(),
	),
	'0.99' => array(
		'info' => '
				V0.99
				1.Add Survey Plugin which can generate custom survey for the website
				2.Fix error record page
				3.Add CSS and JS merge function which can merge and minify all CSS or JS file into one files
				4.Add HTML minify function with a switch
				5.Add HTML cache parameter to all plugin module page
				6.Add independent Etag page that can be included to any page need Etag.
				7.Enhance Etag control function in offical plugin
				8.Fix a bug in template class
				9.Fix a bug in delete attachment in article edit page
				10.Some other adjusts...
			',
		'sql' => array(),
		'file' => array(
				'inc.php',
				'error.php',
				'index.html',
				'module.php',
				'admin/update.php',
				'files/index.php',
				'images/classic/style.css',
				'images/default/style.css',
				'images/style.css',
				'images/truck.png',
				'include/config/chs.php',
				'include/config/default.php',
				'include/config/en.php',
				'include/parameter.php',
				'plugin/admin_cat/admin_cat.php',
				'plugin/admin_cat/language/chs.php',
				'plugin/admin_cat/language/default.php',
				'plugin/admin_cat/language/en.php',
				'plugin/custom_sql/custom_sql.php',
				'plugin/custom_sql/language/chs.php',
				'plugin/custom_sql/language/default.php',
				'plugin/custom_sql/language/en.php',
				'plugin/inc.php',
				'plugin/meeting/regist.php',
				'plugin/meeting/tpl/list.tpl',
				'plugin/news_mark/index.php',
				'plugin/news_mark/news_mark.js',
				'plugin/news_mark/style.css',
				'plugin/news_snatch/news_snatch.php',
				'plugin/news_snatch/rule/3b405644d701556f7404a65acdf6d0f5_snatch.php',
				'plugin/news_snatch/tpl/news_edit.tpl',
				'plugin/offical/class.php',
				'plugin/offical/index.php',
				'plugin/offical/offical.php',
				'plugin/se_detect/language/chs.php',
				'plugin/se_detect/language/default.php',
				'plugin/se_detect/language/en.php',
				'plugin/se_detect/se_detect.php',
				'plugin/search/block_search.tpl',
				'plugin/search/language/chs.php',
				'plugin/search/language/default.php',
				'plugin/search/language/en.php',
				'plugin/search/se_manager.php',
				'plugin/search/search.php',
				'plugin/survey/class.php',
				'plugin/survey/index.php',
				'plugin/survey/info.php',
				'plugin/survey/info/chs.php',
				'plugin/survey/info/en.php',
				'plugin/survey/install.sql',
				'plugin/survey/language/chs.php',
				'plugin/survey/language/default.php',
				'plugin/survey/language/en.php',
				'plugin/survey/style.css',
				'plugin/survey/survey.js',
				'plugin/survey/survey.php',
				'plugin/survey/survey_manager.php',
				'plugin/survey/tpl/block_survey_classic.tpl',
				'plugin/survey/tpl/block_survey_simple.tpl',
				'plugin/survey/tpl/input.tpl',
				'plugin/survey/tpl/list.tpl',
				'plugin/survey/tpl/main.tpl',
				'plugin/survey/tpl/survey.tpl',
				'plugin/visit_analysis/language/chs.php',
				'plugin/visit_analysis/language/default.php',
				'plugin/visit_analysis/language/en.php',
				'plugin/visit_analysis/visit_analysis.php',
				'script/checkForm.js',
				'script/chs2cht.js',
				'script/global.js',
				'script/jquery.js',
				'script/language.js',
				'source/class/minify.class.php',
				'source/class/mystep.class.php',
				'source/class/mytpl.class.php',
				'source/class/image.class.php',
				'source/function/etag.php',
				'source/language/chs.php',
				'source/language/default.php',
				'source/merge.php',
				'template/admin/art_content_input.tpl',
				'template/admin/index.tpl',
				'template/admin/info_main.tpl',
				'template/admin/main.tpl',
				'template/admin/web_subweb_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/index.tpl',
				'template/admin_simple/main.tpl',
				'template/admin_simple/web_subweb_input.tpl',
				'template/classic/main.tpl',
				'template/classic/read.tpl',
				'template/classic/tag.tpl',
				'template/default/block_news_describe.tpl',
				'template/default/block_news_image.tpl',
				'template/default/block_news_picture.tpl',
				'template/default/block_news_plat.tpl',
				'template/default/block_news_simple.tpl',
				'template/default/block_news_slide.tpl',
				'template/default/main.tpl',
				'update/index.php',
				'update/version.php'
			),
		'setting' => array(
				'gen' => array(
						'minify' => true,
						'etag' => '20111104',
					),
			),
	),
	'0.99.1' => array(
		'info' => '
				V0.99.1
				1.Enhance Database backup module, add repair function
				2.Enhance Update module
				3.Update jQuery to 1.7
				4.Fix a bug MySQL Class bug in record return function
				5.Fix a order bug in admin template
				6.Some other adjusts...
			',
		'sql' => array(),
		'file' => array(
				'admin/func_backup.php',
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/style.css',
				'admin/update.php',
				'include/parameter.php',
				'plugin/news_snatch/tpl/import.tpl',
				'plugin/news_snatch/tpl/snatch.tpl',
				'script/addon.js',
				'script/checkForm.js',
				'script/global.js',
				'script/jquery.addon.js',
				'script/jquery.js',
				'source/class/mysql.class.php',
				'source/function/global.php',
				'template/admin/func_backup.tpl',
				'template/admin/info_main.tpl',
				'template/admin/main.tpl',
				'template/admin_simple/main.tpl',
				'update/index.php',
				'update/version.php'
			),
		'setting' => array(),
	),
);
?>