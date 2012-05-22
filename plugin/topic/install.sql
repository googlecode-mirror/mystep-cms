# ����ר��
CREATE TABLE `{pre}topic` (
	`topic_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ר������',
	`topic_name` Char(60) NOT NULL COMMENT 'ר������',
	`topic_idx` Char(20) DEFAULT '' COMMENT 'ר������',
	`topic_image` Char(200) DEFAULT '' COMMENT 'ר��ͼʾ',
	`topic_link` Char(200) DEFAULT '' COMMENT 'ר������',
	`topic_cat` Char(200) DEFAULT '' COMMENT '���ӷ���',
	`topic_keyword` Char(255) DEFAULT '' COMMENT '���ӹؼ���',
	`topic_intro` TEXT COMMENT 'ר�����',
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '¼������',
	PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='����ר��';

# ---------------------------------------------------------------------------------------------------------------

# ����ר������
CREATE TABLE `{pre}topic_link` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '��������',
	`topic_id` SMALLINT UNSIGNED NOT NULL COMMENT 'ר������',
	`link_name` Char(100) DEFAULT '' COMMENT '��������',
	`link_url` Char(200) DEFAULT  '' UNIQUE COMMENT '���ӵ�ַ',
	`link_cat` TINYINT UNSIGNED COMMENT '���ӷ���',
	`link_order` TINYINT UNSIGNED COMMENT '��������',
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '�������',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='����ר������';