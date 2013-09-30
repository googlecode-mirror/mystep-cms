# 用户交互系统
CREATE TABLE `{pre}ticket` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(30) NOT NULL COMMENT '主题索引',	
	`name` Char(30) NOT NULL COMMENT '发布人',
	`email` Char(50) NOT NULL COMMENT '电子邮件',
	`type` Char(50) NOT NULL COMMENT '类型',
	`subject` Char(100) NOT NULL COMMENT '主题',
	`priority` TINYINT DEFAULT 0 COMMENT '优先度',
	`message` MEDIUMTEXT NOT NULL COMMENT '内容',
	`reply` MEDIUMTEXT COMMENT '回复',
	`status` TINYINT DEFAULT 0 COMMENT '状态',
	`add_date` Char(15) DEFAULT 0 COMMENT '发布日期（unixtimestamp）',
	`reply_date` Char(15) DEFAULT 0 COMMENT '回复日期（unixtimestamp）',
	PRIMARY KEY (`id`),
	INDEX (`idx`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='用户交互系统';