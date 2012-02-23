<style>
	#page_ole {margin:auto; min-width:100px; padding:0px 0px 20px 0px;}
	td {padding:5px 5px 5px 5px;}
	#list_area {width:560px;}
</style>
<form name="attach_edit" method="post" action="?method=edit_ok" onsubmit="return setWatermark()">
<input type="hidden" id="watermark_yes" name="watermark_yes" value=""><input type="hidden" id="watermark_no" name="watermark_no" value="">
<table id="list_area" cellSpacing="0" cellPadding="0" align="center" border="1">
	<tr class="cat" align="center">
		<td>删除</td><td>文件名</td><td>文件类型</td><td>文件大小</td><td>上传时间</td><td>下载次数</td><td>水印</td>
	</tr>
<!--loop:start key="record"-->
	<tr class='row'>
		<td align='center'><input type='checkbox' name='del_att[]' value='<!--record_id-->::<!--record_file_name_new--><!--record_file_ext-->' /></td>
		<td><a href="javascript:" onclick="attach_add('<!--record_id-->', '<!--record_news_id-->', '<!--record_file_name-->', '<!--record_file_type-->')"><!--record_file_name--></a></td>
		<td><!--record_file_type--></td>
		<td align='right'><!--record_file_size--></td>
		<td><!--record_file_time--></td>
		<td align='center'><!--record_file_count--></td>
		<td align='center'><input type='checkbox' name='watermark[]' value='<!--record_id-->' <!--record_check--> /></td>
	</tr>
<!--loop:end-->
	<tr class="cat">
		<td align='center'><input type="checkbox" onclick="check_it('del_att[]', this.checked)"></td>
		<td colspan="5" align="center">全部选取</td>
		<td align='center'><input type="checkbox" onclick="check_it('watermark[]', this.checked)"></td>
	</tr>
</table>
<table align="center">
	<tr>
		<td align="center" colspan="2"><br>
			<input type="Submit" value=" 确 定 " name="Submit" />&nbsp;&nbsp;
			<input type="button" value=" 关 闭 " name="return" onClick="if(parent==null){self.close();}else{parent.$.closePopupLayer();}" />
		</td>
	</tr>
</table>
</form><br />
<script language="JavaScript">
<!--script-->

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

function check_it(group, mode) {
	var all_box = document.getElementsByName(group);
	for(var i=0; i<all_box.length; i++) {
		all_box[i].checked = mode;
	}
	return;
}
function setWatermark() {
	var all_box = document.getElementsByName('watermark[]');
	var watermark_yes = watermark_no = "";
	for(var i=0; i<all_box.length; i++) {
		if(all_box[i].checked) {
			watermark_yes += all_box[i].value + ",";
		} else {
			watermark_no += all_box[i].value + ",";
		}
	}
	document.getElementById('watermark_yes').value = watermark_yes + "0";
	document.getElementById('watermark_no').value = watermark_no + "0";
	return true;
}
$(function(){
	parent.setIframe('attach');
});
</script>
