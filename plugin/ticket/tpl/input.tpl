<div class="title"><!--title--></div>
<div align="left">
	<script language="JavaScript" src="../../script/checkForm.js"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)"">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">项目索引：</td>
				<td class="row">
					<input name="idx" type="text" value="<!--idx-->" maxlength="20" <!--disabled--> need="" />
					<span class="comment">（请保持索引字串的唯一性，一旦设定后，无法修改）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">项目主题：</td>
				<td class="row">
					<input name="topic" type="text" value="<!--topic-->" maxlength="100" need="" />
					<span class="comment">（请输入本项目的主题）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">电子邮件：</td>
				<td class="row">
					<input name="email" type="text" value="<!--email-->" maxlength="100" need="email" />
					<span class="comment">（用户提交的问题将直接发送至该邮箱）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">相关类型：<span class="comment">（用户针对问题类型的选择，每个选项占一行，请至少写一项）</span></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<textarea name="type" style="width:798px; height:200px;" need=""><!--type--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 提 交 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="history.go(-1)" />
				</td>
			</tr>
		</table>
	</form>
</div>
