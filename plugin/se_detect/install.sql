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
	`date` DATE NOT NULL UNIQUE,											#ͳ������
	PRIMARY KEY (`date`)
) TYPE=MyISAM DEFAULT CHARSET={charset} COMMENT='��������ͳ��';