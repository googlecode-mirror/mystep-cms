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
				1.Fix a bug in multi-web script cache function
				2.Adjust plugin template mode
				3.Fix a bug in search engine plugin
				4.Fix a bug MySQL Class bug in record return function
				5.Some other adjusts...
			',
		'file' => array(
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
$rewrite_list_str = var_export($rewrite_list, true);
$expire_list_str = var_export($expire_list, true);
$ignore_list_str = var_export($ignore_list, true);
if(empty($rewrite_list_str)) $rewrite_list_str = "array()";
if(empty($expire_list_str)) $expire_list_str = "array()";
if(empty($ignore_list_str)) $ignore_list_str = "array()";
$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$rewrite_list = {$rewrite_list_str};
\$expire_list = {$expire_list_str};
\$ignore_list = {$ignore_list_str};
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
				1.Fix a bug in plugin import function
				2.Add visual mode for template edit function
				Some other adjusts...
			',
		'file' => array(
				'admin/style.css',
				'admin/web_plugin.php',
				'images/style.css',
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
				1.Fix a bug in Multi-page article submit function
				2.Add source code plugin for TinyMCE and show with codemirror module
				Some other adjusts...
			',
		'file' => array(
				'admin/art_content.php',
				'images/classic/style.css',
				'images/editor.css',
				'images/style.css',
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
				1.Enhance resume function for crontab plugin
				2.Fix a bug in crontab schedule calculate
				3.Add extend script method for all of the functions of meeting plugin
				4.Fix a bug in date_input script in IE
				5.Fix a bug in subweb setting for plugin
				Some other adjusts...
			',
		'file' => array(
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/web_plugin.php',
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
				'template/admin/web_plugin_setting.tpl',
				'template/admin/web_plugin_view.tpl',
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
	'0.99.9.7' => array(
		'info' => '
				1.Add switch for page information display
				2.Fix a bug in search keyword display
				3.Adjust power image function
				4.Doudle click image attachment to set it to news image
				Some other adjusts...
			',
		'file' => array(
				'include/config/chs.php',
				'include/config/default.php',
				'include/config/en.php',
				'include/parameter.php',
				'index.php',
				'list.php',
				'plugin/search/search.php',
				'read.php',
				'script/jquery.addon.js',
				'script/jquery.jmpopups.js',
				'source/class/mystep.class.php',
				'source/language/chs.php',
				'source/language/default.php',
				'source/language/en.php',
				'tag.php',
				'template/admin/art_content_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/classic/tag.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120501',
						'show_info' => true,
					),
			),
	),
	'0.99.9.8' => array(
		'info' => '
				1.Article title image will be resize to a small size when upload
				2.Enhance image watermark function and add more settings
				3.Fix a bug in page information show when page cache enabled
				Some other adjusts...
			',
		'file' => array(
				'admin/upload_img.php',
				'files/index.php',
				'include/config/chs.php',
				'include/config/default.php',
				'include/config/en.php',
				'include/parameter.php',
				'index.php',
				'list.php',
				'module.php',
				'read.php',
				'source/class/image.class.php',
				'source/class/mystep.class.php',
				'source/function/global.php',
				'tag.php',
				'template/admin/art_content_input.tpl',
				'template/admin/upload_img.tpl',
				'template/admin/web_cache.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/upload_img.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120507',
					),
				'watermark' => array(
						'position' => 3,
						'img_rate' => 4,
						'txt_font' => 'images/font.ttc',
						'txt_fontsize' => 12,
						'txt_fontcolor' => '#FFFFFF',
						'txt_bgcolor' => '#000000',
						'alpha' => 60,
					),
			),
	),
	'0.99.9.8.1' => array(
		'info' => '
				1.Adjust resume code of crontab plugin
				2.Fix a multi-website bug in news_visit plugin
				3.Fix a bug in format function of TinyMCE
				Some other adjusts...
			',
		'file' => array(
				'include/parameter.php',
				'plugin/crontab/class.php',
				'plugin/news_visit/class.php',
				'plugin/news_visit/news_visit.php',
				'plugin/news_visit/news_visit.tpl',
				'template/admin/art_content_input.tpl',
				'template/admin/art_info_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/art_info_input.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120508',
					),
			),
	),
	'0.99.9.8.2' => array(
		'info' => '
				1.Optimize resume code of crontab plugin
				2.Fix a bug in news visit plugin
				Some other adjusts...
			',
		'file' => array(
				'include/parameter.php',
				'plugin/comment/info.php',
				'plugin/crontab/class.php',
				'plugin/crontab/config.php',
				'plugin/crontab/config/chs.php',
				'plugin/crontab/config/default.php',
				'plugin/crontab/config/en.php',
				'plugin/crontab/info.php',
				'plugin/crontab/run.php',
				'plugin/custom_sql/info.php',
				'plugin/meeting/info.php',
				'plugin/mssql/info.php',
				'plugin/news_mark/info.php',
				'plugin/news_snatch/info.php',
				'plugin/news_visit/info.php',
				'plugin/news_visit/news_visit.php',
				'plugin/news_visit/news_visit.tpl',
				'plugin/offical/info.php',
				'plugin/se_detect/info.php',
				'plugin/survey/info.php',
				'plugin/topic/info.php',
				'plugin/visit_analysis/info.php',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120510',
					),
			),
	),
	'0.99.9.8.3' => array(
		'info' => '
				1.Enhance Database Module, repair and optimize function added
				2.Enhance Plugin Module, install check and remote update mode added
				3.Improve installation function
				4.Database information plugin added
				5.Enhance mysql class
				Some other adjusts...
			',
		'file' => array(
				'admin/func_backup.php',
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/subweb.sql',
				'admin/web_plugin.php',
				'cache/index.php',
				'images/index.php',
				'include/parameter.php',
				'index.html',
				'plugin/ad_show/class.php',
				'plugin/ad_show/install.sql',
				'plugin/comment/class.php',
				'plugin/comment/install.sql',
				'plugin/crontab/class.php',
				'plugin/crontab/install.sql',
				'plugin/custom_sql/class.php',
				'plugin/db_info',
				'plugin/db_info/class.php',
				'plugin/db_info/db_info.php',
				'plugin/db_info/index.php',
				'plugin/db_info/info',
				'plugin/db_info/info.php',
				'plugin/db_info/info/chs.php',
				'plugin/db_info/info/en.php',
				'plugin/db_info/language',
				'plugin/db_info/language/chs.php',
				'plugin/db_info/language/default.php',
				'plugin/db_info/language/en.php',
				'plugin/db_info/tpl',
				'plugin/db_info/tpl/db.tpl',
				'plugin/db_info/tpl/tbl.tpl',
				'plugin/email/class.php',
				'plugin/email/install.sql',
				'plugin/front_code/class.php',
				'plugin/index.php',
				'plugin/meeting/class.php',
				'plugin/meeting/install.sql',
				'plugin/meeting/tpl/default_mail_cn.tpl',
				'plugin/meeting/tpl/default_mail_en.tpl',
				'plugin/meeting/tpl/default_regist_cn.tpl',
				'plugin/meeting/tpl/default_regist_en.tpl',
				'plugin/news_mark/install.sql',
				'plugin/news_snatch/class.php',
				'plugin/news_snatch/install.sql',
				'plugin/news_visit/class.php',
				'plugin/news_visit/install.sql',
				'plugin/se_detect/class.php',
				'plugin/se_detect/install.sql',
				'plugin/search/class.php',
				'plugin/search/install.sql',
				'plugin/survey/class.php',
				'plugin/survey/install.sql',
				'plugin/topic/class.php',
				'plugin/topic/install.sql',
				'plugin/visit_analysis/install.sql',
				'script/index.php',
				'script/jquery.addon.js',
				'source/class/mysql.class.php',
				'source/class/mystep.class.php',
				'template/admin/art_content_input.tpl',
				'template/admin/art_info_input.tpl',
				'template/admin/func_backup.tpl',
				'template/admin/web_plugin_view.tpl',
				'template/admin/web_setting.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/art_info_input.tpl',
				'template/index.php',
			),
		'sql' => array(
				'update `{pre}admin_cat` set `name`="数据维护" where `name`="数据备份"',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120520',
					),
			),
	),
	'0.99.9.8.4' => array(
		'info' => '
				1.New plugin custom_form as a alias of meeting plugin added
				2.Meeting plugin enhanced
				3.Fix a bug in admin_cat plugin
				4.Fix a bug in date.js
				Some other adjusts...
			',
		'file' => array(
				'include/parameter.php',
				'plugin/admin_cat/admin_cat.php',
				'plugin/custom_form',
				'plugin/custom_form/class.php',
				'plugin/custom_form/config.php',
				'plugin/custom_form/custom_form.php',
				'plugin/custom_form/images',
				'plugin/custom_form/images/div.png',
				'plugin/custom_form/images/format.png',
				'plugin/custom_form/index.php',
				'plugin/custom_form/info.php',
				'plugin/custom_form/install.sql',
				'plugin/custom_form/language',
				'plugin/custom_form/language/chs.php',
				'plugin/custom_form/language/default.php',
				'plugin/custom_form/language/en.php',
				'plugin/custom_form/setting',
				'plugin/custom_form/setting/default.php',
				'plugin/custom_form/setting/ext_script.php',
				'plugin/custom_form/setting/main.tpl',
				'plugin/custom_form/show.php',
				'plugin/custom_form/style.css',
				'plugin/custom_form/tpl',
				'plugin/custom_form/tpl/add.tpl',
				'plugin/custom_form/tpl/block_cf_list_cn.tpl',
				'plugin/custom_form/tpl/block_cf_list_en.tpl',
				'plugin/custom_form/tpl/default_cf_list_cn.tpl',
				'plugin/custom_form/tpl/default_cf_list_en.tpl',
				'plugin/custom_form/tpl/default_cf_submit_cn.tpl',
				'plugin/custom_form/tpl/default_cf_submit_en.tpl',
				'plugin/custom_form/tpl/default_mail_cn.tpl',
				'plugin/custom_form/tpl/default_mail_en.tpl',
				'plugin/custom_form/tpl/edit.tpl',
				'plugin/custom_form/tpl/edit_data.tpl',
				'plugin/custom_form/tpl/list.tpl',
				'plugin/custom_form/tpl/list_data.tpl',
				'plugin/custom_form/tpl/main.tpl',
				'plugin/meeting/class.php',
				'plugin/meeting/info.php',
				'plugin/meeting/install.sql',
				'plugin/meeting/style.css',
				'plugin/meeting/tpl/add.tpl',
				'plugin/meeting/tpl/block_reg_cn_tbl.tpl',
				'plugin/meeting/tpl/block_reg_en_tbl.tpl',
				'plugin/meeting/tpl/default_regist_cn.tpl',
				'plugin/meeting/tpl/default_regist_en.tpl',
				'plugin/meeting/tpl/edit.tpl',
				'script/date.js',
				'script/global.js',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120521',
					),
			),
	),
	'0.99.9.8.5' => array(
		'info' => '
			1.Rewrite Rule Management module added
			2.Enhance getUrl function, plugins can regist it\'s own rewrite rule with mystep class
			3.Enhance gotoPage function to match rewrite rules
			4.Fix a bug in add_slash function
			5.Fix a bug in cache management template
			6.Add base-url tag to match rewrite need
			7.Fix a bug in search template
			Some other adjusts...
			',
		'file' => array(
				'.htaccess',
				'admin/art_content.php',
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/style.css',
				'admin/web_cache.php',
				'admin/web_rewrite.php',
				'admin/web_setting.php',
				'admin/update.php',
				'error.php',
				'include/config/chs.php',
				'include/config/default.php',
				'include/config/en.php',
				'include/parameter.php',
				'list.php',
				'module.php',
				'plugin/comment/class.php',
				'plugin/comment/comment.php',
				'plugin/custom_form/class.php',
				'plugin/custom_form/custom_form.php',
				'plugin/custom_form/index.php',
				'plugin/custom_form/info.php',
				'plugin/custom_form/setting/2.php',
				'plugin/custom_form/setting/2_cf_list_cn.tpl',
				'plugin/custom_form/setting/2_cf_list_en.tpl',
				'plugin/custom_form/setting/2_cf_submit_cn.tpl',
				'plugin/custom_form/setting/2_cf_submit_en.tpl',
				'plugin/custom_form/setting/2_edit_data.tpl',
				'plugin/custom_form/setting/2_ext_script.php',
				'plugin/custom_form/setting/2_list_data.tpl',
				'plugin/custom_form/setting/2_mail_cn.tpl',
				'plugin/custom_form/setting/2_mail_en.tpl',
				'plugin/custom_form/show.php',
				'plugin/custom_form/tpl/add.tpl',
				'plugin/custom_form/tpl/block_cf_list_cn.tpl',
				'plugin/custom_form/tpl/block_cf_list_cn_tbl.tpl',
				'plugin/custom_form/tpl/block_cf_list_en.tpl',
				'plugin/custom_form/tpl/block_cf_list_en_tbl.tpl',
				'plugin/custom_form/tpl/edit.tpl',
				'plugin/custom_form/tpl/list.tpl',
				'plugin/news_mark/class.php',
				'plugin/news_mark/news_mark.php',
				'plugin/news_visit/class.php',
				'plugin/offical/class.php',
				'plugin/offical/info.php',
				'plugin/offical/show.php',
				'plugin/search/class.php',
				'plugin/search/index.php',
				'plugin/search/info.php',
				'plugin/search/show.php',
				'plugin/search/tpl/block_keyword.tpl',
				'plugin/survey/class.php',
				'plugin/survey/index.php',
				'plugin/survey/info.php',
				'plugin/survey/show.php',
				'plugin/survey/survey.php',
				'plugin/survey/tpl/block_survey_classic.tpl',
				'plugin/survey/tpl/list.tpl',
				'plugin/topic/class.php',
				'plugin/topic/index.php',
				'plugin/topic/info.php',
				'plugin/topic/show.php',
				'plugin/topic/topic.php',
				'plugin/topic/topic_link.php',
				'plugin/topic/tpl/input.tpl',
				'plugin/topic/tpl/search.tpl',
				'read.php',
				'rewrite_nginx.txt',
				'rss.php',
				'sitemap.php',
				'source/class/myajax.class.php',
				'source/class/myapi.class.php',
				'source/class/mysql.class.php',
				'source/class/mystep.class.php',
				'source/function/global.php',
				'source/function/web.php',
				'tag.php',
				'template/admin/web_cache.tpl',
				'template/admin/web_rewrite.tpl',
				'template/classic/index.tpl',
				'template/classic/main.tpl',
				'template/classic/search.tpl',
			),
		'sql' => array(
				'INSERT INTO `{pre}admin_cat` VALUES (0, 3, "网址重写", "web_rewrite.php", "", 0, 0, "URL Rewrite 规则管理")',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120605',
					),
				'rewrite' => array(
						'enable' => false,
						'read' => 'article',
						'list' => 'catalog',
						'tag' => 'tag',
					),
			),
		'code' => '
