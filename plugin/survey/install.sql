# ͶƱ
CREATE TABLE `{pre}survey` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`subject` Char(120) NOT NULL COMMENT '�������',
	`describe` Char(255) DEFAULT '' COMMENT '��������',
	`max_select` TINYINT UNSIGNED NOT NULL COMMENT '��ѡ������0-�����ƣ�1-��ѡ��������ѡ��',
	`add_date` Char(15) DEFAULT 0 COMMENT '������ڣ�unixtimestamp��',
	`expire` Char(15) DEFAULT 0 COMMENT '��Чʱ�䣨�룩',
	`user_lvl` Char(10) NOT NULL DEFAULT '0' COMMENT 'ͶƱȨ��',
	`times` INT DEFAULT 0 COMMENT '��������',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='ͶƱ';
