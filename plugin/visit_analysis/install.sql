# ��Դ��ַ��¼
CREATE TABLE `{pre}visit_analysis` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`host` Char(100) NOT NULL UNIQUE,									#��Դ����
	`count` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,		#���ô���
	`add_date` Char(15) DEFAULT 0,										#�״��������ڣ�unixtimestamp��
	`chg_date` Char(15) DEFAULT 0,										#����������ڣ�unixtimestamp��
	index (`host`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��Դ��ַ��¼';
INSERT INTO `{pre}visit_analysis` values(0, 'None', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

# ���ùؼ���
CREATE TABLE `{pre}visit_keyword` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`keyword` Char(80) NOT NULL UNIQUE,				#�ؼ���
	`count` SMALLINT DEFAULT 0,								#��������
	`add_date` Char(15) DEFAULT 0,						#�״μ������ڣ�unixtimestamp��
	`chg_date` Char(15) DEFAULT 0,						#����������ڣ�unixtimestamp��
	INDEX (`keyword`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='���ùؼ���';
