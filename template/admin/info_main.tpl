<div class="title">网站基本信息</div>
<div>&nbsp;</div>
<div>
	<table width="900" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td class="cat" width="250">网站程序版本</td>
			<td class="row">
				V<?=$ms_version['ver']?> （<?=$ms_version['language']?>/<?=$ms_version['charset']?>/<?=$ms_version['date']?>）
				<a href="###" onclick="checkUpdate()">检查升级</a>
				<a href="###" onclick="checkModify()">检查文件改动</a>
				<a href="###" onclick="updateModify()">更新文件校验</a>
<!--
				 |
				<a href="###" onclick="emptyUpdate()">清空升级信息</a>
				 |
				<a href="###" onclick="exportUpdate()">导出升级信息</a>
-->
			</td>
		</tr>
		<tr>
			<td class="cat" width="250">网站运行时间</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."counter")?> 天</td>
		</tr>
		<tr>
			<td class="cat" width="250">注册会员数</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."users")?> 人</td>
		</tr>
		<tr>
			<td class="cat" width="250">登录新闻数量</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."news_show")?> 条</td>
		</tr>
		<tr>
			<td class="cat" width="250">当前在线人数</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."user_online")?> 人</td>
		</tr>
		<tr>
			<td class="cat" width="250">最高在线人数</td>
			<td class="row"><?=$db->GetSingleResult("select max(online) from ".$setting['db']['pre']."counter")?> 人</td>
		</tr>
		<tr>
			<td class="cat" width="250">今日页面访问量</td>
			<td class="row"><?=$db->GetSingleResult("select pv from ".$setting['db']['pre']."counter where date=curdate()")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">最高日页面访问量</td>
			<td class="row"><?=$db->GetSingleResult("select max(pv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">网站页面日均访问量</td>
			<td class="row"><?=(int)$db->GetSingleResult("select avg(pv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">网站页面总访问量</td>
			<td class="row"><?=$db->GetSingleResult("select sum(pv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">今日 IP 访问量</td>
			<td class="row"><?=$db->GetSingleResult("select iv from ".$setting['db']['pre']."counter where date=curdate()")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">最高日 IP 访问量</td>
			<td class="row"><?=$db->GetSingleResult("select max(iv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">网站日均 IP 访问量</td>
			<td class="row"><?=(int)$db->GetSingleResult("select avg(iv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">网站总 IP 访问量</td>
			<td class="row"><?=$db->GetSingleResult("select sum(iv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
	</table>
</div>
<div id="bar_loading"><img src="../images/loading.gif" alt="系统更新"><br / >本系统正在更新，请稍候！</div>
<script language="javascript">
var cur_ver = <?=toJson($ms_version, $setting['gen']['charset']);?>;
function checkUpdate() {
	loadingShow();
	$.get("update.php?"+Math.random(), function(ver_info){
		loadingShow();
		try {
			if(ver_info.ver>cur_ver.ver) {
				if(confirm("目前更新服务器的最新版本为： v" + ver_info.ver + "(" + ver_info.date + ")\n\n按“确定”自动更新，按“取消”下载更新程序！\n" + ver_info.update)) {
					applyUpdate(1);
				} else {
					applyUpdate(0);
				}
			} else {
				alert("系统当前版本已为最新，无需更新！");
			}
		} catch(e) {
			alert("获取更新服务器信息失败，请检查相关设置！");
		}
	}, "json");
}
function applyUpdate(mode) {
	loadingShow();
	mode = (mode==1?"update":"download");
	$.get("update.php?"+mode, function(info){
		loadingShow();
		try {
			alert(info.info);
			if(info.link.length>2) {
				window.open(info.link);
			}
			window.top.location.reload();
		} catch(e) {
			alert("更新获取失败，请检查相关设置！");
		}
	}, "json");
}
function emptyUpdate() {
	$.get("update.php?empty", function(info){
		if(info.length==0) {
			alert("更新数据已清空！");
		} else {
			alert(info);
		}
	});
}
function checkModify() {
	$.get("update.php?check", function(info){
		if(info=="error") {
			alert("校验失败，请确认校验信息是否已成功建立！");
		} else if(info.length==0) {
			alert("未发现改变的文件！");
		} else {
			alert("发现如下文件发生改变：\n\n"+info);
		}
	});
}
function updateModify() {
	if(confirm("更新校验信息会造成自动升级时将已改动文件错误覆盖，是否继续？")==false) return;
	$.get("update.php?build", function(info){
		if(info.length==0) {
			alert("已成功更新当前系统文件校验信息！");
		} else {
			alert("校验信息更新失败！");
		}
	});
}
function exportUpdate() {
	window.open("update.php?export");
}
</script>
