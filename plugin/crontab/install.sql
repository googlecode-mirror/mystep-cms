# �ƻ���������趨
CREATE TABLE `{pre}crontab` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,			#����
	`name` Char(200) DEFAULT '',												#����
	`mode` TINYINT DEFAULT 0,														#��ʱģʽ
	`describe` Char(100) NOT NULL DEFAULT '',						#�ƻ�����
	`schedule` Char(100) NOT NULL DEFAULT '',						#ִ�мƻ�
	`url` Char(200) NOT NULL DEFAULT '',								#���ӵ�ַ
	`exe_count` INT DEFAULT 0,													#ִ�д���
	`exe_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#���ִ������
	`next_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#�´�ִ������
	`expire` DATE DEFAULT '0000-00-00',									#��������
	`code` TEXT,																				#ִ�д���
	INDEX `next_date` (`next_date`),
	PRIMARY KEY (`id`),
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='�ƻ�����';

# ---------------------------------------------------------------------------------------------------------------