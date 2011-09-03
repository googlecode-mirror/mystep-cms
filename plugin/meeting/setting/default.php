<?php
$para = array(
	"name" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => ".",
		"length" => "50",
		"title" => "代表姓名",
		"title_en" => "",
		"comment" => "参会代表中文姓名",
		"comment_en" => "",
	),
	"name_en" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "",
		"length" => "50",
		"title" => "姓名拼音",
		"title_en" => "Full Name",
		"comment" => "请录入姓名全拼",
		"comment_en" => "What's your name?",
	),
	"gender" => array(
		"type" => "radio",
		"value" => array(
			"cn"=> array("男","女"),
			"en"=> array("Male","Famale"),
		),
		"default" => "男",
		"format" => "",
		"length" => "",
		"title" => "性别",
		"title_en" => "Gender",
		"comment" => "请选择您的性别",
		"comment_en" => "Select your gender",
	),
	"country" => array(
		"type" => "text",
		"value" => "",
		"default" => "中国",
		"format" => "",
		"length" => "20",
		"title" => "国家",
		"title_en" => "Country",
		"comment" => "请录入您的国家",
		"comment_en" => "Where are you come from?",
	),
	"company" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "",
		"length" => "150",
		"title" => "公司中文",
		"title_en" => "",
		"comment" => "公司中文名称",
		"comment_en" => "",
	),
	"company_en" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "",
		"length" => "200",
		"title" => "公司英文",
		"title_en" => "Company",
		"comment" => "公司英文名称",
		"comment_en" => "What's your company's name?",
	),
	"duty" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "",
		"length" => "30",
		"title" => "公司职务",
		"title_en" => "",
		"comment" => "您在公司担任的职务",
		"comment_en" => "",
	),
	"duty_en" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "",
		"length" => "50",
		"title" => "职务英文",
		"title_en" => "Duty",
		"comment" => "公司职务的英文",
		"comment_en" => "What's your position in your company?",
	),
	"address" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "",
		"length" => "",
		"title" => "公司地址",
		"title_en" => "",
		"comment" => "您公司的详细地址",
		"comment_en" => "",
	),
	"address_en" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "",
		"length" => "",
		"title" => "",
		"title_en" => "Address",
		"comment" => "",
		"comment_en" => "Where is your company?",
	),
	"zipcode" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "digital",
		"length" => "6",
		"title" => "邮政编码",
		"title_en" => "",
		"comment" => "对应公司地址的邮政编码",
		"comment_en" => "",
	),
	"mobile" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "",
		"length" => "30",
		"title" => "手机号码",
		"title_en" => "Cellphone",
		"comment" => "请填写本人的手机号码",
		"comment_en" => "Your mobile phone number",
	),
	"areacode" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "digital",
		"length" => "4",
		"title" => "电话区号",
		"title_en" => "",
		"comment" => "公司所在地区的电话区号",
		"comment_en" => "",
	),
	"tel" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "",
		"length" => "20",
		"title" => "公司电话",
		"title_en" => "Telephone",
		"comment" => "公司联络电话",
		"comment_en" => "Telephone number of your company",
	),
	"fax" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "",
		"length" => "20",
		"title" => "传真号码",
		"title_en" => "Fax",
		"comment" => "公司传真号码",
		"comment_en" => "Fax number of your company",
	),
	"email" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "email",
		"length" => "30",
		"title" => "电子邮件",
		"title_en" => "Email",
		"comment" => "您常用的电子邮件地址",
		"comment_en" => "Your email",
	),
	"website" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => ".",
		"length" => "150",
		"title" => "公司网址",
		"title_en" => "Website",
		"comment" => "贵公司网站地址",
		"comment_en" => "Website of your company",
	),
	"diet_type" => array(
		"type" => "radio",
		"value" => array(
			"cn"=> array("普通饮食","穆斯林","素食"),
			"en"=> array("Normal","Muslim","Vegetarian Only"),
		),
		"default" => "普通饮食",
		"format" => "",
		"length" => "",
		"title" => "饮食习惯",
		"title_en" => "Diet Type",
		"comment" => "您的饮食习惯",
		"comment_en" => "Your favorite food",
	),
	"sponsorship" => array(
		"type" => "select",
		"value" => array(
			"cn"=> array("不赞助","赞助"),
			"en"=> array("No","Yes"),
		),
		"default" => "不赞助",
		"format" => "",
		"length" => "",
		"title" => "赞助会议",
		"title_en" => "Sponsorship",
		"comment" => "是否有意赞助",
		"comment_en" => "Make a sponsor for the meeting",
	),
	"room_type" => array(
		"type" => "select",
		"value" => array(
			"cn"=> array("不住宿","单间","合住"),
			"en"=> array("No Need","King Bed","Twin Bed"),
		),
		"default" => "不住宿",
		"format" => "",
		"length" => "",
		"title" => "房间类型",
		"title_en" => "Book Hotel",
		"comment" => "预订房间类型",
		"comment_en" => "Room Type of the hotel",
	),
	"date_checkin" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "date_",
		"length" => "10",
		"title" => "入住时间",
		"title_en" => "Check In",
		"comment" => "您入住宾馆的时间",
		"comment_en" => "The time your will check in.",
	),
	"date_checkout" => array(
		"type" => "text",
		"value" => "",
		"default" => "",
		"format" => "date_",
		"length" => "10",
		"title" => "退房时间",
		"title_en" => "Check Out",
		"comment" => "您离开宾馆的时间",
		"comment_en" => "The time your will check out.",
	),
	"notes" => array(
		"type" => "textarea",
		"value" => "",
		"default" => "",
		"format" => ".",
		"length" => "",
		"title" => "备注信息",
		"title_en" => "Note",
		"comment" => "",
		"comment_en" => "",
	),
);
?>