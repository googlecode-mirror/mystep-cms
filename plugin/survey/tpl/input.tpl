<div class="title"><!--title--></div>
<div align="left">
	<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="80">�������⣺</td>
				<td class="row">
				<input type="hidden" name="id" value="<!--record_id-->" />
				<input type="text" name="subject" value="<!--record_subject-->" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">����������</td>
				<td class="row">
				<input type="text" name="describe" value="<!--record_describe-->" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">��ѡ������</td>
				<td class="row">
				<input type="text" name="max_select" value="<!--record_max_select-->" need="digital" />
				<font>��0-�����ƣ�1-��ѡ��������ѡ��</font>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">�û�����</td>
				<td class="row">
				<input type="text" name="user_lvl" value="<!--record_user_lvl-->" need="digital" />
				<font>���û�ͶƱ��Ҫ�ﵽ�ĵȼ���</font>
				</td>
			</tr>
			<tr>
				<td class="cat">��Чʱ�䣺</td>
				<td class="row">
				<select name="expire">
				<!--record_expire-->
				<option value="0">����</option>
				<option value="1">һ��</option>
				<option value="2">����</option>
				<option value="3">����</option>
				<option value="4">����</option>
				<option value="5">����</option>
				<option value="6">����</option>
				<option value="7">һ��</option>
				<option value="30">һ��</option>
				<option value="90">һ��</option>
				<option value="180">����</option>
				<option value="365">һ��</option>
				</select>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" �� �� " name="Submit">&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " name="reset">&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " name="empty" onClick="location.href='?method=empty&id=<!--record_id-->'">&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " name="export" onClick="location.href='?method=export&id=<!--record_id-->'">&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " name="return" onClick="history.go(-1)">
				</td>
			</tr>
		</table>
	</form>
</div>

<hr />
<div style="margin-top:50px;">
	<div style="text-align:center;font-weight:bold;font-size:18px;">���ô�������</div>
	<table id="input_area" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td class="cat">���ô���</td>
			<td class="row" id="the_code">&lt;!--survey id="<!--record_id-->"--&gt;</td>
		</tr>
		<tr>
			<td class="cat" width="80">�������ݣ�</td>
			<td class="row">
				<select id="the_order" onchange="changeCode()">
					<option value="catalo desc">Ĭ������</option>
					<option value="title">����</option>
					<option value="catalog">���</option>
					<option value="vote">Ʊ��</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="cat" width="80">��ʾģ�壺</td>
			<td class="row">
				<select id="the_tpl" onchange="changeCode()">
					<option value="">Ĭ��ģ��</option>
					<option value="classic">classic</option>
					<option value="simple">simple</option>
				</select> &nbsp; <font>�����ģ��Ŀ¼������Ϊ block_survey_*.tpl ���ļ���</font>
			</td>
		</tr>
	</table>
</div>
<hr />
<div style="margin-top:50px;display:<!--show_item-->">
	<div style="text-align:center;font-weight:bold;font-size:18px;">������Ŀά��</div>
	<div align="center">
		<form name="add_item" method="post" action="?method=add_item" onsubmit="return checkForm(this)">
			<table id="input_area" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td class="cat" colspan="2">��Ŀ���<input name="id" type="hidden" value="<!--record_id-->"><input name="vote" type="hidden" value="0"></td>
				</tr>
				<tr>
					<td class="cat" width="80">������Ŀ��</td>
					<td class="row"><input name="title" type="text" maxlength="100" need="" value=""> &nbsp; <font>���������ݣ����</font></td>
				</tr>
				<tr>
					<td class="cat" width="80">ѡ����ࣺ</td>
					<td class="row"><input name="catalog" type="text" maxlength="20" value=""> &nbsp; <font>��ѡ����࣬��ѡ��</font></td>
				</tr>
				<tr>
					<td class="cat" width="80">��Ŀͼʾ��</td>
					<td class="row"><input name="image" type="text" maxlength="100" value=""> &nbsp; <font>����Ŀͼʾ����ѡ��</font></td>
				</tr>
				<tr>
					<td class="cat" width="80">���ӵ�ַ��</td>
					<td class="row"><input name="url" type="text" maxlength="100" need="url_" value=""> &nbsp; <font>�������ַ����ѡ��</font></td>
				</tr>
				<tr class="row">
					<td colspan="2" align="center">
						<input class="btn" type="Submit" value=" �� �� " name="Submit">&nbsp;&nbsp;
						<input class="btn" type="reset" value=" �� �� " name="reset">&nbsp;&nbsp;
					</td>
				</tr>
			</table>
		</form>
		<form name="batch_import" method="post" action="?method=import" ENCTYPE="multipart/form-data" onSubmit="return checkForm(this)">
			<table id="input_area" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td class="cat" width="80">�������룺</td>
					<td class="row">
						<input name="id" type="hidden" value="<!--record_id-->">
						<input type='hidden' name='MAX_FILE_SIZE' value='<!--upload_max_filesize-->'>
						<input type="file" name="the_file" style="width:500px;" need="">
						<input class="btn" type="Submit" value=" �� �� " name="Submit" />
					</td>
				</tr>
			</table>
		</form>
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
<!--loop:start key="item_list"-->
			<tr>
				<td class="cat" width="80">��Ŀ <!--item_list_no-->��</td>
				<td class="row"><!--item_list_catalog--> <a href="<!--item_list_url-->" target="_blank"><!--item_list_title--></a> ��<!--item_list_vote-->Ʊ��</td>
				<td class="row" width="40" align="center"><a href="?method=del_item&id=<!--record_id-->&idx=<!--item_list_idx-->"><b>ɾ��</b></a></td>
			</tr>
<!--loop:end-->
		</table>
	</div>
</div>
<script language="JavaScript">
function changeCode(){
	var the_code = '&lt;!--survey id="<!--record_id-->"';
	var the_order = $("#the_order").val();
	var the_tpl = $("#the_tpl").val();
	if(the_order!="") the_code += ' order="'+the_order+'"';
	if(the_tpl!="") the_code += ' template="'+the_tpl+'"';
	the_code += '--&gt;';
	$("#the_code").html(the_code);
}
</script>