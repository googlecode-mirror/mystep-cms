<?php
/*
Command needed in iis FastCGI mode
%windir%\system32\inetsrv\appcmd list config -section:system.webServer/fastCgi
%windir%\system32\inetsrv\appcmd set config -section:system.webServer/fastCgi /[fullPath='D:\server\php_cgi\php-cgi.exe'].activityTimeout:2592000

C:\Windows\System32\inetsrv\config\applicationHost.config
*/
require("../inc.php");
ignore_user_abort("on");
set_time_limit(0);
ob_end_clean();

require("config.php");
$interval = $plugin_setting['crontab']['interval'];
$file_status = "status.txt";
$file_log = "log.txt";
$flag = empty($_SERVER["QUERY_STRING"]);
if($flag) {
	if(file_get_contents($file_status)=="run") {
		file_put_contents($file_status, "");
		sleep($interval+2);
	}
	WriteFile($file_log, "Mission Start at ".date("Y-m-d H:i:s")."\n", "wb");
	echo "Mission Start at ".date("Y-m-d H:i:s")."<br />\n";
} else {
	WriteFile($file_log, "Mission Resume at ".date("Y-m-d H:i:s")."\n", "ab");
}
file_put_contents($file_status, "run");
$flag = true;
if(!empty($plugin_setting['crontab']['s_pass']) && !empty($GLOBALS['authority'])) {
	$q_str = $GLOBALS['authority']."=".urlencode($plugin_setting['crontab']['s_pass']);
} else {
	$q_str = rand();
}
while(true) {
	//WriteFile($file_log, "Mission Check at ".date("Y-m-d H:i:s")."\n", "ab");
	if(file_get_contents($file_status)!="run") break;
	if($record = $db->GetSingleRecord("select * from ".$setting['db']['pre']."crontab where next_date<now() and (expire='0000-00-00' || expire>now()) order by next_date limit 1")) {
		if(!empty($record['code'])) {
			eval($record['code']);
		}
		if(!empty($record['url'])) {
			if(strpos($record['url'], $setting['web']['url'])!==false && !is_numeric($q_str)) {
				$record['url'] .= (strpos($record['url'],"?")?"&":"?").$q_str;
			}
			if($fp = @fopen($record['url'], "r")) {
        $buffer = fgets($fp, 4096);
				fclose($fp);
			}
		}
		$next_date = getNextTime($record['mode'], $record['schedule']);
		WriteFile($file_log, $record['name']." - ".date("Y-m-d H:i:s")." / ".$next_date."\n", "ab");
		echo $record['name']." - ".date("Y-m-d H:i:s")."<br />\n";
		$db->Query("update ".$setting['db']['pre']."crontab set `exe_date`=now(), `exe_count`=`exe_count`+1, `next_date`='".$next_date."' where id=".$record['id']);
		unset($record);
	}
	$db->Free();
	sleep($interval);
}
if($flag) WriteFile($file_log, "Mission Stop at ".date("Y-m-d H:i:s")."\n", "ab");
echo "Mission Stop at ".date("Y-m-d H:i:s")."<br />\n";
file_put_contents($file_status, "");

sleep($interval);
if(!empty($goto_url)) {
	if($fp = @fopen($goto_url, "r")) {
		$buffer = fgets($fp, 4096);
		$buffer .= fgets($fp, 4096);
		fclose($fp);
	}
}
$goto_url = "";
$mystep->pageEnd(false);

function getNextTime($mode, $schedule) {
	if($schedule=="0,0,0,0,0") $schedule = ($mode==1?"0,0,0,0,0":"0,0,0,10,0");
	$schedule = explode(",", $schedule);
	if($mode==1) {
		$the_time = time();
		$date_year = date("Y");
		$date_month = date("n");
		$date_day = date("j");
		$date_week = date("w")+1;
		$date_hour = date("G");
		$date_minute = date("i");
		if($schedule[4]==0) {
			if($schedule[0]!=0) {
				if($schedule[0]<=$date_month+1) $date_year += 1;
				$date_month = $schedule[0];
			}
			if($schedule[1]!=0) {
				if($schedule[1]<=$date_day+1) $date_month += 1;
				$date_day = $schedule[1];
			} else {
				if($schedule[0]!=0) $date_day = 1;
			}
			if($schedule[2]<=$date_hour) $date_day += 1;
			$date_hour = $schedule[2];
			$date_minute = $schedule[3];
		} else {
			if($schedule[4] > $date_week) {
				$date_day += $schedule[4]-$date_week+1;
			} else {
				$date_day += 7+$schedule[4]-$date_week+1;
			}
			$date_hour = $schedule[2];
			$date_minute = $schedule[3];
		}
		$next_time = date("Y-m-d H:i:s", mktime($date_hour, $date_minute, 0, $date_month, $date_day, $date_year));
	} else {
		$now = time();
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
				$now += $schedule[3]*60;
			}
		} else {
			$now += $schedule[4]*24*3600;
		}
		$next_time = date("Y-m-d H:i:s", $now);
	}
	return $next_time;
}
?>