# ����������
CREATE TABLE `{pre}search_keyword` (
	`keyword` Char(80) NOT NULL UNIQUE,				#�ؼ���
	`count` SMALLINT DEFAULT 0,								#��������
	`add_date` Char(15) DEFAULT 0,						#�״μ������ڣ�unixtimestamp��
	`chg_date` Char(15) DEFAULT 0,						#����������ڣ�unixtimestamp��
	INDEX (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='����������';