# ���Ųɼ�
CREATE TABLE `{pre}news_snatch` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(40) NOT NULL DEFAULT '',					#��������
	`url` Char(200) NOT NULL UNIQUE DEFAULT '',	#������ַ
	`original` Char(100) NOT NULL DEFAULT '',		#��Դ��վ
	`subject` Char(255) NOT NULL,								#���ű���
	`item_1` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_2` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_3` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_4` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_5` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_6` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_7` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_8` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_9` Char(255) DEFAULT '',							#�ɼ��ı�
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#¼������
	`content` MEDIUMTEXT NOT NULL,										#��������
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='���Ųɼ�';