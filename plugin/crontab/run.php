<?php
require("../inc.php");
set_time_limit(0);
ignore_user_abort(true);
file_put_contents("status.txt", "run");
WriteFile("log.txt", "Mission Start at ".date("Y-m-d H:i:s")."\n", "wb");

while(true) {
	$status = file_get_contents("status.txt");
	if($status!="run") break;
	$db->Query("select * from ".$setting['db']['pre']."crontab where next_date<now()");
	while($record = $db->GetRS()) {
		if(!empty($record['url'])) {
			if($fp = @fopen($record['url'], "r")) {
				fclose($fp);
			}
		}
		if(!empty($record['code'])) {
			eval($record['code']);
		}
		WriteFile("log.txt", date("Y-m-d H:i:s")." - ".$record['name']."\n", "ab");
		$db->Query("update ".$setting['db']['pre']."crontab set `exe_date`=now(), `exe_count`=`exe_count`+1, `next_date`='".getNextTime($record['mode'], $record['schedule'])."' where id=".$record['id']);
	}
	$db->Free();
	sleep(300);
}
WriteFile("log.txt", "Mission Stop at ".date("Y-m-d H:i:s")."\n", "ab");

function getNextTime($mode, $schedule) {
	if($schedule=="0,0,0,0,0") $schedule = "0,0,0,10,0";
	$schedule = explode(",", $schedule);
	if($mode==1) {
		$date_year = date("Y");
		$date_month = date("m");
		$date_day = date("d");
		$date_week = date("w")+1;
		$date_hour = date("H");
		$date_minute = date("i");
		if($schedule[4]==0) {
			if($schedule[0]!=0) {
				$date_year += 1;
				$date_month = $schedule[0];
			}
			if($schedule[1]!=0) {
				$date_day = $schedule[1];
			}
		} else {
			if($schedule[4] > $date_week) {
				$date_day += $schedule[4]-$date_week;
			} else {
				$date_day += 7+$schedule[4]-$date_week;
			}
		}
		if($schedule[2]!=0) {
			$date_hour = $schedule[2];
		}
		if($schedule[3]!=0) {
			$date_minute = $schedule[3];
		}
		$next_time = $date_year."-".$date_month."-".$date_day." ".$date_hour.":".$date_minute.":00";
	} else {
		$now = $_SERVER['REQUEST_TIME'];
		if($schedule[4]==0) {
			if($schedule[0]!=0) {
				$now += $schedule[0]*30*24*3600;
			}
			if($schedule[1]!=0) {
				$now += $schedule[1]*24*3600;
			}
			if($schedule[2]!=0) {
				$now += $schedule[2]*3600;
			}
			if($schedule[3]!=0) {
				$now += $schedule[2]*60;
			}
		} else {
			$now += $schedule[4]*24*3600;
		}
		$next_time = date("Y-m-d H:i:s", $now);
	}
	return $next_time;
}
?>