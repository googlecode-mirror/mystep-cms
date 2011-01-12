<?php
if(!includeCache("user")) {
	if(buildParaList("user")) {
		includeCache("user");
	} else {
		die("网站出现错误，请联系<a href=\"mailto:{$web_email}\">管理员</a>！");
	}
}

function getGroupDetail($value, $col = "id") {
	return getParaInfo("user_group", $col, $value);
}

function User_info() {
	global $req, $db, $s_user, $s_pass;
	$ms_user = $req->getCookie('ms_user');
	$user_id = $user_pwd = null;
	if(!empty($ms_user)) list($user_id, $user_pwd)=explode("\t",$ms_user);
	$username = $req->getCookie('username');
	if($username==$s_user && $user_pwd==$s_pass) {
		$detail = array();
		$group_info = getGroupDetail("2");
		$detail["uid"] = "-1";
		$detail["username"] = $username;
		$detail['type'] = "管理员";
		$detail['power'] = $group_info['power_func'];
		$detail['power_cata'] = $group_info['power_cata'];
		$detail['groupid'] = $group_info['id'];
	} elseif($user_id && strlen($user_pwd)>=16 && $detail =$db->GetSingleRecord("SELECT user_id, group_id, username, password from users where user_id='{$user_id}'")) {
		if($user_pwd==$detail['password']) {
			unset($detail['password']);
			if($group_info = getGroupDetail($detail['group_id'])) {
				$detail['type'] = $group_info['group_name'];
				$detail['power'] = $group_info['power_func'];
				$detail['power_cata'] = $group_info['power_cata'];
			} else {
				$detail['type'] = "";
				$detail['power'] = "";
				$detail['power_cata'] = "";
			}
		} else {
			unset($detail);
		}
	}
	if(!isset($detail)) {
		if(empty($username)) {
			global $ip;
			$username = "guest_".md5($ip.$_SERVER['REQUEST_TIME']);
			$req->setCookie("username", $username, $_SERVER['REQUEST_TIME']+3600*24);
		}
		$detail = array();
		$group_info = getGroupDetail("1");
		$detail["uid"] = "-1";
		$detail["username"] = $username;
		$detail['type'] = $group_info['group_name'];
		$detail['power'] = $group_info['power_func'];
		$detail['power_cata'] = $group_info['power_cata'];
	}
	return $detail;
}

$ip = getIp();
$user = User_info();

//online
$position = $req->getServer("REQUEST_URI");
if(!get_magic_quotes_gpc()) $position = addslashes($position);
if(strpos($position, "ajax")===false) {
	$flag = $db->Query("update user_online set reflash_time=unix_timestamp(), user_name='".$user['username']."', user_type='".$user['type']."', position='{$position}' where ip='{$ip}'");
	if($flag==0) {
		$db->Query("insert into user_online values('{$ip}','".$user['username']."','".$user['type']."',unix_timestamp(),'{$position}')");
	}
	if(rand(0,10)>8) $db->Query("delete from user_online where reflash_time<(unix_timestamp()-".($session_expire*60).")");
}

// Website Counter
$cnt_visitor	= $req->getCookie("cnt_visitor");
$add_ip		= 0;
$pv		= 0;
$iv		= 0;
if (empty($cnt_visitor) || $cnt_visitor!=$ip){
	$req->setCookie("cnt_visitor", $ip, $_SERVER['REQUEST_TIME']+3600*24);
	$add_ip = 1;
}
$count_online = $db->GetSingleResult("select count(*) from user_online");
if($record = $db->GetSingleRecord("select pv, iv, online from counter where date=curdate()")) {
	$pv = $record['pv'] + 1;
	$iv = $record['iv'] + $add_ip;
	$online = max($record['online'], $count_online);
	$result = $db->Query("update counter set pv={$pv}, iv={$iv}, online={$online} where date=curdate()");
}else{
	$pv = 1;
	$iv = 1;
	$result = $db->Query("insert into counter values(0,curdate(), $pv, $iv, 1)");
}
?>