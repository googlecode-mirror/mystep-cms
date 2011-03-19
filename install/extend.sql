# 新闻专题
CREATE TABLE `{pre}news_theme` (
	`theme_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,		#专题索引
	`theme_name` Char(60) NOT NULL,													#专题名称
	`theme_idx` Char(20) DEFAULT '',												#专题索引（用于目录名等）
	`theme_image` Char(100) DEFAULT '',											#专题图示
	`theme_link` Char(100) DEFAULT '',											#专题链接
	`theme_cat` Char(200) DEFAULT '',												#专题分类
	`theme_comment` Char(250) DEFAULT '',										#专题介绍
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',			#录入日期
	PRIMARY KEY (`theme_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻专题';

# ---------------------------------------------------------------------------------------------------------------

# 新闻专题链接
CREATE TABLE `{pre}news_theme_link` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,					#链接索引
	`theme_id` SMALLINT UNSIGNED NOT NULL,									#专题索引
	`news_id` MEDIUMINT UNSIGNED,														#新闻索引
	`link_name` Char(100) DEFAULT '',												#链接名称
	`link_url` Char(200) DEFAULT '',												#链接地址
	`link_cat` TINYINT UNSIGNED,														#链接分类
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻专题链接';

# ---------------------------------------------------------------------------------------------------------------

# 新闻采集
CREATE TABLE `{pre}news_snatch` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(40) NOT NULL DEFAULT '',					#规则索引
	`url` Char(200) NOT NULL DEFAULT '',				#新闻网址
	`original` Char(100) NOT NULL DEFAULT '',		#来源网站
	`subject` Char(255) NOT NULL,								#新闻标题
	`item_1` Char(255) DEFAULT '',							#采集文本
	`item_2` Char(255) DEFAULT '',							#采集文本
	`item_3` Char(255) DEFAULT '',							#采集文本
	`item_4` Char(255) DEFAULT '',							#采集文本
	`item_5` Char(255) DEFAULT '',							#采集文本
	`item_6` Char(255) DEFAULT '',							#采集文本
	`item_7` Char(255) DEFAULT '',							#采集文本
	`item_8` Char(255) DEFAULT '',							#采集文本
	`item_9` Char(255) DEFAULT '',							#采集文本
	`content` TEXT NOT NULL,										#新闻内容
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻采集';

# ---------------------------------------------------------------------------------------------------------------

# 投票
CREATE TABLE `{pre}survey` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`subject` Char(120) NOT NULL,									#调查标题
	`describe` Char(255) DEFAULT '',							#调查描述
	`max_select` TINYINT UNSIGNED NOT NULL,				#可选数量（0-不限制，1-单选，其他多选）
	`post_limit` MEDIUMINT UNSIGNED NOT NULL,			#发贴量限制（0-不限制）
	`template` Char(20) NOT NULL,									#调用模板
	`add_date` Char(15) DEFAULT 0,								#添加日期（unixtimestamp）
	`expire` Char(15) DEFAULT 0,									#有效时间（unixtimestamp）
	`times` INT DEFAULT 0,												#参与人数
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='投票';

# ---------------------------------------------------------------------------------------------------------------

# 新闻评论（所有评论都在此表记录）
CREATE TABLE `{pre}comment` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`news_id` MEDIUMINT UNSIGNED,								#关联索引
	`user_name` Char(20) NOT NULL,							#用户名称
	`ip` Char(24) NOT NULL,											#用户 IP
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#评论发表日期
	`comment` TEXT NOT NULL,										#评论内容
	`agree` MEDIUMINT UNSIGNED DEFAULT 0,				#赞同
	`oppose` MEDIUMINT UNSIGNED DEFAULT 0,			#鄙视
	`report` MEDIUMINT UNSIGNED DEFAULT 0,			#举报
	`quote` SMALLINT UNSIGNED DEFAULT 0,				#引用楼层
	INDEX (`news_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='新闻评论';

# ---------------------------------------------------------------------------------------------------------------

# 企业注册
CREATE TABLE `{pre}regist` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` Char(20),											#姓名
	`name_en` Char(20),										#姓名英文
	`gender` Bool DEFAULT 0,							#性别
	`country` Char(50),										#国家
	`duty` Char(40),											#职务
	`duty_en` Char(40),										#职务英文
	`company` Char(100),									#公司
	`company_en` Char(100),								#公司英文
	`address` Char(200),									#地址
	`address_en` Char(200),								#地址英文
	`zipcode` Char(6),										#邮编
	`mobile` Char(20),										#手机
	`areacode` Char(20),									#区号
	`tel` Char(20),												#电话
	`fax` Char(20),												#传真
	`email` Char(40),											#电子邮件
	`website` Char(200),									#网址
	PRIMARY KEY (`id`)
)COMMENT='企业注册';

# ---------------------------------------------------------------------------------------------------------------

