# ��������
CREATE TABLE `{pre}news_mark` (
	`web_id` TINYINT UNSIGNED DEFAULT 0,						#��վ����
	`news_id` MEDIUMINT UNSIGNED,										#��������
	`cat_id` MEDIUMINT UNSIGNED NOT NULL,						#��������
	`subject` Char(120) NOT NULL,										#���ű���
	`jump` SMALLINT DEFAULT 0,											#��������
	`jump_time` Char(10) DEFAULT '0',								#�������ʱ��
	`rank_times` SMALLINT UNSIGNED DEFAULT 0,				#�������ִ���
	`rank_total` INT DEFAULT 0,											#���������ܷ�
	`rank_time` Char(10) DEFAULT '0',								#�������ʱ��
	UNIQUE INDEX `web_news` (`web_id`, `news_id`),
	INDEX (`jump`),
	INDEX (`rank_total`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';