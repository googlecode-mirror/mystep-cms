<style type="text/css">
	#page_ole {margin:auto; min-width:100px; padding:0px 0px 0px 0px;height:400px; overflow-y:auto;}
	td {padding:5px 5px 5px 5px;}
	#list_area {width:560px;}
</style>
<form name="keyword_list" method="post" action="?method=batch_add&topic_id=<!--topic_id-->">
	<div style="font-weight:bold;text-align:center;padding-bottom:10px;">
		������վ��
		<select name="web_id" onchange="location.href='?keyword=<!--keyword-->&web_id='+this.value">
<!--loop:start key="website"-->
			<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
		</select>
	</div>
	<table align="center" width="560" border="1" bordercolorlight="#000000" bordercolordark="#FFFFFF" cellpadding="0" cellspacing="0">
		<tr class="cat">
			<td colspan="7">
				<input id="check_all" type="checkbox" onclick="check_it(this.checked)"> <label for="check_all">ȫ��ѡȡ</label>
				<select onchange="chg_cat(this.value);this.selectedIndex=0;">
					<option>����ѡ���б�</option>
					<!--style_select-->
				</select>
			</td>
		</tr>
		<tr class="cat" align="center">
			<td width="30">No.</td>
			<td width="30">���</td>
			<td>����</td>
			<td>���±���</td>
		</tr>
<!--loop:start key="record"-->
	<tr class="row" align="center">
		<td><!--record_n--></td>
		<td><input type="checkbox" name="add_list[]" value="<!--record_n-->::<!--record_subject-->::<!--record_news_id-->"></td>
		<td>
			<select name="cat_list[]">
				<!--record_style_select-->
			</select>
		</td>
		<td align="left">[<!--record_cat_name-->] <!--record_subject--></td>
	</tr>
<!--loop:end-->
		<tr class="cat">
			<td colspan="7">
				<input id="check_all" type="checkbox" onclick="check_it(this.checked)"> <label for="check_all">ȫ��ѡȡ</label>
				<select onchange="chg_cat(this.value);this.selectedIndex=0;">
					<option>����ѡ���б�</option>
					<!--style_select-->
				</select>
			</td>
		</tr>
	</table>
	<table align="center">
		<tr>
			<td align="center" colspan="2"><br>
				<input type="Submit" value=" �� �� " name="Submit">&nbsp;&nbsp;
				<input type="button" value=" �� �� " name="return" onClick="parent.$.closePopupLayer()">
			</td>
		</tr>
	</table>
</form>
<script language="JavaScript">
<!--script-->
var all_box = $("input[name='add_list[]']");
if(all_box.length==0) {
	alert('û�м�����������£�');
	parent.$.closePopupLayer();
}
function check_it(mode) {
	all_box.attr("checked", mode);
	return;
}
function chg_cat(val){
	$("select[name='cat_list[]']").val(val);
}
$(function(){
	parent.setIframe('searchArticle');
});
</script>