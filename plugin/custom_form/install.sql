# ������Ϣ
CREATE TABLE `{pre}custom_form` (
	`mid` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '������վ',
	`name` Char(100) COMMENT '����',
	`name_en` Char(100) COMMENT '����Ӣ��',
	`notes` char(255)	DEFAULT '' COMMENT '��ע',
	`add_date` DATETIME COMMENT '�������',
	PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='�Զ������Ϣ';
