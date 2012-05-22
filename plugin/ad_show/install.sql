# ��վ����
CREATE TABLE `{pre}ad_show` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(20) NOT NULL COMMENT '����������',
	`ad_client` Char(100) NOT NULL COMMENT '�ͻ�����',
	`ad_url` Char(100) COMMENT '�������',
	`ad_mode` TINYINT(3) UNSIGNED DEFAULT 1 COMMENT '������ͣ�image��flash��html��js��',
	`ad_file` Char(100) COMMENT '����ļ�',
	`ad_text` Char(100) COMMENT '��ʾ����',
	`ad_level` TINYINT UNSIGNED DEFAULT 0 COMMENT '��ʾ����',
	`ip_view` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '����������',
	`ip_click` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '���������',
	`view` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '�����ʾ����',
	`click` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '���������',
	`add_date` DATE DEFAULT '0000-00-00' COMMENT '��淢������',
	`exp_date` DATE DEFAULT '0000-00-00' COMMENT '����ֹ����',
	`comment` Char(255) DEFAULT '' COMMENT '��ر�ע',
	INDEX (`idx`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��վ����';