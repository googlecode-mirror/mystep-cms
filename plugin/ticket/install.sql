# �û�����ϵͳ
CREATE TABLE `{pre}ticket` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(30) NOT NULL COMMENT '��������',	
	`name` Char(30) NOT NULL COMMENT '������',
	`email` Char(50) NOT NULL COMMENT '�����ʼ�',
	`type` Char(50) NOT NULL COMMENT '����',
	`subject` Char(100) NOT NULL COMMENT '����',
	`priority` TINYINT DEFAULT 0 COMMENT '���ȶ�',
	`message` MEDIUMTEXT NOT NULL COMMENT '����',
	`reply` MEDIUMTEXT COMMENT '�ظ�',
	`status` TINYINT DEFAULT 0 COMMENT '״̬',
	`add_date` Char(15) DEFAULT 0 COMMENT '�������ڣ�unixtimestamp��',
	`reply_date` Char(15) DEFAULT 0 COMMENT '�ظ����ڣ�unixtimestamp��',
	PRIMARY KEY (`id`),
	INDEX (`idx`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='�û�����ϵͳ';