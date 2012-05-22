<?php
class plugin_ad_show implements plugin {
	public static function install() {
		global $setting;
		$info = self::info();
		if($plugin_info = getParaInfo("plugin", "idx", $info['idx'])) {
			showInfo(sprintf($setting['language']['plugin_err_dup'], $info['name']));
		}
		if($plugin_info = getParaInfo("plugin", "class", $info['class'])) {
			showInfo(sprintf($setting['language']['plugin_err_classname'], $info['name']));
		}
		global $db, $setting, $admin_cat;
		$strFind = array("{pre}", "{charset}");
		$strReplace = array($setting['db']['pre'], $setting['db']['charset']);
		$result = $db->ExeSqlFile(dirname(__FILE__)."/install.sql", $strFind, $strReplace);
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['ver'].'", "plugin_ad_show", 1, "'.$info['intro'].'", "'.$info['copyright'].'", 1, "")');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 3, '".$info['cat_name']."', 'ad_show.php', '../plugin/ad_show/', 0, 0, '".$info['cat_desc']."')");
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_install']."
			<br />
			<pre>
			".join("\n------------------------\n", $err)."
			</pre>
			");
		} else {
			deleteCache("admin_cat");
			includeCache("admin_cat");
			$admin_cat = toJson($admin_cat, $setting['gen']['charset']);
			echo <<<mystep
<script language="javascript">
parent.admin_cat = {$admin_cat};
parent.setNav();
</script>
mystep;
			deleteCache("plugin");
			buildParaList("plugin");
			echo showInfo($setting['language']['plugin_install_done'], false);
		}
	}
	
	public static function uninstall() {
		global $db, $setting, $admin_cat;
		$info = self::info();
		$db->query("truncate table ".$setting['db']['pre']."ad_show");
		$db->query("drop table ".$setting['db']['pre']."ad_show");
		$db->query("delete from ".$setting['db']['pre']."admin_cat where file='ad_show.php'");
		$db->query("delete from ".$setting['db']['pre']."plugin where idx='".$info['idx']."'");
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_uninstall']."
			<br />
			<pre>
			".join("\n------------------------\n", $err)."
			</pre>
			");
		} else {
			deleteCache("admin_cat");
			includeCache("admin_cat");
			$admin_cat = toJson($admin_cat, $setting['gen']['charset']);
			echo <<<mystep
<script language="javascript">
parent.admin_cat = {$admin_cat};
parent.setNav();
</script>
mystep;
			deleteCache("plugin");
			buildParaList("plugin");
			echo showInfo($setting['language']['plugin_uninstall_done'], false);
		}
	}
	
	public static function info() {
		$info = null;
		if(is_file(dirname(__FILE__)."/info.php")) include(dirname(__FILE__)."/info.php");
		return $info;
	}
	
	public static function check() {
		$result = "";
		$theList = array(
			"/ipdata/",
			"/files/",
		);
		$error = false;
		foreach($theList as $cur) {
			if(isWriteable(dirname(__FILE__).$cur)) {
				$result .= $cur . ' - <span style="color:green">Writable</span><br />';
			} else {
				$result .= $cur . ' - <span style="color:red">Readonly</span><br />';
				$error = true;
			}
		}
		if($error) $result .= '<span id="error"></span>';
		return $result;
	}
	
	public static function ad_show(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		$style = "overflow:hidden;";
		if(!isset($att_list['limit'])) $att_list['limit'] = 1;
		if(!isset($att_list['class'])) $att_list['class'] = "";
		if(isset($att_list['css'])) $style .= $att_list['css'];
		if(isset($att_list['width'])) $style .= "width:".$att_list['width']."px";
		if(isset($att_list['height'])) $style .= "height:".$att_list['height']."px";
		if(!isset($att_list['css_ad'])) $att_list['css_ad'] = "";
		if(!isset($att_list['width_ad'])) $att_list['width_ad'] = "";
		if(!isset($att_list['height_ad'])) $att_list['height_ad'] = "";
		
		$str_sql = "select * from ".$setting['db']['pre']."ad_show where exp_date>now()";
		if(isset($att_list['idx']))  $str_sql .= " and idx='".$att_list['idx']."'";
		$str_sql .= " order by ad_level desc";
		if(isset($att_list['limit']))  $str_sql .= " limit ".$att_list['limit'];
		$the_path = dirname(__FILE__);
		$result = <<<mytpl
<?php
global \$req;
\$records = getData("{$str_sql}", "all", 3600*24);

echo "<div class=\"{$att_list['class']}\" style=\"{$style}\">\n";
for(\$i=0, \$m=count(\$records); \$i<\$m; \$i++) {
	\$style = "overflow:hidden;";
	if(\$i<\$m-1) \$style = "margin-left:10px;";
	\$size = "";
	if("{$att_list['width_ad']}"!="") {
		\$style .= 'width:{$att_list[width_ad]}px;';
		\$size .= ' width="{$att_list[width_ad]}"';
	}
	if("{$att_list['height_ad']}"!="") {
		\$style .= 'height:{$att_list[height_ad]}px;';
		\$size .= ' height="{$att_list[height_ad]}"';
	}
	echo "<span style=\"{\$style}{$att_list['css_ad']}\">\n";
	switch(\$records[\$i]['ad_mode']) {
		case "1":
			echo '<a href="module.php?m=ad_link&id='.\$records[\$i]['id'].'" target="_blank"><img src="'.\$records[\$i]['ad_file'].'" border="0" alt="'.\$records[\$i]['ad_text'].'" '.\$size.' /></a>';
			break;
		case "2":
			echo '<embed src="'.\$records[\$i]['ad_file'].'" '.\$size.'></embed>';
			break;
		case "3":
			echo '<iframe src="'.\$records[\$i]['ad_file'].'" '.\$size.' marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" ALLOWTRANSPARENCY="true"></iframe>';
			break;
		case "4":
			echo '<script language="Javascript" src="'.\$records[\$i]['ad_file'].'"></script>';
			break;
		default:
			echo '<a href="module.php?m=ad_link&id='.\$records[\$i]['id'].'" target="_blank">'.\$records[\$i]['ad_text'].'</a>';
			break;
	}
	echo "</span>\n";
	\$agent = strtolower(\$req->getServer('HTTP_USER_AGENT'));
	if(strpos(\$agent, "spider")===false && strpos(\$agent, "bot")===false) {
		 \$if_view = \$req->getCookie("img_view_".\$records[\$i]['id']);
		if(!empty(\$if_view)) {
			\$new_ip = 0;
		} else {
			\$req->setCookie("img_view_".\$records[\$i]['id'], "Y", 3600*24);
			WriteFile("{$the_path}/ipdata/".\$records[\$i]['id'].".csv", "view,".GetIp().",".date("Y-m-d H:i:s")."\n", "ab");
			\$new_ip = 1;
		}
		\$db->query("update ".\$setting['db']['pre']."ad_show set view=view+1, ip_view=ip_view+".\$new_ip." where id=".\$records[\$i]['id']);
	}
}
echo "</div>\n";
?>
mytpl;
		return $result;
	}
}
?>