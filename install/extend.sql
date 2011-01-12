# ����ר��
CREATE TABLE `{pre}news_theme` (
	`theme_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,		#ר������
	`theme_name` Char(60) NOT NULL,													#ר������
	`theme_idx` Char(20) DEFAULT '',												#ר������������Ŀ¼���ȣ�
	`theme_image` Char(100) DEFAULT '',											#ר��ͼʾ
	`theme_link` Char(100) DEFAULT '',											#ר������
	`theme_cat` Char(200) DEFAULT '',												#ר�����
	`theme_comment` Char(250) DEFAULT '',										#ר�����
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',			#¼������
	PRIMARY KEY (`theme_id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='����ר��';

# ---------------------------------------------------------------------------------------------------------------

# ����ר������
CREATE TABLE `{pre}news_theme_link` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,					#��������
	`theme_id` SMALLINT UNSIGNED NOT NULL,									#ר������
	`news_id` MEDIUMINT UNSIGNED,														#��������
	`link_name` Char(100) DEFAULT '',												#��������
	`link_url` Char(200) DEFAULT '',												#���ӵ�ַ
	`link_cat` TINYINT UNSIGNED,														#���ӷ���
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='����ר������';

# ---------------------------------------------------------------------------------------------------------------

# ���Ųɼ�
CREATE TABLE `{pre}news_snatch` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`idx` Char(40) NOT NULL DEFAULT '',					#��������
	`url` Char(200) NOT NULL DEFAULT '',				#������ַ
	`original` Char(100) NOT NULL DEFAULT '',		#��Դ��վ
	`subject` Char(255) NOT NULL,								#���ű���
	`item_1` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_2` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_3` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_4` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_5` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_6` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_7` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_8` Char(255) DEFAULT '',							#�ɼ��ı�
	`item_9` Char(255) DEFAULT '',							#�ɼ��ı�
	`content` TEXT NOT NULL,										#��������
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='���Ųɼ�';

# ---------------------------------------------------------------------------------------------------------------

# ͶƱ
CREATE TABLE `{pre}survey` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`subject` Char(120) NOT NULL,									#�������
	`describe` Char(255) DEFAULT '',							#��������
	`max_select` TINYINT UNSIGNED NOT NULL,				#��ѡ������0-�����ƣ�1-��ѡ��������ѡ��
	`post_limit` MEDIUMINT UNSIGNED NOT NULL,			#���������ƣ�0-�����ƣ�
	`template` Char(20) NOT NULL,									#����ģ��
	`add_date` Char(15) DEFAULT 0,								#������ڣ�unixtimestamp��
	`expire` Char(15) DEFAULT 0,									#��Чʱ�䣨unixtimestamp��
	`times` INT DEFAULT 0,												#��������
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='ͶƱ';

# ---------------------------------------------------------------------------------------------------------------

# �������ۣ��������۶��ڴ˱��¼��
CREATE TABLE `{pre}comment` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`news_id` MEDIUMINT UNSIGNED,								#��������
	`user_name` Char(20) NOT NULL,							#�û�����
	`ip` Char(24) NOT NULL,											#�û� IP
	`add_date` DATETIME DEFAULT '0000-00-00 00:00:00',	#���۷�������
	`comment` TEXT NOT NULL,										#��������
	`agree` MEDIUMINT UNSIGNED DEFAULT 0,				#��ͬ
	`oppose` MEDIUMINT UNSIGNED DEFAULT 0,			#����
	`report` MEDIUMINT UNSIGNED DEFAULT 0,			#�ٱ�
	`quote` SMALLINT UNSIGNED DEFAULT 0,				#����¥��
	INDEX (`news_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������';

# ---------------------------------------------------------------------------------------------------------------

# ���ŷ���ͳ��
CREATE TABLE `{pre}news_count` (
	`news_id` MEDIUMINT UNSIGNED NOT NULL,					#��������
	`subject` Char(120) NOT NULL,										#���ű���
	`views` MEDIUMINT UNSIGNED DEFAULT 0,						#���������
	`day_start` Char(10) DEFAULT '0',								#��ͳ�����
	`day_count` SMALLINT UNSIGNED DEFAULT 0,				#�������
	`day_max_time` Char(10) DEFAULT '0',						#��������ʱ��
	`day_max_count` SMALLINT UNSIGNED DEFAULT 0,		#������������
	`week_start` Char(10) DEFAULT '0',							#��ͳ�����
	`week_count` MEDIUMINT UNSIGNED DEFAULT 0,			#�������
	`week_max_time` Char(10) DEFAULT '0',						#��������ʱ��
	`week_max_count` MEDIUMINT UNSIGNED DEFAULT 0,	#������������
	`month_start` Char(10) DEFAULT '0',							#��ͳ�����
	`month_count` MEDIUMINT UNSIGNED DEFAULT 0,			#�������
	`month_max_time` Char(10) DEFAULT '0',					#��������ʱ��
	`month_max_count` MEDIUMINT UNSIGNED DEFAULT 0,	#������������
	`year_start` Char(10) DEFAULT '0',							#��ͳ�����
	`yearh_count` MEDIUMINT UNSIGNED DEFAULT 0,			#�������
	`year_max_time` Char(10) DEFAULT '0',						#��������ʱ��
	`year_max_count` MEDIUMINT UNSIGNED DEFAULT 0,	#������������
	INDEX (`news_id`),
	INDEX (`day_count`),
	INDEX (`week_count`),
	INDEX (`month_count`),
	INDEX (`year_count`),
	UNIQUE KEY (`news_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������ͳ��';

# ---------------------------------------------------------------------------------------------------------------

# ���ŷ���ͳ�ƣ��������ͳ�ƶ��ڴ˱��¼��
CREATE TABLE `{pre}news_mark` (
	`news_id` MEDIUMINT UNSIGNED,										#��������
	`subject` Char(120) NOT NULL,										#���ű���
	`jump` SMALLINT UNSIGNED DEFAULT 0,						#��������
	`jumps_time` Char(10) DEFAULT '0',							#�������ʱ��
	`rank_times` SMALLINT UNSIGNED DEFAULT 0,				#�������ִ���
	`rank_total` SMALLINT UNSIGNED DEFAULT 0,				#���������ܷ�
	INDEX (`news_id`),
	INDEX (`jumps`),
	UNIQUE KEY (`news_id`),
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='�û���������';

# ---------------------------------------------------------------------------------------------------------------

# �򵥷���ͳ��
CREATE TABLE `{pre}counter` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`date` DATE NOT NULL,															#ͳ������
	`pv` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,				#ҳ�������
	`iv` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,				#IP ������
	`online` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,		#�����������
	PRIMARY KEY (`id`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='�򵥷���ͳ��';

# ---------------------------------------------------------------------------------------------------------------

# ��ҵע��
CREATE TABLE `{pre}regist` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` Char(20),											#����
	`name_en` Char(20),										#����Ӣ��
	`gender` Bool DEFAULT 0,							#�Ա�
	`country` Char(50),										#����
	`duty` Char(40),											#ְ��
	`duty_en` Char(40),										#ְ��Ӣ��
	`company` Char(100),									#��˾
	`company_en` Char(100),								#��˾Ӣ��
	`address` Char(200),									#��ַ
	`address_en` Char(200),								#��ַӢ��
	`zipcode` Char(6),										#�ʱ�
	`mobile` Char(20),										#�ֻ�
	`areacode` Char(20),									#����
	`tel` Char(20),												#�绰
	`fax` Char(20),												#����
	`email` Char(40),											#�����ʼ�
	`website` Char(200),									#��ַ
	`if_travel_1` tinyint default 0,			#������
	`if_travel_2` tinyint default 0,			#�����
	`room_type` tinyint default 0,				#��������
	`date_checkin` DATETIME,							#��ס����
	`date_checkout` DATETIME,							#�˷�����
	`add_date` DATETIME,									#¼������
	PRIMARY KEY (`id`)
)COMMENT='��ҵע��';

# ---------------------------------------------------------------------------------------------------------------

