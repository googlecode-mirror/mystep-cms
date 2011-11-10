# ����ר��
CREATE TABLE `{pre}topic` (
	`topic_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,		#ר������
	`topic_name` Char(60) NOT NULL,													#ר������
	`topic_idx` Char(20) DEFAULT '',												#ר������
	`topic_image` Char(200) DEFAULT '',											#ר��ͼʾ
	`topic_link` Char(200) DEFAULT '',											#ר������
	`topic_cat` Char(200) DEFAULT '',												#���ӷ���
	`topic_intro` TEXT,																			#ר�����
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',			#¼������
	PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='����ר��';

# ---------------------------------------------------------------------------------------------------------------

# ����ר������
CREATE TABLE `{pre}topic_link` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,					#��������
	`topic_id` SMALLINT UNSIGNED NOT NULL,									#ר������
	`link_name` Char(100) DEFAULT '',												#��������
	`link_url` Char(200) DEFAULT '',												#���ӵ�ַ
	`link_cat` TINYINT UNSIGNED,														#���ӷ���
	`link_order` TINYINT UNSIGNED,													#��������
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',			#�������
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='����ר������';