$rewrite_list = array (
  array ("article/[^\\/]+/(\\d+)(_(\\d+))?\\.html","read.php?id=$1&page=$3"),
  array ("catalog/([^\\/]+)/(index(_(\\d+))?\\.html)?","list.php?cat=$1&page=$4"),
  array ("catalog/([^\\/]+)/([^\\/]+)/(index(_(\\d+))?\\.html)?","list.php?cat=$1&pre=$2&page=$5"),
  array ("tag/(.+?)(_(\\d+))?\\.html","tag.php?tag=$1&page=$3"),
  array ("article(/)?","list.php"),
  array ("catalog(/)?","list.php"),
  array ("tag(/)?","tag.php"),
  array ("rss.xml","rss.php"),
  array ("(.+?)/rss.xml","rss.php?cat=$1"),
  array ("api/(.+?)/(.+?)(/(.+))?","api.php?$1|$2|$4"),
  array ("ajax/(.+?)(/(.+))?","ajax.php?func=$1&return=$3"),
);
$cur_setting = $setting;
unset($setting);
include(ROOT_PATH."/include/config.php");
unset($setting["gen"]["rewrite"]);
$setting["rewrite"] = array();
$setting["rewrite"]["enable"] = false;
$setting["rewrite"]["read"] = "article";
$setting["rewrite"]["list"] = "catalog";
$setting["rewrite"]["tag"] = "tag";
$rewrite_list_str = var_export($rewrite_list, true);
$expire_list_str = var_export($expire_list, true);
$ignore_list_str = var_export($ignore_list, true);
if(empty($rewrite_list_str)) $rewrite_list_str = "array()";
if(empty($expire_list_str)) $expire_list_str = "array()";
if(empty($ignore_list_str)) $ignore_list_str = "array()";
$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$rewrite_list = {$rewrite_list_str};
\$expire_list = {$expire_list_str};
\$ignore_list = {$ignore_list_str};
\$authority = "{$authority}";
?>
mystep;
$content = str_replace("/*--settings--*/", makeVarsCode($setting, "\$setting"), $content);
WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
unset($setting);
$setting = $cur_setting;
		',
	),
	'0.99.9.9' => array(
		'info' => '
				1.Adjust install pack maker
				2.Add custom template function for all catalog
				3.Fix a bug in backup function
				4.Add Server-site file check function
				5.Fix a bug when link a article with a external link
				6.Enhance request function in MyReq class
				7.Fix some code which cause some alert in new version php
				8.Fix a bug in MakeDir function
				Some other adjusts...
			',
		'file' => array(
				'admin/art_catalog.php',
				'admin/func_backup.php',
				'admin/update.php',
				'files/index.php',
				'include/config/chs.php',
				'include/config/default.php',
				'include/config/en.php',
				'include/parameter.php',
				'list.php',
				'plugin/custom_form/tpl/edit_data.tpl',
				'plugin/custom_form/tpl/list_data.tpl',
				'read.php',
				'script/jquery.codemirror.js',
				'source/class/myreq.class.php',
				'source/class/mytpl.class.php',
				'source/function/admin.php',
				'source/function/global.php',
				'source/function/web.php',
				'template/admin/art_catalog_input.tpl',
				'template/admin/info_main.tpl',
				'template/admin/info_server.tpl',
				'template/admin/web_subweb_input.tpl',
				'template/admin_simple/art_catalog_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/classic/main.tpl',
				'template/default/main.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120625',
					),
			),
		'code' => '
