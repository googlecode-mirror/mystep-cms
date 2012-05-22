# ��Դ��ַ��¼
CREATE TABLE `{pre}visit_analysis` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`host` Char(100) NOT NULL UNIQUE COMMENT '��Դ����',
	`count` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL COMMENT '�����ô���',
	`count_month` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL COMMENT '�����ô���',
	`count_year` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL COMMENT '�����ô���',
	`add_date` Char(15) DEFAULT 0 COMMENT '�״��������ڣ�unixtimestamp��',
	`chg_date` Char(15) DEFAULT 0 COMMENT '����������ڣ�unixtimestamp��',
	index (`host`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��Դ��ַ��¼';
INSERT INTO `{pre}visit_analysis` values(0, 'None', 0, 0, 0, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

# ���ùؼ���
CREATE TABLE `{pre}visit_keyword` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`keyword` Char(200) NOT NULL UNIQUE COMMENT '�ؼ���',
	`count` SMALLINT DEFAULT 0 COMMENT '��������',
	`url` Char(200) DEFAULT "###" NOT NULL COMMENT '������ַ',
	`referer` Char(255) DEFAULT "" NOT NULL COMMENT '�����Դ��ַ',
	`add_date` Char(15) DEFAULT 0 COMMENT '�״μ������ڣ�unixtimestamp��',
	`chg_date` Char(15) DEFAULT 0 COMMENT '����������ڣ�unixtimestamp��',
	INDEX (`keyword`),
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='���ùؼ���';

/*
#2011.10.19
alter table ms_visit_analysis add `count_year` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL after `count`;
alter table ms_visit_analysis add `count_month` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL after `count`;
alter table ms_visit_keyword add `url` Char(200) DEFAULT "###" NOT NULL after `count`;
alter table ms_visit_keyword add `referer` Char(200) DEFAULT "" NOT NULL after `url`;
alter table ms_visit_keyword modify `keyword` Char(200) NOT NULL UNIQUE;
update  ms_visit_analysis set `count_month`=`count`, `count_year`=`count`;
*/