<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form name="db_bak" method="post" action="?1" ENCTYPE="multipart/form-data" onSubmit="var flag=true;if(document.db_bak.method.value=='import'){flag=confirm('���µ������ݽ��ƻ����е������ļ��� �Ƿ������')};return (flag && checkForm(this))">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td colspan="2" class="cat" style="width:100%; text-align:center; font-weight:bold; padding:5px"><!--result--></td>
			</tr>
			<tr>
				<td class="cat" width="80">�� �� ��</td>
				<td class="row">
					<select name="table">
						<option value="">��ѡ��</option>
						<option value="all">ȫ�����ݱ�</option>
<!--loop:start key="tbls"-->
						<option value="<!--tbls_name-->" /><!--tbls_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">����ģʽ��</td>
				<td class="row">
					<select name="method" onchange="if(this.value=='export'){document.db_bak.the_file.disabled=true;document.db_bak.table.disabled=false}else if(this.value=='import'){document.db_bak.the_file.disabled=false;document.db_bak.table.disabled=true}else{document.db_bak.the_file.disabled=false;document.db_bak.table.disabled=false}" need="" />
						<option value="">��ѡ��</option>
						<option value="import">����</option>
						<option value="export">����</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" valign="top">�ϴ����ݣ�</td>
				<td class="row">
					<input type="hidden" name="MAX_FILE_SIZE" value="<!--upload_max_filesize-->" />
					<input type="file" name="the_file" style="background-color:#fff; border:0px;" size="35" disabled /> ���ϴ��ļ���Ҫ���� <!--max_size-->B��
				</td>
			</tr>
			<tr>
				<td class="row" align="center" colspan="2">
					<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="2" class="cat"><!--import_info--></td>
			</tr>
		</table>
	</form>
</div>
