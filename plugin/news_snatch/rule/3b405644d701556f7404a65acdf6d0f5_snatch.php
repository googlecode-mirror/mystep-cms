<?php
function snatchGetInfo($url, $para=array()) {
	global $db, $setting;
	$date = isset($para['date'])?$para['date']:date("Ymd");
	$url = "http://news.sohu.com/_scroll_newslist/".$date."/news.inc";
	$info = array();
	$info['page_count'] = 1;
	$header = array();
	if(isset($para['header'])) $header = $para['header'];
	$info['header'] = $header;
	if($content = GetRemoteContent($url, $header)) {
		$content = preg_replace("/^.+?(\{.+\}).*$/", '\1', $content);
		$content = json_decode_js($content, true);
		$info['catList'] = $content['category'];
		$info['newList'] = $content['item'];
		unset($content);
		$info['cat_main'] = $db->getSingleResult("select cat_id from ".$setting['db']['pre']."news_cat where cat_name='新闻资讯'");
		if(empty($info['cat_main'])) {
			$db->Query("INSERT INTO `".$setting['db']['pre']."news_cat` VALUES (0, ".$para['web_id'].", 0, '新闻资讯', '国内,国际,社会,财经,军事,体育,娱乐,文化,汽车', '国内资讯,国际资讯,社会资讯,财经资讯,军事资讯,体育资讯,娱乐资讯,文化资讯,汽车资讯', 'news', '', '', 1, 0, '', 1, 255, 0, '');");
			$info['cat_main'] = $db->GetInsertId();
		}
		for($i=0, $m=count($info['catList']); $i<$m; $i++) {
			$info['catList'][$i][0] = chg_charset($info['catList'][$i][0], "utf-8", $setting['gen']['charset']);
			$cat_id = $db->getSingleResult("select cat_id from ".$setting['db']['pre']."news_cat where cat_name='".mysql_real_escape_string($info['catList'][$i][0])."'");
			if(empty($cat_id)) {
				$keyword = "";
				$descripiton = "";
				if($content = GetRemoteContent($info['catList'][$i][1], $header)) {
					if(preg_match("/<meta name=\"keywords\" content=\"(.+?)\">/i", $content, $matches)) {
						$keyword = str_replace(" ", ",", $matches[1]);
						unset($matches);
					}
					if(preg_match("/<meta name=\"description\" content=\"(.+?)\">/i", $content, $matches)) {
						$descripiton = str_replace(" ", ",", $matches[1]);
						unset($matches);
					}
				}
				$db->Query("INSERT INTO `".$setting['db']['pre']."news_cat` VALUES (0, ".$para['web_id'].", ".$info['cat_main'].", '".mysql_real_escape_string($info['catList'][$i][0])."', '".mysql_real_escape_string($keyword)."', '".mysql_real_escape_string($descripiton)."', '".mysql_real_escape_string($info['catList'][$i][0])."', '', '', 1, 0, '', 2, 255, 0, '');");
				$cat_id = $db->GetInsertId();
			}
			$info['catList'][$i][] = $cat_id;
		}
		deleteCache("news_cat");
		for($i=0, $m=count($info['newList']); $i<$m; $i++) {
			$info['newList'][$i][1] = chg_charset($info['newList'][$i][1], "utf-8", $setting['gen']['charset']);
			$info['newList'][$i][] = $info['catList'][$info['newList'][$i][0]][2];
		}
	} else {
		return false;
	}
	return $info;
}

