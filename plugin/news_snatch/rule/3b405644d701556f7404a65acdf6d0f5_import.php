<?php
function importData($record, $para, $db=null) {
	global $news_show, $news_detail, $setting, $setting_sub;
	if(is_null($db)) global $db;
	$item = $news_show;
	$item['web_id'] = $para['web_id'];
	$item['subject'] = $record['subject'];
	$item['original'] = $record['original'];
	$item['add_date'] = $record['add_date'];
	$item['cat_id'] = $record['item_2'];
	$item['tag'] = $record['item_3'];
	$item['describe'] = $record['item_4'];
	$item['image'] = $record['item_5'];
	$db->insert($setting_sub['db']['pre']."news_show", $item);
	unset($item);

	$item = $news_detail;
	$item['news_id'] = $db->GetInsertId();
	$item['cat_id'] = $record['item_2'];
	$item['sub_title'] = $record['subject'];
	$content = explode("<!-- pagebreak -->", $record['content']);
	$max_count = count($content);
	for($i=0; $i<$max_count; $i++) {
		$item['page'] = $i + 1;
		$item['sub_title'] = $record['subject']." - ".$item['page'];
		$item['content'] = $content[$i];
		$db->insert($setting_sub['db']['pre']."news_detail", $item);
	}
	$db->update($setting_sub['db']['pre']."news_show", array("pages"=>$max_count), array("news_id","n=",$item['news_id']));
	unset($item);
	return;
}
?>