# ������Ϣ
CREATE TABLE `{pre}meeting` (
	`mid` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0,	#������վ
	`name` Char(100),											#����
	`name_en` Char(100),									#����Ӣ��
	`notes` char(255)	DEFAULT '',					#��ע
	`add_date` DATETIME,									#�������
	PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='������Ϣ';
