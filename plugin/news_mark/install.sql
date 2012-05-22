# ��������
CREATE TABLE `{pre}news_mark` (
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '��վ����',
	`news_id` MEDIUMINT UNSIGNED COMMENT '��������',
	`cat_id` MEDIUMINT UNSIGNED NOT NULL COMMENT '��������',
	`subject` Char(120) NOT NULL COMMENT '���ű���',
	`jump` SMALLINT DEFAULT 0 COMMENT '��������',
	`jump_time` Char(10) DEFAULT '0' COMMENT '�������ʱ��',
	`rank_times` SMALLINT UNSIGNED DEFAULT 0 COMMENT '�������ִ���',
	`rank_total` INT DEFAULT 0 COMMENT '���������ܷ�',
	`rank_time` Char(10) DEFAULT '0' COMMENT '�������ʱ��',
	UNIQUE INDEX `web_news` (`web_id`, `news_id`),
	INDEX (`jump`),
	INDEX (`rank_total`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';