<form id="<!--id-->" class="<!--class-->" method="post" action="module.php?m=offical&f=login" onsubmit="return (this.user_name.value!='' && this.user_psw.value!='')">
	<div>用　户：<input type="text" name="user_name" size="16" /></div>
	<div>密　码：<input type="password" name="user_psw" size="16" /></div>
	<div>验证码：<input type="text" name="check_code" size="16" /></div>
	<div><img border="0" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()" /></div>
	<div>
		<input type="submit" value=" 提 交 " /> &nbsp; &nbsp;
		<input type="reset" value=" 复 位 " />
	</div>
</form>