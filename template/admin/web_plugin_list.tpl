<div class="title"><!--title--></div>
<div class="addnew"><a href="###" onclick="showPop('upload','导入插件','url','web_plugin.php?method=upload',420, 100)">导入插件</a></div>
<div align="center"><h1>已安装插件</h1></div>
<div align="center">
<form method="post" action="?method=order">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">排序</td>
			<td class="cat" width="150">插件名称</td>
			<td class="cat" width="80">插件版本</td>
			<td class="cat">插件描述</td>
			<td class="cat" width="120">相关操作</td>
		</tr>
<!--loop:start key="plugin_list_1"-->
		<tr class="row" align="center">
			<td>
				<input type="hidden" name="idx[]" value="<!--plugin_list_1_idx-->" size="2" />
				<input type="text" name="order[]" value="<!--plugin_list_1_order-->" size="2" />
			</td>
			<td><!--plugin_list_1_name--></td>
			<td><!--plugin_list_1_ver--><span style="display:<!--plugin_list_1_update-->">（<a href="###" onclick="update('<!--plugin_list_1_idx-->', '<!--plugin_list_1_name-->')" title="可升级至 <!--plugin_list_1_ver_new-->">升级</a>）</span></td>
			<td><!--plugin_list_1_intro--></td>
			<td align="center">
				<a href="?method=uninstall&idx=<!--plugin_list_1_idx-->" onclick="return confirm('是否确认删除该插件？ 请按确定继续。')">卸载</a>
				<a href="?method=active&idx=<!--plugin_list_1_idx-->"><!--plugin_list_1_active--></a>
				<a href="?method=setting&idx=<!--plugin_list_1_idx-->">设置</a>
				<a href="?method=pack&idx=<!--plugin_list_1_idx-->">打包</a>
			</td>
		</tr>
<!--loop:end-->
		<tr>
			<td class="row" colspan="5" align="center">
				<input class="btn" type="Submit" value=" 排 序 " />&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="btn" type="reset" value=" 重 置 " />
			</td>
		</tr>
	</table>
	</form>
</div>

<div align="center"><h1>未安装插件</h1></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="200">插件名称</td>
			<td class="cat" width="80">插件版本</td>
			<td class="cat">插件描述</td>
			<td class="cat" width="120">相关操作</td>
		</tr>
<!--loop:start key="plugin_list_2"-->
		<tr class="row" align="center">
			<td><!--plugin_list_2_name--></td>
			<td><!--plugin_list_2_ver--><span style="display:<!--plugin_list_2_update-->">（<a href="###" onclick="update('<!--plugin_list_2_idx-->', '<!--plugin_list_2_name-->')" title="可升级至 <!--plugin_list_2_ver_new-->">升级</a>）</span></td>
			<td><!--plugin_list_2_intro--></td>
			<td align="center">
				<a href="?method=view&idx=<!--plugin_list_2_idx-->">安装</a>
				<a href="?method=uninstall&idx=<!--plugin_list_2_idx-->" onclick="return confirm('本功能主要用于清除安装未成功的插件残留，可能会造成一些错误记录！ 请按确定继续。')">清除</a>
				<a href="?method=delete&idx=<!--plugin_list_2_idx-->" onclick="return confirm('是否确认删除当前插件？')">删除</a>
				<a href="?method=pack&idx=<!--plugin_list_2_idx-->">打包</a>
			</td>
		</tr>
<!--loop:end-->
<!--if:start condition="judge" key="empty_2"-->
		<tr align="center">
			<td class="row" colspan="4" style="padding:10px;font-size:16px;text-align:center;">所有本地插件均已安装</td>
		</tr>
<!--if:end-->
		</tr>
	</table>
</div>

<div align="center"><h1>可下载插件</h1></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="200">插件名称</td>
			<td class="cat" width="80">插件版本</td>
			<td class="cat">插件描述</td>
			<td class="cat" width="120">相关操作</td>
		</tr>
<!--loop:start key="plugin_list_3"-->
		<tr class="row" align="center">
			<td><!--plugin_list_3_name--></td>
			<td><!--plugin_list_3_ver--></td>
			<td><!--plugin_list_3_intro--></td>
			<td align="center">
				<a href="###" onclick="update('<!--plugin_list_3_idx-->', '<!--plugin_list_3_name-->')">下载</a>
			</td>
		</tr>
<!--loop:end-->
<!--if:start condition="judge" key="empty_3"-->
		<tr align="center">
			<td class="row" colspan="4" style="padding:10px;font-size:16px;text-align:center;">更新服务器无可下载插件</td>
		</tr>
<!--if:end-->
		</tr>
	</table>
</div>

<script language="JavaScript" type="text/javascript">
//<![CDATA[
var dp_list = "<!--dp_list-->";
if(dp_list.length>1) {
	alert("发现如下插件文件存在管理文件名重复，这将影响网站权限的分配，请确认并修正：\n\n" + dp_list);
}
function update(idx, name) {
	loadingShow("“"+name+"”正在更新，请等待！");
	$.get("<!--self-->?method=update&idx="+idx, function(info){
		loadingShow();
		try {
			alert(info.info);
			if(info.link.length>2) {
				window.open(info.link);
			}
			window.location.reload();
		} catch(e) {
			alert("更新获取失败，请检查相关设置！");
		}
	}, "json");
}
//]]> 
</script>
