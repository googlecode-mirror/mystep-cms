<?PHP
$sql_list = array (
  0 => 
  array (
    'name' => 'test',
    'fields' => '编号,名称,文件,描述',
    'sql' => 'select `id`,`name`,`file`,`comment` from ms_admin_cat order by id',
  ),
  1 => 
  array (
    'name' => '报道情况',
    'fields' => '分类,姓名,公司,房间号,房间类型,入住时间',
    'sql' => 'select cata, name, company, room_no, room_type, date_checkin from ms_custom_form_4 where room_no is not null and room_no!=\'\' and company!=\'中国食品土畜进出口商会\'',
  ),
  2 => 
  array (
    'name' => '入住情况',
    'fields' => '房间类型,入住日期,入住数量',
    'sql' => 'select room_type, date_checkin, count(*) as cnt from ms_custom_form_4 where room_no is not null and room_no!=\'\' and company!=\'中国食品土畜进出口商会\' group by room_type, date_checkin ',
  ),
  3 => 
  array (
    'name' => '合住情况',
    'fields' => '房间号,已入住',
    'sql' => 'select room_no, count(*) as cnt from ms_custom_form_4 where room_type=\'拼间\' and room_no is not null and room_no!=\'\' and company!=\'中国食品土畜进出口商会\' group by room_no order by cnt',
  ),
  4 => 
  array (
    'name' => '未报道企业',
    'fields' => '类别,姓名,公司,应收款,支付情况',
    'sql' => 'select cata, name, company, fee_total, pay from ms_custom_form_4 where room_no is null or room_no=\'\' order by company',
  ),
  5 => 
  array (
    'name' => '支付统计',
    'fields' => '发票,应付款,已付款,支付酒店',
    'sql' => 'select pay,sum(fee_total) as 应付款, sum(pay_hotel) as 支付酒店 from ms_custom_form_4',
  ),
  6 => 
  array (
    'name' => '2012中国果汁大会_报道情况',
    'fields' => 'ID,公司,姓名,报到时间',
    'sql' => 'select id, concat(company, "\\n",company_en) as company,concat(name, "\\n",name_en) as name, reg_date from ms_custom_form_3 where reg_date!="" and reg_date is not null',
  ),
  7 => 
  array (
    'name' => '2012中国果汁大会_各国家地区参会人数',
    'fields' => '国家,数量',
    'sql' => 'select country,count(*) as total from ms_custom_form_3 group by country order by total desc',
  ),
  8 => 
  array (
    'name' => '2012中国果汁大会_交费情况',
    'fields' => 'ID,公司,姓名,国家/地区,应收,实收,款到时间',
    'sql' => 'select id,concat(company, "\\n",company_en) as company,concat(name, "\\n",name_en) as name,country,fee,pay,date_pay from ms_custom_form_3 where pay>0 order by date_pay desc',
  ),
  9 => 
  array (
    'name' => '2012中国果汁大会_已缴费未报到',
    'fields' => 'ID,公司,公司英文,姓名,姓名英文,国家/地区,应收,实收,款到时间',
    'sql' => 'select id,company,company_en,name,name_en,country,fee,pay,date_pay from ms_custom_form_3 where pay>0 and (reg_date=\'\' or reg_date is null) order by date_pay desc',
  ),
  10 => 
  array (
    'name' => '2012中国果汁大会_产业参观报名',
    'fields' => 'ID,公司,公司英文,姓名,姓名英文,国家/地区,报到时间',
    'sql' => 'select id,company,company_en,name,name_en,country,reg_date from ms_custom_form_3 where tour=\'参加\' order by date_pay desc',
  ),
);			
?>