<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form name="db_bak" method="post" ENCTYPE="multipart/form-data" onSubmit="return doit(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td colspan="2" class="cat" style="width:100%; text-align:center; font-weight:bold; padding:5px"><!--result--></td>
			</tr>
			<tr>
				<td class="cat" width="80">������վ��</td>
				<td class="row">
					<select name="web_idx" onchange="location.href='?web_idx='+this.value">
<!--loop:start key="website"-->
						<option value="<!--website_idx-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">�� �� ��</td>
				<td class="row">
					<select name="table">
						<option value="">��ѡ��</option>
						<option value="all">ȫ�����ݱ�</option>
<!--loop:start key="tbls"-->
						<option value="<!--tbls_name-->"><!--tbls_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">����ģʽ��</td>
				<td class="row">
					<select name="method" onchange="setSelection(this.value)" need="">
						<option value="">��ѡ��</option>
						<option value="import">����</option>
						<option value="export">����</option>
						<option value="repair">�޸�</option>
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
<script language="JavaScript">
function doit(theForm) {
	if(checkForm(theForm, checkForm_append)) {
		if(document.db_bak.method.value!='export') {
			loadingShow("�������ڽ��У������ĵȴ���");
		} else {
			theForm.target = "_blank";
		}
		return true;
	} else {
		return false;
	}
}
function setSelection(mode) {
	if(mode=='export') {
		document.db_bak.the_file.outerHTML = document.db_bak.the_file.outerHTML;
		document.db_bak.the_file.disabled=true;
		document.db_bak.table.disabled=false;
	} else if(mode=='import') {
		document.db_bak.the_file.disabled=false;
		document.db_bak.table.disabled=true;
	} else if(mode=='repair') {
		document.db_bak.the_file.outerHTML = document.db_bak.the_file.outerHTML;
		document.db_bak.the_file.disabled=true;
		document.db_bak.table.disabled=false;
	} else {
		document.db_bak.the_file.disabled=false;
		document.db_bak.table.disabled=false;
	}
}
function checkForm_append(theForm) {
	var flag=true;
	if(document.db_bak.method.value=='import') {
		flag=confirm('���µ������ݽ��ƻ����е������ļ��� �Ƿ������');
	}
	return flag;
}
</script>