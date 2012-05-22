# 检索索引表
CREATE TABLE `{pre}search_keyword` (
	`keyword` Char(80) NOT NULL UNIQUE COMMENT '关键字',
	`count` SMALLINT DEFAULT 0 COMMENT '搜索次数',
	`add_date` Char(15) DEFAULT 0 COMMENT '首次检索日期（unixtimestamp）',
	`chg_date` Char(15) DEFAULT 0 COMMENT '最近检索日期（unixtimestamp）',
	INDEX (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='检索索引表';