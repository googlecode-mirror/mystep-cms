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
	'0.99.2' => array(
		'info' => '
				V0.99.2
				1.Fix a bug in multi-web script cache function
				2.Adjust plugin template mode
				3.Fix a bug in search engine plugin
				4.Fix a bug MySQL Class bug in record return function
				5.Some other adjusts...
			',
		'sql' => array(),
		'file' => array(
				'include/config.php',
				'plugin/admin_cat/admin_cat.php',
				'plugin/admin_cat/input.tpl',
				'plugin/admin_cat/list.tpl',
				'plugin/admin_cat/tpl',
				'plugin/admin_cat/tpl/input.tpl',
				'plugin/admin_cat/tpl/list.tpl',
				'plugin/custom_sql/custom_sql.php',
				'plugin/custom_sql/input.tpl',
				'plugin/custom_sql/list.tpl',
				'plugin/custom_sql/tpl',
				'plugin/custom_sql/tpl/input.tpl',
				'plugin/custom_sql/tpl/list.tpl',
				'plugin/custom_sql/tpl/view.tpl',
				'plugin/custom_sql/view.tpl',
				'plugin/front_code/front_code.php',
				'plugin/front_code/input.tpl',
				'plugin/front_code/list.tpl',
				'plugin/front_code/main.tpl',
				'plugin/front_code/tpl',
				'plugin/front_code/tpl/input.tpl',
				'plugin/front_code/tpl/list.tpl',
				'plugin/front_code/tpl/main.tpl',
				'plugin/news_mark/news_jump.tpl',
				'plugin/news_mark/news_mark.php',
				'plugin/news_mark/news_mark.tpl',
				'plugin/news_mark/news_rank.tpl',
				'plugin/news_mark/tpl',
				'plugin/news_mark/tpl/news_jump.tpl',
				'plugin/news_mark/tpl/news_mark.tpl',
				'plugin/news_mark/tpl/news_rank.tpl',
				'plugin/offical/class.php',
				'plugin/offical/offical.php',
				'plugin/offical/password.tpl',
				'plugin/offical/rss.tpl',
				'plugin/offical/tpl',
				'plugin/offical/tpl/password.tpl',
				'plugin/offical/tpl/rss.tpl',
				'plugin/se_detect/input.tpl',
				'plugin/se_detect/list.tpl',
				'plugin/se_detect/main.tpl',
				'plugin/se_detect/se_detect.php',
				'plugin/se_detect/tpl',
				'plugin/se_detect/tpl/input.tpl',
				'plugin/se_detect/tpl/list.tpl',
				'plugin/se_detect/tpl/main.tpl',
				'plugin/se_detect/tpl/view.tpl',
				'plugin/se_detect/view.tpl',
				'plugin/search/block_keyword.tpl',
				'plugin/search/block_search.tpl',
				'plugin/search/engine.tpl',
				'plugin/search/keyword.tpl',
				'plugin/search/main.tpl',
				'plugin/search/se_manager.php',
				'plugin/search/tpl',
				'plugin/search/tpl/block_keyword.tpl',
				'plugin/search/tpl/block_search.tpl',
				'plugin/search/tpl/engine.tpl',
				'plugin/search/tpl/keyword.tpl',
				'plugin/search/tpl/main.tpl',
				'plugin/survey/class.php',
				'script/language.js',
				'source/merge.php',
				'template/admin/func_backup.tpl',
				'update/version.php',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20111106',
					),
			),
	),
	'0.99.3' => array(
		'info' => '
				V0.99.3
				1.Fix a bug in database import function
				2.Fix a problem in input page with tinyMCE
				3.Enhance update function
				4.Some other adjusts...
			',
		'sql' => array(),
		'file' => array(
				'admin/func_backup.php',
				'include/parameter.php',
				'plugin/survey/survey_manager.php',
				'script/addon.js',
				'template/admin/art_content_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'update/index.php',
				'update/version.php',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20111107',
					),
			),
	),
	'0.99.4' => array(
		'info' => '
				V0.99.4
				1.Fix a bug in MultiDel function
				2.Update information export and empty function add
				3.Fix a problem in MyDB module
				4.Some other adjusts...
			',
		'sql' => array(),
		'file' => array(
				'admin/update.php',
				'admin/web_cache.php',
				'include/parameter.php',
				'source/class/mydb.class.php',
				'source/function/global.php',
				'template/admin/info_main.tpl',
				'update/version.php',
			),
		'setting' => array(),
	),
	'0.99.5' => array(
		'info' => '
				V0.99.5
				1.Disable html code minify in admin panle
				2.Disable session in merge.php
				3.Add update referer
				4.Fix a bug in getRemoteContent function
				5.Some other adjusts...
			',
		'sql' => array(),
		'file' => array(
				'admin/inc.php',
				'admin/update.php',
				'include/parameter.php',
				'plugin/inc.php',
				'source/class/session.class.php',
				'source/function/global.php',
				'template/admin/info_main.tpl',
				'template/admin/web_setting.tpl',
				'update/index.php',
				'update/version.php',
			),
		'setting' => array(),
	),
	'0.99.5.1' => array(
		'info' => '
				V0.99.5.1
				Fix a language bug in update function
			',
		'sql' => array(),
		'file' => array(
				'admin/language/chs.php',
				'admin/update.php',
				'include/parameter.php',
				'update/version.php',
			),
		'setting' => array(),
	),
	'0.99.5.2' => array(
		'info' => '
				V0.99.5.2
				1.Fix a plugin template path bug
				2.Fix a update referer bug
				3.Some other adjusts...
			',
		'sql' => array(),
		'file' => array(
				'include/parameter.php',
				'plugin/news_mark/class.php',
				'plugin/search/class.php',
				'script/addon.js',
				'template/admin/info_main.tpl',
				'update/index.php',
				'update/version.php',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20111108',
					),
			),
	),
	'0.99.6' => array(
		'info' => '
				V0.99.6
				1.Plugin script file adjusts
				2.Update function time zone fixed
				3.Fix a variant bug in merger script
				4.Fix a bug in bad picture load handle script
				5.Fix a script order bug in plugin module
				6.Add loading bar in some page of admin panel
				7.Topic plugin added
				8.Some other adjusts...
			',
		'sql' => array(
				'update `{pre}admin_cat` set `file`="survey.php" where `file`="survey_manager.php"',
				'update `{pre}admin_cat` set `file`="search.php?method=engine" where `file`="se_manager.php?method=engine"',
				'update `{pre}admin_cat` set `file`="search.php?method=keyword" where `file`="se_manager.php?method=keyword"',
			),
		'file' => array(
				'admin/inc.php',
				'admin/style.css',
				'images/style.css',
				'include/config.php',
				'include/parameter.php',
				'plugin/admin_cat/info/en.php',
				'plugin/admin_cat/tpl/input.tpl',
				'plugin/admin_cat/tpl/list.tpl',
				'plugin/custom_sql/info/en.php',
				'plugin/custom_sql/tpl/input.tpl',
				'plugin/custom_sql/tpl/list.tpl',
				'plugin/custom_sql/tpl/view.tpl',
				'plugin/front_code/info/en.php',
				'plugin/front_code/tpl/main.tpl',
				'plugin/inc.php',
				'plugin/meeting/class.php',
				'plugin/meeting/meeting.php',
				'plugin/meeting/meeting_manager.php',
				'plugin/meeting/tpl/main.tpl',
				'plugin/mssql/info/en.php',
				'plugin/news_mark/info/en.php',
				'plugin/news_mark/tpl/news_mark.tpl',
				'plugin/news_snatch/info/en.php',
				'plugin/news_snatch/tpl/main.tpl',
				'plugin/news_visit/info/en.php',
				'plugin/news_visit/news_visit.tpl',
				'plugin/offical/index.php',
				'plugin/offical/info/en.php',
				'plugin/offical/offical.php',
				'plugin/offical/show.php',
				'plugin/se_detect/info/en.php',
				'plugin/se_detect/tpl/main.tpl',
				'plugin/search/class.php',
				'plugin/search/index.php',
				'plugin/search/info/en.php',
				'plugin/search/se_manager.php',
				'plugin/search/search.php',
				'plugin/search/show.php',
				'plugin/search/tpl/main.tpl',
				'plugin/survey/class.php',
				'plugin/survey/index.php',
				'plugin/survey/info/en.php',
				'plugin/survey/show.php',
				'plugin/survey/survey.php',
				'plugin/survey/survey_manager.php',
				'plugin/survey/tpl/input.tpl',
				'plugin/survey/tpl/main.tpl',
				'plugin/topic',
				'plugin/topic/class.php',
				'plugin/topic/index.php',
				'plugin/topic/info',
				'plugin/topic/info.php',
				'plugin/topic/info/chs.php',
				'plugin/topic/info/en.php',
				'plugin/topic/install.sql',
				'plugin/topic/language',
				'plugin/topic/language/chs.php',
				'plugin/topic/language/default.php',
				'plugin/topic/language/en.php',
				'plugin/topic/show.php',
				'plugin/topic/topic',
				'plugin/topic/topic.php',
				'plugin/topic/topic_link.php',
				'plugin/topic/tpl',
				'plugin/topic/tpl/input.tpl',
				'plugin/topic/tpl/list.tpl',
				'plugin/topic/tpl/main.tpl',
				'plugin/topic/tpl/search.tpl',
				'plugin/visit_analysis/info/en.php',
				'plugin/visit_analysis/tpl/main.tpl',
				'read.php',
				'script/addon.js',
				'script/global.js',
				'source/merge.php',
				'template/admin/attachment_edit.tpl',
				'template/admin/func_backup.tpl',
				'template/admin/web_cache.tpl',
				'update/index.php',
				'update/version.php',
			),
		'setting' => array(
				'gen' => array(
						'cache' => true,
						'etag' => '20111111',
					),
			),
	),
);
?>