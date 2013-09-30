<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	<!--topic-->
</div>
<div style="color:#ff0000; text-align:center; font-weight:bold;"><!--info--></div>
<hr />
<br />
<script src="script/checkForm.js" Language="JavaScript1.2"></script>
<form name="ticket_submit" method="post" ACTION="/module.php?m=ticket" ENCTYPE="multipart/form-data" onsubmit="return checkForm(this)">
	<input name="idx" type="hidden" value="<!--idx-->" />
	<table width="780" border="0" class="ticket_form" align="center" cellpadding="2" cellspacing="1">
		<tr>
			<td class="cat" width="80">您的姓名：</td>
			<td class="row">
				<input name="idx" type="hidden" value="<!--idx-->" />
				<input name="name" type="text" value="<!--user_name-->" maxlength="20" need="" />
				<span class="comment">（如何称呼您）</span>
			</td>
		</tr>
		<tr>
			<td class="cat" width="80">电子邮件：</td>
			<td class="row">
				<input name="email" type="text" value="<!--user_email-->" maxlength="100" need="email" />
				<span class="comment">（用户答复您问题的邮箱）</span>
			</td>
		</tr>
		<tr>
			<td class="cat" width="80">问题类型：</td>
			<td class="row">
				<select name="type" need="">
					<option value="">请选择</option>
<!--loop:start key="type"-->
					<option value="<!--type_name-->"><!--type_name--></option>
<!--loop:end-->
				</select>
				<span class="comment">（您所提问题的类型）</span>
			</td>
		</tr>
		<tr>
			<td class="cat" width="80">问题主题：</td>
			<td class="row">
				<input name="subject" type="text" value="" maxlength="100" need="" />
				<span class="comment">（请填写问题标题）</span>
			</td>
		</tr>
		<tr>
			<td class="cat" colspan="2">详细内容：<span class="comment">（请尽可能详细描述您的问题）</span></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<textarea name="message" style="width:776px; height:200px;" need=""></textarea>
			</td>
		</tr>
		<tr>
			<td class="cat" width="80">优先级：</td>
			<td class="row">
				<select name="priority">
					<option value="0">无</option>
					<option value="1" style="background-color:#009900;">一般</option>
					<option value="2" style="background-color:#999900;">重要</option>
					<option value="3" style="background-color:#990000;">亟待</option>
				</select>
				<span class="comment">（您所提问题的类型）</span>
			</td>
		</tr>
		<tr class="row">
			<td colspan="2" align="center">
				<input class="btn" type="Submit" value=" 确 定 " /> &nbsp; &nbsp;
				<input class="btn" type="reset" value=" 重 置 " />
			</td>
		</tr>
	</table>
</form>
<br /><br />
<div align="center">
	<table width="780" border="0" class="ticket_list" align="center" cellSpacing="2" cellPadding="1">
<!--loop:start key="record"-->
		<tr align="center">
			<td class="cat" width="30" rowspan="2" valign="middle"><!--record_id--></td>
			<td class="cat" align="left"><!--record_subject-->（<a href="mailto:<!--record_email-->" target="_blank"><!--record_name--></a> - <!--record_add_date-->）</td>
		</tr>
		<tr>
			<td class="row" align="left" style="background-color:<!--record_color-->">
				<div class="message">
					<!--record_message-->
				</div>
				<div class="reply">
					<div>回复：</div>
					<pre><!--record_reply--></pre>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>