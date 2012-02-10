# 电子邮件发送规则设定
CREATE TABLE `{pre}email` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,			#索引
	`single` TINYINT DEFAULT 0,													#单条发送
	`subject` Char(200) DEFAULT '',											#主题
	`from` Char(100) NOT NULL DEFAULT '',								#发件地址
	`reply` Char(100) NOT NULL DEFAULT '',							#回复地址
	`notification` Char(10) NOT NULL DEFAULT '',				#阅读收条
	`priority` TINYINT DEFAULT 3,												#优先级
	`to` TEXT,																					#接收地址
	`cc` TEXT,																					#抄送地址
	`bcc` TEXT,																					#暗送地址
	`header` TEXT,																			#邮件头
	`content` TEXT,																			#邮件内容
	`attachment` TEXT,																	#邮件附件
	`send_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#发送日期
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='电子邮件';

# ---------------------------------------------------------------------------------------------------------------
