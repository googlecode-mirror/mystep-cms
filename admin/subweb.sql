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
	`cat_id` SMALLINT UNSIGNED NOT NULL,								#������������
	`web_id` TINYINT DEFAULT 0,													#������վ
	`subject` Char(120) NOT NULL,												#���ű���
	`style` Char(40) NOT NULL,													#������ʽ
	`views` MEDIUMINT UNSIGNED DEFAULT 0,								#�������
	`describe` Char(255) DEFAULT '',										#��������
	`original` Char(40) NOT NULL DEFAULT '',						#����/����
	`link` Char(255) DEFAULT '',												#��ת��ַ
	`tag` Char(120) NOT NULL DEFAULT '',								#�������
	`image` Char(100) NOT NULL DEFAULT '',							#���ͼƬ
	`setop` SMALLINT UNSIGNED,													#�ö�ģʽ
	`pages` TINYINT UNSIGNED NOT NULL DEFAULT 1,				#����ҳ��
	`add_user` Char(20) NOT NULL,												#¼����
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#¼������
	INDEX `catalog` (`web_id`, `cat_id`),
	PRIMARY KEY (`news_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';

# ---------------------------------------------------------------------------------------------------------------

# ��������
CREATE TABLE `{pre}news_detail` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`cat_id` SMALLINT UNSIGNED NOT NULL,							#������������
	`news_id` MEDIUMINT UNSIGNED NOT NULL,						#��������
	`page` TINYINT UNSIGNED DEFAULT 1,								#��ҳ����
	`sub_title` Char(100) DEFAULT '',									#�ӱ���
	`ctype` TINYINT UNSIGNED DEFAULT 1,								#��������(ubb, html)
	`content` TEXT NOT NULL,													#��������
	INDEX (`news_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';

# ---------------------------------------------------------------------------------------------------------------

# ���Źؼ��֣����ڽ�������ͳ��������
CREATE TABLE `{pre}news_tag` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`tag` Char(120) NOT NULL,										#�ؼ���
	`count` MEDIUMINT UNSIGNED DEFAULT 0,				#���ִ���
	`click` MEDIUMINT UNSIGNED DEFAULT 0,				#�������
	`add_date` Char(15) DEFAULT 0,							#�ؼ���������ڣ�unixtimestamp��
	`update_date` Char(15) DEFAULT 0,						#�ؼ��ָ������ڣ�unixtimestamp��
	INDEX (`count`),
	INDEX (`click`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='���Źؼ���';

# ---------------------------------------------------------------------------------------------------------------
