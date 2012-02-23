		<div class="login">
			<div class="box">
				<div class="title">修改密码</div>
				<div class="content">
					<form id="login" method="post" onsubmit="reset_psw(this); return false;">
						<div>原密码：<input type="password" name="psw_org" size="16" /></div>
						<div>新密码：<input type="password" name="psw_new" size="16" /></div>
						<div>确　认：<input type="password" name="psw_rep" size="16" /></div>
						<div>
							<input type="submit" value=" 提 交 " /> &nbsp; &nbsp;
							<input type="reset" value=" 复 位 " />
						</div>
					<form>
				</div>
			</div>
		</div>
<script language="JavaScript">
function reset_psw(theForm) {
	if(theForm.psw_org.value=="" || theForm.psw_new.value=="" || theForm.psw_rep.value=="") {
		alert("请填写相关密码项！");
		return;
	}
	if(theForm.psw_new.value!=theForm.psw_rep.value) {
		alert("请确认两次输入的新密码相同！");
		theForm.psw_new.value="";
		theForm.psw_rep.value="";
		theForm.psw_new.focus();
		return;
	}
	var theDate = arr2json($(theForm).serializeArray());
	$.post("ajax.php?func=reset_psw", theDate, function(data){
		if(data=="") {
			alert("密码修改成功，请您重新登录！");
			top.location.href="module.php?m=offical&f=logout";
		} else {
			alert(data);
		}
	});
}
</script>