<!--1293775791-->
	<div class="page_bar after">
		<div class="hslice box_1">
			<div class="entry-title">最新情况</div>
			<div class="entry-content after">
<?php
echo $db->getSingleResult("select content from ms_info_show where subject='guide'");
?>
			</div>
		</div>
		<div class="hslice box_2">
			<div class="entry-title">
				<div class="c1"><img src="images/default/bar_pic1.png" /></div>
				<div class="c2">新闻动态</div>
			</div>
			<div class="entry-content">
<ul>
<?php
$n = 0;
$db->Query("select * from ms_news_show where 1=1 and cat_id in (2) order by  news_id desc limit 9");
while($record = $db->GetRS()) {
	$record['subject'] = trans_title($record['subject']);
	$record['style'] = $n++%2 ? "" : "";
	$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
	if(empty($record['link'])) $record['link'] = getFileURL($record['news_id'], ($cat_info?$cat_info['cat_idx']:""));
	$record['add_date'] = ("Y-m-d"!="") ? date("Y-m-d", strtotime($record['add_date'])) : "";
	$record['catalog'] = "";
	if(""!="") {
		$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
		if($cat_info) {
			$record['catalog'] = "<a href=\"".getFileURL(0, $cat_info['cat_idx'])."\" target=\"_blank\">[".$cat_info['cat_name']."]</a>";
		}
	}
	echo <<<content
	<li style="{$record['style']}"><em>{$record['catalog']}</em> <a href="{$record['link']}" target="_blank">{$record['subject']}</a> &nbsp; <i>{$record['add_date']}</i></li>
content;
	echo "\n";
}
$db->Free();
for(; $n<=9; $n++) {
	$unit = str_replace("style=\"\"", "style=\"".($n%2?"":"")."\"", "
	<li style=\"\">&nbsp;</li>
");
	echo $unit;
	echo "\n";
}
?>
</ul>
			</div>
		</div>
		<div class="hslice box_3">
			<div class="entry-title"><img src="images/default/textbar_3.png" /></div>
			<div class="entry-content">
<ul>
<?php
$n = 0;
$db->Query("select * from ms_news_show where 1=1 and cat_id in (1) order by  news_id desc limit 9");
while($record = $db->GetRS()) {
	$record['subject'] = trans_title($record['subject']);
	$record['style'] = $n++%2 ? "" : "";
	$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
	if(empty($record['link'])) $record['link'] = getFileURL($record['news_id'], ($cat_info?$cat_info['cat_idx']:""));
	$record['add_date'] = ("Y-m-d"!="") ? date("Y-m-d", strtotime($record['add_date'])) : "";
	$record['catalog'] = "";
	if(""!="") {
		$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
		if($cat_info) {
			$record['catalog'] = "<a href=\"".getFileURL(0, $cat_info['cat_idx'])."\" target=\"_blank\">[".$cat_info['cat_name']."]</a>";
		}
	}
	echo <<<content
	<li style="{$record['style']}"><em>{$record['catalog']}</em> <a href="{$record['link']}" target="_blank">{$record['subject']}</a> &nbsp; <i>{$record['add_date']}</i></li>
content;
	echo "\n";
}
$db->Free();
for(; $n<=0; $n++) {
	$unit = str_replace("style=\"\"", "style=\"".($n%2?"":"")."\"", "
	<li style=\"\">&nbsp;</li>
");
	echo $unit;
	echo "\n";
}
?>
</ul>
			</div>
		</div>
	</div>
	<div class="page_bar after">
		<img src="images/default/show_1.png" width="980" />
	</div>
	<div class="page_bar after">
		<div class="hslice box_4">
			<div class="entry-title"><img src="images/default/textbar_3.png" /></div>
			<div class="entry-content">
<?php
$base_size = 8;
$dyn_size = 32;
$count_max = 0;
$db->Query("select tag, count from ms_news_tag where count>5 and length(tag)>3 and 1=1 order by rand() limit 150");
$tag_list = array();
while($record = $db->GetRS()) {
	if($setting['gen']['rewrite']) {
		$record['link'] = $setting['web']['url'].$path_cache."/tag/".urlencode($record['tag']).$setting['gen']['cache_ext'];
	} else {
		$record['link'] = $setting['web']['url']."/tag.php?tag=".urlencode($record['tag']);
	}
	$record['link'] = str_replace("//", "/", $record['link']);
	$record['link'] = str_replace("http:/", "http://", $record['link']);
	$record['size'] = $base_size;
	if($count_max<$record['count']) $count_max = $record['count'];
	$tag_list[] = $record;
}
$db->Free();
$max_count = count($tag_list);
for($i=0; $i<$max_count; $i++) {
	$tag_list[$i]['size'] = $base_size + round($dyn_size * $tag_list[$i]['count'] / $count_max);
	echo <<<content
						<span class="tag"><a href="{$tag_list[$i]['link']}" style="font-size: {$tag_list[$i]['size']}px" title="{$tag_list[$i]['tag']} - {$tag_list[$i]['count']}">{$tag_list[$i]['tag']}</a></span> ,
content;
	echo "\n";
}
?>
								<ul class="img_list">
<?php
$n = 0;
$db->Query("select * from ms_news_show where 1=1 and cat_id in (4) and image!='' order by  news_id desc limit 12");
while($record = $db->GetRS()) {
	$record['subject'] = trans_title($record['subject']);
	$record['style'] = $n++%2 ? "" : "";
	$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
	if(empty($record['link'])) $record['link'] = getFileURL($record['news_id'], ($cat_info?$cat_info['cat_idx']:""));
	$record['add_date'] = ("Y-m-d"!="") ? date("Y-m-d", strtotime($record['add_date'])) : "";
	$record['catalog'] = "";
	if(""!="") {
		$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
		if($cat_info) {
			$record['catalog'] = "<a href=\"".getFileURL(0, $cat_info['cat_idx'])."\" target=\"_blank\">[".$cat_info['cat_name']."]</a>";
		}
	}
	echo <<<content
									<li>
										<a href="{$record['link']}" target="_blank"><img src="{$record['image']}" alt="{$record['subject']}"></a><br />
										<a href="{$record['link']}" target="_blank">{$record['subject']}</a>
									</li>
content;
	echo "\n";
}
$db->Free();
for(; $n<=0; $n++) {
	$unit = str_replace("style=\"\"", "style=\"".($n%2?"":"")."\"", "
									<li>&nbsp;</li>
");
	echo $unit;
	echo "\n";
}
?>
								</ul>
			</div>
		</div>
		<div class="hslice box_5">
			<div class="entry-title"><img src="images/default/textbar_3.png" /></div>
			<div class="entry-content">
						<ul>
<?php
$n = 0;
$db->Query("select * from ms_news_show where 1=1 and cat_id in (9) order by  news_id desc limit 5");
while($record = $db->GetRS()) {
	$record['subject'] = trans_title($record['subject']);
	$record['style'] = $n++%2 ? "" : "";
	$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
	if(empty($record['link'])) $record['link'] = getFileURL($record['news_id'], ($cat_info?$cat_info['cat_idx']:""));
	$record['add_date'] = ("Y-m-d"!="") ? date("Y-m-d", strtotime($record['add_date'])) : "";
	$record['catalog'] = "";
	if(""!="") {
		$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
		if($cat_info) {
			$record['catalog'] = "<a href=\"".getFileURL(0, $cat_info['cat_idx'])."\" target=\"_blank\">[".$cat_info['cat_name']."]</a>";
		}
	}
	echo <<<content
							<li style="{$record['style']}">
								<div class="c1">{$record['describe']}</div>
								<div class="c2">-- <a href="{$record['link']}" target="_blank">{$record['original']}</a></div>
							</li>
content;
	echo "\n";
}
$db->Free();
for(; $n<=0; $n++) {
	$unit = str_replace("style=\"\"", "style=\"".($n%2?"":"")."\"", "
							<li style=\"\">&nbsp;</li>
");
	echo $unit;
	echo "\n";
}
?>
						</ul>
			</div>
		</div>
	</div>
	<div class="page_bar after">
		<div class="hslice box_6">
			<div class="entry-title"><img src="images/default/textbar_3.png" /></div>
			<div class="entry-content">
<ul>
<?php
$n = 0;
$db->Query("select * from ms_news_show where 1=1 and cat_id in (10) order by  news_id desc limit 9");
while($record = $db->GetRS()) {
	$record['subject'] = trans_title($record['subject']);
	$record['style'] = $n++%2 ? "" : "";
	$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
	if(empty($record['link'])) $record['link'] = getFileURL($record['news_id'], ($cat_info?$cat_info['cat_idx']:""));
	$record['add_date'] = ("Y-m-d"!="") ? date("Y-m-d", strtotime($record['add_date'])) : "";
	$record['catalog'] = "";
	if(""!="") {
		$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
		if($cat_info) {
			$record['catalog'] = "<a href=\"".getFileURL(0, $cat_info['cat_idx'])."\" target=\"_blank\">[".$cat_info['cat_name']."]</a>";
		}
	}
	echo <<<content
	<li style="{$record['style']}"><em>{$record['catalog']}</em> <a href="{$record['link']}" target="_blank">{$record['subject']}</a> &nbsp; <i>{$record['add_date']}</i></li>
content;
	echo "\n";
}
$db->Free();
for(; $n<=0; $n++) {
	$unit = str_replace("style=\"\"", "style=\"".($n%2?"":"")."\"", "
	<li style=\"\">&nbsp;</li>
");
	echo $unit;
	echo "\n";
}
?>
</ul>
			</div>
		</div>
		<div class="hslice box_7">
			<div class="entry-title"><img src="images/default/textbar_3.png" /></div>
			<div class="entry-content">
<ul>
<?php
$n = 0;
$db->Query("select * from ms_news_show where 1=1 and cat_id in (7) order by  news_id desc limit 9");
while($record = $db->GetRS()) {
	$record['subject'] = trans_title($record['subject']);
	$record['style'] = $n++%2 ? "" : "";
	$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
	if(empty($record['link'])) $record['link'] = getFileURL($record['news_id'], ($cat_info?$cat_info['cat_idx']:""));
	$record['add_date'] = ("Y-m-d"!="") ? date("Y-m-d", strtotime($record['add_date'])) : "";
	$record['catalog'] = "";
	if(""!="") {
		$cat_info = getParaInfo("news_cat", "cat_id", $record['cat_id']);
		if($cat_info) {
			$record['catalog'] = "<a href=\"".getFileURL(0, $cat_info['cat_idx'])."\" target=\"_blank\">[".$cat_info['cat_name']."]</a>";
		}
	}
	echo <<<content
	<li style="{$record['style']}"><em>{$record['catalog']}</em> <a href="{$record['link']}" target="_blank">{$record['subject']}</a> &nbsp; <i>{$record['add_date']}</i></li>
content;
	echo "\n";
}
$db->Free();
for(; $n<=0; $n++) {
	$unit = str_replace("style=\"\"", "style=\"".($n%2?"":"")."\"", "
	<li style=\"\">&nbsp;</li>
");
	echo $unit;
	echo "\n";
}
?>
</ul>
			</div>
		</div>
	</div>
	<div class="page_bar after">
		<div class="hslice box_8">
			<div class="entry-title"><img src="images/default/textbar_2.png" /></div>
			<div class="entry-content">
<?php
$link_list = $GLOBALS['link_txt'];$max_count = count($link_list);
if(0>0 && 0<$max_count) $max_count = 0;
for($i=0; $i<$max_count; $i++) {
	echo <<<content
						<a href="{$link_list[$i]['url']}" target="_blank">{$link_list[$i]['name']}</a>
content;
	echo "\n";
}
?>
<br />
<?php
$link_list = $GLOBALS['link_img'];$max_count = count($link_list);
if(0>0 && 0<$max_count) $max_count = 0;
for($i=0; $i<$max_count; $i++) {
	echo <<<content
			<a href="{$link_list[$i]['link_url']}" target="_blank"><img src="{$link_list[$i]['image']}" alt="{$link_list[$i]['link_name']}" /></a>
content;
	echo "\n";
}
?>
			</div>
		</div>
	</div>