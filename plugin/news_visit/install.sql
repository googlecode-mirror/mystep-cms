# ���ŷ���ͳ��
CREATE TABLE `{pre}news_visit` (
	`web_id` TINYINT UNSIGNED DEFAULT 0,						#��վ����
	`news_id` MEDIUMINT UNSIGNED NOT NULL,					#��������
	`cat_id` MEDIUMINT UNSIGNED NOT NULL,						#��������
	`subject` Char(120) NOT NULL,										#���ű���
	`views` MEDIUMINT UNSIGNED DEFAULT 0,						#���������
	`day_start` Char(10) DEFAULT '0',								#��ͳ�����
	`day_count` SMALLINT UNSIGNED DEFAULT 0,				#�������
	`day_max_time` Char(10) DEFAULT '0',						#��������ʱ��
	`day_max_count` SMALLINT UNSIGNED DEFAULT 0,		#������������
	`week_start` Char(10) DEFAULT '0',							#��ͳ�����
	`week_count` MEDIUMINT UNSIGNED DEFAULT 0,			#�������
	`week_max_time` Char(10) DEFAULT '0',						#��������ʱ��
	`week_max_count` MEDIUMINT UNSIGNED DEFAULT 0,	#������������
	`month_start` Char(10) DEFAULT '0',							#��ͳ�����
	`month_count` MEDIUMINT UNSIGNED DEFAULT 0,			#�������
	`month_max_time` Char(10) DEFAULT '0',					#��������ʱ��
	`month_max_count` MEDIUMINT UNSIGNED DEFAULT 0,	#������������
	`year_start` Char(10) DEFAULT '0',							#��ͳ�����
	`year_count` MEDIUMINT UNSIGNED DEFAULT 0,			#�������
	`year_max_time` Char(10) DEFAULT '0',						#��������ʱ��
	`year_max_count` MEDIUMINT UNSIGNED DEFAULT 0,	#������������
	UNIQUE INDEX `web_news` (`web_id`, `news_id`),
	INDEX (`cat_id`),
	INDEX `day` (`web_id`, `day_count`),
	INDEX `week` (`web_id`, `week_count`),
	INDEX `month` (`web_id`, `month_count`),
	INDEX `year` (`web_id`, `year_count`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������ͳ��';