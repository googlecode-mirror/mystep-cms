# �����ʼ����͹����趨
CREATE TABLE `{pre}email` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,			#����
	`single` TINYINT DEFAULT 0,													#��������
	`subject` Char(200) DEFAULT '',											#����
	`from` Char(100) NOT NULL DEFAULT '',								#������ַ
	`reply` Char(100) NOT NULL DEFAULT '',							#�ظ���ַ
	`notification` Char(10) NOT NULL DEFAULT '',				#�Ķ�����
	`priority` TINYINT DEFAULT 3,												#���ȼ�
	`to` TEXT,																					#���յ�ַ
	`cc` TEXT,																					#���͵�ַ
	`bcc` TEXT,																					#���͵�ַ
	`header` TEXT,																			#�ʼ�ͷ
	`content` TEXT,																			#�ʼ�����
	`attachment` TEXT,																	#�ʼ�����
	`send_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#��������
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='�����ʼ�';

# ---------------------------------------------------------------------------------------------------------------
