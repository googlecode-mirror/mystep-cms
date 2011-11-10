<?php
$id = $req->getGet("id");
if(isset($_GET['show'])) {
	$path = dirname(__FILE__)."/data/";
	$img_cache = ROOT_PATH."/".$setting['path']['cache']."/html/survey_{$id}.png";
	if(!file_exists($img_cache)) {
		if(file_exists($path."survey_".$id.".db")) {
			$mydb = $mystep->getInstance("MyDB", "survey_".$id, $path);
			$item_list=$mydb->queryAll();
			$chart_item = array();
			$chart_data = array();
			for($i=0,$m=count($item_list);$i<$m;$i++) {
				$chart_item[] = $item_list[$i]['title'];
				$chart_data[] = $item_list[$i]['vote'];
			}
			unset($item_list);
			$width = 600;
			$height = 500 + $m * 30;
			$chart = $mystep->getInstance("coordinateMaker", $width, $height);
			$chart->createImage(true, array(0xff,0xff,0xff));
			$chart->setFont(ROOT_PATH."/images/font.ttc");
			$chart->drawPie($chart_data, $chart_item, array(300, 250), 400, 300, 1, 2, 20, 0, 10, 0);
			$chart->makeImage("png", $img_cache);
		} else {
			$goto_url = "/images/noimage.gif";
		}
	}
	if(empty($goto_url)) $goto_url = str_replace(ROOT_PATH, "/", $img_cache);
} else {
	if($survey_info = getData("select * from ".$setting['db']['pre']."survey where id={$id}", "record", 86400)) {
		$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
		$tpl_info['idx'] = "survey";
		$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/";
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
		$survey_info['expire'] = date("Y-m-d", $survey_info['add_date']+$survey_info['expire']);
		$survey_info['add_date'] = date("Y-m-d", $survey_info['add_date']);
		$survey_info['type'] = ($survey_info['max_select']==1 ? "radio" : "checkbox");
		$surver[$id] = $survey_info;
		$tpl_tmp->Set_Variable("survey", $surver);
		$tpl_tmp->Set_Variables($survey_info, "record");
		$GLOBALS['survey_id'] = $survey_info['id'];
		$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
		unset($tpl_temp);
		$mystep->show($tpl);
	} else {
		$goto_url = "/";
	}
}
$mystep->pageEnd(false);
?>