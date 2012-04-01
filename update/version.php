<?php
$version = array(
	'0' => array(
		'info' => '',
		'sql' => array(),
		'file' => array(),
		'setting' => array(),
		'code' => '',
	),
	'0.98' => array(
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
				'plugin/news_snatch/tpl/rule_input.tpl',
				'plugin/news_visit/class.php',
				'script/global.js',
				'script/setting.js.php',
				'source/class/myzip.class.php',
				'source/function/global.php',
				'template/admin/art_catalog_input.tpl',
				'template/admin/info_main.tpl',
			),
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
			),
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
				2.Fix a problem in input page with TinyMCE
				3.Enhance update function
				4.Some other adjusts...
			',
		'file' => array(
				'admin/func_backup.php',
				'include/parameter.php',
				'plugin/survey/survey_manager.php',
				'script/addon.js',
				'template/admin/art_content_input.tpl',
				'template/admin_simple/art_content_input.tpl',
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
		'file' => array(
				'admin/update.php',
				'admin/web_cache.php',
				'include/parameter.php',
				'source/class/mydb.class.php',
				'source/function/global.php',
				'template/admin/info_main.tpl',
			),
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
		'file' => array(
				'admin/inc.php',
				'admin/update.php',
				'include/parameter.php',
				'plugin/inc.php',
				'source/class/session.class.php',
				'source/function/global.php',
				'template/admin/info_main.tpl',
				'template/admin/web_setting.tpl',
			),
	),
	'0.99.5.1' => array(
		'info' => '
				V0.99.5.1
				Fix a language bug in update function
			',
		'file' => array(
				'admin/language/chs.php',
				'admin/update.php',
				'include/parameter.php',
			),
	),
	'0.99.5.2' => array(
		'info' => '
				V0.99.5.2
				1.Fix a plugin template path bug
				2.Fix a update referer bug
				3.Some other adjusts...
			',
		'file' => array(
				'include/parameter.php',
				'plugin/news_mark/class.php',
				'plugin/search/class.php',
				'script/addon.js',
				'template/admin/info_main.tpl',
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
			),
		'setting' => array(
				'gen' => array(
						'cache' => true,
						'etag' => '20111111',
					),
			),
	),
	'0.99.6.1' => array(
		'info' => '
				V0.99.6.1
				1.Fix a bug in language.js.php
				2.Fix a directory bug in update function
				3.Fix a custom link bug in topic plugin
				4.Some other adjusts...
			',
		'file' => array(
				'admin/func_backup.php',
				'admin/update.php',
				'include/parameter.php',
				'plugin/topic/class.php',
				'script/language.js.php',
			),
	),
	'0.99.7' => array(
		'info' => '
				V0.99.7
				1.Fix a link bug in admin catalog list with multi subweb
				2.Fix a bug in multi subweb cache delete
				3.Fix a bug in file cache clear function
				4.Fix a bug in plugin install function
				5.Fix a cache page bug in article list page when a prefix exists
				6.Add subweb selection in list page of news_mark plugin
				7.Add subweb selection in list page of news_visit plugin
				8.Visit counter will not make count when a spider visit
				9.Add delect all link of any topic function in topic plugin
				10.Add referer item in visit keyword record of visit analysis plugin
				11.Fix a bug in read page when html cache enable
				12.Fix a xml format bug in template module
				13.Session will not work count when a spider visit
				14.Fix a bug in admin log function
				15.Fix a bug in getSubSetting function
				16.Comment management plugin added
				17.Some javascript adjust...
				18.Some css adjusts...
				19.Some language adjusts...
				20.Some other bug fixes and adjusts...
		',
		'sql' => array(
				'delete from {pre}news_mark where jump=0 and rank_times=0',
				'alter table {pre}visit_keyword add `referer` Char(200) DEFAULT "" NOT NULL after `url`',
			),
		'file' => array(
				'admin/art_catalog.php',
				'admin/art_content.php',
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/update.php',
				'admin/web_cache.php',
				'admin/web_plugin.php',
				'images/classic/style.css',
				'include/config.php',
				'include/parameter.php',
				'list.php',
				'plugin/admin_cat/class.php',
				'plugin/comment',
				'plugin/comment/cache',
				'plugin/comment/class.php',
				'plugin/comment/comment.js',
				'plugin/comment/comment.php',
				'plugin/comment/config',
				'plugin/comment/config-detail.php',
				'plugin/comment/config.php',
				'plugin/comment/config/chs.php',
				'plugin/comment/config/default.php',
				'plugin/comment/config/en.php',
				'plugin/comment/index.php',
				'plugin/comment/info',
				'plugin/comment/info.php',
				'plugin/comment/info/chs.php',
				'plugin/comment/info/en.php',
				'plugin/comment/install.sql',
				'plugin/comment/language',
				'plugin/comment/language/chs.php',
				'plugin/comment/language/default.php',
				'plugin/comment/language/en.php',
				'plugin/comment/quote.gif',
				'plugin/comment/style.css',
				'plugin/comment/tpl',
				'plugin/comment/tpl/comment_classic.tpl',
				'plugin/comment/tpl/list.tpl',
				'plugin/comment/tpl/main.tpl',
				'plugin/custom_sql/class.php',
				'plugin/front_code/class.php',
				'plugin/meeting/class.php',
				'plugin/meeting/meeting.php',
				'plugin/meeting/tpl/list.tpl',
				'plugin/mssql/class.php',
				'plugin/news_mark/class.php',
				'plugin/news_mark/index.php',
				'plugin/news_mark/language/en.php',
				'plugin/news_mark/news_mark.php',
				'plugin/news_mark/tpl/news_mark.tpl',
				'plugin/news_snatch/class.php',
				'plugin/news_snatch/tpl/import.tpl',
				'plugin/news_visit/class.php',
				'plugin/news_visit/news_visit.php',
				'plugin/news_visit/news_visit.tpl',
				'plugin/offical/class.php',
				'plugin/offical/index.php',
				'plugin/offical/tpl/rss.tpl',
				'plugin/se_detect/class.php',
				'plugin/search/class.php',
				'plugin/survey/class.php',
				'plugin/survey/data',
				'plugin/topic/class.php',
				'plugin/topic/install.sql',
				'plugin/topic/language/chs.php',
				'plugin/topic/language/default.php',
				'plugin/topic/language/en.php',
				'plugin/topic/topic',
				'plugin/topic/topic_link.php',
				'plugin/topic/tpl/input.tpl',
				'plugin/visit_analysis/class.php',
				'plugin/visit_analysis/install.sql',
				'plugin/visit_analysis/tpl/keyword.tpl',
				'read.php',
				'rss.php',
				'script/addon.js',
				'script/global.js',
				'script/jquery.js',
				'script/language.js.php',
				'source/class/mycache.class.php',
				'source/class/mystep.class.php',
				'source/class/mytpl.class.php',
				'source/class/session.class.php',
				'source/function/admin.php',
				'source/function/global.php',
				'source/function/web.php',
				'source/language/en.php',
				'source/merge.php',
				'template/admin/art_catalog_list.tpl',
				'template/admin/main.tpl',
				'template/admin/web_plugin_list.tpl',
				'template/admin_simple/art_catalog_list.tpl',
				'template/admin_simple/main.tpl',
				'template/classic/index.tpl',
				'template/classic/main.tpl',
				'template/classic/read.tpl',
				'template/default/block_comment.tpl',
				'template/default/block_link_img.tpl',
				'template/default/block_link_txt.tpl',
				'template/default/block_news_describe.tpl',
				'template/default/block_news_image.tpl',
				'template/default/block_news_mix.tpl',
				'template/default/block_news_picture.tpl',
				'template/default/block_news_slide.tpl',
				'template/default/main.tpl',
				'template/default/rss.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20111201',
					),
			),
	),
	'0.99.7.1' => array(
		'info' => '
				V0.99.7.1
				1.Fix a bug in update function
				2.Fix a bug in get remote picture function
				3.Some adjust in meeting plugin
				4.Some other adjusts...
			',
		'file' => array(
				'admin/update.php',
				'include/parameter.php',
				'plugin/meeting/class.php',
				'plugin/meeting/index.php',
				'plugin/meeting/meeting.php',
				'plugin/meeting/regist.php',
				'plugin/meeting/style.css',
				'plugin/meeting/tpl/default_regist_cn.tpl',
				'plugin/meeting/tpl/default_regist_en.tpl',
				'plugin/visit_analysis/class.php',
				'source/class/mycache.class.php',
				'source/function/admin.php',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20111207',
					),
			),
	),
	'0.99.7.2' => array(
		'info' => '
				V0.99.7.2
				1.Enhance meeting plugin
				2.Fix a bug in news_visit plugin
				3.Fix a bug in news_parse tag when it has a variant value in tag attribute
				4.Fix a bug in picture watermark function
				5.Fix a bug in news_visit plugin
				6.Some other adjusts...
			',
		'file' => array(
				'error.php',
				'read.php',
				'include/parameter.php',
				'images/classic/style.css',
				'plugin/meeting/meeting.php',
				'plugin/meeting/tpl/add.tpl',
				'plugin/meeting/tpl/edit.tpl',
				'plugin/news_visit/info/chs.php',
				'plugin/news_visit/info/en.php',
				'plugin/offical/class.php',
				'plugin/visit_analysis/class.php',
				'source/class/session.class.php',
				'source/function/global.php',
				'template/classic/list_0.tpl',
				'template/classic/read.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20111229',
					),
			),
	),
	'0.99.8.1' => array(
		'info' => '
				V0.99.8.1
				1.Pack all file into one php installation file
				2.Enhance catalog reorder function
				3.Enhance cache clear function
				4.Add export function for plugin module
				5.Add email group sending function (html/text with attchment)
				6.Fix a bug in install function
				7.Add sub-website assign function for plugin module
				8.Enhance meeting plugin, and fix some bug
				9.Limit tags can only show current sub-website content in offical plugin
				10.And clearError function in base class
				11.Enhance file pack class
				Some other adjusts...
			',
		'sql' => array(
				'alter table {pre}news_cat modify `cat_order` SMALLINT UNSIGNED DEFAULT 1',
				'alter table {pre}plugin add `subweb` Char(255) DEFAULT "" NOT NULL',
				'alter table {pre}website modify `name` Char(200) DEFAULT "" NOT NULL',
			),
		'file' => array(
				'admin/art_catalog.php',
				'admin/attachment.php',
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/upload_img.php',
				'admin/web_cache.php',
				'admin/web_plugin.php',
				'files/index.php',
				'include/config.php',
				'include/config/chs.php',
				'include/config/default.php',
				'include/config/en.php',
				'include/parameter.php',
				'plugin/admin_cat/class.php',
				'plugin/comment/class.php',
				'plugin/custom_sql/class.php',
				'plugin/front_code/class.php',
				'plugin/meeting/class.php',
				'plugin/meeting/index.php',
				'plugin/meeting/language',
				'plugin/meeting/language/chs.php',
				'plugin/meeting/language/default.php',
				'plugin/meeting/language/en.php',
				'plugin/meeting/meeting.php',
				'plugin/meeting/regist.php',
				'plugin/meeting/setting/default.php',
				'plugin/meeting/setting/main.tpl',
				'plugin/meeting/tpl/add.tpl',
				'plugin/meeting/tpl/default_regist_cn.tpl',
				'plugin/meeting/tpl/default_regist_en.tpl',
				'plugin/meeting/tpl/default_reglist_cn.tpl',
				'plugin/meeting/tpl/default_reglist_en.tpl',
				'plugin/meeting/tpl/edit.tpl',
				'plugin/meeting/tpl/list.tpl',
				'plugin/mssql/class.php',
				'plugin/news_mark/class.php',
				'plugin/news_snatch/class.php',
				'plugin/news_snatch/news_snatch.php',
				'plugin/news_visit/class.php',
				'plugin/offical/class.php',
				'plugin/se_detect/class.php',
				'plugin/search/class.php',
				'plugin/survey/class.php',
				'plugin/topic/class.php',
				'plugin/visit_analysis/class.php',
				'script/checkForm.js',
				'source/class/abstract.class.php',
				'source/class/class.smtp.php',
				'source/class/myemail.class.php',
				'source/class/mypack.class.php',
				'source/class/mystep.class.php',
				'source/class/myuploader.class.php',
				'source/class/myzip.class.php',
				'source/function/global.php',
				'source/function/web.php',
				'source/language/chs.php',
				'source/language/en.php',
				'template/admin/art_catalog_list.tpl',
				'template/admin/web_cache.tpl',
				'template/admin/web_plugin_list.tpl',
				'template/admin/web_plugin_setting.tpl',
				'template/admin/web_plugin_upload.tpl',
				'template/admin/web_subweb_input.tpl',
				'template/admin_simple/art_catalog_list.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/art_info_list.tpl',
				'template/admin_simple/func_link_list.tpl',
				'template/admin_simple/web_subweb_input.tpl',
				'template/classic/index.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120201',
					),
				'email' => array(
						'mode' => '',
						'smtp' => '',
						'port' => 25,
						'user' => '',
						'password' => '',
					),
			),
	),
	
	'0.99.8.2' => array(
		'info' => '
				V0.99.8.2
				1.Crontab plugin added, you can run any code in schedule with it
				2.Email plugin added, you can send mass email with it
				3.Fix a bug in tag page
				4.Fix a bug in sitemap
				5.Fix a bug in GetFileSize function
				6.Open parameter cache function for all other database table
				7.Add date input component(js) for all date input area
				Some other adjusts...
			',
		'file' => array(
				'admin/info_err.php',
				'admin/style.css',
				'admin/web_subweb.php',
				'include/config.php',
				'include/config/chs.php',
				'include/config/default.php',
				'include/config/en.php',
				'include/parameter.php',
				'plugin/admin_cat/admin_cat.php',
				'plugin/admin_cat/class.php',
				'plugin/admin_cat/language/chs.php',
				'plugin/admin_cat/language/default.php',
				'plugin/admin_cat/language/en.php',
				'plugin/admin_cat/tpl/input.tpl',
				'plugin/admin_cat/tpl/list.tpl',
				'plugin/comment/tpl/list.tpl',
				'plugin/comment/tpl/main.tpl',
				'plugin/crontab',
				'plugin/crontab/class.php',
				'plugin/crontab/crontab.php',
				'plugin/crontab/index.php',
				'plugin/crontab/info',
				'plugin/crontab/info.php',
				'plugin/crontab/info/chs.php',
				'plugin/crontab/info/en.php',
				'plugin/crontab/install.sql',
				'plugin/crontab/language',
				'plugin/crontab/language/chs.php',
				'plugin/crontab/language/default.php',
				'plugin/crontab/language/en.php',
				'plugin/crontab/log.txt',
				'plugin/crontab/run.php',
				'plugin/crontab/status.txt',
				'plugin/crontab/tpl',
				'plugin/crontab/tpl/input.tpl',
				'plugin/crontab/tpl/list.tpl',
				'plugin/custom_sql/class.php',
				'plugin/custom_sql/tpl/input.tpl',
				'plugin/custom_sql/tpl/list.tpl',
				'plugin/custom_sql/tpl/view.tpl',
				'plugin/email',
				'plugin/email/attachment',
				'plugin/email/attachment.php',
				'plugin/email/class.php',
				'plugin/email/config',
				'plugin/email/config-detail.php',
				'plugin/email/config.php',
				'plugin/email/config/chs.php',
				'plugin/email/config/default.php',
				'plugin/email/config/en.php',
				'plugin/email/email.php',
				'plugin/email/index.php',
				'plugin/email/info',
				'plugin/email/info.php',
				'plugin/email/info/chs.php',
				'plugin/email/info/en.php',
				'plugin/email/install.sql',
				'plugin/email/language',
				'plugin/email/language/chs.php',
				'plugin/email/language/default.php',
				'plugin/email/language/en.php',
				'plugin/email/send.log',
				'plugin/email/tpl',
				'plugin/email/tpl/attachment.tpl',
				'plugin/email/tpl/input.tpl',
				'plugin/email/tpl/list.tpl',
				'plugin/front_code/class.php',
				'plugin/front_code/tpl/main.tpl',
				'plugin/meeting/setting/main.tpl',
				'plugin/meeting/tpl/main.tpl',
				'plugin/meeting/tpl/list.tpl',
				'plugin/meeting/tpl/default_regist_cn.tpl',
				'plugin/meeting/tpl/default_regist_en.tpl',
				'plugin/news_mark/tpl/news_mark.tpl',
				'plugin/news_snatch/news_snatch.php',
				'plugin/news_snatch/tpl/main.tpl',
				'plugin/news_visit/news_visit.tpl',
				'plugin/offical/class.php',
				'plugin/offical/config.php',
				'plugin/se_detect/tpl/main.tpl',
				'plugin/search/tpl/main.tpl',
				'plugin/survey/tpl/main.tpl',
				'plugin/topic/tpl/main.tpl',
				'plugin/visit_analysis/tpl/main.tpl',
				'script/addon.js',
				'script/admin.js',
				'script/date_input.css',
				'script/jquery.date_input.js',
				'script/read.js',
				'script/setting.js.php',
				'sitemap.php',
				'source/class/myemail.class.php',
				'source/class/mystep.class.php',
				'source/class/myuploader.class.php',
				'source/function/global.php',
				'source/function/web.php',
				'template/admin/art_catalog_list.tpl',
				'template/admin/art_content_input.tpl',
				'template/admin/art_info_input.tpl',
				'template/admin/attachment_add.tpl',
				'template/admin/func_backup.tpl',
				'template/admin/index.tpl',
				'template/admin/info_err.tpl',
				'template/admin/main.tpl',
				'template/admin/web_language.tpl',
				'template/admin/web_plugin_list.tpl',
				'template/admin/web_setting.tpl',
				'template/admin_simple/art_catalog_list.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/art_info_input.tpl',
				'template/admin_simple/index.tpl',
				'template/admin_simple/main.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120210',
					),
			),
	),
	'0.99.8.3' => array(
		'info' => '
				V0.99.8.3
				1.Fix a bug in plugin install
				2.Add authority mode for advance user (Check detail from checkUser() function, authority varaint can be set in parameter.php)
				3.Fix date_input script
				4.Fix setting.js.php for more extend setting
				Some other adjusts...
			',
		'file' => array(
				'admin/web_plugin.php',
				'include/parameter.php',
				'script/date_input.css',
				'script/jquery.date_input.js',
				'script/language.js.php',
				'script/setting.js.php',
				'template/admin/info_main.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120213',
					),
			),
	),
	'0.99.9' => array(
		'info' => '
				V0.99.9
				1.Advertisement plugin added
				2.Delete data cache when article has been edited
				3.Fix a bug in attachment multi-upload
				4.Fix a bug in error show page
				5.Fix a bug in thumb making function
				Some other adjusts...
			',
		'file' => array(
				'admin/art_content.php',
				'admin/attachment.php',
				'admin/func_attach.php',
				'admin/inc.php',
				'admin/info_err.php',
				'admin/style.css',
				'admin/update.php',
				'ajax.php',
				'api.php',
				'admin/web_cache.php',
				'files/index.php',
				'inc.php',
				'include/config.php',
				'include/parameter.php',
				'module.php',
				'plugin/ad_show',
				'plugin/ad_show/ad_show.php',
				'plugin/ad_show/class.php',
				'plugin/ad_show/files',
				'plugin/ad_show/go.php',
				'plugin/ad_show/index.php',
				'plugin/ad_show/info',
				'plugin/ad_show/info.php',
				'plugin/ad_show/info/chs.php',
				'plugin/ad_show/info/en.php',
				'plugin/ad_show/install.sql',
				'plugin/ad_show/ipdata',
				'plugin/ad_show/language',
				'plugin/ad_show/language/chs.php',
				'plugin/ad_show/language/default.php',
				'plugin/ad_show/language/en.php',
				'plugin/ad_show/tpl',
				'plugin/ad_show/tpl/input.tpl',
				'plugin/ad_show/tpl/list.tpl',
				'plugin/ad_show/tpl/main.tpl',
				'plugin/ad_show/tpl/upload.tpl',
				'plugin/ad_show/upload.php',
				'plugin/admin_cat/tpl/input.tpl',
				'plugin/comment/index.php',
				'plugin/comment/tpl/list.tpl',
				'plugin/crontab/crontab.php',
				'plugin/crontab/tpl/input.tpl',
				'plugin/crontab/tpl/list.tpl',
				'plugin/custom_sql/tpl/input.tpl',
				'plugin/email/config.php',
				'plugin/email/tpl/input.tpl',
				'plugin/front_code/index.php',
				'plugin/front_code/info.php',
				'plugin/front_code/info/chs.php',
				'plugin/front_code/tpl/input.tpl',
				'plugin/front_code/tpl/list.tpl',
				'plugin/inc.php',
				'plugin/meeting/config.php',
				'plugin/meeting/index.php',
				'plugin/meeting/meeting.php',
				'plugin/meeting/regist.php',
				'plugin/meeting/setting/default.php',
				'plugin/meeting/style.css',
				'plugin/meeting/tpl/add.tpl',
				'plugin/meeting/tpl/confirm.tpl',
				'plugin/meeting/tpl/default_mail_cn.tpl',
				'plugin/meeting/tpl/default_mail_en.tpl',
				'plugin/meeting/tpl/default_regist_cn.tpl',
				'plugin/meeting/tpl/default_regist_en.tpl',
				'plugin/meeting/tpl/edit.tpl',
				'plugin/meeting/tpl/edit_reg.tpl',
				'plugin/meeting/tpl/edit_reg_custom.tpl',
				'plugin/meeting/tpl/list.tpl',
				'plugin/meeting/tpl/list_reg.tpl',
				'plugin/mssql/config.php',
				'plugin/mssql/index.php',
				'plugin/news_mark/index.php',
				'plugin/news_snatch/news_snatch.php',
				'plugin/news_snatch/tpl/import.tpl',
				'plugin/news_snatch/tpl/news.tpl',
				'plugin/news_snatch/tpl/news_edit.tpl',
				'plugin/news_snatch/tpl/rule.tpl',
				'plugin/news_snatch/tpl/rule_input.tpl',
				'plugin/news_snatch/tpl/snatch.tpl',
				'plugin/news_visit/index.php',
				'plugin/offical/index.php',
				'plugin/offical/class.php',
				'plugin/offical/tpl/password.tpl',
				'plugin/se_detect/config.php',
				'plugin/se_detect/config/chs.php',
				'plugin/se_detect/config/default.php',
				'plugin/se_detect/config/en.php',
				'plugin/se_detect/index.php',
				'plugin/se_detect/tpl/input.tpl',
				'plugin/se_detect/tpl/view.tpl',
				'plugin/search/index.php',
				'plugin/search/tpl/block_keyword.tpl',
				'plugin/search/tpl/block_search.tpl',
				'plugin/survey/index.php',
				'plugin/survey/tpl/input.tpl',
				'plugin/topic/index.php',
				'plugin/topic/tpl/input.tpl',
				'plugin/topic/tpl/list.tpl',
				'plugin/visit_analysis/index.php',
				'read.php',
				'script/admin.js',
				'script/date.js',
				'script/language.js.php',
				'script/setting.js.php',
				'source/class/abstract.class.php',
				'source/class/eaccelerator.class.php',
				'source/class/htc_parser.class.php',
				'source/class/image.class.php',
				'source/class/magickwand.class.php',
				'source/class/memcache.class.php',
				'source/class/mssql.class.php',
				'source/class/myajax.class.php',
				'source/class/myapi.class.php',
				'source/class/mycache.class.php',
				'source/class/mydb.class.php',
				'source/class/myemail.class.php',
				'source/class/myfso.class.php',
				'source/class/mypack.class.php',
				'source/class/myreq.class.php',
				'source/class/mysql.class.php',
				'source/class/mystep.class.php',
				'source/class/mytpl.class.php',
				'source/class/myuploader.class.php',
				'source/class/myxls.class.php',
				'source/class/xcache.class.php',
				'source/function/admin.php',
				'source/function/chs2cht.dic',
				'source/function/encry.php',
				'source/function/etag.php',
				'source/function/global.php',
				'source/function/web.php',
				'template/admin/art_catalog_input.tpl',
				'template/admin/art_catalog_list.tpl',
				'template/admin/art_content_input.tpl',
				'template/admin/art_content_list.tpl',
				'template/admin/art_image_input.tpl',
				'template/admin/art_info_input.tpl',
				'template/admin/art_info_list.tpl',
				'template/admin/art_tag.tpl',
				'template/admin/attachment_add.tpl',
				'template/admin/attachment_edit.tpl',
				'template/admin/func_attach.tpl',
				'template/admin/func_backup.tpl',
				'template/admin/func_link_input.tpl',
				'template/admin/index.tpl',
				'template/admin/info_count.tpl',
				'template/admin/info_err.tpl',
				'template/admin/info_log.tpl',
				'template/admin/info_main.tpl',
				'template/admin/info_mysql.tpl',
				'template/admin/login.tpl',
				'template/admin/upload_img.tpl',
				'template/admin/user_group_input.tpl',
				'template/admin/user_input.tpl',
				'template/admin/user_power_input.tpl',
				'template/admin/user_type_input.tpl',
				'template/admin/web_cache.tpl',
				'template/admin/web_language.tpl',
				'template/admin/web_plugin_list.tpl',
				'template/admin/web_plugin_setting.tpl',
				'template/admin/web_plugin_view.tpl',
				'template/admin/web_setting.tpl',
				'template/admin/web_subweb_input.tpl',
				'template/admin/web_template_input.tpl',
				'template/admin/web_template_list.tpl',
				'template/admin_simple/art_catalog_input.tpl',
				'template/admin_simple/art_catalog_list.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/art_content_list.tpl',
				'template/admin_simple/art_image_input.tpl',
				'template/admin_simple/art_info_input.tpl',
				'template/admin_simple/art_info_list.tpl',
				'template/admin_simple/art_tag.tpl',
				'template/admin_simple/attachment_add.tpl',
				'template/admin_simple/attachment_edit.tpl',
				'template/admin_simple/func_link_input.tpl',
				'template/admin_simple/index.tpl',
				'template/admin_simple/login.tpl',
				'template/admin_simple/upload_img.tpl',
				'template/admin_simple/web_subweb_input.tpl',
				'template/classic/index.tpl',
				'vcode.php'
			),
		'setting' => array(
				'gen' => array(
						'update' => 'http://www.mysteps.cn/update/',
						'etag' => '20120228',
					),
			),
	),
	'0.99.9.1' => array(
		'info' => '
				V0.99.9.1
				1.Enhance setup pack maker module
				2.Enhance chs2cht function
				3.Adjust automatic update funtion, now you can choose to download update pack, and update manually
				4.Add clean image cache funtion
				5.Fix a bug in crontab plugin
				6.Adjust email plugin to force single when the quantity of email large then 100
				7.Fix a bug in export function of meeting plugin
				8.Fix a bug in article content format function of editor
				Some other adjusts...
			',
		'file' => array(
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/update.php',
				'admin/web_cache.php',
				'plugin/crontab/run.php',
				'plugin/email/email.php',
				'plugin/meeting/meeting.php',
				'plugin/news_snatch/news_snatch.php',
				'source/function/chs2cht.dic',
				'source/function/global.php',
				'template/admin/art_content_input.tpl',
				'template/admin/info_main.tpl',
				'template/admin/web_cache.tpl',
				'template/admin_simple/art_content_input.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120301',
					),
			),
	),
	'0.99.9.2' => array(
		'info' => '
				V0.99.9.2
				1.Fix a bug in attachment downloading
				2.Enhance Crontab plugin
				3.Add just-download option to update module
				4.Enhance plugin module
				Some other adjusts...
			',
		'file' => array(
				'files/index.php',
				'include/parameter.php',
				'plugin/comment/config-detail.php',
				'plugin/crontab/config',
				'plugin/crontab/config.php',
				'plugin/crontab/config/chs.php',
				'plugin/crontab/config/default.php',
				'plugin/crontab/config/en.php',
				'plugin/crontab/log.txt',
				'plugin/crontab/run.php',
				'plugin/email/config-detail.php',
				'plugin/mssql/config-detail.php',
				'plugin/news_mark/config-detail.php',
				'plugin/offical/config-detail.php',
				'plugin/se_detect/config-detail.php',
				'script/global.js',
				'template/admin/info_main.tpl',
				'template/admin/web_plugin_list.tpl',
				'template/admin/web_plugin_setting.tpl',
				'template/admin/web_plugin_view.tpl',
				'template/admin/web_template_list.tpl',
				'template/classic/main.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120305',
					),
			),
	),
	'0.99.9.3' => array(
		'info' => '
				V0.99.9.3
				1.Allow custom regist list to meeting plugin
				2.Fix a bug in downloading local attachment
				3.Add background music setting in offical plugin
				Some other adjusts...
			',
		'file' => array(
				'admin/style.css',
				'include/parameter.php',
				'plugin/meeting/class.php',
				'plugin/meeting/meeting.php',
				'plugin/meeting/tpl/add.tpl',
				'plugin/meeting/tpl/edit.tpl',
				'plugin/offical/config.php',
				'plugin/offical/config/chs.php',
				'plugin/offical/config/default.php',
				'plugin/offical/config/en.php',
				'plugin/offical/index.php',
				'script/admin.js',
				'source/class/mystep.class.php',
				'source/function/admin.php',
				'source/function/web.php',
				'template/admin/art_content_input.tpl',
				'template/admin/info_main.tpl',
				'template/admin/info_mysql.tpl',
				'template/admin/info_php.tpl',
				'template/admin/info_server.tpl',
				'template/admin_simple/art_content_input.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120308',
					),
			),
	),
	'0.99.9.4' => array(
		'info' => '
				V0.99.9.4
				1.Enhance image loading function in article read page
				2.Exhance password input method in plugin setting function
				3.Fix a bug in comment plugin
				4.Echance crontab plugin, resume mode works fun with authority mode (see V0.99.8.3)
				5.Add background music setting in offical plugin
				6.Add modified file check funtion
				7.Exhance update function, modified files will not be rewrite when auto-update
				Some other adjusts...
			',
		'file' => array(
				'admin/art_content.php',
				'admin/images/btn.gif',
				'admin/func_attach.php',
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/style.css',
				'admin/update.php',
				'admin/web_cache.php',
				'admin/web_plugin.php',
				'images/loading_img.gif',
				'include/config.php',
				'include/parameter.php',
				'plugin/comment/class.php',
				'plugin/crontab/class.php',
				'plugin/crontab/config.php',
				'plugin/crontab/config/chs.php',
				'plugin/crontab/config/default.php',
				'plugin/crontab/config/en.php',
				'plugin/crontab/install.sql',
				'plugin/crontab/run.php',
				'plugin/offical/config.php',
				'script/addon.js',
				'script/admin.js',
				'script/jquery.addon.js',
				'script/setting.js.php',
				'source/class/session.class.php',
				'source/function/admin.php',
				'template/admin/func_backup.tpl',
				'template/admin/info_main.tpl',
				'template/admin/web_cache.tpl',
				'template/admin/web_plugin_setting.tpl',
				'template/classic/index.tpl',
				'template/classic/main.tpl',
				'template/classic/read.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120312',
					),
			),
	),
	'0.99.9.5' => array(
		'info' => '
				V0.99.9.5
				1.Plugin online update added
				2.Fix a plugin data bug
				3.Enhance meeting plugin
				4.Echance plugin management module
				5.Some Style adjusts
				Some other adjusts...
			',
		'sql' => array(
				'update {pre}admin_cat set `name`="管理群组", `comment`="管理群组维护" where `file`="user_group.php"',
			),
		'file' => array(
				'admin/style.css',
				'admin/update.php',
				'admin/web_plugin.php',
				'images/classic/style.css',
				'include/parameter.php',
				'plugin/ad_show/class.php',
				'plugin/crontab/config.php',
				'plugin/front_code/class.php',
				'plugin/meeting/class.php',
				'plugin/meeting/meeting.php',
				'plugin/meeting/tpl/block_reg_cn_tbl.tpl',
				'plugin/meeting/tpl/block_reg_en_tbl.tpl',
				'plugin/meeting/tpl/default_reglist_cn.tpl',
				'plugin/meeting/tpl/default_reglist_en.tpl',
				'plugin/news_snatch/class.php',
				'plugin/survey/class.php',
				'plugin/topic/class.php',
				'script/jquery.addon.js',
				'source/function/global.php',
				'template/admin/func_backup.tpl',
				'template/admin/info_main.tpl',
				'template/admin/main.tpl',
				'template/admin/user_group_list.tpl',
				'template/admin/user_input.tpl',
				'template/admin/user_online.tpl',
				'template/admin/user_power_list.tpl',
				'template/admin/user_type_list.tpl',
				'template/admin/web_cache.tpl',
				'template/admin/web_plugin_list.tpl',
				'template/admin/web_plugin_setting.tpl',
				'template/admin/web_plugin_view.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120319',
					),
			),
	),
	'0.99.9.5.1' => array(
		'info' => '
				V0.99.9.5.1
				1.Fix a bug in update function
				2.Move "ignore list" and "authority" parameter from parameter.php to config.php
				3.Fix a bug in powerImage function (javascript)
				4.Fix a bug in image thumb funtion
				Some other adjusts...
			',
		'file' => array(
				'admin/update.php',
				'admin/web_cache.php',
				'admin/web_setting.php',
				'include/config.php',
				'include/parameter.php',
				'script/jquery.addon.js',
				'source/function/global.php',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120320',
					),
			),
		'code' => '
