# 网站广告表
CREATE TABLE `{pre}ad_show` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(20) NOT NULL,											#广告分类索引
	`ad_client` Char(100) NOT NULL,								#客户名称
	`ad_url` Char(100),														#广告链接
	`ad_mode` TINYINT(3) UNSIGNED DEFAULT 1,			#广告类型（image，flash，html，js）
	`ad_file` Char(100),													#广告文件
	`ad_text` Char(100),													#显示文字
	`ad_level` TINYINT UNSIGNED DEFAULT 0,				#显示级别
	`ip_view` MEDIUMINT UNSIGNED DEFAULT 0,				#广告浏览人数
	`ip_click` MEDIUMINT UNSIGNED DEFAULT 0,			#广告点击人数
	`view` MEDIUMINT UNSIGNED DEFAULT 0,					#广告显示次数
	`click` MEDIUMINT UNSIGNED DEFAULT 0,					#广告点击次数
	`add_date` DATE DEFAULT '0000-00-00',					#广告发布日期
	`exp_date` DATE DEFAULT '0000-00-00',					#广告截止日期
	`comment` Char(255) DEFAULT '',								#相关备注
	INDEX (`idx`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='网站广告表';