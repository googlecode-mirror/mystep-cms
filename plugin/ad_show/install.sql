# ��վ����
CREATE TABLE `{pre}ad_show` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(20) NOT NULL,											#����������
	`ad_client` Char(100) NOT NULL,								#�ͻ�����
	`ad_url` Char(100),														#�������
	`ad_mode` TINYINT(3) UNSIGNED DEFAULT 1,			#������ͣ�image��flash��html��js��
	`ad_file` Char(100),													#����ļ�
	`ad_text` Char(100),													#��ʾ����
	`ad_level` TINYINT UNSIGNED DEFAULT 0,				#��ʾ����
	`ip_view` MEDIUMINT UNSIGNED DEFAULT 0,				#����������
	`ip_click` MEDIUMINT UNSIGNED DEFAULT 0,			#���������
	`view` MEDIUMINT UNSIGNED DEFAULT 0,					#�����ʾ����
	`click` MEDIUMINT UNSIGNED DEFAULT 0,					#���������
	`add_date` DATE DEFAULT '0000-00-00',					#��淢������
	`exp_date` DATE DEFAULT '0000-00-00',					#����ֹ����
	`comment` Char(255) DEFAULT '',								#��ر�ע
	INDEX (`idx`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��վ����';