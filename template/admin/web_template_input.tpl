<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" width="400" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td class="cat" width="80">����ģ�壺</td>
				<td class="row">
					<!--file_idx-->
					<input name="idx" type="hidden" value="<!--file_idx-->" />
				</td>
			</tr>
			<tr> 
				<td class="cat" width="80">�ļ����ƣ�<span>*</span></td>
				<td class="row">
					<input name="file_name" type="text" size="20" maxlength="20" value="<!--file_name-->" <!--readonly--> need="" />
				</td>
			</tr>
			<tr> 
				<td class="cat" colspan="2">ģ������</td>
			</tr>
			<tr> 
				<td class="row" colspan="2">
					<textarea name="file_content" style="width:100%;height:400px;" wrap='off'><!--file_content--></textarea>
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

