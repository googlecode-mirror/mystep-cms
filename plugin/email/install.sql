# 电子邮件发送规则设定
CREATE TABLE `{pre}email` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '索引',
	`single` TINYINT DEFAULT 0 COMMENT '单条发送',
	`subject` Char(200) DEFAULT '' COMMENT '主题',
	`from` Char(100) NOT NULL DEFAULT '' COMMENT '发件地址',
	`reply` Char(100) NOT NULL DEFAULT '' COMMENT '回复地址',
	`notification` Char(10) NOT NULL DEFAULT '' COMMENT '阅读收条',
	`priority` TINYINT DEFAULT 3 COMMENT '优先级',
	`to` TEXT COMMENT '接收地址',
	`cc` TEXT COMMENT '抄送地址',
	`bcc` TEXT COMMENT '暗送地址',
	`header` TEXT COMMENT '邮件头',
	`content` TEXT COMMENT '邮件内容',
	`attachment` TEXT COMMENT '邮件附件',
	`send_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '发送日期',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='电子邮件';

# ---------------------------------------------------------------------------------------------------------------
