		<div class="login">
			<div class="box">
				<div class="title">�޸�����</div>
				<div class="content">
					<form id="login" method="post" onsubmit="reset_psw(this); return false;">
						<div>ԭ���룺<input type="password" name="psw_org" size="16" /></div>
						<div>�����룺<input type="password" name="psw_new" size="16" /></div>
						<div>ȷ���ϣ�<input type="password" name="psw_rep" size="16" /></div>
						<div>
							<input type="submit" value=" �� �� " /> &nbsp; &nbsp;
							<input type="reset" value=" �� λ " />
						</div>
					<form>
				</div>
			</div>
		</div>
<script language="JavaScript">
function reset_psw(theForm) {
	if(theForm.psw_org.value=="" || theForm.psw_new.value=="" || theForm.psw_rep.value=="") {
		alert("����д��������");
		return;
	}
	if(theForm.psw_new.value!=theForm.psw_rep.value) {
		alert("��ȷ�������������������ͬ��");
		theForm.psw_new.value="";
		theForm.psw_rep.value="";
		theForm.psw_new.focus();
		return;
	}
	var theDate = arr2json($(theForm).serializeArray());
	$.post("ajax.php?func=reset_psw", theDate, function(data){
		if(data=="") {
			alert("�����޸ĳɹ����������µ�¼��");
			top.location.href="module.php?m=offical&f=logout";
		} else {
			alert(data);
		}
	});
}
</script>