$cur_setting = $setting;
unset($setting);
include(ROOT_PATH."/include/config.php");
$expire_list = var_export($expire_list, true);
$ignore_list = var_export($ignore_list, true);
$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$expire_list = {$expire_list};
\$ignore_list = {$ignore_list};
\$authority = "{$authority}";
?>
mystep;
$content = str_replace("/*--settings--*/", makeVarsCode($setting, "\$setting"), $content);
WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
unset($setting);
$setting = $cur_setting;
		',
	),
	'0.99.9.5.2' => array(
		'info' => '
				V0.99.9.5.2
				1.Fix a bug in plugin import function
				2.Add visual mode for template edit function
				Some other adjusts...
			',
		'file' => array(
				'admin/style.css',
				'admin/web_plugin.php',
				'images/style.css',
				'include/config.php',
				'include/parameter.php',
				'plugin/meeting/config.php',
				'script/admin.js',
				'script/global.js',
				'script/jquery.codemirror.js',
				'template/admin/art_catalog_input.tpl',
				'template/admin/art_content_input.tpl',
				'template/admin/art_image_input.tpl',
				'template/admin/art_info_input.tpl',
				'template/admin/func_backup.tpl',
				'template/admin/func_link_input.tpl',
				'template/admin/info_err.tpl',
				'template/admin/main.tpl',
				'template/admin/user_group_input.tpl',
				'template/admin/user_input.tpl',
				'template/admin/user_power_input.tpl',
				'template/admin/user_type_input.tpl',
				'template/admin/web_cache.tpl',
				'template/admin/web_language.tpl',
				'template/admin/web_plugin_list.tpl',
				'template/admin/web_plugin_setting.tpl',
				'template/admin/web_plugin_view.tpl',
				'template/admin/web_subweb_input.tpl',
				'template/admin/web_template_input.tpl',
				'template/admin_simple/art_catalog_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/art_image_input.tpl',
				'template/admin_simple/art_info_input.tpl',
				'template/admin_simple/func_link_input.tpl',
				'template/admin_simple/web_subweb_input.tpl',
				'template/classic/main.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120322',
					),
			),
	),
	'0.99.9.5.3' => array(
		'info' => '
				V0.99.9.5.3
				1.Fix a bug in Multi-page article submit function
				2.Add source code plugin for TinyMCE and show with codemirror module
				Some other adjusts...
			',
		'file' => array(
				'admin/art_content.php',
				'images/classic/style.css',
				'images/editor.css',
				'images/style.css',
				'include/config.php',
				'include/parameter.php',
				'plugin/ad_show/tpl/input.tpl',
				'plugin/admin_cat/tpl/input.tpl',
				'plugin/comment/tpl/list.tpl',
				'plugin/crontab/tpl/input.tpl',
				'plugin/custom_sql/tpl/input.tpl',
				'plugin/email/tpl/input.tpl',
				'plugin/front_code/tpl/input.tpl',
				'plugin/meeting/tpl/add.tpl',
				'plugin/meeting/tpl/edit.tpl',
				'plugin/meeting/tpl/edit_reg.tpl',
				'plugin/news_snatch/rule/3b405644d701556f7404a65acdf6d0f5_snatch.php',
				'plugin/news_snatch/tpl/import.tpl',
				'plugin/news_snatch/tpl/news_edit.tpl',
				'plugin/news_snatch/tpl/rule_input.tpl',
				'plugin/news_snatch/tpl/snatch.tpl',
				'plugin/se_detect/tpl/input.tpl',
				'plugin/search/tpl/engine.tpl',
				'plugin/survey/tpl/input.tpl',
				'plugin/topic/tpl/input.tpl',
				'script/global.js',
				'script/jquery.codemirror.js',
				'script/tinymce/plugins/bbscode/bbscode.htm',
				'script/tinymce/plugins/source_code',
				'script/tinymce/plugins/source_code/editor_plugin.js',
				'script/tinymce/plugins/source_code/img',
				'script/tinymce/plugins/source_code/img/source_code.jpg',
				'script/tinymce/plugins/source_code/js',
				'script/tinymce/plugins/source_code/js/source_code.js',
				'script/tinymce/plugins/source_code/langs',
				'script/tinymce/plugins/source_code/langs/en.js',
				'script/tinymce/plugins/source_code/langs/en_dlg.js',
				'script/tinymce/plugins/source_code/langs/zh.js',
				'script/tinymce/plugins/source_code/langs/zh_dlg.js',
				'script/tinymce/plugins/source_code/source_code.htm',
				'template/admin/art_content_input.tpl',
				'template/admin/web_template_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/classic/read.tpl',
				'template/default/main.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120326',
					),
			),
	),
	'0.99.9.5.4' => array(
		'info' => '
				V0.99.9.5.4
				1.Fix some tpl display bug
				2.Enhance codemirror module
				3.Add codemirror module to meeting plugin
				Some other adjusts...
			',
		'file' => array(
				'include/parameter.php',
				'plugin/ad_show/tpl/main.tpl',
				'plugin/front_code/tpl/main.tpl',
				'plugin/meeting/meeting.php',
				'plugin/meeting/setting/main.tpl',
				'plugin/meeting/tpl/add.tpl',
				'plugin/meeting/tpl/edit.tpl',
				'plugin/meeting/tpl/main.tpl',
				'plugin/news_snatch/tpl/main.tpl',
				'plugin/se_detect/tpl/main.tpl',
				'plugin/search/tpl/main.tpl',
				'plugin/survey/tpl/main.tpl',
				'plugin/topic/tpl/main.tpl',
				'plugin/visit_analysis/tpl/main.tpl',
				'script/jquery.codemirror.js',
				'template/admin/web_template_input.tpl',
				'template/classic/read.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120326',
					),
			),
	),
	'0.99.9.5.5' => array(
		'info' => '
				V0.99.9.5.5
				1.Fix a bug that admin cannot edit locked articles
				2.Allow user edit css file of every template
				3.Add textara mode from all setting functions
				4.Add bgsound setting from every subweb
				Some other adjusts...
			',
		'file' => array(
				'admin/art_content.php',
				'admin/style.css',
				'admin/web_template.php',
				'include/parameter.php',
				'plugin/offical/config.php',
				'plugin/offical/config/chs.php',
				'plugin/offical/config/default.php',
				'plugin/offical/config/en.php',
				'plugin/offical/index.php',
				'script/checkForm.js',
				'template/admin/web_plugin_setting.tpl',
				'template/admin/web_plugin_view.tpl',
				'template/admin/web_setting.tpl',
				'template/admin/web_template_input.tpl',
				'template/admin_simple/main.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120327',
					),
			),
	),
	'0.99.9.5.6' => array(
		'info' => '
				V0.99.9.5.6
				1.Adjust templates to match xhtml standard
				2.Adjust css W3C standard
				3.Enhance content format function for TinyMCE
				Some other adjusts...
			',
		'file' => array(
				'admin/art_content.php',
				'admin/style.css',
				'images/classic/style.css',
				'images/editor.css',
				'images/style.css',
				'include/parameter.php',
				'plugin/offical/index.php',
				'template/admin/art_catalog_input.tpl',
				'template/admin/art_catalog_list.tpl',
				'template/admin/art_content_input.tpl',
				'template/admin/art_image_input.tpl',
				'template/admin/art_info_input.tpl',
				'template/admin/attachment_add.tpl',
				'template/admin/attachment_edit.tpl',
				'template/admin/attachment_mine.tpl',
				'template/admin/func_backup.tpl',
				'template/admin/func_link_input.tpl',
				'template/admin/index.tpl',
				'template/admin/info_main.tpl',
				'template/admin/login.tpl',
				'template/admin/main.tpl',
				'template/admin/script.tpl',
				'template/admin/upload_img.tpl',
				'template/admin/user_group_input.tpl',
				'template/admin/user_input.tpl',
				'template/admin/user_power_input.tpl',
				'template/admin/user_type_input.tpl',
				'template/admin/web_cache.tpl',
				'template/admin/web_language.tpl',
				'template/admin/web_plugin_list.tpl',
				'template/admin/web_plugin_setting.tpl',
				'template/admin/web_plugin_upload.tpl',
				'template/admin/web_plugin_view.tpl',
				'template/admin/web_setting.tpl',
				'template/admin/web_subweb_input.tpl',
				'template/admin/web_subweb_list.tpl',
				'template/admin/web_template_input.tpl',
				'template/admin_simple/art_catalog_input.tpl',
				'template/admin_simple/art_catalog_list.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/art_image_input.tpl',
				'template/admin_simple/art_info_input.tpl',
				'template/admin_simple/attachment_add.tpl',
				'template/admin_simple/attachment_edit.tpl',
				'template/admin_simple/attachment_mine.tpl',
				'template/admin_simple/func_link_input.tpl',
				'template/admin_simple/index.tpl',
				'template/admin_simple/login.tpl',
				'template/admin_simple/main.tpl',
				'template/admin_simple/script.tpl',
				'template/admin_simple/upload_img.tpl',
				'template/admin_simple/web_subweb_input.tpl',
				'template/classic/block_login.tpl',
				'template/classic/index.tpl',
				'template/classic/main.tpl',
				'template/classic/read.tpl',
				'template/default/read.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120328',
					),
			),
	),
	'0.99.9.5.7' => array(
		'info' => '
				V0.99.9.5.7
				1.Fix a bug in multi_catalog post
				2.Fix a mistake in html tag
				3.Fix a bug in format function of TinyMCE
				Some other adjusts...
			',
		'file' => array(
				'admin/art_content.php',
				'include/parameter.php',
				'template/admin/art_content_input.tpl',
				'template/admin_simple/art_content_input.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120328',
					),
			),
	),
	'0.99.9.5.8' => array(
		'info' => '
				V0.99.9.5.8
				1.Fix a bug in meeting plugin
				2.Fix a bug in format function of TinyMCE
				Some other adjusts...
			',
		'file' => array(
				'include/parameter.php',
				'plugin/meeting/meeting.php',
				'template/admin/art_content_input.tpl',
				'template/admin_simple/art_content_input.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120328',
					),
			),
	),
	'0.99.9.6' => array(
		'info' => '
				V0.99.9.6
				1.Enhance resume function for crontab plugin
				2.Fix a bug in crontab schedule calculate
				3.Add extend script method for all of the functions of meeting plugin
				4.Fix a bug in date_input script in IE
				Some other adjusts...
			',
		'file' => array(
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'include/config.php',
				'include/parameter.php',
				'plugin/crontab/class.php',
				'plugin/crontab/config.php',
				'plugin/crontab/index.php',
				'plugin/crontab/run.php',
				'plugin/meeting/class.php',
				'plugin/meeting/images',
				'plugin/meeting/images/div.png',
				'plugin/meeting/images/format.png',
				'plugin/meeting/info.php',
				'plugin/meeting/language/chs.php',
				'plugin/meeting/language/default.php',
				'plugin/meeting/language/en.php',
				'plugin/meeting/meeting.php',
				'plugin/meeting/setting/ext_script.php',
				'plugin/meeting/tpl/add.tpl',
				'plugin/meeting/tpl/default_mail_cn.tpl',
				'plugin/meeting/tpl/default_mail_en.tpl',
				'plugin/meeting/tpl/default_regist_cn.tpl',
				'plugin/meeting/tpl/default_regist_en.tpl',
				'plugin/meeting/tpl/edit.tpl',
				'plugin/meeting/tpl/edit_reg.tpl',
				'plugin/meeting/tpl/list_reg.tpl',
				'script/date_input.css',
				'script/global.js',
				'script/jquery.addon.js',
				'script/jquery.codemirror.js',
				'script/jquery.date_input.js',
				'script/jquery.jmpopups.js',
				'source/class/myemail.class.php',
				'source/language/chs.php',
				'source/language/default.php',
				'source/language/en.php',
				'template/admin/art_content_input.tpl',
				'template/admin/art_info_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/classic/main.tpl',
			),
		'setting' => array(
				'gen' => array(
						'cache' => true,
						'minify' => true,
						'etag' => '20120401',
					),
			),
	),
);
?>