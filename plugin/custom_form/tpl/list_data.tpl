<div class="title"><!--title--></div>
<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	<!--custom_form_name-->
</div>
<div class="nav">
	<a href="?mid=<!--mid-->">显示全部</a>
 |
	<a href="?method=export&mid=<!--mid-->">导出数据</a>
 |
	关键字：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?mid=<!--mid-->&keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?mid=<!--mid-->&keyword='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40"><a href="?mid=<!--mid-->&keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat"><a href="?mid=<!--mid-->&keyword=<!--keyword-->&order=name&order_type=<!--order_type-->"><font color="#000000">姓名</font></a></td>
			<td class="cat"><a href="?mid=<!--mid-->&keyword=<!--keyword-->&order=company&order_type=<!--order_type-->"><font color="#000000">公司</font></a></td>
			<td class="cat"><a href="?mid=<!--mid-->&keyword=<!--keyword-->&order=tel&order_type=<!--order_type-->"><font color="#000000">电话</font></a></td>
			<td class="cat"><a href="?mid=<!--mid-->&keyword=<!--keyword-->&order=add_date&order_type=<!--order_type-->"><font color="#000000">填表时间</font></a></td>
			<td class="cat" width="100">相关操作</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><a href="mailto:<!--record_email-->" class="mail"><!--record_name--></a></td>
			<td class="row"><a href="?method=edit&mid=<!--mid-->&id=<!--record_id-->&keyword=<!--keyword-->"><!--record_company--></a></td>
			<td class="row"><!--record_tel--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row" align="center"><a href="?method=edit&mid=<!--mid-->&id=<!--record_id-->&keyword=<!--keyword-->">编辑</a> &nbsp;<a href="?method=delete&mid=<!--mid-->&id=<!--record_id-->" onclick="return confirm('确认删除？？')">删除</a><!--record_confirm--></td>
		</tr>
<!--loop:end-->
	</table>
</center>
<div class="nav">
	<a href="###" onclick="showPop('import','导入数据','id','import',420, 150)">导入数据</a>
 |
	新用户：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13 && this.value.length>=2)location.href='?method=add_data_ok&mid=<!--mid-->&name='+this.value" /><input type="button" value="添加" onclick="if(this.previousSibling.value.length>=2)location.href='?method=add_data_ok&mid=<!--mid-->&name='+this.previousSibling.value" />
 |
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>
	<a href="<!--page_prev-->">上页</a>
	<a href="<!--page_next-->">下页</a>
	<a href="<!--page_last-->">末页</a>
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" /><input type="button" value="GO" onclick="location.href='?mid=<!--mid-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
</div>
		</td>
	</tr>
</table>
</div>

<div id="import" class="popshow">
<form name="upload" method="post" ACTION="?method=import&mid=<!--mid-->" ENCTYPE="multipart/form-data" onsubmit="return false">
	<table border="0" cellspacing="0" width="400">
		<tr id=load>
			<td align="center">
				<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
				上传文件：
				<input type="file" name="the_file" size="35" /><br /><br />
				<b>请确保上传文件为csv格式，且列与导出表一一对应！</b><br />
				（提示：可将导出表另存为csv格式）<br /><br />
				<input type="checkbox" name="empty" value="empty" /> 清空现有数据<br /><br />
				<input type="button" name="Submit" value=" 上 传 " onclick="check()" />
				&nbsp; &nbsp; &nbsp;
				<input type="button" name="Close" value=" 关 闭 " onclick="if(parent==null){self.close();}else{parent.$.closePopupLayer();}" />
			</td>
		</tr>
		<tr id=wait style="display:none">
			<td align="center">
				正在上传，请稍侯......
			</td>
		</tr>
	</table>
</form>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
if(typeof($.setupJMPopups)=="undefined") $.getScript("../../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});
function check(){
	if ($("#popupLayer_import").find("form").get(0).the_file.value==0){
		alert("上传文件不能为空！");
		$("#popupLayer_import").find("form").get(0).the_file.focus();
	}else{
		$id("load").style.display = "none";
		$id("wait").style.display = "";
		$("#popupLayer_import").find("form").get(0).submit();
	}
}
$(function(){
	$("a.mail").each(function(){
		if(this.href.length>10) {
			this.href = this.href+"?subject="+UrlEncode("<!--custom_form_name-->");
		}
	});
});
//]]> 
</script>