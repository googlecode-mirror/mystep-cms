# 投票
CREATE TABLE `{pre}survey` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`subject` Char(120) NOT NULL COMMENT '调查标题',
	`describe` Char(255) DEFAULT '' COMMENT '调查描述',
	`max_select` TINYINT UNSIGNED NOT NULL COMMENT '可选数量（0-不限制，1-单选，其他多选）',
	`add_date` Char(15) DEFAULT 0 COMMENT '添加日期（unixtimestamp）',
	`expire` Char(15) DEFAULT 0 COMMENT '有效时间（秒）',
	`user_lvl` Char(10) NOT NULL DEFAULT '0' COMMENT '投票权限',
	`times` INT DEFAULT 0 COMMENT '参与人数',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='投票';
