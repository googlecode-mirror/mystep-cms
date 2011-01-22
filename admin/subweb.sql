/*
MyStep ��վϵͳ���ݿ�ṹ
14:05 2010-12-23 By Windy2000
*/

# ---------------------------------------------------------------------------------------------------------------

Create DataBase if not exists {db_name};
use {db_name};

# ��������
CREATE TABLE if not exists `{pre}news_show` (
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
	`setop` TINYINT(3) UNSIGNED,												#�ö�ģʽ
	`pages` TINYINT UNSIGNED NOT NULL DEFAULT 1,				#����ҳ��
	`add_user` Char(20) NOT NULL,												#¼����
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#¼������
	INDEX (`add_date`),
	PRIMARY KEY (`news_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';

# ---------------------------------------------------------------------------------------------------------------

# ��������
CREATE TABLE if not exists `{pre}news_detail` (
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

# ����չʾ
CREATE TABLE if not exists `{pre}info_show` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT DEFAULT 1,												#������վ
	`subject` Char(100) NOT NULL,											#չʾ����
	`content` TEXT NOT NULL,													#չʾ����
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='����չʾ';

# ---------------------------------------------------------------------------------------------------------------

# ���Źؼ��֣����ڽ�������ͳ��������
CREATE TABLE if not exists `{pre}news_tag` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT DEFAULT 1,									#������վ
	`tag` Char(120) NOT NULL,										#�ؼ���
	`count` MEDIUMINT UNSIGNED DEFAULT 0,				#���ִ���
	`click` MEDIUMINT UNSIGNED DEFAULT 0,				#�������
	`add_date` Char(15) DEFAULT 0,							#�ؼ���������ڣ�unixtimestamp��
	`update_date` Char(15) DEFAULT 0,						#�ؼ��ָ������ڣ�unixtimestamp��
	INDEX (`count`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='���Źؼ���';

# ---------------------------------------------------------------------------------------------------------------

# ���Ÿ����������ϴ��ĸ������ڴ˱��¼��
CREATE TABLE if not exists `{pre}attachment` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`news_id` MEDIUMINT UNSIGNED,								#��������
	`web_id` TINYINT DEFAULT 1,									#������վ
	`file_name` Char(150) NOT NULL,							#�����ļ���
	`file_type` Char(40) NOT NULL,							#��������
	`file_size` MEDIUMINT UNSIGNED NOT NULL,		#������С
	`file_comment` Char(200) DEFAULT '',				#�ļ�˵��
	`file_time` Char(15) DEFAULT 0,							#�����ϴ�ʱ�䣨unixtimestamp��
	`file_count` MEDIUMINT UNSIGNED DEFAULT 0,	#�������ش���
	`tag` Char(120),														#�������
	`add_user` Char(20) NOT NULL,								#���������
	`watermark` BOOL NOT NULL DEFAULT 0,				#�Ƿ����ˮӡ
	INDEX (`news_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='���Ÿ���';

# ---------------------------------------------------------------------------------------------------------------

# �������ӱ�
CREATE TABLE if not exists `{pre}links` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT DEFAULT 1,									#������վ
	`link_name` Char(100) NOT NULL,							#��������
	`link_url` Char(100) NOT NULL,							#���ӵ�ַ
	`image` Char(100),													#����ͼ�Σ�����Ϊ�������ӣ���С�̶� 88 * 31��
	`level` TINYINT UNSIGNED DEFAULT 0,					#��ʾ����0 Ϊ����ʾ��
	INDEX (`level`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='�������ӱ�';

# ---------------------------------------------------------------------------------------------------------------

# ����ͳ��
CREATE TABLE if not exists `{idx}_counter` (
	`date` DATE NOT NULL UNIQUE,											#ͳ������
	`pv` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,				#ҳ�������
	`iv` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,				#IP ������
	`online` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,		#�����������
	PRIMARY KEY (`date`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='�򵥷���ͳ��';

# ---------------------------------------------------------------------------------------------------------------
