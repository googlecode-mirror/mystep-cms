<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/check_form.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="120">网站名称：</td>
				<td class="row">
					<input name="web_id" type="hidden" value="<!--web_id-->">
					<input type="text" name="name" value="<!--name-->"  need=""/>
				</td>
			</tr>
			<tr> 
				<td class="cat">网站索引：</td>
				<td class="row">
					<input type="text" name="idx" value="<!--idx-->"  need=""/>
				</td>
			</tr>
			<tr> 
				<td class="cat">网站域名：</td>
				<td class="row">
					<input type="text" name="host" value="<!--host-->"  need=""/>
				</td>
			</tr>
			<tr> 
				<td align="center" colspan=2" class="cat"> 
					<input class="btn" type="Submit" value=" 确 定 ">&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 ">&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'">
				</td>
			</tr>
		</table>
	</form>
</div>
