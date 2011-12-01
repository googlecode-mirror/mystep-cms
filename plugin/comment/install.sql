# ��������
CREATE TABLE `{pre}comment` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0,				#��վ����
	`news_id` MEDIUMINT UNSIGNED,								#��������
	`user_name` Char(40) NOT NULL,							#�û�����
	`ip` Char(24) NOT NULL,											#�û� IP
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#���۷�������
	`comment` TEXT NOT NULL,										#��������
	`agree` MEDIUMINT UNSIGNED DEFAULT 0,				#��ͬ
	`oppose` MEDIUMINT UNSIGNED DEFAULT 0,			#����
	`report` MEDIUMINT UNSIGNED DEFAULT 0,			#�ٱ�
	`rpt_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#�ٱ�����
	`quote` SMALLINT UNSIGNED DEFAULT 0,				#����¥��
	INDEX `idx` (`web_id`, `news_id`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';

# ---------------------------------------------------------------------------------------------------------------

