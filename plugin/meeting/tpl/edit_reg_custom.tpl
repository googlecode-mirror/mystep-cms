<div class="title"><!--title--></div>
<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	<!--meeting_name-->
</div>
<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
<table id="tbl_main" width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
	<tr>
		<td align="center">
		<br />
		<div align="center"><b>ע�����ڣ�</b> <!--record_add_date--></div>
		<br />
		<div align="center">
			��<a href="?method=confirm&mid=<!--mid-->&id=<!--record_id-->" target="_blank">����ȷ���ʼ�</a>��
		</div>
		<br />
		<form name="reg_<!--method-->" method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
			<center>
			<input name="id" type="hidden" value="<!--record_id-->">
			<input name="mid" type="hidden" value="<!--mid-->">
			<table cellspacing="0" cellpadding="0" id="reg_info" align="center">
				<tr>
					<td class="cat" width="80">��������</td>
					<td class="row">
					<input name="name" type="text" value="<!--record_name-->" size="50" len="50" />
					<span class="comment">���λ��������������</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">����ƴ��</td>
					<td class="row">
					<input name="name_en" type="text" value="<!--record_name_en-->" size="50" len="50" />
					<span class="comment">����¼������ȫƴ��</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">�Ա�</td>
					<td class="row">
					<input name="gender" id="i_gender_0" type="radio" value="��" /><label for="i_gender_0"> ��</label>
					<input name="gender" id="i_gender_1" type="radio" value="Ů" /><label for="i_gender_1"> Ů</label>
					<span class="comment">����ѡ�������Ա�</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">����</td>
					<td class="row">
					<input name="country" type="text" value="<!--record_country-->" size="50" len="20" />
					<span class="comment">����¼�����Ĺ��ң�</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��˾����</td>
					<td class="row">
					<input name="company" type="text" value="<!--record_company-->" size="50" len="150" />
					<span class="comment">����˾�������ƣ�</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��˾Ӣ��</td>
					<td class="row">
					<input name="company_en" type="text" value="<!--record_company_en-->" size="50" len="200" />
					<span class="comment">����˾Ӣ�����ƣ�</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��˾ְ��</td>
					<td class="row">
					<input name="duty" type="text" value="<!--record_duty-->" size="50" len="30" />
					<span class="comment">�����ڹ�˾���ε�ְ��</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">ְ��Ӣ��</td>
					<td class="row">
					<input name="duty_en" type="text" value="<!--record_duty_en-->" size="50" len="50" />
					<span class="comment">����˾ְ���Ӣ�ģ�</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��˾��ַ</td>
					<td class="row">
					<input name="address" type="text" value="<!--record_address-->" size="50" />
					<span class="comment">������˾����ϸ��ַ��</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">Address</td>
					<td class="row">
					<input name="address_en" type="text" value="<!--record_address_en-->" size="50" />
					<span class="comment">��Where is your company?��</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��������</td>
					<td class="row">
					<input name="zipcode" type="text" value="<!--record_zipcode-->" size="50" len="6" need="digital_" />
					<span class="comment">����Ӧ��˾��ַ���������룩</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">�ֻ�����</td>
					<td class="row">
					<input name="mobile" type="text" value="<!--record_mobile-->" size="50" len="30" />
					<span class="comment">������д���˵��ֻ����룩</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">�绰����</td>
					<td class="row">
					<input name="areacode" type="text" value="<!--record_areacode-->" size="50" len="4" need="digital_" />
					<span class="comment">����˾���ڵ����ĵ绰���ţ�</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��˾�绰</td>
					<td class="row">
					<input name="tel" type="text" value="<!--record_tel-->" size="50" len="20" />
					<span class="comment">����˾����绰��</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">�������</td>
					<td class="row">
					<input name="fax" type="text" value="<!--record_fax-->" size="50" len="20" />
					<span class="comment">����˾������룩</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">�����ʼ�</td>
					<td class="row">
					<input name="email" type="text" value="<!--record_email-->" size="50" len="30" need="email_" />
					<span class="comment">�������õĵ����ʼ���ַ��</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��˾��ַ</td>
					<td class="row">
					<input name="website" type="text" value="<!--record_website-->" size="50" len="150" />
					<span class="comment">����˾��վ��ַ��</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��ʳϰ��</td>
					<td class="row">
					<input name="diet_type" id="i_diet_type_0" type="radio" value="��ͨ��ʳ" /><label for="i_diet_type_0"> ��ͨ��ʳ</label>
					<input name="diet_type" id="i_diet_type_1" type="radio" value="��˹��" /><label for="i_diet_type_1"> ��˹��</label>
					<input name="diet_type" id="i_diet_type_2" type="radio" value="��ʳ" /><label for="i_diet_type_2"> ��ʳ</label>
					<span class="comment">��������ʳϰ�ߣ�</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��������</td>
					<td class="row"><select name="sponsorship">
					<option value="������">������</option>
					<option value="����">����</option></select>
					<span class="comment">���Ƿ�����������</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��ע��Ϣ</td>
					<td class="row">
					<textarea name="notes" style="width:100%;height:50px;"><!--record_notes--></textarea>
					</td>
				</tr>
				<tr>
					<td class="cat" colspan="2" align="center">ס����Ϣ</td>
				</tr>
				<tr>
					<td class="cat" width="80">��������</td>
					<td class="row"><select name="room_type">
					<option value="��ס��">��ס��</option>
					<option value="����">����</option>
					<option value="��ס">��ס</option></select>
					<span class="comment">��Ԥ���������ͣ�</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">��סʱ��</td>
					<td class="row">
					<input name="date_checkin" type="text" value="<!--record_date_checkin-->" size="50" len="10" need="date_" />
					<span class="comment">������ס���ݵ�ʱ�䣩</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">�˷�ʱ��</td>
					<td class="row">
					<input name="date_checkout" type="text" value="<!--record_date_checkout-->" size="50" len="10" need="date_" />
					<span class="comment">�����뿪���ݵ�ʱ�䣩</span>
					</td>
				</tr>
				<tr>
					<td class="cat" colspan="2" align="center">
						<input class="normal" type="Submit" value=" ȷ �� " name="Submit">&nbsp;&nbsp;
						<input class="normal" type="reset" value=" �� �� " name="reset">&nbsp;&nbsp;
						<input class="normal" type="button" value=" �� �� " name="return" onClick="history.go(-1)">
					</td>
				</tr>
			</table>
			</center>
		</form>
		</td>
	</tr>
</table>
<br />
<script language="JavaScript">
$(function(){
	$("#reg_info input:radio[name=gender]").val(["<!--record_gender-->"]);
	$("#reg_info input:radio[name=diet_type]").val(["<!--record_diet_type-->"]);
	$("#reg_info select[name=sponsorship]").val(["<!--record_sponsorship-->"]);
	$("#reg_info select[name=room_type]").val(["<!--record_room_type-->"]);
});
</script>
