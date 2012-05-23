# 会议信息
CREATE TABLE `{pre}custom_form` (
	`mid` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '所属网站',
	`name` Char(100) COMMENT '名称',
	`name_en` Char(100) COMMENT '名称英文',
	`notes` char(255)	DEFAULT '' COMMENT '备注',
	`add_date` DATETIME COMMENT '添加日期',
	PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='自定义表单信息';
