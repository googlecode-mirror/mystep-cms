# �ƻ���������趨
CREATE TABLE `{pre}crontab` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '����',
	`name` Char(200) DEFAULT '' COMMENT '����',
	`mode` TINYINT DEFAULT 0 COMMENT '��ʱģʽ',
	`describe` Char(100) NOT NULL DEFAULT '' COMMENT '�ƻ�����',
	`schedule` Char(100) NOT NULL DEFAULT '' COMMENT 'ִ�мƻ�',
	`url` Char(200) NOT NULL DEFAULT '' COMMENT '���ӵ�ַ',
	`exe_count` INT DEFAULT 0 COMMENT 'ִ�д���',
	`exe_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '���ִ������',
	`next_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '�´�ִ������',
	`expire` DATE DEFAULT '0000-00-00' COMMENT '��������',
	`code` TEXT COMMENT 'ִ�д���',
	INDEX `next_date` (`next_date`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='�ƻ�����';

# ---------------------------------------------------------------------------------------------------------------