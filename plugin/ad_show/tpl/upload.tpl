<br />
<form name="upload" method="post" ACTION="upload.php" targe1="upload_file" ENCTYPE="multipart/form-data" >
	<table border="0" cellspacing="0" width="400">
		<tr id=load>
			<td align="center">
				<input type="hidden" name="MAX_FILE_SIZE" value="<!--MaxSize-->" />
				上传文件：
				<input type="file" name="the_file" size="35" /><br /><br />
				<input type="button" name="Submit" value=" 上 传 " onclick="check()" />
				(上传限度：<font color='red'><!--Max_size--></font>)
				<input type="button" name="Close" value=" 关 闭 " onclick="if(parent==null){self.close();}else{parent.$.closePopupLayer();}" />
			</td>
		</tr>
		<tr id=wait style="display:none">
			<td align="center">
				正在上传，请稍侯......
			</td>
		</tr>
	</table>
</form>
<iframe scrolling="no" name="upload_file" src="about:blank" MARGINHEIGHT="0" MARGINWIDTH="0" style="display:none;"></iframe>
<script language="JavaScript">
$(function(){
	<!--script-->
	if(typeof(window.dialogArguments)=='undefined' && typeof(window.opener)=='undefined' && typeof(window.parent)=='undefined') {
		window.opener = null;
		self.close();
		location.href = './';
	}
	if(window.opener!='undefined') window.resizeTo(400,160);
	$(document.body).css({"width":"420px", "height":"100px", "overflow":"hidden"});
});
function check(){
	if (document.upload.the_file.value.length==0){
		alert("上传文件不能为空！");
		document.upload.the_file.focus();
	}else{
		document.getElementById("load").style.display = "none";
		document.getElementById("wait").style.display = "";
		document.upload.submit();
	}
}
</script>