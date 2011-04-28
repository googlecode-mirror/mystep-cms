/*
MyStep ��վϵͳ���ݿ�ṹ
14:05 2010-12-23 By Windy2000
*/

# ---------------------------------------------------------------------------------------------------------------

drop DataBase if exists {db_name};
Create DataBase if not exists {db_name} default charset {charset} COLLATE {charset_collate};
use {db_name};

# ��վ�б�
CREATE TABLE `{pre}website` (
	`web_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,			#��վ����
	`name` Char(40) DEFAULT '' NOT NULL,										#��վ����
	`idx` Char(20) DEFAULT '' NOT NULL,											#�ַ�����������������Ŀ¼��
	`host` Char(30) DEFAULT '' NOT NULL,										#��վ����
	PRIMARY KEY (`web_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��վ�б�';

INSERT INTO `{pre}website` VALUES (1, 'MyStep', 'main', '{host}');
# ---------------------------------------------------------------------------------------------------------------

# ����Ŀ¼
CREATE TABLE `{pre}admin_cat` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,					#Ŀ¼����
	`pid` SMALLINT UNSIGNED DEFAULT 0,											#��Ŀ¼����
	`name` Char(40) DEFAULT '' NOT NULL,										#Ŀ¼����
	`file` Char(30) DEFAULT '' NOT NULL,										#�����ļ�
	`path` Char(100) DEFAULT '' NOT NULL,										#�����ļ�·��
	`web_id` TINYINT UNSIGNED DEFAULT 0,										#������վ
	`order` TINYINT UNSIGNED DEFAULT 0,											#��ʾ˳��
	`comment` Char(255) DEFAULT '' NOT NULL,								#Ŀ¼˵��
	INDEX `order` (`order`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='����Ŀ¼';

INSERT INTO `{pre}admin_cat` VALUES 
		(1, 0, '��ҳ', '###', '', 0, 0, '������ҳ'),
		(2, 0, '�û�', '###', '', 0, 0, '�û�����'),
		(3, 0, '����', '###', '', 0, 0, '��վ����'),
		(4, 0, '����', '###', '', 0, 0, '���ݹ���'),
		(5, 0, '��Ϣ', '###', '', 0, 0, 'վ����Ϣ'),
		(6, 0, '����', '###', '', 0, 0, '��վ����'),
		(7, 0, '��չ', '###', '', 0, 0, '��չ����'),

		(0, 1, '��վ��Ϣ', 'info.php', '', 0, 0, '��վ��Ϣ'),
		(0, 1, '��������Ϣ', 'info.php?server', '', 0, 0, '��������Ϣ'),
		(0, 1, 'MySQL ��Ϣ', 'info.php?mysql', '', 0, 0, 'MySQL ��Ϣ'),
		(0, 1, 'PHP ��Ϣ', 'info.php?php', '', 0, 0, 'PHP ��Ϣ'),
		(0, 1, 'phpinfo()', 'info.php?phpinfo', '', 0, 0, 'phpinfo()'),
		
		(0, 2, '�����û�', 'user_online.php', '', 0, 0, '�����û�'),
		(0, 2, '�û�����', 'user_detail.php', '', 0, 0, '�û�����'),
		(0, 2, '�û�����', 'user_type.php', '', 0, 0, '�û�����ά��'),
		(0, 2, '�û�Ⱥ��', 'user_group.php', '', 0, 0, '�û���Ⱥά��'),
		(0, 2, '�û�Ȩ��', 'user_power.php', '', 0, 0, '�û�Ȩ��ά��'),
		
		(0, 3, '��������', 'func_attach.php', '', 0, 0, '��������'),
		(0, 3, '��������', 'func_link.php', '', 0, 0, '�������ӹ���'),
		(0, 3, '��վ����', 'web_subweb.php', '', 255, 0, '��վ����'),
		(0, 3, '���ݱ���', 'func_backup.php', '', 0, 0, '���ݱ���'),
		
		(0, 4, '���·���', 'art_catalog.php', '', 255, 0, '���·������'),
		(0, 4, '��������', 'art_content.php', '', 255, 0, '�������ݹ���'),
		(0, 4, '���±�ǩ', 'art_tag.php', '', 255, 0, '���±�ǩ����'),
		(0, 4, '����ͼʾ', 'art_image.php', '', 255, 0, '����ͼʾ����'),
		(0, 4, '����չʾ', 'art_info.php', '', 255, 0, 'չʾ���ݹ���'),
		
		(0, 5, '������־', 'info_log.php', '', 0, 0, '������־'),
		(0, 5, '����쿴', 'info_err.php', '', 0, 0, '����쿴'),
		(0, 5, '����ͳ��', 'info_count.php', '', 0, 0, '����վ����ͳ��'),
		
		(0, 6, '�����趨', 'web_setting.php', '', 0, 0, '�����趨'),
		(0, 6, '�������', 'web_cache.php', '', 0, 0, '��վ����'),
		(0, 6, '���Թ���', 'web_language.php', '', 0, 0, '���Թ���'),
		(0, 6, 'ģ�����', 'web_template.php', '', 0, 0, 'ģ�����'),
		
		(0, 7, '�������', 'web_plugin.php', '', 0, 0, '�������');
# ---------------------------------------------------------------------------------------------------------------

# ��վ���
CREATE TABLE `{pre}plugin` (
	`id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,					#�������
	`name` Char(40) DEFAULT '' NOT NULL,										#�������
	`idx` Char(20) DEFAULT '' NOT NULL,											#���������Ŀ¼����
	`ver` Char(20) DEFAULT '' NOT NULL,											#����汾
	`class` Char(20) DEFAULT '' NOT NULL,										#�����
	`active` BOOL NOT NULL DEFAULT 0,												#�Ƿ�����
	`intro` Char(255) DEFAULT '' NOT NULL,									#�����Ϣ
	`copyright` Char(255) DEFAULT '' NOT NULL,							#��Ȩ��Ϣ
	`order` TINYINT UNSIGNED,																#ִ��˳��
	INDEX `order` (`order`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��վ���';

INSERT INTO `{pre}plugin` VALUES (0, "�ٷ����", "offical", "1.0", "plugin_offical", 1, "Offical Plugin Show, you may treat it as an example.", "Copyright 2010 Windy2000");

# ---------------------------------------------------------------------------------------------------------------

# ���ŷ���
CREATE TABLE `{pre}news_cat` (
	`cat_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,			#��������
	`web_id` TINYINT UNSIGNED DEFAULT 0,										#������վ
	`cat_main` SMALLINT UNSIGNED NOT NULL DEFAULT 0,				#����������
	`cat_name` Char(40) NOT NULL,														#��������
	`cat_comment` Char(200) NOT NULL,												#��������
	`cat_idx` Char(20) DEFAULT '',													#��������������Ŀ¼���ȣ�
	`cat_image` Char(200) DEFAULT '',												#����ͼʾ
	`cat_sub` Char(240) DEFAULT '',													#ǰ׺�б���Ƕ��ż����
	`cat_order` TINYINT DEFAULT 1,													#��������
	`cat_type` TINYINT NOT NULL,														#������ʾģʽ��0 �����б�1 ͼƬ��飬2 ͼƬչʾ��
	`cat_link` Char(200) DEFAULT '',												#��������
	`cat_layer` TINYINT UNSIGNED NOT NULL DEFAULT 0,				#����㼶
	`cat_show` TINYINT UNSIGNED NOT NULL DEFAULT 0,					#��ʾλ�ã�0 ����ʾ���Զ�����ģʽ���䣩
	PRIMARY KEY (`cat_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='���ŷ���';

INSERT INTO `{pre}news_cat` VALUES
		(0, 1, 0, '��վͨ��', '��վͨ��', 'notice', '', '', 0, 0, '', 1, 0),
		(0, 1, 0, '������Ѷ', '������Ѷ ʱ�±��� �������� ��������', 'news', '', 'ʱ��,����,����,����', 1, 0, '', 1, 255);
# ---------------------------------------------------------------------------------------------------------------

# ��������
CREATE TABLE `{pre}news_show` (
	`news_id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`cat_id` SMALLINT UNSIGNED NOT NULL,								#������������
	`web_id` TINYINT UNSIGNED DEFAULT 0,								#������վ
	`subject` Char(150) NOT NULL,												#���ű���
	`style` Char(40) NOT NULL,													#������ʽ
	`views` MEDIUMINT UNSIGNED DEFAULT 0,								#�������
	`describe` Char(255) DEFAULT '',										#��������
	`original` Char(40) NOT NULL DEFAULT '',						#����/����
	`link` Char(255) DEFAULT '',												#��ת��ַ
	`tag` Char(120) NOT NULL DEFAULT '',								#�������
	`image` Char(200) NOT NULL DEFAULT '',							#���ͼƬ
	`setop` SMALLINT UNSIGNED,													#����ģʽ
	`order` TINYINT UNSIGNED,														#�б�����
	`view_lvl` Char(10) NOT NULL DEFAULT '0',						#�Ķ�Ȩ��
	`pages` TINYINT UNSIGNED NOT NULL DEFAULT 1,				#����ҳ��
	`add_user` Char(20) NOT NULL,												#¼����
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#¼������
	INDEX `catalog` (`web_id`, `cat_id`),
	INDEX `order` (`order`, `news_id`),
	PRIMARY KEY (`news_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';

# ---------------------------------------------------------------------------------------------------------------

# ��������
CREATE TABLE `{pre}news_detail` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`news_id` MEDIUMINT UNSIGNED NOT NULL,						#��������
	`cat_id` SMALLINT UNSIGNED NOT NULL,							#������������
	`page` TINYINT UNSIGNED DEFAULT 1,								#��ҳ����
	`sub_title` Char(100) DEFAULT '',									#�ӱ���
	`ctype` TINYINT UNSIGNED DEFAULT 1,								#��������(ubb, html)
	`content` MEDIUMTEXT NOT NULL,										#��������
	INDEX (`news_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';

# ---------------------------------------------------------------------------------------------------------------

# ����չʾ
CREATE TABLE `{pre}info_show` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0,							#������վ
	`subject` Char(100) NOT NULL,											#չʾ����
	`attach_list` Char(255) default '',								#��ظ���
	`content` MEDIUMTEXT NOT NULL,										#չʾ����
	INDEX (`web_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='����չʾ';

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

# ���Ÿ����������ϴ��ĸ������ڴ˱��¼��
CREATE TABLE `{pre}attachment` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0,				#������վ
	`news_id` MEDIUMINT UNSIGNED,								#��������
	`file_name` Char(150) NOT NULL,							#�����ļ���
	`file_type` Char(40) NOT NULL,							#��������
	`file_size` INT UNSIGNED NOT NULL,					#������С
	`file_comment` Char(200) DEFAULT '',				#�ļ�˵��
	`file_time` Char(15) DEFAULT 0,							#�����ϴ�ʱ�䣨unixtimestamp��
	`file_count` MEDIUMINT UNSIGNED DEFAULT 0,	#�������ش���
	`tag` Char(120),														#�������
	`add_user` Char(20) NOT NULL,								#���������
	`watermark` BOOL NOT NULL DEFAULT 0,				#�Ƿ����ˮӡ
	INDEX (`web_id`, `news_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='���Ÿ���';

# ---------------------------------------------------------------------------------------------------------------

# �������ӱ�
CREATE TABLE `{pre}links` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(20) DEFAULT '' NOT NULL,					#�ַ�����
	`link_name` Char(100) NOT NULL,							#��������
	`link_url` Char(100) NOT NULL,							#���ӵ�ַ
	`image` Char(100),													#����ͼ�Σ�����Ϊ�������ӣ�
	`level` TINYINT UNSIGNED DEFAULT 0,					#��ʾ����0 Ϊ����ʾ��
	INDEX (`idx`),
	INDEX (`level`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='�������ӱ�';

# ---------------------------------------------------------------------------------------------------------------

# �û���
CREATE TABLE `{pre}user_group` (
	`group_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`group_name` Char(20) NOT NULL UNIQUE,					#�û�������
	`power_func` Char(255) NOT NULL,								#����Ȩ��
	`power_cat` Char(255) NOT NULL,									#��ĿȨ��
	`power_web` Char(255) NOT NULL,									#��վȨ��
	PRIMARY KEY (`group_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='�û���';

INSERT INTO `{pre}user_group` VALUES (0, '����Ա', 'all', 'all', 'all');

# ---------------------------------------------------------------------------------------------------------------

# �û���
CREATE TABLE `{pre}user_type` (
	`type_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`type_name` Char(20) NOT NULL UNIQUE,					#�û�������
	PRIMARY KEY (`type_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='�û���';

INSERT INTO `{pre}user_type` VALUES (1, 'һ��ÿ�');
INSERT INTO `{pre}user_type` VALUES (2, '��ͨ�û�');
INSERT INTO `{pre}user_type` VALUES (3, '�߼��û�');

# ---------------------------------------------------------------------------------------------------------------

# ��Ա��Ȩ��
CREATE TABLE `{pre}user_power` (
	`power_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(20) NOT NULL UNIQUE,									#Ȩ������
	`name` Char(40) NOT NULL UNIQUE,								#Ȩ������
	`value` Char(255) NOT NULL,											#Ȩ��Ĭ��ֵ
	`format` Char(20) NOT NULL,											#Ҫ���ʽ
	`comment` Char(255),														#Ȩ������
	PRIMARY KEY (`power_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��Ա��Ȩ��';

INSERT INTO `{pre}user_power` VALUES (0, 'view_lvl', '�Ķ�Ȩ��', '0', 'digital', '���������Ķ�ʱ��Ȩ���ж�');
alter table `{pre}user_type` add `view_lvl` Char(10) NOT NULL DEFAULT '0';
update `{pre}user_type` set `view_lvl`='1' where `type_id`=2;
update `{pre}user_type` set `view_lvl`='5' where `type_id`=3;

# ---------------------------------------------------------------------------------------------------------------

# ��վ�û�
CREATE TABLE `{pre}users` (
	`user_id` mediumint(8) unsigned auto_increment,
	`group_id` TINYINT UNSIGNED NOT NULL Default 0,	#�û���
	`type_id` TINYINT UNSIGNED NOT NULL Default 1,	#�û���
	`username` varchar(15) UNIQUE,									#�û���
	`password` varchar(40) ,												#����
	`email` varchar(60) ,														#�����ʼ�
	`regdate` int(10) unsigned Default "0" ,				#ע������
	INDEX (`username`),
	PRIMARY KEY (`user_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��վ�û�';

# ---------------------------------------------------------------------------------------------------------------

# ��վ��ǰ�����
CREATE TABLE `{pre}user_online` (
	`sid` char(32) NOT NULL,														#SessionID
	`ip` Char(50) NOT NULL,															#ip��ַ
	`username` Char(40) NOT NULL DEFAULT 'guest',				#�û�����
	`usertype` TINYINT UNSIGNED NOT NULL DEFAULT 0,			#�û�����
	`usergroup` TINYINT UNSIGNED NOT NULL DEFAULT 0,		#�û���
	`reflash` Char(15) DEFAULT 0,												#���ˢ��ʱ�䣨unixtimestamp��
	`url` Char(150),																		#��ǰ����ҳ��
	PRIMARY KEY (`sid`)
) TYPE=HEAP DEFAULT CHARSET={charset} COMMENT='��վ��ǰ�����';

# ---------------------------------------------------------------------------------------------------------------

# ά����־
CREATE TABLE `{pre}modify_log` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user` Char(40) NOT NULL,									#����Ա����
	`group` Char(40) NOT NULL,								#����Ա����
	`time` Char(15) DEFAULT 0,								#����ʱ�䣨unixtimestamp��
	`link` Char(200),													#����ҳ��
	`comment` Char(100) DEFAULT '',					  #���±�ע
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��վά����־';

# ---------------------------------------------------------------------------------------------------------------

# ����ͳ��
CREATE TABLE `{pre}counter` (
	`date` DATE NOT NULL UNIQUE,											#ͳ������
	`pv` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,				#ҳ�������
	`iv` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,				#IP ������
	`online` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,		#�����������
	PRIMARY KEY (`date`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='�򵥷���ͳ��';

# ---------------------------------------------------------------------------------------------------------------

# ����ͼʾ
CREATE TABLE `{pre}news_image` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0,							#������վ
	`name` Char(40) NOT NULL DEFAULT '',							#����
	`image` Char(150) NOT NULL DEFAULT '',						#ͼƬ
	`keyword` Char(150) NOT NULL DEFAULT '',					#�ؼ���
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='����ͼʾ';

# ---------------------------------------------------------------------------------------------------------------
