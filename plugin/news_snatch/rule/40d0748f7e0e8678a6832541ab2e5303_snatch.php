<?php
function snatchGetInfo($url, $para=array()) {
	global $db, $setting;
	$info = array();
	$info['page_count'] = 1;
	$header = array();
	if(isset($para['header'])) $header = $para['header'];
	$info['header'] = $header;
	if($content = GetRemoteContent($url, $header)) {
		$content = chg_charset($content, "utf-8", $setting['gen']['charset']);
		preg_match_all("/<item>.+?<title><\!\[CDATA\[(.+?)\]\]><\/title>.+?<category><\!\[CDATA\[(.+?)\]\]><\/category>.+?<description><\!\[CDATA\[(.+?)\]\]><\/description>.+?<pubDate>(.+?)<\/pubDate>.+?<guid>(.+?)<\/guid>.+?<\/item>/is", $content, $matches);
		$info['titleList'] = $matches[1];
		$info['catList'] = $matches[2];
		$info['descList'] = $matches[3];
		$info['dateList'] = $matches[4];
		$info['linkList'] = $matches[5];
		unset($matches);
		$info['cat'] = array();
		for($i=0, $m=count($info['titleList']);$i<$m; $i++) {
			$info['catList'][$i] = str_replace("cnBeta ", "", $info['catList'][$i]);
			$info['descList'][$i] = strip_tags($info['descList'][$i]);
			if(strlen($info['descList'][$i])>230) $info['descList'][$i] = substrPro($info['descList'][$i], 0, 230)."……";
			$info['dateList'][$i] = date("Y-m-d H:i:s", strtotime($info['dateList'][$i]));
			$cat_id = $db->getSingleResult("select cat_id from ".$setting['db']['pre']."news_cat where cat_keyword='".mysql_real_escape_string($info['catList'][$i])."'");
			if(empty($cat_id)) {
				$the_name = preg_replace("/^([^\/]+).*$/", "\\1", $info['catList'][$i]);
				$the_idx = preg_replace("/^([^\s]+).*$/", "\\1", $the_name);
				$db->Query("INSERT INTO `".$setting['db']['pre']."news_cat` VALUES (0, ".$para['web_id'].", 0, '".mysql_real_escape_string($the_name)."', '".mysql_real_escape_string($info['catList'][$i])."', '".mysql_real_escape_string($info['catList'][$i])."', '".mysql_real_escape_string($the_idx)."', '', '', 1, 0, '', 1, 2, 0, '');");
				$cat_id = $db->GetInsertId();
			}
			$info['cat'][] = $cat_id;
		}
		deleteCache("news_cat");
	} else {
		return false;
	}
	return $info;
}

function snatchGetList($record, &$info) {
	global $db, $setting;
	for($i=0, $m=count($info['titleList']); $i<$m; $i++) {
		$record['subject'] = $info['titleList'][$i];
		$record['original'] = "cnBeta";
		$record['url'] = $info['linkList'][$i];
		$record['add_date'] = $info['dateList'][$i];
		$record['item_1'] = $info['cat'][$i];
		$record['item_2'] = $info['descList'][$i];
		
		if($content = GetRemoteContent($record['url'], $info['header'])) {
			if(preg_match("/<meta name=\"keywords\" content=\"(.+?)\" \/>/i", $content, $matches)) {
				$record['item_3'] = str_replace(" ", ",", $matches[1]);
				unset($matches);
			}
			if(preg_match('/<div id\="news_content"><a href\=".+?" ><img src\="(.+?)".+?\/><\/a>(.+?)<div class\="digbox">/is', $content, $matches)) {
				$cat_image = $db->getSingleResult("select cat_image from ".$setting['db']['pre']."news_cat where cat_id='".$record['item_1']."'");
				if(empty($cat_image)){
					$cat_image = $matches[1];
					$new_file = ROOT_PATH."/".$setting['path']['upload']."/pic".date("/Ym/").GetMicrotime().".".GetFileExt($cat_image);
					if(GetRemoteFile($cat_image, $new_file)) {
						$db->Query("update ".$setting['db']['pre']."news_cat set cat_image='".mysql_real_escape_string($new_file)."' where cat_id='".$record['item_1']."'");
					}
				}
				$record['content'] = $matches[2];
				$record['content'] = preg_replace("/<b>感谢.+?的投递<\/b><br \/>/", "", $record['content']);
				$record['content'] = preg_replace("/新闻来源.+?<br \/>/", "", $record['content']);
				unset($matches);
				$record['item_4'] = "";
				if(preg_match("/<img.+?src=(.?)(http.+?)\\1.+?>/is", $record['content'], $matches)) {
					$new_file = ROOT_PATH."/".$setting['path']['upload']."/article".date("/Ym/").GetMicrotime().".".GetFileExt($matches[2]);
					if(GetRemoteFile($matches[2], $new_file)) {
						$record['item_4'] = $new_file;
					}
				}
				if(preg_match("/<img.+?src=(.?)(http.+?)\\1.+?>/is", $record['content'], $matches)) {
					$record['item_5'] = $matches[2];
				} else {
					$record['item_5'] = "";
				}
				$record['content'] = preg_replace("/^[\r\n\s]+/is", "", $record['content']);
				$record['content'] = preg_replace("/[\r\n\s]+$/is", "", $record['content']);
				if($db->getSingleRecord("select id from ".$setting['db']['pre']."news_snatch where url='".mysql_real_escape_string($record['url'])."'")===false) {
					snatch_log('<div class="item">'.($info['counter']++).' - <a href="'.$record['url'].'" target="_blank">'.$record['subject'].'</a> 获取<span class="succeed" style="color:green;">成功！</span></div>');
					$db->Query($db->buildSQL($setting['db']['pre']."news_snatch", $record, "insert"));
				} else {
					snatch_log('<div class="item">'.($info['counter']++).' - <a href="'.$record['url'].'" target="_blank">'.$record['subject'].'</a> <span class="duplicate" style="color:black;">已存在！</span></div>');
				}
			} else {
				snatch_log('<div class="item">'.($info['counter']++).' - <a href="'.$record['url'].'" target="_blank">'.$record['subject'].'</a> 获取<span class="failed" style="color:red;">失败！</span></div>');
			}
		} else {
			snatch_log('<div class="item">'.($info['counter']++).' - <a href="'.$record['url'].'" target="_blank">'.$record['subject'].'</a> 获取<span class="failed" style="color:red;">失败！</span></div>');
		}
	}
	return true;
}
?>