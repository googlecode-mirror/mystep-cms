<div class="title"><!--title--></div>
<div class="addnew"><a href="###" onclick="showPop('upload','�ϴ�ģ��','id','upload',420, 150)">�ϴ�ģ��</a></div>
<div align="left" style="clear:both;">
	<form method="post" action="?method=set">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center" style="width:auto;">
			<tr>
				<td class="cat" colspan="2">��վģ������</td>
			</tr>
<!--loop:start key="website"-->
			<tr>
				<td class="cat"><!--website_name--></td>
				<td class="row">
					<input name="web_id[]" type="hidden" value="<!--website_web_id-->" />
					<input name="idx[]" type="hidden" value="<!--website_idx-->" />
					<select name="tpl[]" class="website" tpl="<!--website_tpl-->"></select>
				</td>
			</tr>
<!--loop:end-->
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />
				</td>
			</tr>
		</table>
	</form>
</div>

<div>&nbsp;</div>

<div align="center" id="img_lst" class="after">
<!--loop:start key="tpl_list"-->
	<dl>
		<dt><!--tpl_list_idx--><br /><a href="?idx=<!--tpl_list_idx-->"><img src="<!--tpl_list_img-->"></a></dt>
		<dd><a href="?idx=<!--tpl_list_idx-->">�༭</a> | <a href="?method=export&idx=<!--tpl_list_idx-->">����</a> | <a href="?method=remove&idx=<!--tpl_list_idx-->" onclick="return confirm('�Ƿ�ȷ��ɾ����ǰģ�壿')">ɾ��</a></dd>
	</dl>
<!--loop:end-->
</div>

<div id="upload" class="popshow">
<form name="upload" method="post" ACTION="?method=upload" ENCTYPE="multipart/form-data" onsubmit="return false">
	<table border="0" cellspacing="0" width="400">
		<tr id=load>
			<td align="center">
				<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
				�ϴ��ļ���
				<input type="file" name="the_file" size="35" /><br /><br />
				�������ͬ��ģ�壬����ģ�彫�����ǣ���ע��ȷ�ϣ�<br /><br />
				<input type="button" name="Submit" value=" �� �� " onclick="check()" />
				&nbsp; &nbsp; &nbsp;
				<input type="button" name="Close" value=" �� �� " onclick="$.closePopupLayer()" />
			</td>
		</tr>
		<tr id=wait style="display:none">
			<td align="center">
				�����ϴ������Ժ�......
			</td>
		</tr>
	</table>
</form>
</div>

<script language="JavaScript" type="text/javascript">
//<![CDATA[
$(function(){
	var tpl_list = <!--tpl_list-->;
	for(var i=0,m=tpl_list.length;i<m;i++) {
		$(".website").each(function(){
			var tpl = $(this).attr("tpl");
			var opt = $("<option>").attr("value", tpl_list[i]).text(tpl_list[i]);
			if(tpl==tpl_list[i]) opt.attr("selected", true);
			$(this).append(opt);
		});
	}
});
function check(){
	if ($("#popupLayer_upload").find("form").get(0).the_file.value==0){
		alert("�ϴ��ļ�����Ϊ�գ�");
		$("#popupLayer_upload").find("form").get(0).the_file.focus();
	}else{
		$id("load").style.display = "none";
		$id("wait").style.display = "";
		$("#popupLayer_upload").find("form").get(0).submit();
	}
}
//]]> 
</script>