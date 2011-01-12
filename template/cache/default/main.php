<!--1294497308-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=$tpl_para['tf13121331b']['para']['web_title']?></title>
<link rel="stylesheet" type="text/css" href="images/<?=$tpl_para['tf13121331b']['para']['template']?>/style.css" />
<meta http-equiv="Pragma" contect="no-cache">
<meta http-equiv="Expires" contect="-1">
<meta http-equiv="windows-Target" contect="_top">
<meta http-equiv="Content-Type" content="text/html; charset=<?=$tpl_para['tf13121331b']['para']['charset']?>" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="keywords" content="<?=$tpl_para['tf13121331b']['para']['page_keywords']?>">
<meta name="description" content="<?=$tpl_para['tf13121331b']['para']['page_description']?>">
<link rel="alternate" title="<?=$tpl_para['tf13121331b']['para']['web_title']?>" href="<?=$tpl_para['tf13121331b']['para']['rss_link']?>" type="application/rss+xml" />
<link rel="Shortcut Icon" href="favicon.ico" />
<?=$tpl_para['tf13121331b']['para']['page_start']?>
</head>
<body>
<div id="ajax" style="display:none;"><img src="images/loading.gif" alt="<?=$tpl_para['tf13121331b']['para']['lang_ajax_sending']?>"></div>
<div id="page_ole">
	<div id="page_top" class="after">
		<div class="l fl">
			<img src="images/default/logo.png" width="280" />
		</div>
		<div class="r fr">
			<img src="images/default/title_text_1.png" />
			<img src="images/default/title_text_2.png" />
		</div>
	</div>
	<div id="topbar" class="after">
		<div class="l fl"></div>
		<div class="m fl tc">
			<ul>
				<li class="first"><a href="<?=$tpl_para['tf13121331b']['para']['web_url']?>"><?=$tpl_para['tf13121331b']['para']['lang_page_main']?></a></li>
<?php
$time = 0 - 1;
$max_count = count($tpl_para['tf13121331b']['loop']['news_cat']);
for($i=0; $i<$max_count; $i++) {
	echo <<<content
				<li><a href="{$tpl_para['tf13121331b']['loop']['news_cat'][$i]['cat_link']}">{$tpl_para['tf13121331b']['loop']['news_cat'][$i]['cat_name']}</a></li>
content;
	echo "\n";
	if($i>=$time && $time>0) break;
}
for($i=$max_count-1; $i<$time; $i++) {
	echo <<<content
				<li>&nbsp;</li>
content;
	echo "\n";
}
?>
			</ul>
		</div>
		<div class="r fr"></div>
	</div>
	
<?=$tpl_para['tf13121331b']['para']['main']?>
	
	<div id="page_bottom" class="after">
		<?php
echo $db->getSingleResult("select content from ms_info_show where subject='copyright'");
?>
	</div>
	<div align="center"><?=$tpl_para['tf13121331b']['para']['lang_page_update']?><?=$tpl_para['tf13121331b']['para']['last_modify']?></div>
</div>
<?=$tpl_para['tf13121331b']['para']['page_end']?>
</body>
</html>