# ���������¼
CREATE TABLE `{pre}se_detect` (
	`idx` Char(20) NOT NULL COMMENT '������������',
	`ip` Char(30) NOT NULL UNIQUE COMMENT 'ip��ַ',
	`count` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL COMMENT '���ʴ���',
	index (`idx`),
	INDEX (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='���������¼';

# ��������ͳ��
CREATE TABLE `{pre}se_count` (
	`date` DATE NOT NULL UNIQUE COMMENT 'ͳ������',
	`����` mediumint(8) unsigned NOT NULL default '0' COMMENT '��������ͳ��',
	PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������ͳ��';

alter table `{pre}se_count` add `�е�` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `����` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `�ѹ�` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `�Ż�` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `��Ӧ` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `�ٶ�` mediumint(8) unsigned NOT NULL default '0' after `date`;
alter table `{pre}se_count` add `�ȸ�` mediumint(8) unsigned NOT NULL default '0' after `date`;