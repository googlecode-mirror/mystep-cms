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
	`web_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '��վ����',
	`name` Char(200) DEFAULT '' NOT NULL COMMENT '��վ����',
	`idx` Char(20) DEFAULT '' NOT NULL COMMENT '�ַ�����������������Ŀ¼��',
	`host` Char(30) DEFAULT '' NOT NULL COMMENT '��վ����',
	PRIMARY KEY (`web_id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��վ�б�';

INSERT INTO `{pre}website` VALUES (1, '{web_name}', 'main', '{host}');
# ---------------------------------------------------------------------------------------------------------------

# ����Ŀ¼
CREATE TABLE `{pre}admin_cat` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Ŀ¼����',
	`pid` SMALLINT UNSIGNED DEFAULT 0 COMMENT '��Ŀ¼����',
	`name` Char(40) DEFAULT '' NOT NULL COMMENT 'Ŀ¼����',
	`file` Char(50) DEFAULT '' NOT NULL COMMENT '�����ļ�',
	`path` Char(100) DEFAULT '' NOT NULL COMMENT '�����ļ�·��',
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '������վ',
	`order` TINYINT UNSIGNED DEFAULT 0 COMMENT '��ʾ˳��',
	`comment` Char(255) DEFAULT '' NOT NULL COMMENT 'Ŀ¼˵��',
	INDEX `order` (`order`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='����Ŀ¼';

INSERT INTO `{pre}admin_cat` VALUES 
		(1, 0, '��ҳ', '###', '', 0, 9, '������ҳ'),
		(2, 0, '�û�', '###', '', 0, 6, '�û�����'),
		(3, 0, '����', '###', '', 0, 5, '��վ����'),
		(4, 0, '����', '###', '', 0, 8, '���ݹ���'),
		(5, 0, '��Ϣ', '###', '', 0, 7, 'վ����Ϣ'),
		(6, 0, '����', '###', '', 0, 4, '��վ����'),
		(7, 0, '��չ', '###', '', 0, 3, '��չ����'),

		(0, 1, '��վ��Ϣ', 'info.php', '', 0, 0, '��վ��Ϣ'),
		(0, 1, '��������Ϣ', 'info.php?server', '', 0, 0, '��������Ϣ'),
		(0, 1, 'MySQL ��Ϣ', 'info.php?mysql', '', 0, 0, 'MySQL ��Ϣ'),
		(0, 1, 'PHP ��Ϣ', 'info.php?php', '', 0, 0, 'PHP ��Ϣ'),
		(0, 1, 'phpinfo()', 'info.php?phpinfo', '', 0, 0, 'phpinfo()'),
		
		(0, 2, '�����û�', 'user_online.php', '', 0, 0, '�����û�'),
		(0, 2, '�û�����', 'user_detail.php', '', 0, 0, '�û�����'),
		(0, 2, '�û�����', 'user_type.php', '', 0, 0, '�û�����ά��'),
		(0, 2, '����Ⱥ��', 'user_group.php', '', 0, 0, '����Ⱥ��ά��'),
		(0, 2, '�û�Ȩ��', 'user_power.php', '', 0, 0, '�û�Ȩ��ά��'),
		
		(0, 3, '��������', 'func_attach.php', '', 0, 0, '��������'),
		(0, 3, '��������', 'func_link.php', '', 255, 0, '�������ӹ���'),
		(0, 3, '����ά��', 'func_backup.php', '', 0, 0, '����ά��'),
		(0, 3, '��ַ��д', 'web_rewrite.php', '', 0, 0, 'URL Rewrite �������'),
		
		(0, 4, '���·���', 'art_catalog.php', '', 255, 0, '���·������'),
		(0, 4, '��������', 'art_content.php', '', 255, 0, '�������ݹ���'),
		(0, 4, '���±�ǩ', 'art_tag.php', '', 255, 0, '���±�ǩ����'),
		(0, 4, '����ͼʾ', 'art_image.php', '', 255, 0, '����ͼʾ����'),
		(0, 4, '����չʾ', 'art_info.php', '', 255, 0, 'չʾ���ݹ���'),
		
		(0, 5, '������־', 'info_log.php', '', 0, 0, '������־'),
		(0, 5, '����쿴', 'info_err.php', '', 0, 0, '����쿴'),
		(0, 5, '����ͳ��', 'info_count.php', '', 0, 0, '����վ����ͳ��'),
		
		(0, 6, '�����趨', 'web_setting.php', '', 0, 0, '�����趨'),
		(0, 6, '��վ����', 'web_subweb.php', '', 255, 0, '��վ����'),
		(0, 6, '�������', 'web_cache.php', '', 0, 0, '��վ����'),
		(0, 6, '���Թ���', 'web_language.php', '', 0, 0, '���Թ���'),
		(0, 6, 'ģ�����', 'web_template.php', '', 0, 0, 'ģ�����'),
		
		(0, 7, '�������', 'web_plugin.php', '', 0, 0, '�������');
# ---------------------------------------------------------------------------------------------------------------

# ��վ���
CREATE TABLE `{pre}plugin` (
	`id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '�������',
	`name` Char(40) DEFAULT '' NOT NULL COMMENT '�������',
	`idx` Char(20) DEFAULT '' NOT NULL COMMENT '���������Ŀ¼����',
	`ver` Char(20) DEFAULT '' NOT NULL COMMENT '����汾',
	`class` Char(40) DEFAULT '' NOT NULL COMMENT '�����',
	`active` BOOL NOT NULL DEFAULT 0 COMMENT '�Ƿ�����',
	`intro` Char(255) DEFAULT '' NOT NULL COMMENT '�����Ϣ',
	`copyright` Char(255) DEFAULT '' NOT NULL COMMENT '��Ȩ��Ϣ',
	`order` TINYINT UNSIGNED COMMENT 'ִ��˳��',
	`subweb` Char(255) DEFAULT '' NOT NULL COMMENT '��վȨ��',
	INDEX `order` (`order`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��վ���';

INSERT INTO `{pre}plugin` VALUES (0, "�ٷ����", "offical", "1.0", "plugin_offical", 1, "Offical Plugin Show, you may treat it as an example.", "Copyright 2010 Windy2000", 1, '');

# ---------------------------------------------------------------------------------------------------------------

# ���ŷ���
CREATE TABLE `{pre}news_cat` (
	`cat_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '��������',
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '������վ',
	`cat_main` SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '����������',
	`cat_name` Char(40) NOT NULL COMMENT '��������',
	`cat_keyword` Char(100) NOT NULL COMMENT '����ؼ���',
	`cat_comment` Char(255) NOT NULL COMMENT '��������',
	`cat_idx` Char(20) DEFAULT '' COMMENT '��������������Ŀ¼���ȣ�',
	`cat_image` Char(200) DEFAULT '' COMMENT '����ͼʾ',
	`cat_sub` Char(240) DEFAULT '' COMMENT 'ǰ׺�б���Ƕ��ż����',
	`cat_order` SMALLINT UNSIGNED DEFAULT 1 COMMENT '��������',
	`cat_type` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '������ʾģʽ��0 �����б�1 ͼƬ��飬2 ͼƬչʾ��',
	`cat_link` Char(200) DEFAULT '' COMMENT '��������',
	`cat_layer` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '����㼶',
	`cat_show` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '��ʾλ�ã�0 ����ʾ���Զ�����ģʽ���䣩',
	`view_lvl` Char(10) NOT NULL DEFAULT '0' COMMENT '�Ķ�Ȩ��',
	`notice` Char(255) DEFAULT '' COMMENT '������ʾ',
	PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='���ŷ���';

INSERT INTO `{pre}news_cat` VALUES (0, 1, 0, '������Ѷ', '����,����,����,�ƾ�,IT,����,����,Ů��', '������Ѷ ʱ�±��� �������� ��������', 'news', '', 'ʱ��,����,����,����', 1, 0, '', 1, 255, 0, '');
# ---------------------------------------------------------------------------------------------------------------

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

# ����չʾ
CREATE TABLE `{pre}info_show` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '������վ',
	`subject` Char(100) NOT NULL COMMENT 'չʾ����',
	`attach_list` Char(255) default '' COMMENT '��ظ���',
	`content` MEDIUMTEXT NOT NULL COMMENT 'չʾ����',
	INDEX (`web_id`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='����չʾ';
INSERT INTO `{pre}info_show` VALUES (0, 1, 'copyright', '', '<p style="text-align: center;">&copy;2010-2012&nbsp;www.mysteps.cn</p>');
INSERT INTO `{pre}info_show` VALUES (0, 1, 'contact', '', '<p>QQ��18509608</p><p>MSN��windy2000_sk@msn.com</p><p>Email��windy2006@gmail.com</p>');

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

# ���Ÿ����������ϴ��ĸ������ڴ˱��¼��
CREATE TABLE `{pre}attachment` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '������վ',
	`news_id` MEDIUMINT UNSIGNED COMMENT '��������',
	`file_name` Char(150) NOT NULL COMMENT '�����ļ���',
	`file_type` Char(80) NOT NULL COMMENT '��������',
	`file_size` INT UNSIGNED NOT NULL COMMENT '������С',
	`file_comment` Char(200) DEFAULT '' COMMENT '�ļ�˵��',
	`file_time` Char(15) DEFAULT 0 COMMENT '�����ϴ�ʱ�䣨unixtimestamp��',
	`file_count` MEDIUMINT UNSIGNED DEFAULT 0 COMMENT '�������ش���',
	`tag` Char(120) COMMENT '�������',
	`add_user` Char(20) NOT NULL COMMENT '���������',
	`watermark` BOOL NOT NULL DEFAULT 0 COMMENT '�Ƿ����ˮӡ',
	INDEX (`web_id`, `news_id`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='���Ÿ���';

# ---------------------------------------------------------------------------------------------------------------

# �������ӱ�
CREATE TABLE `{pre}links` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '������վ',
	`idx` Char(20) DEFAULT '' NOT NULL COMMENT '�ַ�����',
	`link_name` Char(100) NOT NULL COMMENT '��������',
	`link_url` Char(100) NOT NULL COMMENT '���ӵ�ַ',
	`image` Char(100) COMMENT '����ͼ�Σ�����Ϊ�������ӣ�',
	`level` TINYINT UNSIGNED DEFAULT 0 COMMENT '��ʾ����0 Ϊ����ʾ��',
	INDEX (`idx`),
	INDEX (`level`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='�������ӱ�';

# ---------------------------------------------------------------------------------------------------------------

# �û���
CREATE TABLE `{pre}user_group` (
	`group_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`group_name` Char(20) NOT NULL UNIQUE COMMENT '�û�������',
	`power_func` Char(255) NOT NULL COMMENT '����Ȩ��',
	`power_cat` Char(255) NOT NULL COMMENT '��ĿȨ��',
	`power_web` Char(255) NOT NULL COMMENT '��վȨ��',
	PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='�û���';

INSERT INTO `{pre}user_group` VALUES (0, '����Ա', 'all', 'all', 'all');

# ---------------------------------------------------------------------------------------------------------------

# �û���
CREATE TABLE `{pre}user_type` (
	`type_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`type_name` Char(20) NOT NULL UNIQUE COMMENT '�û�������',
	PRIMARY KEY (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='�û���';

INSERT INTO `{pre}user_type` VALUES (1, 'һ��ÿ�');
INSERT INTO `{pre}user_type` VALUES (2, '��ͨ�û�');
INSERT INTO `{pre}user_type` VALUES (3, '�߼��û�');

# ---------------------------------------------------------------------------------------------------------------

# ��Ա��Ȩ��
CREATE TABLE `{pre}user_power` (
	`power_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(20) NOT NULL UNIQUE COMMENT 'Ȩ������',
	`name` Char(40) NOT NULL UNIQUE COMMENT 'Ȩ������',
	`value` Char(255) NOT NULL COMMENT 'Ȩ��Ĭ��ֵ',
	`format` Char(20) NOT NULL COMMENT 'Ҫ���ʽ',
	`comment` Char(255) COMMENT 'Ȩ������',
	PRIMARY KEY (`power_id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��Ա��Ȩ��';

INSERT INTO `{pre}user_power` VALUES (0, 'view_lvl', '�Ķ�Ȩ��', '0', 'digital', '���������Ķ�ʱ��Ȩ���ж�');
alter table `{pre}user_type` add `view_lvl` Char(10) NOT NULL DEFAULT '0';
update `{pre}user_type` set `view_lvl`='1' where `type_id`=2;
update `{pre}user_type` set `view_lvl`='5' where `type_id`=3;

# ---------------------------------------------------------------------------------------------------------------

# ��վ�û�
CREATE TABLE `{pre}users` (
	`user_id` mediumint(8) unsigned auto_increment,
	`group_id` TINYINT UNSIGNED NOT NULL Default 0 COMMENT '�û���',
	`type_id` TINYINT UNSIGNED NOT NULL Default 1 COMMENT '�û���',
	`username` varchar(15) UNIQUE COMMENT '�û���',
	`password` varchar(40)  COMMENT '����',
	`email` varchar(60)  COMMENT '�����ʼ�',
	`regdate` int(10) unsigned Default "0"  COMMENT 'ע������',
	INDEX (`username`),
	PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��վ�û�';

# ---------------------------------------------------------------------------------------------------------------

# ��վ��ǰ�����
CREATE TABLE `{pre}user_online` (
	`sid` char(32) NOT NULL COMMENT 'SessionID',
	`ip` Char(50) NOT NULL COMMENT 'ip��ַ',
	`username` Char(40) NOT NULL DEFAULT 'guest' COMMENT '�û�����',
	`usertype` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '�û�����',
	`usergroup` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '�û���',
	`reflash` Char(15) DEFAULT 0 COMMENT '���ˢ��ʱ�䣨unixtimestamp��',
	`url` Char(150) COMMENT '��ǰ����ҳ��',
	PRIMARY KEY (`sid`)
) ENGINE=HEAP DEFAULT CHARSET={charset} COMMENT='��վ��ǰ�����';

# ---------------------------------------------------------------------------------------------------------------

# ά����־
CREATE TABLE `{pre}modify_log` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user` Char(40) NOT NULL COMMENT '����Ա����',
	`group` Char(40) NOT NULL COMMENT '����Ա����',
	`time` Char(15) DEFAULT 0 COMMENT '����ʱ�䣨unixtimestamp��',
	`link` Char(255) COMMENT '����ҳ��',
	`comment` Char(100) DEFAULT '' COMMENT '���±�ע',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��վά����־';

# ---------------------------------------------------------------------------------------------------------------

# ����ͳ��
CREATE TABLE `{pre}counter` (
	`date` DATE NOT NULL UNIQUE COMMENT 'ͳ������',
	`pv` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL COMMENT 'ҳ�������',
	`iv` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL COMMENT 'IP ������',
	`online` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL COMMENT '�����������',
	PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='�򵥷���ͳ��';

# ---------------------------------------------------------------------------------------------------------------

# ����ͼʾ
CREATE TABLE `{pre}news_image` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`web_id` TINYINT UNSIGNED DEFAULT 0 COMMENT '������վ',
	`name` Char(40) NOT NULL DEFAULT '' COMMENT '����',
	`image` Char(150) NOT NULL DEFAULT '' COMMENT 'ͼƬ',
	`keyword` Char(150) NOT NULL DEFAULT '' COMMENT '�ؼ���',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='����ͼʾ';

# ---------------------------------------------------------------------------------------------------------------
