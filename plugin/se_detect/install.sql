# ���������¼
CREATE TABLE `{pre}se_detect` (
	`idx` Char(20) NOT NULL,													#������������
	`ip` Char(30) NOT NULL UNIQUE,										#ip��ַ
	`count` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL,		#���ʴ���
	index (`idx`),
	INDEX (`ip`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='���������¼';

# ��������ͳ��
CREATE TABLE `{pre}se_count` (
	`date` DATE NOT NULL UNIQUE,													#ͳ������
	`����` mediumint(8) unsigned NOT NULL default '0',		#��������ͳ��
	PRIMARY KEY (`date`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������ͳ��';

alter table `{pre}se_count` add `�ȸ�` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `�ٶ�` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `�е�` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `�Ż�` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `����` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `��Ӧ_msn` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `�ѹ�` mediumint(8) unsigned NOT NULL default '0';
alter table `{pre}se_count` add `��Ӧ_bing` mediumint(8) unsigned NOT NULL default '0';