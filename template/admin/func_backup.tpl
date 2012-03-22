<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form name="db_bak" method="post" ENCTYPE="multipart/form-data" onSubmit="return doit(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td colspan="2" class="cat" style="width:100%; text-align:center; font-weight:bold; padding:5px"><!--result--></td>
			</tr>
			<tr>
				<td class="cat" width="80">所属网站：</td>
				<td class="row">
					<select name="web_idx" onchange="location.href='?web_idx='+this.value">
<!--loop:start key="website"-->
						<option value="<!--website_idx-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">数 据 表：</td>
				<td class="row">
					<select name="table">
						<option value="">请选择</option>
						<option value="all">全部数据表</option>
<!--loop:start key="tbls"-->
						<option value="<!--tbls_name-->"><!--tbls_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">操作模式：</td>
				<td class="row">
					<select name="method" onchange="setSelection(this.value)" need="">
						<option value="">请选择</option>
						<option value="import">导入</option>
						<option value="export">导出</option>
						<option value="repair">修复</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" valign="top">上传数据：</td>
				<td class="row">
					<input type="hidden" name="MAX_FILE_SIZE" value="<!--upload_max_filesize-->" />
					<input type="file" name="the_file" style="background-color:#fff; border:0px;" size="35" disabled /> （上传文件不要大于 <!--max_size-->B）
				</td>
			</tr>
			<tr>
				<td class="row" align="center" colspan="2">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
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
			loadingShow("操作正在进行，请耐心等待！");
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
		flag=confirm('重新导入数据将破坏已有的数据文件！ 是否继续？');
	}
	return flag;
}
</script>