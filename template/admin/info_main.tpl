<div class="title">网站基本信息</div>
<div id="info">&nbsp;</div>
<div>
	<table id="list_area" width="900" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td class="cat" width="120">网站程序版本</td>
			<td class="row">
				V<?=$ms_version['ver']?> （<?=$ms_version['language']?>/<?=$ms_version['charset']?>/<?=$ms_version['date']?>）
				<a href="###" onclick="confirm('请选择校验方式：\n\n本机校验：通过本地生成的校验信息校验网站文件\n\n网络校验：通过更新服务器上的校验文件校验', 'checkModify', ['本机校验','网络校验'], '文件校验')">检查文件改动</a>
				 |
				<a href="###" onclick="confirm('更新校验信息会造成自动升级时将已改动文件错误覆盖！\n&nbsp;\n是否继续？', 'updateModify', ['确 定','取 消'], '更新本地校验')">更新本地校验</a>
				<span style="display:<?=(file_exists("../update/")?"inline":"none")?>">
					 |
					<a href="###" onclick="emptyUpdate()">清空升级信息</a>
					 |
					<a href="###" onclick="exportUpdate()">导出升级信息</a>
					 |
					<a href="/_maker/log.txt" target="_blank">查看下载记录</a>
				</span>
			</td>
		</tr>
		<tr>
			<td class="cat">网站运行时间</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."counter")?> 天</td>
		</tr>
		<tr>
			<td class="cat">注册会员数</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."users")?> 人</td>
		</tr>
		<tr>
			<td class="cat">登录新闻数量</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."news_show")?> 条</td>
		</tr>
		<tr>
			<td class="cat">当前在线人数</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."user_online")?> 人</td>
		</tr>
		<tr>
			<td class="cat">最高在线人数</td>
			<td class="row"><?=$db->GetSingleResult("select max(online) from ".$setting['db']['pre']."counter")?> 人</td>
		</tr>
		<tr>
			<td class="cat">今日页面访问量</td>
			<td class="row"><?=$db->GetSingleResult("select pv from ".$setting['db']['pre']."counter where date=curdate()")?> 次</td>
		</tr>
		<tr>
			<td class="cat">最高日页面访问量</td>
			<td class="row"><?=$db->GetSingleResult("select max(pv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat">网站页面日均访问量</td>
			<td class="row"><?=(int)$db->GetSingleResult("select avg(pv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat">网站页面总访问量</td>
			<td class="row"><?=$db->GetSingleResult("select sum(pv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat">今日 IP 访问量</td>
			<td class="row"><?=$db->GetSingleResult("select iv from ".$setting['db']['pre']."counter where date=curdate()")?> 次</td>
		</tr>
		<tr>
			<td class="cat">最高日 IP 访问量</td>
			<td class="row"><?=$db->GetSingleResult("select max(iv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat">网站日均 IP 访问量</td>
			<td class="row"><?=(int)$db->GetSingleResult("select avg(iv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat">网站总 IP 访问量</td>
			<td class="row"><?=$db->GetSingleResult("select sum(iv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
	</table>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
var cur_ver = <?=toJson($ms_version, $setting['gen']['charset']);?>;
var update_info = null;
function checkUpdate() {
	if(update_info==null) {
		alert("系统当前版本已为最新，无需更新！");
		return;
	}
	var result = "";
	result += '\
<div align="center">\
	<span style="font-weight:bold;font-size:16px;">更新详情</span><br /><br />\
</div>\
<hr />\
';
	try {
		for(var ver in update_info) {
			result += '\
<div>\
	<div style="font-weight:bold;">Version: '+ver+'</div>\
	<div>'+update_info[ver].info.replace(/[\r\n]+/g, "<br />")+'</div>\
	<div>&nbsp;</div>\
	<div><a href="###" onclick="showFiles($(this).next())">[查看更新文件]</a><div style="display:none;">'+update_info[ver].file.join("<br />")+'</div></div>\
</div>\
<hr />\
';
		}
		confirm(result, "applyUpdate", [" 下载更新 ", " 自动更新 "], "系统更新", false);
	} catch(e) {
		alert("获取更新服务器信息有误，请刷新重试！");
	}
}
function showFiles(obj) {
	var theObj=$("#popupLayer_info_show_content").find(".info");
	if(theObj.css("overflow-y")!="scroll") {
		if(obj.is(":visible")) {
			theObj.css({"height":"auto","width":theObj.width()+10});
		} else {
			theObj.css({"height":theObj.height()+20,"width":theObj.width()-10});
		}
	}
	obj.toggle();
}
function applyUpdate(mode) {
	loadingShow("系统正在获取更新，请耐心等待！");
	mode = (mode==1?"update":"download");
	$.get("update.php?"+mode, function(info){
		loadingShow();
		try {
			alert_org(info.info);
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
function checkModify(mode) {
	loadingShow("正在检测系统文件的变更情况，请等待！");
	var url = "update.php?check_server";
	if(mode==0) url = "update.php?check";
	$.get(url, function(info){
		loadingShow();
		if(info==false) {
			if(mode==0) {
				alert("校验失败，请确认校验信息是否已成功建立！");
			} else {
				alert("服务器连接失败，或不存在本网站对应字符集的校验信息");
			}
		} else {
			var result = "";
			if(info['new']!=null) {
				result += "<b>发现 " + info['new'].length + " 个新增文件：</b>\n";
				result += info['new'].join("\n");
				result += "\n&nbsp;\n";
			}
			if(info['mod']!=null) {
				result += "<b>发现 " + info['mod'].length + " 个文件发生改变：</b>\n";
				result += info['mod'].join("\n");
				result += "\n&nbsp;\n";
			}
			if(info['miss']!=null) {
				result += "<b>发现 " + info['miss'].length + " 个文件被删除：</b>\n";
				result += info['miss'].join("\n");
				result += "\n&nbsp;\n";
			}
		}
		if(result.length==0) {
			alert("未发现改变的文件！");
		} else {
			alert(result, true);
		}
	}, "json");
}
function updateModify(mode) {
	if(mode==1) return;
	loadingShow("正在更新系统文件校验信息，请等待！");
	$.get("update.php?build", function(info){
		loadingShow();
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
$(function(){
	$.get("update.php?"+Math.random(), function(ver_info){
		if(ver_info==null) return;
		$('<a href="###" onclick="checkUpdate()">系统有新版本可更新，点击本链接查看详情！</a>').appendTo("#info");
		$("#info").css({'text-align':'center','padding':'10px','font-size':'18px','font-weight':'bold'});
		update_info = ver_info;
	}, "json");
});
//]]> 
</script>
