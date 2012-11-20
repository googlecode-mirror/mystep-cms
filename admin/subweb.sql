/*
MyStep ��վϵͳ���ݿ�ṹ
14:05 2010-12-23 By Windy2000
*/

# ---------------------------------------------------------------------------------------------------------------

Create DataBase if not exists {db_name};
use {db_name};

# ��������
CREATE TABLE `{pre}news_show` (
	`news_id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`cat_id` SMALLINT UNSIGNED NOT NULL COMMENT '������������',
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '������վ',
	`subject` Char(200) NOT NULL COMMENT '���ű���',
	`style` Char(40) NOT NULL COMMENT '������ʽ',
	`views` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '�������',
	`describe` Char(255) DEFAULT '' COMMENT '��������',
	`original` Char(40) NOT NULL DEFAULT '' COMMENT '����/����',
	`link` Char(255) DEFAULT '' COMMENT '��ת��ַ',
	`tag` Char(120) NOT NULL DEFAULT '' COMMENT '�������',
	`image` Char(200) NOT NULL DEFAULT '' COMMENT '���ͼƬ',
	`setop` SMALLINT UNSIGNED COMMENT '����ģʽ',
	`order` TINYINT UNSIGNED COMMENT '�б�����',
	`view_lvl` Char(10) NOT NULL DEFAULT '0' COMMENT '�Ķ�Ȩ��',
	`pages` TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '����ҳ��',
	`add_user` Char(20) NOT NULL COMMENT '¼����',
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT '¼������',
	`notice` Char(255) DEFAULT '' COMMENT '������ʾ',
	`expire` DATE COMMENT '����ʱ��',
	INDEX `catalog` (`web_id`, `cat_id`),
	INDEX `order` (`order`, `news_id`),
	PRIMARY KEY (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';

# ---------------------------------------------------------------------------------------------------------------

# ��������
CREATE TABLE `{pre}news_detail` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`news_id` MEDIUMINT UNSIGNED NOT NULL COMMENT '��������',
	`cat_id` SMALLINT UNSIGNED NOT NULL COMMENT '������������',
	`page` TINYINT UNSIGNED DEFAULT 1 COMMENT '��ҳ����',
	`sub_title` Char(200) DEFAULT '' COMMENT '�ӱ���',
	`content` MEDIUMTEXT NOT NULL COMMENT '��������',
	INDEX (`news_id`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';

# ---------------------------------------------------------------------------------------------------------------

# ���Źؼ��֣����ڽ�������ͳ��������
CREATE TABLE `{pre}news_tag` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`tag` Char(120) NOT NULL COMMENT '�ؼ���',
	`count` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '���ִ���',
	`click` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '�������',
	`add_date` Char(15) DEFAULT 0 COMMENT '�ؼ���������ڣ�unixtimestamp��',
	`update_date` Char(15) DEFAULT 0 COMMENT '�ؼ��ָ������ڣ�unixtimestamp��',
	INDEX (`count`),
	INDEX (`click`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='���Źؼ���';

# ---------------------------------------------------------------------------------------------------------------
