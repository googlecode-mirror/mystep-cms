<?php
function importData($record, $para, $db=null) {
	global $news_show, $news_detail, $setting, $setting_sub;
	if(is_null($db)) global $db;
	
	$item = $news_show;
	$item['web_id'] = $para['web_id'];
	$item['subject'] = $record['subject'];
	$item['original'] = $record['original'];
	$item['add_date'] = $record['add_date'];
	$item['cat_id'] = $record['item_1'];
	$item['describe'] = $record['item_2'];
	$item['tag'] = $record['item_3'];
	$item['image'] = $record['item_4'];
	if(!empty($item['image'])) {
		$new_file = ROOT_PATH."/".$setting['path']['upload']."/article".date("/Ym/").GetMicrotime().".".GetFileExt($item['image']);
		if(GetRemoteFile($item['image'], $new_file)) {
			$item['image'] = str_replace(ROOT_PATH, "", $new_file);
		}
	}

	$db->Query($db->buildSQL($setting_sub['db']['pre']."news_show", $item, "insert"));
	unset($item);

	$item = $news_detail;
	$item['news_id'] = $db->GetInsertId();
	$item['cat_id'] = $record['item_1'];
	$item['sub_title'] = $record['subject'];
	$attach_list = GetPictures($record['content']);
	$content = explode("<!-- pagebreak -->", $record['content']);
	$max_count = count($content);
	for($i=0; $i<$max_count; $i++) {
		$item['page'] = $i + 1;
		$item['sub_title'] = $record['subject']." - ".$item['page'];
		$item['content'] = $content[$i];
		$db->Query($db->buildSQL($setting_sub['db']['pre']."news_detail", $item, "insert"));
	}
	$db->Query("update ".$setting['db']['pre']."attachment set news_id={$item['news_id']}, web_id={$para['web_id']} where id in ({$attach_list})");
	$db->Query("update ".$setting_sub['db']['pre']."news_show set pages={$max_count} where news_id='{$item['news_id']}'");
	unset($item);
	return;
}
?>