<div class="title"><!--title--></div>
<div align="left">
	<script language="JavaScript" src="../../script/checkForm.js"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)"">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">��Ŀ������</td>
				<td class="row">
					<input name="idx" type="text" value="<!--idx-->" maxlength="20" <!--disabled--> need="" />
					<span class="comment">���뱣�������ִ���Ψһ�ԣ�һ���趨���޷��޸ģ�</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">��Ŀ���⣺</td>
				<td class="row">
					<input name="topic" type="text" value="<!--topic-->" maxlength="100" need="" />
					<span class="comment">�������뱾��Ŀ�����⣩</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">�����ʼ���</td>
				<td class="row">
					<input name="email" type="text" value="<!--email-->" maxlength="100" need="email" />
					<span class="comment">���û��ύ�����⽫ֱ�ӷ����������䣩</span>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">������ͣ�<span class="comment">���û�����������͵�ѡ��ÿ��ѡ��ռһ�У�������дһ�</span></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<textarea name="type" style="width:798px; height:200px;" need=""><!--type--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="history.go(-1)" />
				</td>
			</tr>
		</table>
	</form>
</div>
