<?PHP
$sql_list = array (
  0 => 
  array (
    'name' => 'test',
    'fields' => '���,����,�ļ�,����',
    'sql' => 'select `id`,`name`,`file`,`comment` from ms_admin_cat order by id',
  ),
  1 => 
  array (
    'name' => '�������',
    'fields' => '����,����,��˾,�����,��������,��סʱ��',
    'sql' => 'select cata, name, company, room_no, room_type, date_checkin from ms_custom_form_4 where room_no is not null and room_no!=\'\' and company!=\'�й�ʳƷ����������̻�\'',
  ),
  2 => 
  array (
    'name' => '��ס���',
    'fields' => '��������,��ס����,��ס����',
    'sql' => 'select room_type, date_checkin, count(*) as cnt from ms_custom_form_4 where room_no is not null and room_no!=\'\' and company!=\'�й�ʳƷ����������̻�\' group by room_type, date_checkin ',
  ),
  3 => 
  array (
    'name' => '��ס���',
    'fields' => '�����,����ס',
    'sql' => 'select room_no, count(*) as cnt from ms_custom_form_4 where room_type=\'ƴ��\' and room_no is not null and room_no!=\'\' and company!=\'�й�ʳƷ����������̻�\' group by room_no order by cnt',
  ),
  4 => 
  array (
    'name' => 'δ������ҵ',
    'fields' => '���,����,��˾,Ӧ�տ�,֧�����',
    'sql' => 'select cata, name, company, fee_total, pay from ms_custom_form_4 where room_no is null or room_no=\'\' order by company',
  ),
  5 => 
  array (
    'name' => '֧��ͳ��',
    'fields' => '��Ʊ,Ӧ����,�Ѹ���,֧���Ƶ�',
    'sql' => 'select pay,sum(fee_total) as Ӧ����, sum(pay_hotel) as ֧���Ƶ� from ms_custom_form_4',
  ),
  6 => 
  array (
    'name' => '2012�й���֭���_�������',
    'fields' => 'ID,��˾,����,����ʱ��',
    'sql' => 'select id, concat(company, "\\n",company_en) as company,concat(name, "\\n",name_en) as name, reg_date from ms_custom_form_3 where reg_date!="" and reg_date is not null',
  ),
  7 => 
  array (
    'name' => '2012�й���֭���_�����ҵ����λ�����',
    'fields' => '����,����',
    'sql' => 'select country,count(*) as total from ms_custom_form_3 group by country order by total desc',
  ),
  8 => 
  array (
    'name' => '2012�й���֭���_�������',
    'fields' => 'ID,��˾,����,����/����,Ӧ��,ʵ��,�ʱ��',
    'sql' => 'select id,concat(company, "\\n",company_en) as company,concat(name, "\\n",name_en) as name,country,fee,pay,date_pay from ms_custom_form_3 where pay>0 order by date_pay desc',
  ),
  9 => 
  array (
    'name' => '2012�й���֭���_�ѽɷ�δ����',
    'fields' => 'ID,��˾,��˾Ӣ��,����,����Ӣ��,����/����,Ӧ��,ʵ��,�ʱ��',
    'sql' => 'select id,company,company_en,name,name_en,country,fee,pay,date_pay from ms_custom_form_3 where pay>0 and (reg_date=\'\' or reg_date is null) order by date_pay desc',
  ),
  10 => 
  array (
    'name' => '2012�й���֭���_��ҵ�ι۱���',
    'fields' => 'ID,��˾,��˾Ӣ��,����,����Ӣ��,����/����,����ʱ��',
    'sql' => 'select id,company,company_en,name,name_en,country,reg_date from ms_custom_form_3 where tour=\'�μ�\' order by date_pay desc',
  ),
);			
?>