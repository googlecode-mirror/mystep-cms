<style>
	#page_ole {margin:auto; min-width:100px; padding:0px 0px 20px 0px;}
	td {padding:5px 5px 5px 5px;}
	#show {display:none; position:absolute; top:0px; left:0px;}
	#list_area {width:560px;}
</style>
<div class="nav">
	共有 <!--page_total--> 条记录，&nbsp;
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?method=mine&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?method=mine&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
	&nbsp;|&nbsp;
	关键字：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?method=mine&keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?method=mine&keyword='+this.previousSibling.value" />
</div>
<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
	<tr class="cat" align="center">
		<td class="cat" width="30"><a href="?method=mine&keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
		<td class="cat" width="30"><a href="?method=mine&keyword=<!--keyword-->&order_type=<!--order_type-->&order=news_id"><font color="#000000">索引</font></a></td>
		<td class="cat"><a href="?method=mine&keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_name"><font color="#000000">名称</font></a></td>
		<td class="cat" width="80"><a href="?method=mine&keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_type"><font color="#000000">类型</font></a></td>
		<td class="cat" width="60"><a href="?method=mine&keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_time"><font color="#000000">时间</font></a></td>
		<td class="cat" width="30">操作</td>
	</tr>
<!--loop:start key="record"-->
	<tr class="item" align="center">
		<td class="row"><!--record_id--></td>
		<td class="row"><!--record_news_id--></td>
		<td class="row" align="left"><a href="javascript:" onclick="attach_add('<!--record_id-->', '<!--record_news_id-->', '<!--record_file_name-->', '<!--record_file_type-->')"><!--record_file_name--></a><img src="<!--record_web_url-->/files?<!--record_id-->" width="0" height="0" /></td>
		<td class="row"><!--record_file_type--></td>
		<td class="row"><!--record_file_time--></td>
		<td class="row"><a href="javascript:" onclick="attach_add('<!--record_id-->', '<!--record_news_id-->', '<!--record_file_name-->', '<!--record_file_type-->')">插入</a></td>
	</tr>
<!--loop:end-->
</table>
<div id="show"></div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
function attach_add(id, news_id, file_name, file_type) {
	var code = "";
	if(file_type.indexOf("image")==-1) {
		code = '<br /><a id="att_'+id+'" href="/files?'+id+'" target="_blank">'+file_name+'</a><br />';
	} else {
		code = '<br /><a id="att_'+id+'" href="/files/show.htm?'+id+'" target="_blank"><img src="/files/?'+id+'" alt="'+file_name+'" /></a><br />';
	}
	if(news_id==0) {
		parent.document.forms[0].attach_list.value += id+'|';
	}
	parent.attach_add(code);
	parent.$.closePopupLayer();
	return;
}

$(function(){
	parent.setIframe('attach_mine');
	$(".item").hover(function(){
		if($(this).children().eq(3).text().indexOf("image")!=-1) {
			$("#show").html('<img src="/files/?'+$(this).children().eq(0).text()+'" width="200" />');
			$("#show").show();
		}
	}, function(){
		$("#show").hide();
	});
});
//]]> 
</script>