$cur_setting = $setting;
unset($setting);
include(ROOT_PATH."/include/config.php");
$ignore_list[] = "install";
$rewrite_list_str = var_export($rewrite_list, true);
$expire_list_str = var_export($expire_list, true);
$ignore_list_str = var_export($ignore_list, true);
if(empty($rewrite_list_str)) $rewrite_list_str = "array()";
if(empty($expire_list_str)) $expire_list_str = "array()";
if(empty($ignore_list_str)) $ignore_list_str = "array()";
$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$rewrite_list = {$rewrite_list_str};
\$expire_list = {$expire_list_str};
\$ignore_list = {$ignore_list_str};
\$authority = "{$authority}";
?>
mystep;
$content = str_replace("/*--settings--*/", makeVarsCode($setting, "\$setting"), $content);
WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
unset($setting);
$setting = $cur_setting;
		',
	),
	'0.99.9.9.1' => array(
		'info' => '
				1.Every sub-web can be closed individually
				2.Make all html dom obj which inline to the html page before inject by javascript in real time
				3.Enhance update function
				4.Adjust and enhance javascript
				5.Change alert,confirm,prompt dialog to PopUp mode
				6.Autocomplete plugin for jQuery added, put dictionaries in "script\jquery.autocomplete" folder
				7.Update jQuery to the lastest version
				8.Remove some useless files
				9.Some template error fixed
				Some other adjusts...
			',
		'file' => array(
				'admin/art_content.php',
				'admin/attachment.php',
				'admin/images/div.png',
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/style.css',
				'admin/update.php',
				'images/arrow.gif',
				'images/classic/style.css',
				'images/default/style.css',
				'images/style.css',
				'inc.php',
				'include/parameter.php',
				'plugin/admin_cat/tpl/input.tpl',
				'plugin/admin_cat/tpl/list.tpl',
				'plugin/comment/tpl/list.tpl',
				'plugin/crontab/tpl/input.tpl',
				'plugin/crontab/tpl/list.tpl',
				'plugin/custom_form/custom_form.php',
				'plugin/custom_form/setting',
				'plugin/custom_form/setting/default.php',
				'plugin/custom_form/setting/main.tpl',
				'plugin/custom_form/tpl/add.tpl',
				'plugin/custom_form/tpl/default_mail_cn.tpl',
				'plugin/custom_form/tpl/default_mail_en.tpl',
				'plugin/custom_form/tpl/edit.tpl',
				'plugin/custom_form/tpl/edit_data.tpl',
				'plugin/custom_form/tpl/list.tpl',
				'plugin/custom_form/tpl/list_data.tpl',
				'plugin/custom_form/tpl/main.tpl',
				'plugin/custom_sql/custom_sql.php',
				'plugin/custom_sql/tpl/input.tpl',
				'plugin/custom_sql/tpl/list.tpl',
				'plugin/custom_sql/tpl/view.tpl',
				'plugin/db_info/tpl/db.tpl',
				'plugin/db_info/tpl/tbl.tpl',
				'plugin/email/tpl/attachment.tpl',
				'plugin/email/tpl/input.tpl',
				'plugin/email/tpl/list.tpl',
				'plugin/news_mark/tpl/news_mark.tpl',
				'plugin/news_visit/news_visit.tpl',
				'plugin/offical/class.php',
				'plugin/offical/index.php',
				'plugin/search/tpl/block_search.tpl',
				'script/addon.js',
				'script/date_input.css',
				'script/global.js',
				'script/jquery.addon.js',
				'script/jquery.autocomplete',
				'script/jquery.autocomplete.css',
				'script/jquery.autocomplete.js',
				'script/jquery.autocomplete/country.php',
				'script/jquery.autocomplete/location.php',
				'script/jquery.autocomplete/province.php',
				'script/jquery.autocomplete/shadow.png',
				'script/jquery.codemirror.js',
				'script/jquery.date_input.css',
				'script/jquery.date_input.js',
				'script/jquery.jmpopups.css',
				'script/jquery.jmpopups.js',
				'script/jquery.js',
				'script/tinymce/plugins/source_code/js/source_code.js',
				'source/class/mysql.class.php',
				'source/class/mystep.class.php',
				'source/function/admin.php',
				'template/admin/art_catalog_input.tpl',
				'template/admin/art_content_input.tpl',
				'template/admin/art_image_input.tpl',
				'template/admin/art_info_input.tpl',
				'template/admin/func_link_input.tpl',
				'template/admin/index.tpl',
				'template/admin/info_main.tpl',
				'template/admin/main.tpl',
				'template/admin/web_plugin_list.tpl',
				'template/admin/web_rewrite.tpl',
				'template/admin/web_subweb_input.tpl',
				'template/admin/web_template_input.tpl',
				'template/admin_simple/art_catalog_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/art_content_list.tpl',
				'template/admin_simple/art_image_input.tpl',
				'template/admin_simple/art_info_input.tpl',
				'template/admin_simple/func_link_input.tpl',
				'template/admin_simple/index.tpl',
				'template/admin_simple/main.tpl',
				'template/classic/index.tpl',
				'template/classic/main.tpl',
				'template/classic/read.tpl',
				'template/default/index.tpl',
				'template/default/list.tpl',
				'template/default/list_0.tpl',
				'template/default/list_1.tpl',
				'template/default/list_2.tpl',
				'template/default/main.tpl',
				'template/default/read.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120814',
					),
			),
	),
	'0.99.9.9.2' => array(
		'info' => '
				1.Enhance template mamagerment module
				2.Fix a bug in file check function when execute after update function
				3.Fix a bug in zip file function
				4.Fix a bug in operation log function
				Some other adjusts...
			',
		'file' => array(
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/style.css',
				'admin/update.php',
				'admin/web_cache.php',
				'admin/web_rewrite.php',
				'admin/web_setting.php',
				'admin/web_template.php',
				'images/classic/style.css',
				'images/default/style.css',
				'images/style.css',
				'include/parameter.php',
				'plugin/custom_form/tpl/add.tpl',
				'plugin/custom_form/tpl/edit.tpl',
				'plugin/custom_form/tpl/list_data.tpl',
				'plugin/custom_form/tpl/main.tpl',
				'plugin/news_snatch/class.php',
				'plugin/news_snatch/tpl/main.tpl',
				'plugin/news_snatch/tpl/rule_input.tpl',
				'source/class/myzip.class.php',
				'source/function/admin.php',
				'source/function/web.php',
				'template/admin/index.tpl',
				'template/admin/info_main.tpl',
				'template/admin/web_template.tpl',
				'template/admin/web_template_list.tpl',
				'template/admin_simple/index.tpl',
				'template/classic/main.tpl',
				'template/classic/read.tpl',
				'template/default/main.tpl',
				'template/default/read.tpl',
				'template/classic/sample.jpg',
				'template/default/sample.jpg',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120816',
					),
			),
		'sql' => array(
				'update `{pre}admin_cat` set `pid`=6 where `file`="web_subweb.php"',
			),
	),
	'0.99.9.9.3' => array(
		'info' => '
				1.Add pull down menu function for news catalog
				2.Fix a template bug in custom_form plugin
				3.Fix a template bug in subweb setting function
				Some other adjusts...
			',
		'file' => array(
				'images/classic/style.css',
				'images/default/style.css',
				'include/parameter.php',
				'plugin/custom_form/setting/main.tpl',
				'plugin/custom_form/tpl/add.tpl',
				'plugin/custom_form/tpl/edit.tpl',
				'plugin/custom_form/tpl/list_data.tpl',
				'plugin/meeting/tpl/add.tpl',
				'plugin/meeting/tpl/edit.tpl',
				'plugin/offical/class.php',
				'plugin/offical/index.php',
				'script/addon.js',
				'template/admin_simple/web_subweb_input.tpl',
				'template/classic/main.tpl',
				'template/default/main.tpl',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20120818',
					),
			),
	),
	'0.99.9.9.4' => array(
		'info' => '
				1.Add three url_rewrite rules which are missing before.
				2.Add print function to custom_form plugin when submit
				3.Fix a bug in set type data of custom_form plugin
				4.Add manager tag to each item of custom_form plugin
				5.Fix a charset bug in visit_analysis plugin
				6.Fix a bug in file check function
				Some other adjusts...
			',
		'file' => array(
				'include/parameter.php',
				'plugin/custom_form/custom_form.php',
				'plugin/custom_form/show.php',
				'plugin/custom_form/tpl/add.tpl',
				'plugin/custom_form/tpl/default_cf_print_cn.tpl',
				'plugin/custom_form/tpl/default_cf_print_en.tpl',
				'plugin/custom_form/tpl/default_cf_submit_cn.tpl',
				'plugin/custom_form/tpl/default_cf_submit_en.tpl',
				'plugin/custom_form/tpl/default_mail_cn.tpl',
				'plugin/custom_form/tpl/default_mail_en.tpl',
				'plugin/custom_form/tpl/edit.tpl',
				'plugin/visit_analysis/class.php',
				'script/addon.js',
				'script/jquery.autocomplete.js',
				'script/jquery.date_input.js',
				'script/jquery.jmpopups.js',
				'source/class/mystep.class.php',
				'source/class/mytpl.class.php',
				'source/function/admin.php',
				'template/classic/list.tpl',
		),
		'setting' => array(
				'gen' => array(
						'etag' => '20120905',
					),
			),
		'code' => '
$cur_setting = $setting;
unset($setting);
include(ROOT_PATH."/include/config.php");
$rewrite_list = array (
  array (
    0 => "article/[^\\/]+/(\\d+)(_(\\d+))?\\.html",
    1 => "read.php?id=$1&page=$3",
  ),
  array (
    0 => "article(/)?",
    1 => "list.php",
  ),
  array (
    0 => "article/(index(_(\\d+))?\\.html)?",
    1 => "list.php?page=$3",
  ),
  array (
    0 => "catalog(/)?",
    1 => "list.php",
  ),
  array (
    0 => "catalog/(index(_(\\d+))?\\.html)?",
    1 => "list.php?page=$3",
  ),
  array (
    0 => "catalog/([^\\/]+)/(index(_(\\d+))?\\.html)?",
    1 => "list.php?cat=$1&page=$4",
  ),
  array (
    0 => "catalog/([^\\/]+)/([^\\/]+)/(index(_(\\d+))?\\.html)?",
    1 => "list.php?cat=$1&pre=$2&page=$5",
  ),
  array (
    0 => "tag/(.+?)(_(\\d+))?\\.html",
    1 => "tag.php?tag=$1&page=$3",
  ),
  array (
    0 => "tag(/)?",
    1 => "tag.php",
  ),
  array (
    0 => "rss.xml",
    1 => "rss.php",
  ),
  array (
    0 => "(.+?)/rss.xml",
    1 => "rss.php?cat=$1",
  ),
  array (
    0 => "api/(.+?)/(.+?)(/(.+))?",
    1 => "api.php?$1|$2|$4",
  ),
  array (
    0 => "ajax/(.+?)(/(.+))?",
    1 => "ajax.php?func=$1&return=$3",
  ),
);
$rewrite_list_str = var_export($rewrite_list, true);
$expire_list_str = var_export($expire_list, true);
$ignore_list_str = var_export($ignore_list, true);
if(empty($rewrite_list_str)) $rewrite_list_str = "array()";
if(empty($expire_list_str)) $expire_list_str = "array()";
if(empty($ignore_list_str)) $ignore_list_str = "array()";
$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$rewrite_list = {$rewrite_list_str};
\$expire_list = {$expire_list_str};
\$ignore_list = {$ignore_list_str};
\$authority = "{$authority}";
?>
mystep;
$content = str_replace("/*--settings--*/", makeVarsCode($setting, "\$setting"), $content);
WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
unset($setting);
$setting = $cur_setting;
		',
	),
	'0.99.9.9.5' => array(
		'info' => '
				1.Fix a bug in list.php when connect to a catalog with a link
				2.Enhance custom_form plugin
				Some other adjusts...
			',
		'file' => array(
				'include/parameter.php',
				'list.php',
				'plugin/custom_form/custom_form.php',
				'plugin/custom_form/setting',
				'plugin/custom_form/setting/default.php',
				'plugin/search/tpl/block_search.tpl',
		),
	),
	'0.99.9.9.6' => array(
		'info' => '
				1.System will jump to the page you linked before login
				2.Fix a bug that vertify code cannot display when web was closed
				3.Add expire setting for each article
				4.Fix a multi-thread bug in crontab plugin
				5.Add sender setting from the email function of custom_form plugin
				6.Fix a bug in sitemap.php
				7.Add buildSQL function for mssql.class.php
				8.Adjust some script in mysql.class.php which make query inefficient
				9.Add cache to checkUser function
				10.Add ttl parameter to getFuncData function
				Some other adjusts...
			',
		'sql' => array(
				'alter table `{pre}news_show` add `expire` DATE',
			),
		'file' => array(
				'admin/art_content.php',
				'admin/inc.php',
				'admin/login.php',
				'inc.php',
				'include/parameter.php',
				'list.php',
				'plugin/crontab/run.php',
				'plugin/custom_form/custom_form.php',
				'plugin/custom_form/tpl/default_mail_cn.tpl',
				'plugin/custom_form/tpl/default_mail_en.tpl',
				'plugin/inc.php',
				'plugin/offical/class.php',
				'sitemap.php',
				'source/class/mssql.class.php',
				'source/class/mysql.class.php',
				'source/function/global.php',
				'source/function/web.php',
				'template/admin/art_catalog_input.tpl',
				'template/admin/art_content_input.tpl',
				'template/admin/login.tpl',
				'template/admin/main.tpl',
				'template/admin_simple/art_catalog_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/login.tpl',
				'template/admin_simple/main.tpl',
				'template/classic/main.tpl',
				'template/classic/search.tpl',
				'template/default/search.tpl',
		),
	),
	'0.99.9.9.7' => array(
		'info' => '
				1.Fix subweb.sql to fit install.sql
				2.Add a shortcut function (getString) for the function of getSafecode
				3.Add a image marquee effect for the article or somewhere which can be used in article editor
				4.Update TinyMCE to lasted version
				5.Fix a bug in news_snatch plugin
				6.Source_code show plugin added
				7.Add convertLimit function to MSSQL class to fit the function in MySQL
				8.Add Multi domain support for each subweb
				9.Fix a bug in cut string of the charset of UTF-8
				Some other adjusts...
			',
		'sql' => array(
				'alter table `{pre}website` modify `host` Char(150) DEFAULT "" NOT NULL',
			),
		'file' => array(
				'admin/images/show.png',
				'admin/subweb.sql',
				'admin/web_plugin.php',
				'images/arrow.png',
				'images/editor.css',
				'images/style.css',
				'include/parameter.php',
				'list.php',
				'plugin/comment/class.php',
				'plugin/news_snatch/news_snatch.php',
				'plugin/offical/class.php',
				'plugin/source/class.php',
				'plugin/source/index.php',
				'plugin/source/info.php',
				'plugin/source/info/chs.php',
				'plugin/source/info/en.php',
				'plugin/source/show.php',
				'plugin/source/show.tpl',
				'plugin/visit_analysis/class.php',
				'script/jquery.addon.js',
				'script/tinymce/jquery.tinymce.js',
				'script/tinymce/langs/cn.js',
				'script/tinymce/langs/en.js',
				'script/tinymce/langs/zh.js',
				'script/tinymce/license.txt',
				'script/tinymce/plugins/advhr/langs/cn_dlg.js',
				'script/tinymce/plugins/advhr/langs/en_dlg.js',
				'script/tinymce/plugins/advhr/langs/zh_dlg.js',
				'script/tinymce/plugins/advhr/rule.htm',
				'script/tinymce/plugins/advimage/editor_plugin.js',
				'script/tinymce/plugins/advimage/image.htm',
				'script/tinymce/plugins/advimage/js/image.js',
				'script/tinymce/plugins/advimage/langs/cn_dlg.js',
				'script/tinymce/plugins/advimage/langs/en_dlg.js',
				'script/tinymce/plugins/advimage/langs/zh_dlg.js',
				'script/tinymce/plugins/advlink/js/advlink.js',
				'script/tinymce/plugins/advlink/langs/cn_dlg.js',
				'script/tinymce/plugins/advlink/langs/en_dlg.js',
				'script/tinymce/plugins/advlink/langs/zh_dlg.js',
				'script/tinymce/plugins/advlink/link.htm',
				'script/tinymce/plugins/advlist/editor_plugin.js',
				'script/tinymce/plugins/autolink/editor_plugin.js',
				'script/tinymce/plugins/autoresize/editor_plugin.js',
				'script/tinymce/plugins/autosave/editor_plugin.js',
				'script/tinymce/plugins/bbscode/langs/cn.js',
				'script/tinymce/plugins/bbscode/langs/cn_dlg.js',
				'script/tinymce/plugins/bbscode/langs/zh.js',
				'script/tinymce/plugins/bbscode/langs/zh_dlg.js',
				'script/tinymce/plugins/contextmenu/editor_plugin.js',
				'script/tinymce/plugins/directionality/editor_plugin.js',
				'script/tinymce/plugins/emotions/emotions.htm',
				'script/tinymce/plugins/emotions/img/smiley-foot-in-mouth.gif',
				'script/tinymce/plugins/emotions/img/smiley-laughing.gif',
				'script/tinymce/plugins/emotions/img/smiley-sealed.gif',
				'script/tinymce/plugins/emotions/img/smiley-smile.gif',
				'script/tinymce/plugins/emotions/img/smiley-surprised.gif',
				'script/tinymce/plugins/emotions/img/smiley-wink.gif',
				'script/tinymce/plugins/emotions/js/emotions.js',
				'script/tinymce/plugins/emotions/langs/cn_dlg.js',
				'script/tinymce/plugins/emotions/langs/en_dlg.js',
				'script/tinymce/plugins/emotions/langs/zh_dlg.js',
				'script/tinymce/plugins/example_dependency/editor_plugin.js',
				'script/tinymce/plugins/fullpage/css/fullpage.css',
				'script/tinymce/plugins/fullpage/editor_plugin.js',
				'script/tinymce/plugins/fullpage/fullpage.htm',
				'script/tinymce/plugins/fullpage/js/fullpage.js',
				'script/tinymce/plugins/fullpage/langs/cn_dlg.js',
				'script/tinymce/plugins/fullpage/langs/en_dlg.js',
				'script/tinymce/plugins/fullpage/langs/zh_dlg.js',
				'script/tinymce/plugins/fullscreen/editor_plugin.js',
				'script/tinymce/plugins/fullscreen/fullscreen.htm',
				'script/tinymce/plugins/inlinepopups/editor_plugin.js',
				'script/tinymce/plugins/inlinepopups/skins/clearlooks2/img/alert.gif',
				'script/tinymce/plugins/inlinepopups/skins/clearlooks2/img/button.gif',
				'script/tinymce/plugins/inlinepopups/skins/clearlooks2/img/confirm.gif',
				'script/tinymce/plugins/inlinepopups/skins/clearlooks2/img/corners.gif',
				'script/tinymce/plugins/inlinepopups/skins/clearlooks2/img/vertical.gif',
				'script/tinymce/plugins/inlinepopups/skins/clearlooks2/window.css',
				'script/tinymce/plugins/layer/editor_plugin.js',
				'script/tinymce/plugins/legacyoutput/editor_plugin.js',
				'script/tinymce/plugins/lists/editor_plugin.js',
				'script/tinymce/plugins/media/css/content.css',
				'script/tinymce/plugins/media/css/media.css',
				'script/tinymce/plugins/media/editor_plugin.js',
				'script/tinymce/plugins/media/img/flash.gif',
				'script/tinymce/plugins/media/img/flv_player.swf',
				'script/tinymce/plugins/media/img/quicktime.gif',
				'script/tinymce/plugins/media/img/realmedia.gif',
				'script/tinymce/plugins/media/img/shockwave.gif',
				'script/tinymce/plugins/media/img/trans.gif',
				'script/tinymce/plugins/media/img/windowsmedia.gif',
				'script/tinymce/plugins/media/js/media.js',
				'script/tinymce/plugins/media/langs/cn_dlg.js',
				'script/tinymce/plugins/media/langs/en_dlg.js',
				'script/tinymce/plugins/media/langs/zh_dlg.js',
				'script/tinymce/plugins/media/media.htm',
				'script/tinymce/plugins/media/moxieplayer.swf',
				'script/tinymce/plugins/nonbreaking/editor_plugin.js',
				'script/tinymce/plugins/noneditable/editor_plugin.js',
				'script/tinymce/plugins/pagebreak/css/content.css',
				'script/tinymce/plugins/pagebreak/editor_plugin.js',
				'script/tinymce/plugins/pagebreak/img/pagebreak.gif',
				'script/tinymce/plugins/pagebreak/img/trans.gif',
				'script/tinymce/plugins/paste/editor_plugin.js',
				'script/tinymce/plugins/paste/langs/cn_dlg.js',
				'script/tinymce/plugins/paste/langs/en_dlg.js',
				'script/tinymce/plugins/paste/langs/zh_dlg.js',
				'script/tinymce/plugins/quote/langs/cn.js',
				'script/tinymce/plugins/quote/langs/zh.js',
				'script/tinymce/plugins/safari/blank.htm',
				'script/tinymce/plugins/safari/editor_plugin.js',
				'script/tinymce/plugins/searchreplace/editor_plugin.js',
				'script/tinymce/plugins/searchreplace/js/searchreplace.js',
				'script/tinymce/plugins/searchreplace/langs/cn_dlg.js',
				'script/tinymce/plugins/searchreplace/langs/en_dlg.js',
				'script/tinymce/plugins/searchreplace/langs/zh_dlg.js',
				'script/tinymce/plugins/searchreplace/searchreplace.htm',
				'script/tinymce/plugins/source_code/editor_plugin.js',
				'script/tinymce/plugins/source_code/langs/cn.js',
				'script/tinymce/plugins/source_code/langs/cn_dlg.js',
				'script/tinymce/plugins/source_code/langs/zh.js',
				'script/tinymce/plugins/source_code/langs/zh_dlg.js',
				'script/tinymce/plugins/spellchecker/editor_plugin.js',
				'script/tinymce/plugins/style/css/props.css',
				'script/tinymce/plugins/style/editor_plugin.js',
				'script/tinymce/plugins/style/js/props.js',
				'script/tinymce/plugins/style/langs/cn_dlg.js',
				'script/tinymce/plugins/style/langs/en_dlg.js',
				'script/tinymce/plugins/style/langs/zh_dlg.js',
				'script/tinymce/plugins/style/props.htm',
				'script/tinymce/plugins/style/readme.txt',
				'script/tinymce/plugins/subtitle/langs/cn.js',
				'script/tinymce/plugins/subtitle/langs/zh.js',
				'script/tinymce/plugins/tabfocus/editor_plugin.js',
				'script/tinymce/plugins/table/cell.htm',
				'script/tinymce/plugins/table/editor_plugin.js',
				'script/tinymce/plugins/table/js/cell.js',
				'script/tinymce/plugins/table/js/row.js',
				'script/tinymce/plugins/table/js/table.js',
				'script/tinymce/plugins/table/langs/cn_dlg.js',
				'script/tinymce/plugins/table/langs/en_dlg.js',
				'script/tinymce/plugins/table/langs/zh_dlg.js',
				'script/tinymce/plugins/table/merge_cells.htm',
				'script/tinymce/plugins/table/row.htm',
				'script/tinymce/plugins/table/table.htm',
				'script/tinymce/plugins/template/js/template.js',
				'script/tinymce/plugins/template/langs/cn_dlg.js',
				'script/tinymce/plugins/template/langs/en_dlg.js',
				'script/tinymce/plugins/template/langs/zh_dlg.js',
				'script/tinymce/plugins/visualblocks/css',
				'script/tinymce/plugins/visualblocks/css/visualblocks.css',
				'script/tinymce/plugins/visualblocks/editor_plugin.js',
				'script/tinymce/plugins/visualchars/editor_plugin.js',
				'script/tinymce/plugins/wordcount/editor_plugin.js',
				'script/tinymce/plugins/xhtmlxtras/abbr.htm',
				'script/tinymce/plugins/xhtmlxtras/acronym.htm',
				'script/tinymce/plugins/xhtmlxtras/attributes.htm',
				'script/tinymce/plugins/xhtmlxtras/cite.htm',
				'script/tinymce/plugins/xhtmlxtras/del.htm',
				'script/tinymce/plugins/xhtmlxtras/editor_plugin.js',
				'script/tinymce/plugins/xhtmlxtras/ins.htm',
				'script/tinymce/plugins/xhtmlxtras/js/attributes.js',
				'script/tinymce/plugins/xhtmlxtras/js/del.js',
				'script/tinymce/plugins/xhtmlxtras/js/element_common.js',
				'script/tinymce/plugins/xhtmlxtras/js/ins.js',
				'script/tinymce/plugins/xhtmlxtras/langs/cn_dlg.js',
				'script/tinymce/plugins/xhtmlxtras/langs/en_dlg.js',
				'script/tinymce/plugins/xhtmlxtras/langs/zh_dlg.js',
				'script/tinymce/themes/advanced/about.htm',
				'script/tinymce/themes/advanced/anchor.htm',
				'script/tinymce/themes/advanced/charmap.htm',
				'script/tinymce/themes/advanced/color_picker.htm',
				'script/tinymce/themes/advanced/editor_template.js',
				'script/tinymce/themes/advanced/image.htm',
				'script/tinymce/themes/advanced/img/colorpicker.jpg',
				'script/tinymce/themes/advanced/img/flash.gif',
				'script/tinymce/themes/advanced/img/icons.gif',
				'script/tinymce/themes/advanced/img/iframe.gif',
				'script/tinymce/themes/advanced/img/pagebreak.gif',
				'script/tinymce/themes/advanced/img/quicktime.gif',
				'script/tinymce/themes/advanced/img/realmedia.gif',
				'script/tinymce/themes/advanced/img/shockwave.gif',
				'script/tinymce/themes/advanced/img/trans.gif',
				'script/tinymce/themes/advanced/img/video.gif',
				'script/tinymce/themes/advanced/img/windowsmedia.gif',
				'script/tinymce/themes/advanced/js/about.js',
				'script/tinymce/themes/advanced/js/anchor.js',
				'script/tinymce/themes/advanced/js/charmap.js',
				'script/tinymce/themes/advanced/js/color_picker.js',
				'script/tinymce/themes/advanced/js/image.js',
				'script/tinymce/themes/advanced/js/link.js',
				'script/tinymce/themes/advanced/js/source_editor.js',
				'script/tinymce/themes/advanced/langs/cn.js',
				'script/tinymce/themes/advanced/langs/cn_dlg.js',
				'script/tinymce/themes/advanced/langs/en.js',
				'script/tinymce/themes/advanced/langs/en_dlg.js',
				'script/tinymce/themes/advanced/langs/zh.js',
				'script/tinymce/themes/advanced/langs/zh_dlg.js',
				'script/tinymce/themes/advanced/link.htm',
				'script/tinymce/themes/advanced/shortcuts.htm',
				'script/tinymce/themes/advanced/skins/default/content.css',
				'script/tinymce/themes/advanced/skins/default/dialog.css',
				'script/tinymce/themes/advanced/skins/default/img/buttons.png',
				'script/tinymce/themes/advanced/skins/default/img/items.gif',
				'script/tinymce/themes/advanced/skins/default/img/tabs.gif',
				'script/tinymce/themes/advanced/skins/default/ui.css',
				'script/tinymce/themes/advanced/skins/highcontrast/content.css',
				'script/tinymce/themes/advanced/skins/highcontrast/dialog.css',
				'script/tinymce/themes/advanced/skins/highcontrast/ui.css',
				'script/tinymce/themes/advanced/skins/o2k7/content.css',
				'script/tinymce/themes/advanced/skins/o2k7/dialog.css',
				'script/tinymce/themes/advanced/skins/o2k7/img/button_bg.png',
				'script/tinymce/themes/advanced/skins/o2k7/img/button_bg_black.png',
				'script/tinymce/themes/advanced/skins/o2k7/img/button_bg_silver.png',
				'script/tinymce/themes/advanced/skins/o2k7/ui.css',
				'script/tinymce/themes/advanced/skins/o2k7/ui_black.css',
				'script/tinymce/themes/advanced/skins/o2k7/ui_silver.css',
				'script/tinymce/themes/advanced/source_editor.htm',
				'script/tinymce/themes/simple/editor_template.js',
				'script/tinymce/themes/simple/img/icons.gif',
				'script/tinymce/themes/simple/langs/cn.js',
				'script/tinymce/themes/simple/langs/en.js',
				'script/tinymce/themes/simple/langs/zh.js',
				'script/tinymce/tiny_mce.js',
				'script/tinymce/tiny_mce_popup.js',
				'script/tinymce/utils/editable_selects.js',
				'script/tinymce/utils/form_utils.js',
				'script/tinymce/utils/mctabs.js',
				'script/tinymce/utils/validate.js',
				'source/class/mssql.class.php',
				'source/class/mystep.class.php',
				'source/function/admin.php',
				'source/function/global.php',
				'source/function/web.php',
				'tag.php',
				'template/admin/art_catalog_input.tpl',
				'template/admin/art_content_input.tpl',
				'template/admin/art_info_input.tpl',
				'template/admin/index.tpl',
				'template/admin/web_subweb_input.tpl',
				'template/admin_simple/art_catalog_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/art_info_input.tpl',
				'template/admin_simple/web_subweb_input.tpl',
				'template/classic/read.tpl',
				'template/default/read.tpl',
		),
	),
	'0.99.9.9.8' => array(
		'info' => '
				1.Add Drop upload function to TinyMCE Editor for webkit explorers
				2.Add paragraph indent/outdent function to TinyMCE Editor with Tab/Backspace button
				3.Fix a bug in codemirror module
				4.Fix a bug in substrPro function
				5.Fix a bug a getUrl function when a subweb with multi-url
				Some other adjusts...
			',
		'file' => array(
				'admin/art_content.php',
				'admin/art_info.php',
				'admin/attachment.php',
				'images/editor.css',
				'include/parameter.php',
				'plugin/source/show.php',
				'script/admin.js',
				'script/global.js',
				'script/jquery.codemirror.js',
				'script/jquery.powerupload.css',
				'script/jquery.powerupload.js',
				'script/tinymce/plugins/paste/editor_plugin.js',
				'script/tinymce/plugins/source_code/js/source_code.js',
				'script/tinymce/themes/advanced/skins/default/dialog.css',
				'script/tinymce/themes/advanced/skins/default/ui.css',
				'source/function/global.php',
				'source/function/web.php',
				'template/admin/art_content_input.tpl',
				'template/admin/art_info_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/art_info_input.tpl',
				'admin/upload.php',
		),
	),
	'0.99.9.9.9' => array(
		'info' => '
				1.Fix a bug in update function, sql updates will be applied to all sub-web now.
				2.Add resume function to attachment download
				3.Add imageShow and imageWall function(Javascript) to article editor
				4.Some adjust in getUrl function to compatible with all plugins
				5.Localized codemirror scripts and recode jQuery function to fit the newest version of codemirror
				6.Adjust error message function of uploader module to fit the new error code of php
				7.Enhance the following function, include RndKey, html_watermark, HtmlTrans, getSafeCode
				Some other adjusts...
			',
		'file' => array(
				'admin/update.php',
				'files/index.php',
				'images/arrows.png',
				'images/left.cur',
				'images/right.cur',
				'images/style.css',
				'include/parameter.php',
				'plugin/custom_form/class.php',
				'plugin/custom_form/info.php',
				'plugin/custom_form/tpl/edit.tpl',
				'plugin/search/class.php',
				'plugin/survey/class.php',
				'plugin/topic/class.php',
				'read.php',
				'script/addon.js',
				'script/admin.js',
				'script/checkForm.js',
				'script/codemirror',
				'script/codemirror/.gitattributes',
				'script/codemirror/.gitignore',
				'script/codemirror/.travis.yml',
				'script/codemirror/bin',
				'script/codemirror/bin/compress',
				'script/codemirror/CONTRIBUTING.md',
				'script/codemirror/demo',
				'script/codemirror/demo/activeline.html',
				'script/codemirror/demo/btree.html',
				'script/codemirror/demo/changemode.html',
				'script/codemirror/demo/closetag.html',
				'script/codemirror/demo/complete.html',
				'script/codemirror/demo/emacs.html',
				'script/codemirror/demo/folding.html',
				'script/codemirror/demo/formatting.html',
				'script/codemirror/demo/fullscreen.html',
				'script/codemirror/demo/loadmode.html',
				'script/codemirror/demo/marker.html',
				'script/codemirror/demo/matchhighlighter.html',
				'script/codemirror/demo/multiplex.html',
				'script/codemirror/demo/mustache.html',
				'script/codemirror/demo/preview.html',
				'script/codemirror/demo/resize.html',
				'script/codemirror/demo/runmode.html',
				'script/codemirror/demo/search.html',
				'script/codemirror/demo/theme.html',
				'script/codemirror/demo/variableheight.html',
				'script/codemirror/demo/vim.html',
				'script/codemirror/demo/visibletabs.html',
				'script/codemirror/demo/widget.html',
				'script/codemirror/demo/xmlcomplete.html',
				'script/codemirror/doc',
				'script/codemirror/doc/baboon.png',
				'script/codemirror/doc/baboon_vector.svg',
				'script/codemirror/doc/compress.html',
				'script/codemirror/doc/docs.css',
				'script/codemirror/doc/internals.html',
				'script/codemirror/doc/manual.html',
				'script/codemirror/doc/oldrelease.html',
				'script/codemirror/doc/realworld.html',
				'script/codemirror/doc/reporting.html',
				'script/codemirror/doc/upgrade_v2.2.html',
				'script/codemirror/doc/upgrade_v3.html',
				'script/codemirror/index.html',
				'script/codemirror/keymap',
				'script/codemirror/keymap/emacs.js',
				'script/codemirror/keymap/vim.js',
				'script/codemirror/lib',
				'script/codemirror/lib/codemirror.css',
				'script/codemirror/lib/codemirror.js',
				'script/codemirror/lib/util',
				'script/codemirror/lib/util/closetag.js',
				'script/codemirror/lib/util/colorize.js',
				'script/codemirror/lib/util/continuecomment.js',
				'script/codemirror/lib/util/continuelist.js',
				'script/codemirror/lib/util/dialog.css',
				'script/codemirror/lib/util/dialog.js',
				'script/codemirror/lib/util/foldcode.js',
				'script/codemirror/lib/util/formatting.js',
				'script/codemirror/lib/util/javascript-hint.js',
				'script/codemirror/lib/util/loadmode.js',
				'script/codemirror/lib/util/match-highlighter.js',
				'script/codemirror/lib/util/matchbrackets.js',
				'script/codemirror/lib/util/multiplex.js',
				'script/codemirror/lib/util/overlay.js',
				'script/codemirror/lib/util/pig-hint.js',
				'script/codemirror/lib/util/runmode-standalone.js',
				'script/codemirror/lib/util/runmode.js',
				'script/codemirror/lib/util/search.js',
				'script/codemirror/lib/util/searchcursor.js',
				'script/codemirror/lib/util/simple-hint.css',
				'script/codemirror/lib/util/simple-hint.js',
				'script/codemirror/lib/util/xml-hint.js',
				'script/codemirror/LICENSE',
				'script/codemirror/mode',
				'script/codemirror/mode/clike',
				'script/codemirror/mode/clike/clike.js',
				'script/codemirror/mode/clike/index.html',
				'script/codemirror/mode/clike/scala.html',
				'script/codemirror/mode/clojure',
				'script/codemirror/mode/clojure/clojure.js',
				'script/codemirror/mode/clojure/index.html',
				'script/codemirror/mode/coffeescript',
				'script/codemirror/mode/coffeescript/coffeescript.js',
				'script/codemirror/mode/coffeescript/index.html',
				'script/codemirror/mode/coffeescript/LICENSE',
				'script/codemirror/mode/commonlisp',
				'script/codemirror/mode/commonlisp/commonlisp.js',
				'script/codemirror/mode/commonlisp/index.html',
				'script/codemirror/mode/css',
				'script/codemirror/mode/css/css.js',
				'script/codemirror/mode/css/index.html',
				'script/codemirror/mode/css/test.js',
				'script/codemirror/mode/diff',
				'script/codemirror/mode/diff/diff.js',
				'script/codemirror/mode/diff/index.html',
				'script/codemirror/mode/ecl',
				'script/codemirror/mode/ecl/ecl.js',
				'script/codemirror/mode/ecl/index.html',
				'script/codemirror/mode/erlang',
				'script/codemirror/mode/erlang/erlang.js',
				'script/codemirror/mode/erlang/index.html',
				'script/codemirror/mode/gfm',
				'script/codemirror/mode/gfm/gfm.js',
				'script/codemirror/mode/gfm/index.html',
				'script/codemirror/mode/gfm/test.js',
				'script/codemirror/mode/go',
				'script/codemirror/mode/go/go.js',
				'script/codemirror/mode/go/index.html',
				'script/codemirror/mode/groovy',
				'script/codemirror/mode/groovy/groovy.js',
				'script/codemirror/mode/groovy/index.html',
				'script/codemirror/mode/haskell',
				'script/codemirror/mode/haskell/haskell.js',
				'script/codemirror/mode/haskell/index.html',
				'script/codemirror/mode/haxe',
				'script/codemirror/mode/haxe/haxe.js',
				'script/codemirror/mode/haxe/index.html',
				'script/codemirror/mode/htmlembedded',
				'script/codemirror/mode/htmlembedded/htmlembedded.js',
				'script/codemirror/mode/htmlembedded/index.html',
				'script/codemirror/mode/htmlmixed',
				'script/codemirror/mode/htmlmixed/htmlmixed.js',
				'script/codemirror/mode/htmlmixed/index.html',
				'script/codemirror/mode/http',
				'script/codemirror/mode/http/http.js',
				'script/codemirror/mode/http/index.html',
				'script/codemirror/mode/javascript',
				'script/codemirror/mode/javascript/index.html',
				'script/codemirror/mode/javascript/javascript.js',
				'script/codemirror/mode/javascript/typescript.html',
				'script/codemirror/mode/jinja2',
				'script/codemirror/mode/jinja2/index.html',
				'script/codemirror/mode/jinja2/jinja2.js',
				'script/codemirror/mode/less',
				'script/codemirror/mode/less/index.html',
				'script/codemirror/mode/less/less.js',
				'script/codemirror/mode/lua',
				'script/codemirror/mode/lua/index.html',
				'script/codemirror/mode/lua/lua.js',
				'script/codemirror/mode/markdown',
				'script/codemirror/mode/markdown/index.html',
				'script/codemirror/mode/markdown/markdown.js',
				'script/codemirror/mode/markdown/test.js',
				'script/codemirror/mode/mysql',
				'script/codemirror/mode/mysql/index.html',
				'script/codemirror/mode/mysql/mysql.js',
				'script/codemirror/mode/ntriples',
				'script/codemirror/mode/ntriples/index.html',
				'script/codemirror/mode/ntriples/ntriples.js',
				'script/codemirror/mode/ocaml',
				'script/codemirror/mode/ocaml/index.html',
				'script/codemirror/mode/ocaml/ocaml.js',
				'script/codemirror/mode/pascal',
				'script/codemirror/mode/pascal/index.html',
				'script/codemirror/mode/pascal/LICENSE',
				'script/codemirror/mode/pascal/pascal.js',
				'script/codemirror/mode/perl',
				'script/codemirror/mode/perl/index.html',
				'script/codemirror/mode/perl/LICENSE',
				'script/codemirror/mode/perl/perl.js',
				'script/codemirror/mode/php',
				'script/codemirror/mode/php/index.html',
				'script/codemirror/mode/php/php.js',
				'script/codemirror/mode/pig',
				'script/codemirror/mode/pig/index.html',
				'script/codemirror/mode/pig/pig.js',
				'script/codemirror/mode/plsql',
				'script/codemirror/mode/plsql/index.html',
				'script/codemirror/mode/plsql/plsql.js',
				'script/codemirror/mode/properties',
				'script/codemirror/mode/properties/index.html',
				'script/codemirror/mode/properties/properties.js',
				'script/codemirror/mode/python',
				'script/codemirror/mode/python/index.html',
				'script/codemirror/mode/python/LICENSE.txt',
				'script/codemirror/mode/python/python.js',
				'script/codemirror/mode/r',
				'script/codemirror/mode/r/index.html',
				'script/codemirror/mode/r/LICENSE',
				'script/codemirror/mode/r/r.js',
				'script/codemirror/mode/rpm',
				'script/codemirror/mode/rpm/changes',
				'script/codemirror/mode/rpm/changes/changes.js',
				'script/codemirror/mode/rpm/changes/index.html',
				'script/codemirror/mode/rpm/spec',
				'script/codemirror/mode/rpm/spec/index.html',
				'script/codemirror/mode/rpm/spec/spec.css',
				'script/codemirror/mode/rpm/spec/spec.js',
				'script/codemirror/mode/rst',
				'script/codemirror/mode/rst/index.html',
				'script/codemirror/mode/rst/rst.js',
				'script/codemirror/mode/ruby',
				'script/codemirror/mode/ruby/index.html',
				'script/codemirror/mode/ruby/LICENSE',
				'script/codemirror/mode/ruby/ruby.js',
				'script/codemirror/mode/rust',
				'script/codemirror/mode/rust/index.html',
				'script/codemirror/mode/rust/rust.js',
				'script/codemirror/mode/scheme',
				'script/codemirror/mode/scheme/index.html',
				'script/codemirror/mode/scheme/scheme.js',
				'script/codemirror/mode/shell',
				'script/codemirror/mode/shell/index.html',
				'script/codemirror/mode/shell/shell.js',
				'script/codemirror/mode/sieve',
				'script/codemirror/mode/sieve/index.html',
				'script/codemirror/mode/sieve/LICENSE',
				'script/codemirror/mode/sieve/sieve.js',
				'script/codemirror/mode/smalltalk',
				'script/codemirror/mode/smalltalk/index.html',
				'script/codemirror/mode/smalltalk/smalltalk.js',
				'script/codemirror/mode/smarty',
				'script/codemirror/mode/smarty/index.html',
				'script/codemirror/mode/smarty/smarty.js',
				'script/codemirror/mode/sparql',
				'script/codemirror/mode/sparql/index.html',
				'script/codemirror/mode/sparql/sparql.js',
				'script/codemirror/mode/stex',
				'script/codemirror/mode/stex/index.html',
				'script/codemirror/mode/stex/stex.js',
				'script/codemirror/mode/stex/test.js',
				'script/codemirror/mode/tiddlywiki',
				'script/codemirror/mode/tiddlywiki/index.html',
				'script/codemirror/mode/tiddlywiki/tiddlywiki.css',
				'script/codemirror/mode/tiddlywiki/tiddlywiki.js',
				'script/codemirror/mode/tiki',
				'script/codemirror/mode/tiki/index.html',
				'script/codemirror/mode/tiki/tiki.css',
				'script/codemirror/mode/tiki/tiki.js',
				'script/codemirror/mode/vb',
				'script/codemirror/mode/vb/index.html',
				'script/codemirror/mode/vb/LICENSE.txt',
				'script/codemirror/mode/vb/vb.js',
				'script/codemirror/mode/vbscript',
				'script/codemirror/mode/vbscript/index.html',
				'script/codemirror/mode/vbscript/vbscript.js',
				'script/codemirror/mode/velocity',
				'script/codemirror/mode/velocity/index.html',
				'script/codemirror/mode/velocity/velocity.js',
				'script/codemirror/mode/verilog',
				'script/codemirror/mode/verilog/index.html',
				'script/codemirror/mode/verilog/verilog.js',
				'script/codemirror/mode/xml',
				'script/codemirror/mode/xml/index.html',
				'script/codemirror/mode/xml/xml.js',
				'script/codemirror/mode/xquery',
				'script/codemirror/mode/xquery/index.html',
				'script/codemirror/mode/xquery/LICENSE',
				'script/codemirror/mode/xquery/test.js',
				'script/codemirror/mode/xquery/xquery.js',
				'script/codemirror/mode/yaml',
				'script/codemirror/mode/yaml/index.html',
				'script/codemirror/mode/yaml/yaml.js',
				'script/codemirror/mode/z80',
				'script/codemirror/mode/z80/index.html',
				'script/codemirror/mode/z80/z80.js',
				'script/codemirror/package.json',
				'script/codemirror/README.md',
				'script/codemirror/test',
				'script/codemirror/test/driver.js',
				'script/codemirror/test/index.html',
				'script/codemirror/test/lint',
				'script/codemirror/test/lint/acorn.js',
				'script/codemirror/test/lint/lint.js',
				'script/codemirror/test/lint/parse-js.js',
				'script/codemirror/test/lint/walk.js',
				'script/codemirror/test/mode_test.css',
				'script/codemirror/test/mode_test.js',
				'script/codemirror/test/phantom_driver.js',
				'script/codemirror/test/run.js',
				'script/codemirror/test/test.js',
				'script/codemirror/test/vim_test.js',
				'script/codemirror/theme',
				'script/codemirror/theme/ambiance-mobile.css',
				'script/codemirror/theme/ambiance.css',
				'script/codemirror/theme/blackboard.css',
				'script/codemirror/theme/cobalt.css',
				'script/codemirror/theme/eclipse.css',
				'script/codemirror/theme/elegant.css',
				'script/codemirror/theme/erlang-dark.css',
				'script/codemirror/theme/lesser-dark.css',
				'script/codemirror/theme/monokai.css',
				'script/codemirror/theme/neat.css',
				'script/codemirror/theme/night.css',
				'script/codemirror/theme/rubyblue.css',
				'script/codemirror/theme/solarized.css',
				'script/codemirror/theme/twilight.css',
				'script/codemirror/theme/vibrant-ink.css',
				'script/codemirror/theme/xq-dark.css',
				'script/global.js',
				'script/jquery.addon.js',
				'script/jquery.codemirror.js',
				'script/jquery.jmpopups.js',
				'script/tinymce/plugins/source_code/js/source_code.js',
				'source/class/mysql.class.php',
				'source/class/myuploader.class.php',
				'source/function/global.php',
				'source/function/web.php',
				'template/admin/web_template_input.tpl',
		),
		'code' => '
$cur_setting = $setting;
unset($setting);
include(ROOT_PATH."/include/config.php");
$ignore_list = array (
  0 => ".",
  1 => "..",
  2 => "_maker",
  3 => "cache",
  4 => "update",
  5 => "install.lock",
  6 => "article",
  7 => "pic",
  8 => "tmp",
  9 => "web.config",
  10 => "aspnet_client",
  11 => ".svn",
  12 => "2011",
  13 => "2012",
  14 => "2013",
  15 => "2014",
  16 => "_bak",
  17 => "_test",
  18 => "_archive",
  19 => "install",
  20 => "xcache",
);
$rewrite_list_str = var_export($rewrite_list, true);
$expire_list_str = var_export($expire_list, true);
$ignore_list_str = var_export($ignore_list, true);
if(empty($rewrite_list_str)) $rewrite_list_str = "array()";
if(empty($expire_list_str)) $expire_list_str = "array()";
if(empty($ignore_list_str)) $ignore_list_str = "array()";
$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$rewrite_list = {$rewrite_list_str};
\$expire_list = {$expire_list_str};
\$ignore_list = {$ignore_list_str};
\$authority = "{$authority}";
?>
mystep;
$content = str_replace("/*--settings--*/", makeVarsCode($setting, "\$setting"), $content);
WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
unset($setting);
$setting = $cur_setting;
		',
	),
	'0.99.9.9.9.1' => array(
		'info' => '
				1.Set the first function page of the power setting to the first login page for all admin user
				2.Fix a bug in plugin function
				3.Fix a bug in custom_form plugin
				4.Add multi post function to custom_form plugin
				5.Data_trans plugin added which can transfer data from one sub-site to another
				6.Add number of result data for the search plugin
				7.Add full-content-view mode for read function
				8.Fix a bug in TinyMCE editor function
				9.Add custom template function for the read page
				Dozens of adjusts...
			',
		'sql' => array(
				'alter table `{pre}news_show` modify `style` Char(40) NOT NULL DEFAULT ""',
				'alter table `{pre}news_show` modify `original` Char(100) NOT NULL DEFAULT ""',
				'alter table `{pre}news_show` add `template` Char(255) DEFAULT "" AFTER `add_date`',
			),
		'file' => array(
				'admin/art_catalog.php',
				'admin/art_content.php',
				'admin/art_info.php',
				'admin/index.php',
				'admin/language/chs.php',
				'admin/language/default.php',
				'admin/language/en.php',
				'admin/style.css',
				'admin/subweb.sql',
				'admin/update.php',
				'admin/web_cache.php',
				'admin/web_plugin.php',
				'admin/web_rewrite.php',
				'admin/web_setting.php',
				'files/index.php',
				'images/classic/style.css',
				'images/default/style.css',
				'images/style.css',
				'inc.php',
				'include/config/chs.php',
				'include/config/default.php',
				'include/parameter.php',
				'index.php',
				'plugin/ad_show/class.php',
				'plugin/ad_show/tpl/list.tpl',
				'plugin/admin_cat/admin_cat.php',
				'plugin/admin_cat/class.php',
				'plugin/comment/class.php',
				'plugin/comment/tpl/list.tpl',
				'plugin/crontab/class.php',
				'plugin/custom_form/class.php',
				'plugin/custom_form/setting/default.php',
				'plugin/custom_form/show.php',
				'plugin/custom_form/style.css',
				'plugin/custom_form/tpl/add.tpl',
				'plugin/custom_form/tpl/default_cf_submit_cn.tpl',
				'plugin/custom_form/tpl/default_cf_submit_en.tpl',
				'plugin/custom_form/tpl/default_mail_cn.tpl',
				'plugin/custom_form/tpl/default_mail_en.tpl',
				'plugin/custom_form/tpl/edit_data.tpl',
				'plugin/custom_form/tpl/list_data.tpl',
				'plugin/custom_sql/class.php',
				'plugin/custom_sql/custom_sql.php',
				'plugin/custom_sql/tpl/list.tpl',
				'plugin/data_trans/class.php',
				'plugin/data_trans/data_trans.php',
				'plugin/data_trans/index.php',
				'plugin/data_trans/info',
				'plugin/data_trans/info.php',
				'plugin/data_trans/info/chs.php',
				'plugin/data_trans/info/en.php',
				'plugin/data_trans/language',
				'plugin/data_trans/language/chs.php',
				'plugin/data_trans/language/default.php',
				'plugin/data_trans/language/en.php',
				'plugin/data_trans/tpl',
				'plugin/data_trans/tpl/trans.tpl',
				'plugin/db_info/class.php',
				'plugin/email/class.php',
				'plugin/email/tpl/input.tpl',
				'plugin/front_code/class.php',
				'plugin/mssql/class.php',
				'plugin/news_mark/class.php',
				'plugin/news_mark/tpl/news_mark.tpl',
				'plugin/news_snatch/class.php',
				'plugin/news_visit/class.php',
				'plugin/news_visit/news_visit.tpl',
				'plugin/offical/class.php',
				'plugin/offical/update.php',
				'plugin/se_detect/class.php',
				'plugin/se_detect/tpl/view.tpl',
				'plugin/search/class.php',
				'plugin/search/info.php',
				'plugin/search/install.sql',
				'plugin/search/show.php',
				'plugin/search/tpl/keyword.tpl',
				'plugin/source/class.php',
				'plugin/survey/class.php',
				'plugin/survey/tpl/list.tpl',
				'plugin/topic/class.php',
				'plugin/topic/tpl/input.tpl',
				'plugin/topic/tpl/list.tpl',
				'plugin/visit_analysis/class.php',
				'read.php',
				'script/addon.js',
				'script/admin.js',
				'script/checkForm.js',
				'script/date.js',
				'script/global.js',
				'script/jquery.addon.js',
				'script/jquery.codemirror.js',
				'source/class/mssql.class.php',
				'source/class/myemail.class.php',
				'source/class/myreq.class.php',
				'source/class/mysql.class.php',
				'source/class/mystep.class.php',
				'source/class/mytpl.class.php',
				'source/function/global.php',
				'source/function/web.php',
				'template/admin/art_catalog_input.tpl',
				'template/admin/art_content_input.tpl',
				'template/admin/info_count.tpl',
				'template/admin/info_log.tpl',
				'template/admin/user_online.tpl',
				'template/admin/web_template_input.tpl',
				'template/admin_simple/art_catalog_input.tpl',
				'template/admin_simple/art_content_input.tpl',
				'template/admin_simple/index.tpl',
				'template/classic/index.tpl',
				'template/classic/list_1.tpl',
				'template/classic/list_2.tpl',
				'template/classic/main.tpl',
				'template/classic/read.tpl',
				'template/default/list_1.tpl',
				'template/default/list_2.tpl',
				'template/default/main_base.tpl',
				'template/default/main_blank.tpl',
				'template/default/read.tpl',
		),
		'setting' => array(
				'gen' => array(
						'etag' => '20130427',
					),
		),
	),
	'0.99.9.9.9.2' => array(
		'info' => '
				1.Fix a bug in sql file for sub-website
				2.Fix a bug in plugin function
				3.Fix a css bug under IE
				4.Fix a mistake in email functions
				5.Add a new ticket system plugin
				6.Fix a dialog bug in js function
				7.Fix a bug in GetRemoteContent function when it has been gziped
				8.Enhance 3rd part login functions
				Some other adjusts...
			',
		'file' => array(
				'admin/subweb.sql',
				'admin/web_plugin.php',
				'images/classic/style.css',
				'include/parameter.php',
				'plugin/custom_form/custom_form.php',
				'plugin/custom_form/tpl/edit_data.tpl',
				'plugin/news_snatch/tpl/rule_input.tpl',
				'plugin/search/class.php',
				'plugin/search/info.php',
				'plugin/search/search.php',
				'plugin/ticket',
				'plugin/ticket/class.php',
				'plugin/ticket/index.php',
				'plugin/ticket/info',
				'plugin/ticket/info.php',
				'plugin/ticket/info/chs.php',
				'plugin/ticket/info/en.php',
				'plugin/ticket/install.sql',
				'plugin/ticket/language',
				'plugin/ticket/language/chs.php',
				'plugin/ticket/language/default.php',
				'plugin/ticket/language/en.php',
				'plugin/ticket/list.php',
				'plugin/ticket/show.php',
				'plugin/ticket/style.css',
				'plugin/ticket/ticket.php',
				'plugin/ticket/tpl',
				'plugin/ticket/tpl/check.tpl',
				'plugin/ticket/tpl/input.tpl',
				'plugin/ticket/tpl/list.tpl',
				'plugin/ticket/tpl/main.tpl',
				'plugin/ticket/tpl/show.tpl',
				'plugin/ticket/tpl/topic.tpl',
				'script/addon.js',
				'source/class/myemail.class.php',
				'source/class/mystep.class.php',
				'source/function/global.php',
				'source/function/web.php',
				'template/admin/web_subweb_input.tpl',
		),
		'setting' => array(
				'gen' => array(
						'etag' => '20130506',
					),
		),
	),
	'0.99.9.9.9.3' => array(
		'info' => '
				1.Add more user data to session
				2.Optimize user login function, now cms user and 3rd part user can login at a same time
				3.Set login user\'s name and email to the default value of ticket plugin
				4.Fix a bug in email functions
				Some other adjusts...
			',
		'file' => array(
				'include/parameter.php',
				'plugin/offical/class.php',
				'plugin/offical/show.php',
				'plugin/ticket/show.php',
				'plugin/ticket/ticket.php',
				'plugin/ticket/tpl/show.tpl',
				'script/checkForm.js',
				'source/class/mystep.class.php',
				'source/class/session.class.php',
				'source/language/chs.php',
				'source/language/default.php',
				'source/language/en.php',
			),
		'sql' => array(
				'alter table `{pre}user_online` add `userinfo` Char(255) default ""',
				'alter table `{pre}user_online` modify `sid` char(32) UNIQUE NOT NULL',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20130509',
					),
			),
	),
	'0.99.9.9.9.4' => array(
		'info' => '
				1.Fix a bug in online user list
				2.Fix a bug in online user function
				3.Fix a bug in getIP function
				4.Some adjust in ticket plugin
				Some other adjusts...
			',
		'file' => array(
				'admin/user_online.php',
				'admin/web_rewrite.php',
				'include/parameter.php',
				'plugin/ticket/show.php',
				'plugin/ticket/style.css',
				'plugin/ticket/tpl/input.tpl',
				'plugin/ticket/tpl/show.tpl',
				'read.php',
				'source/class/session.class.php',
				'source/function/global.php',
				'template/admin/user_online.tpl',
			),
			'code' => '
if(!function_exists("changeSetting")) {
	function changeSetting($setting_new, $para_new = array(), $if_write = true) {
		require(ROOT_PATH."/include/config.php");
		$setting = arrayMerge($setting, $setting_new);
		if(isset($para_new["rewrite"])) $rewrite_list = $para_new["rewrite"];
		if(isset($para_new["expire"])) $expire_list = $para_new["expire"];
		if(isset($para_new["authority"])) $authority = $para_new["authority"];
		$rewrite_list_str = var_export($rewrite_list, true);
		$expire_list_str = var_export($expire_list, true);
		$content = <<<mystep
	<?php
	\$setting = array();
	
	/*--settings--*/
	\$rewrite_list = {$rewrite_list_str};
	\$expire_list = {$expire_list_str};
	\$authority = "{$authority}";
	?>
	mystep;
		$content = str_replace("/*--settings--*/", makeVarsCode($setting, \'$setting\'), $content);
		if($if_write) WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
		return $content;
	}
}

$para_new = array();
$para_new["rewrite"] = $rewrite_list;
$para_new["rewrite"][0][0] = "article/[^\\/]+/(\\d+)(_(\\w+))?\\.html";
changeSetting($setting, $para_new);
		',
		'setting' => array(
				'gen' => array(
						'etag' => '20130511',
					),
			),
	),
	'1.0' => array(
		'info' => '
				1.Fix a bug in set multi-domain to a subweb
				2.Fix a bug in rebuild tag
				3.Fix a bug in get rewrite url functions
				4.Add bootstrap frameword plugin
				5.Add file upload function to custom_form plugin
				6.Add expire setting to custom_form plugin
				7.Remove front_code plugin
				8.Add Xcode plugin which can execute any codes before or after any page script.
				9.Improve charset functions
				10.Improve form check function
				11.Improve ConvertLimit function in mssql plugin
				12.Add pinyin transfer function
				13.Fix a inject bug in list.php
				Some other adjusts...
			',
		'file' => array(
				'admin/art_catalog.php',
				'admin/art_content.php',
				'admin/art_tag.php',
				'admin/index.php',
				'admin/style.css',
				'admin/web_plugin.php',
				'images',
				'images/classic/style.css',
				'images/default/style.css',
				'inc.php',
				'include/parameter.php',
				'read.php',
				'list.php',
				'plugin/bootstrap',
				'plugin/bootstrap/bootstrap.html',
				'plugin/bootstrap/class.php',
				'plugin/bootstrap/config',
				'plugin/bootstrap/config.php',
				'plugin/bootstrap/config/chs.php',
				'plugin/bootstrap/config/default.php',
				'plugin/bootstrap/config/en.php',
				'plugin/bootstrap/css',
				'plugin/bootstrap/css/bootstrap-responsive.css',
				'plugin/bootstrap/css/bootstrap.css',
				'plugin/bootstrap/css/docs.css',
				'plugin/bootstrap/css/glyphicons-halflings-white.png',
				'plugin/bootstrap/css/glyphicons-halflings.png',
				'plugin/bootstrap/css/icon_search.png',
				'plugin/bootstrap/css/test.css',
				'plugin/bootstrap/index.php',
				'plugin/bootstrap/info',
				'plugin/bootstrap/info.php',
				'plugin/bootstrap/info/chs.php',
				'plugin/bootstrap/info/en.php',
				'plugin/bootstrap/js',
				'plugin/bootstrap/js/bootstrap-affix.js',
				'plugin/bootstrap/js/bootstrap-alert.js',
				'plugin/bootstrap/js/bootstrap-button.js',
				'plugin/bootstrap/js/bootstrap-carousel.js',
				'plugin/bootstrap/js/bootstrap-collapse.js',
				'plugin/bootstrap/js/bootstrap-dropdown.js',
				'plugin/bootstrap/js/bootstrap-modal.js',
				'plugin/bootstrap/js/bootstrap-popover.js',
				'plugin/bootstrap/js/bootstrap-scrollspy.js',
				'plugin/bootstrap/js/bootstrap-tab.js',
				'plugin/bootstrap/js/bootstrap-tooltip.js',
				'plugin/bootstrap/js/bootstrap-transition.js',
				'plugin/bootstrap/js/bootstrap-typeahead.js',
				'plugin/bootstrap/js/jquery.js',
				'plugin/bootstrap/js/test.js',
				'plugin/custom_form/class.php',
				'plugin/custom_form/config.php',
				'plugin/custom_form/custom_form.php',
				'plugin/custom_form/file.php',
				'plugin/custom_form/install.sql',
				'plugin/custom_form/language/chs.php',
				'plugin/custom_form/language/default.php',
				'plugin/custom_form/language/en.php',
				'plugin/custom_form/setting',
				'plugin/custom_form/show.php',
				'plugin/custom_form/tpl/add.tpl',
				'plugin/custom_form/tpl/default_cf_submit_cn.tpl',
				'plugin/custom_form/tpl/default_cf_submit_en.tpl',
				'plugin/custom_form/tpl/default_mail_cn.tpl',
				'plugin/custom_form/tpl/default_mail_en.tpl',
				'plugin/custom_form/tpl/edit.tpl',
				'plugin/custom_form/tpl/edit_data.tpl',
				'plugin/custom_form/tpl/expire.tpl',
				'plugin/custom_form/tpl/sample_cf_submit_cn_mutil.tpl',
				'plugin/custom_form/update.php',
				'plugin/inc.php',
				'plugin/mssql',
				'plugin/news_visit/news_visit.php',
				'plugin/news_visit/news_visit.tpl',
				'plugin/offical/show.php',
				'plugin/se_detect/class.php',
				'plugin/search/show.php',
				'plugin/ticket/info.php',
				'plugin/ticket/install.sql',
				'plugin/ticket/show.php',
				'plugin/ticket/ticket.php',
				'plugin/ticket/tpl/show.tpl',
				'plugin/ticket/update.php',
				'plugin/visit_analysis/class.php',
				'plugin/xcode',
				'plugin/xcode/class.php',
				'plugin/xcode/code',
				'plugin/xcode/code.db',
				'plugin/xcode/index.php',
				'plugin/xcode/info',
				'plugin/xcode/info.php',
				'plugin/xcode/info/chs.php',
				'plugin/xcode/info/en.php',
				'plugin/xcode/language',
				'plugin/xcode/language/chs.php',
				'plugin/xcode/language/default.php',
				'plugin/xcode/language/en.php',
				'plugin/xcode/tpl',
				'plugin/xcode/tpl/input.tpl',
				'plugin/xcode/tpl/list.tpl',
				'plugin/xcode/tpl/main.tpl',
				'plugin/xcode/xcode.php',
				'script/checkForm.js',
				'script/global.js',
				'script/jquery.addon.js',
				'script/jquery.autocomplete.js',
				'source/class/minify.class.php',
				'source/class/mssql.class.php',
				'source/class/myapi.class.php',
				'source/class/myemail.class.php',
				'source/class/mysql.class.php',
				'source/class/mystep.class.php',
				'source/class/mytpl.class.php',
				'source/class/myuploader.class.php',
				'source/function/chs2cht.dic',
				'source/function/global.php',
				'source/function/pinyin.php',
				'source/function/web.php',
				'source/language/chs.php',
				'source/language/default.php',
				'source/language/en.php',
				'template',
				'template/admin/art_catalog_list.tpl',
				'template/admin/info_main.tpl',
				'template/admin/web_template_input.tpl',
				'template/admin_simple/art_catalog_list.tpl',
				'template/admin_simple/index.tpl',
				'template/admin_simple/web_cache.tpl',
				'template/classic/index.tpl',
				'template/classic/tag.tpl',
			),
			'code' => '
$para_new = array();
$para_new["rewrite"] = $rewrite_list;
$para_new["rewrite"][0][0] = "article/[^\\/]+/(\\d+)(_(\\w+))?\\.html";
changeSetting($setting, $para_new);
		',
		'sql' => array(
				'truncate table `{pre}user_online`',
				'alter table `{pre}user_online` modify `ip` Char(50) NOT NULL UNIQUE',
			),
		'setting' => array(
				'gen' => array(
						'etag' => '20130930',
					),
			),
	),
);
?>