<script language="JavaScript">
function check(){
	var objs = document.getElementsByName("the_file[]");
	for(var i=0; i<objs.length; i++) {
		if(objs[i].value.length>0) break;
	}
	if (i==objs.length){
		alert("�ϴ��ļ�����Ϊ�գ�");
	} else {
		document.getElementById("load").style.display = "none";
		document.getElementById("wait").style.display = "";
		document.upload.submit();
	}
}
function upload_add_file(){
	var max_upload = 10;
	if($("#files div").length>max_upload ) {
		alert("ͬʱ����ϴ� " + max_upload + " ���ļ���");
		return;
	}
	var obj = $("#files div:first");
	obj.clone().appendTo("#files").show();
	parent.setIframe('upload');
	return;
}
$(function(){
	upload_add_file();
});
</script>
<form name="upload" method="post" ACTION="?method=add_ok" ENCTYPE="multipart/form-data">
	<table border="0" cellspacing="0">
		<tr id="load">
			<td style="padding:10px 10px 10px 10px;">
				<input type="hidden" name="MAX_FILE_SIZE" value="<!--MaxSize-->">
				<div id="files">
					<div style="padding-bottom:5px; display:none;">
						<b>ѡ���ļ���</b>
						<input type="file" name="the_file[]" size="60" onchange="upload_add_file();" />
					</div>
				</div>
				<div style="padding-bottom:5px">
					<b>�������֣�</b>
					<input type="text" name="comment" size="70">
				</div>
				<div style="padding-bottom:5px;">
					<b>Ԥ��ͼ��</b>
					<select name="zoom">
						<option value="800"> 800 ���� </option>
						<option value="700"> 700 ���� </option>
						<option value="600" selected> 600 ���� </option>
						<option value="500"> 500 ���� </option>
						<option value="400"> 400 ���� </option>
						<option value="300"> 300 ���� </option>
						<option value="200"> 200 ���� </option>
						<option value="100"> 100 ���� </option>
					</select> &nbsp;
					<input type="checkbox" id="watermark" name="watermark" value="1" <!--watermark_use--> /> <label for="watermark">���ͼƬˮӡ</label> &nbsp;  (�ļ���С���ƣ�<font color='red'><!--Max_size--></font>) &nbsp;  &nbsp; 
					<input type="button" name="Submit" value=" �ϴ��ļ� " onclick="check()" />
				</div>
			</td>
		</tr>
		<tr id=wait style="display:none">
			<td align="center">
				�����ϴ������Ժ�......
			</td>
		</tr>
	</table>
</form>
