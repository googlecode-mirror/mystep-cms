		<div class="login">
			<div class="info"><!--info--></div>
			<div class="box"> 
				<div class="title">��Ա��¼</div> 
				<div class="content"> 
					<form method="post" action="module.php?m=offical&f=login" onsubmit="return (this.user_name.value!='' && this.user_psw.value!='')">
						<div>�á�����<input type="text" name="user_name" size="16" /></div>
						<div>�ܡ��룺<input type="password" name="user_psw" size="16" /></div>
						<div>��֤�룺<input type="text" name="check_code" size="16" /></div>
						<div><img border="0" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()" /><br />�����ͼƬ������֤�룩</div>
						<div>
							<input type="submit" value=" �� �� " /> &nbsp; &nbsp;
							<input type="reset" value=" �� λ " />
						</div>
					</form>
				</div> 
			</div>
		</div>