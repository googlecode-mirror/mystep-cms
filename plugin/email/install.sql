# �����ʼ����͹����趨
CREATE TABLE `{pre}email` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '����',
	`single` TINYINT DEFAULT 0 COMMENT '��������',
	`subject` Char(200) DEFAULT '' COMMENT '����',
	`from` Char(100) NOT NULL DEFAULT '' COMMENT '������ַ',
	`reply` Char(100) NOT NULL DEFAULT '' COMMENT '�ظ���ַ',
	`notification` Char(10) NOT NULL DEFAULT '' COMMENT '�Ķ�����',
	`priority` TINYINT DEFAULT 3 COMMENT '���ȼ�',
	`to` TEXT COMMENT '���յ�ַ',
	`cc` TEXT COMMENT '���͵�ַ',
	`bcc` TEXT COMMENT '���͵�ַ',
	`header` TEXT COMMENT '�ʼ�ͷ',
	`content` TEXT COMMENT '�ʼ�����',
	`attachment` TEXT COMMENT '�ʼ�����',
	`send_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '��������',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='�����ʼ�';

# ---------------------------------------------------------------------------------------------------------------
