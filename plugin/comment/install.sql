# ��������
CREATE TABLE `{pre}comment` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '��վ����',
	`news_id` MEDIUMINT UNSIGNED COMMENT '��������',
	`user_name` Char(40) NOT NULL COMMENT '�û�����',
	`ip` Char(24) NOT NULL COMMENT '�û� IP',
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '���۷�������',
	`comment` TEXT NOT NULL COMMENT '��������',
	`agree` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '��ͬ',
	`oppose` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '����',
	`report` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '�ٱ�',
	`rpt_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '�ٱ�����',
	`quote` SMALLINT UNSIGNED DEFAULT 0 COMMENT '����¥��',
	INDEX `idx` (`web_id`, `news_id`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';

# ---------------------------------------------------------------------------------------------------------------