function snatchGetList($record, &$info) {
	global $db, $setting, $req;
	$idx = $req->getCookie("ns_idx");
	if(empty($idx)) $idx = 0;
	for($i=$idx, $m=count($info['newList']); $i<$m; $i++) {
		if(isset($info['para']['pre_max']) && ($i-$idx)>=$info['para']['pre_max']) break;
		$record['subject'] = $info['newList'][$i][1];
		$record['original'] = "搜狐网";
		$record['url'] = $info['newList'][$i][2];
		$record['add_date'] = date("Y")."/".$info['newList'][$i][3];
		$record['item_2'] = $info['newList'][$i][4];
		
		if(strpos($record['url'], ".sohu.com")===false) continue;
		
		if($content = GetRemoteContent($record['url'], $info['header'])) {
			if(preg_match("/来源：<span.+?>(.+?)<\/span>/i", $content, $matches)) {
				$record['original'] = $matches[1];
				unset($matches);
			}
			if(preg_match("/<meta name=\"keywords\" content=\"(.+?)\">/i", $content, $matches)) {
				$record['item_3'] = str_replace(" ", ",", $matches[1]);
				unset($matches);
			}
			if(preg_match("/<meta name=\"description\" content=\"(.+?)\">/i", $content, $matches)) {
				$record['item_4'] = str_replace(" ", ",", $matches[1]);
				$record['item_4'] = substrPro($record['item_4'], 0, 230);
				unset($matches);
			}
			$flag = false;
			if(preg_match("/<\!\-\- 正文 st \-\->[\r\n\s]+<div.+?>(.+?)<\/div>[\r\n\s]+<\!\-\- 正文 end \-\->/is", $content, $matches)) {
				$record['content'] = $matches[1];
				$record['content'] = preg_replace("/<div class\=\"tagIntg.+?<\/div>/is", "", $record['content']);
				$record['content'] = preg_replace("/<div class\=\"tagHotg.+?<\/div>/is", "", $record['content']);
				$record['content'] = preg_replace("/<div class\=\"editer.+?<\/div>/is", "", $record['content']);
				unset($matches);
				$flag = true;
			} elseif(preg_match("/<div class\=\"textcont\" id\=\"textcont\">(.+?)<\/div>/is", $content, $matches)) {
				$cur_content = array();
				$cur_content[0] = $matches[1];
				$cur_content[0] = preg_replace("/<p class\=\"editUsr.+?<\/p>/is", "", $cur_content[0]);
				$cur_content[0] = preg_replace("/<p>.+?<p>/is", "<p>", $cur_content[0]);
				$cur_content[0] = preg_replace("/<\/p>[\s\r\n]+?<\/p>/is", "</p>", $cur_content[0]);
				$cur_content[0] = preg_replace("/^[\r\n\s]+/is", "", $cur_content[0]);
				$cur_content[0] = preg_replace("/[\r\n\s]+$/is", "", $cur_content[0]);
				unset($matches);
				if(preg_match("/<img id\=\"slide_pic\" src\=\"(.+?)\" alt\=\"(.+?)\".*?>/is", $content, $matches)) {
					$cur_content[0] = "<p>".$matches[0]."</p>\n".$cur_content[0];
				}
				unset($matches);
				if(preg_match("/<span id\=\"pageNum\">1\/(\d+)<\/span>/is", $content, $matches)) {
					$pages = $matches[1];
					unset($matches);
					for($n=1; $n<$pages; $n++) {
						$cur_url = preg_replace("/(\.\w+)$/i", "_".$n."\\1", $record['url']);
						if($page_content = GetRemoteContent($cur_url, $info['header'])) {
							if(preg_match("/<div class\=\"textcont\" id\=\"textcont\">(.+?)<\/div>/is", $page_content, $matches)) {
								$cur_content[$n] = $matches[1];
								$cur_content[$n] = preg_replace("/<p class\=\"editUsr.+?<\/p>/is", "", $cur_content[$n]);
								$cur_content[$n] = preg_replace("/<p>.+?<p>/is", "<p>", $cur_content[$n]);
								$cur_content[$n] = preg_replace("/<\/p>[\s\r\n]+?<\/p>/is", "</p>", $cur_content[$n]);
								$cur_content[$n] = preg_replace("/^[\r\n\s]+/is", "", $cur_content[$n]);
								$cur_content[$n] = preg_replace("/[\r\n\s]+$/is", "", $cur_content[$n]);
							}
							unset($matches);
							if(preg_match("/<img id\=\"slide_pic\" src\=\"(.+?)\" alt\=\"(.+?)\".*?>/is", $page_content, $matches)) {
								$cur_content[$n] = "<p>".$matches[0]."</p>\n".$cur_content[$n];
							}
							unset($matches);
						}
					}
				}
				$record['content'] = implode("<!-- pagebreak -->", $cur_content);
				$flag = true;
			} elseif(preg_match("/<div id\=\"news_c\".+?>(.+?)<div id\=\"news_s\"/is", $content, $matches)) {
				$record['content'] = $matches[1];
				unset($matches);
				$flag = true;
			} else {
				snatch_log('<div class="item">'.($info['counter']++).' - <a href="'.$record['url'].'" target="_blank">'.$record['subject'].'</a> 获取<span class="failed" style="color:red;">失败！</span></div>');
			}
			if($flag) {
				if($db->getSingleRecord("select id from ".$setting['db']['pre']."news_snatch where url='".mysql_real_escape_string($record['url'])."'")===false) {
					$record['content'] = preg_replace("/<script.+?<\/script>/is", "", $record['content']);
					$record['content'] = preg_replace("/<style.+?<\/style>/is", "", $record['content']);
					$record['content'] = preg_replace("/<form.+?<\/form>/is", "", $record['content']);
					$record['content'] = preg_replace("/<iframe.+?<\/iframe>/is", "", $record['content']);
					$record['content'] = preg_replace("/^[\r\n\s]+/is", "", $record['content']);
					$record['content'] = preg_replace("/[\r\n\s]+$/is", "", $record['content']);
					$record['content'] = preg_replace("/延伸阅读.+$/", "", $record['content']);
					$record['content'] = preg_replace("/<DIV class\=\"tvsubject.+$/", "", $record['content']);
					$record['content'] = str_replace("微博推荐", "", $record['content']);
					$record['content'] = str_replace("我来纠错", "", $record['content']);
					$record['content'] = str_replace('<div class="line"></div>', "", $record['content']);
					$record['content'] = preg_replace("/<div class\=\"stockTrends.+?<\/div>/s", "", $record['content']);
					$record['content'] = preg_replace("/<div class\=\"shareIn.+?<\/div>/s", "", $record['content']);
					$record['content'] = preg_replace("/[\r\n]+<div class\=\"muLink.+?<\/div>[\r\n]+/", "", $record['content']);
					$record['content'] = preg_replace("/<DIV class\=\"tvsubject.+$/s", "", $record['content']);
					if(preg_match("/<img.+?src=(.?)(http.+?)\\1.+?>/is", $record['content'], $matches)) {
						$record['item_5'] = $matches[2];
					} else {
						$record['item_5'] = "";
					}
					if($record['item_5']=="http://images.sohu.com/ccc.gif" || $record['item_5']=="http://photo.sohu.com/20040809/Img221437781.gif" || $record["item_5"]=="http://photocdn.sohu.com/20090828/dot.gif") $record['item_5']="";
					snatch_log('<div class="item">'.($info['counter']++).' - <a href="'.$record['url'].'" target="_blank">'.$record['subject'].'</a> 获取<span class="succeed" style="color:green;">成功！</span></div>');
					$db->Query($db->buildSQL($setting['db']['pre']."news_snatch", $record, "insert"));
				} else {
					snatch_log('<div class="item">'.($info['counter']++).' - <a href="'.$record['url'].'" target="_blank">'.$record['subject'].'</a> <span class="duplicate" style="color:black;">已存在！</span></div>');
				}
			}
		} else {
			snatch_log('<div class="item">'.($info['counter']++).' - <a href="'.$record['url'].'" target="_blank">'.$record['subject'].'</a> 获取<span class="failed" style="color:red;">失败！</span></div>');
		}
		$req->setCookie("ns_idx", $i, 86400);
	}
	if($i>=$m) $req->setCookie("ns_idx");
	return true;
}
?>