# ����������
CREATE TABLE `{pre}search_keyword` (
	`keyword` Char(80) NOT NULL UNIQUE COMMENT '�ؼ���',
	`count` SMALLINT DEFAULT 0 COMMENT '��������',
	`add_date` Char(15) DEFAULT 0 COMMENT '�״μ������ڣ�unixtimestamp��',
	`chg_date` Char(15) DEFAULT 0 COMMENT '����������ڣ�unixtimestamp��',
	INDEX (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='����������';