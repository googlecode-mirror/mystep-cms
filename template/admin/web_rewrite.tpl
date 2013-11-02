<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?update" onsubmit="return checkForm(this)">
		<table id="input_area" name="main" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" colspan="4">静态网址转向设置</td>
			</tr>
			<tr align="center">
				<td class="cat" width="30">序号</td>
				<td class="cat">规则内容</td>
				<td class="cat">跳转网址</td>
				<td class="cat" width="120">操作</td>
			</tr>
<!--loop:start key="rewrite"-->
			<tr>
				<td class="cat"><!--rewrite_idx--></td>
				<td class="row"><input name="rule[]" type="text" size="10" value="<!--rewrite_rule-->" need="" /></td>
				<td class="row"><input name="jump[]" type="text" size="10" value="<!--rewrite_jump-->" need="" /></td>
				<td class="row" align="center">
					<input class="btn" type="button" onclick="add(this)" style="width:50px;" value="增加" />
					<input class="btn" type="button" onclick="del(this)" style="width:50px;" value="删除" />
				</td>
			</tr>
<!--loop:end-->
			<tr>
				<td class="row" colspan="4">
					网址静态化：
					<input type="radio" class="cbox" id="rewrite_1" name="rewrite" value="true" <!--rewrite_1--> /><label for="rewrite_1">开启</label>
					<input type="radio" class="cbox" id="rewrite_2" name="rewrite" value="false" <!--rewrite_2--> /><label for="rewrite_2">关闭</label>
					<span class="comment">开启 URL Rewrite 可增强搜索引擎的索引，但需要服务器安装相应支持模块！</span>
					<br /><br />
					文章页索引：<input type="text" name="read" value="<!--rewrite_read-->" /> &nbsp;
					列表页索引：<input type="text" name="list" value="<!--rewrite_list-->" />
					<br /><br />
					标签页索引：<input type="text" name="tag" value="<!--rewrite_tag-->" /> &nbsp;
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="4" align="center">
					<select name="write_type" onchange="setRule(this.value)">
						<option value="">写入配置文件</option>
						<option value="Apache">写入 .htaccess （Apache）</option>
						<option value="IIS7">写入 web.config （IIS）</option>
					</select>
					<input type="hidden" name="rule_new" />
			</tr>
			<tr>
				<td class="row" colspan="4" align="center">
					<input class="btn" type="Submit" value=" 确认修改 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重置数据 " />&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	</form>
	<table id="input_area" cellspacing="0" cellpadding="0">
		<tr>
			<td class="cat" colspan="4">静态网址转向设置 - 插件</td>
		</tr>
		<tr align="center">
			<td class="cat" width="30">序号</td>
			<td class="cat">规则内容</td>
			<td class="cat">跳转网址</td>
			<td class="cat" width="120">所属插件</td>
		</tr>
<!--loop:start key="rewrite_plugin"-->
		<tr>
			<td class="cat" align="center"><!--rewrite_plugin_idx--></td>
			<td class="row"><input name="rule[]" type="text" size="10" value="<!--rewrite_plugin_rule-->" need="" /></td>
			<td class="row"><input name="jump[]" type="text" size="10" value="<!--rewrite_plugin_jump-->" need="" /></td>
			<td class="row" align="center"><!--rewrite_plugin_plugin--></td>
		</tr>
<!--loop:end-->
	</table>
	
	<table id="input_area" cellspacing="0" cellpadding="0">
		<tr>
			<td class="cat" colspan="4">
				规则生成：
				<select id="rule_type" name="type" onchange="createRule(this.value)">
					<option>Apache</option>
					<option>Nginx</option>
					<option>IIS7</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="row" colspan="4">
			<textarea id="rule" style="width:100%;height:200px;"></textarea>
			</td>
		</tr>
	</table>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
function add(obj) {
	obj = $(obj).parent().parent().clone();
	obj.find("input[type=text]").val("");
	obj.find("td:first").text($("#input_area[name=main] tr").length - 3);
	$("#input_area tr:last").prev().before(obj);
}
function del(obj) {
	obj = $(obj).parent().parent();
	if(obj.find("input")[0].defaultValue.toLowerCase()!="default") obj.remove();
}
function createRule(type) {
	var result = "";
	var rules = new Array();
	var obj_1 = $name("rule[]");
	var obj_2 = $name("jump[]");
	for(var i=0, m=obj_1.length;i<m;i++) {
		if(obj_1[i].value!="" && obj_2[i].value!="") {
			rules.push([obj_1[i].value, obj_2[i].value.replace(/\$/g,"/")]);
		}
	}
	m = rules.length;
	switch(type) {
		case "Nginx":
			for(i=0;i<m;i++) {
				result += "rewrite ^/"+rules[i][0]+"$\t/"+rules[i][1]+"\tlast;\n";
			}
			break;
		case "IIS7":
			result = "<rewrite>\n\t<rules>";
			for(i=0;i<m;i++) {
				result += '\n\
		<rule name="rule_'+i+'" stopProcessing="true">\n\
			<match url="'+rules[i][0]+'$" ignoreCase="true" />\n\
			<action type="Rewrite" url="'+rules[i][1].replace(/\/(\d+)/g, "{R:$1}").replace(/&/g,"&amp;")+'" appendQueryString="true" />\n\
		</rule>';
			}
			result += "\n\t</rules>\n</rewrite>";
			break;
		default:
			result = "RewriteEngine on\n";
			for(i=0;i<m;i++) {
				result += "RewriteRule ^"+rules[i][0]+"$\t/"+rules[i][1]+"\t[QSA,L]\n";
			}
			break;
	}
	$("#rule").val(result);
	return;
}
function setRule(mode) {
	if(mode=="") {
		$("input[name=rule_new]").val("");
	} else {
		$("#rule_type").val(mode);
		createRule(mode);
		$("input[name=rule_new]").val($("#rule").val());
	}
	return;
}
$(function(){
	createRule();
});
//]]> 
</script>