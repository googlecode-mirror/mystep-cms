<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/check_form.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="120">��վ���ƣ�</td>
				<td class="row">
					<input name="web_id" type="hidden" value="<!--web_id-->">
					<input type="text" name="name" value="<!--name-->"  need=""/>
				</td>
			</tr>
			<tr> 
				<td class="cat">��վ������</td>
				<td class="row">
					<input type="text" name="idx" value="<!--idx-->"  need=""/>
				</td>
			</tr>
			<tr> 
				<td class="cat">��վ������</td>
				<td class="row">
					<input type="text" name="host" value="<!--host-->"  need=""/>
				</td>
			</tr>
			<tr> 
				<td align="center" colspan=2" class="cat"> 
					<input class="btn" type="Submit" value=" ȷ �� ">&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� ">&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="location.href='<!--back_url-->'">
				</td>
			</tr>
		</table>
	</form>
</div>
