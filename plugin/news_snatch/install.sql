# ���Ųɼ�
CREATE TABLE `{pre}news_snatch` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(40) NOT NULL DEFAULT '' COMMENT '��������',
	`url` Char(200) NOT NULL UNIQUE DEFAULT '' COMMENT '������ַ',
	`original` Char(100) NOT NULL DEFAULT '' COMMENT '��Դ��վ',
	`subject` Char(255) NOT NULL COMMENT '���ű���',
	`item_1` Char(255) DEFAULT '' COMMENT '�ɼ��ı�',
	`item_2` Char(255) DEFAULT '' COMMENT '�ɼ��ı�',
	`item_3` Char(255) DEFAULT '' COMMENT '�ɼ��ı�',
	`item_4` Char(255) DEFAULT '' COMMENT '�ɼ��ı�',
	`item_5` Char(255) DEFAULT '' COMMENT '�ɼ��ı�',
	`item_6` Char(255) DEFAULT '' COMMENT '�ɼ��ı�',
	`item_7` Char(255) DEFAULT '' COMMENT '�ɼ��ı�',
	`item_8` Char(255) DEFAULT '' COMMENT '�ɼ��ı�',
	`item_9` Char(255) DEFAULT '' COMMENT '�ɼ��ı�',
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '¼������',
	`content` MEDIUMTEXT NOT NULL COMMENT '��������',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='���Ųɼ�';