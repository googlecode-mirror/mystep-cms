<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" width="400" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td class="cat" width="80">ͼʾ���ƣ�<span>*</span></td>
				<td class="row">
					<input name="id" type="hidden" value="<!--id-->" />
					<input name="web_id" type="hidden" value="<!--web_id-->" />
					<input name="name" type="text" size="20" maxlength="30" value="<!--name-->" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">�� �� �֣�<span>*</span></td>
				<td class="row"><input name="keyword" type="text" value="<!--keyword-->" maxlength="100" need="" /></td>
			</tr>
			<tr>
				<td class="cat">ͼʾ��ַ��<span>*</span></td>
				<td class="row">
					<input style="width:200px" name="image" type="text" maxlength="80" value="<!--image-->" need="" /> &nbsp; 
					<input style="width:60px" class="btn" type="button" onClick="showPop('uploadImage','����ͼʾ�ϴ�','url','upload_img.php?image',420, 100)" value="�ϴ�" />
				</td>
			</tr>
			<tr> 
				<td colspan="2" class="row" align="center">
					<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
if(typeof($.setupJMPopups)=="undefined") $.getScript("../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});
</script>
