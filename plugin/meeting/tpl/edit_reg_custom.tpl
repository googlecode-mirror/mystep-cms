<div class="title"><!--title--></div>
<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	<!--meeting_name-->
</div>
<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
<table id="tbl_main" width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
	<tr>
		<td align="center">
		<br />
		<div align="center"><b>注册日期：</b> <!--record_add_date--></div>
		<br />
		<div align="center">
			【<a href="?method=confirm&mid=<!--mid-->&id=<!--record_id-->" target="_blank">发送确认邮件</a>】
		</div>
		<br />
		<form name="reg_<!--method-->" method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
			<center>
			<input name="id" type="hidden" value="<!--record_id-->">
			<input name="mid" type="hidden" value="<!--mid-->">
			<table cellspacing="0" cellpadding="0" id="reg_info" align="center">
				<tr>
					<td class="cat" width="80">代表姓名</td>
					<td class="row">
					<input name="name" type="text" value="<!--record_name-->" size="50" len="50" />
					<span class="comment">（参会代表中文姓名）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">姓名拼音</td>
					<td class="row">
					<input name="name_en" type="text" value="<!--record_name_en-->" size="50" len="50" />
					<span class="comment">（请录入姓名全拼）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">性别</td>
					<td class="row">
					<input name="gender" id="i_gender_0" type="radio" value="男" /><label for="i_gender_0"> 男</label>
					<input name="gender" id="i_gender_1" type="radio" value="女" /><label for="i_gender_1"> 女</label>
					<span class="comment">（请选择您的性别）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">国家</td>
					<td class="row">
					<input name="country" type="text" value="<!--record_country-->" size="50" len="20" />
					<span class="comment">（请录入您的国家）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">公司中文</td>
					<td class="row">
					<input name="company" type="text" value="<!--record_company-->" size="50" len="150" />
					<span class="comment">（公司中文名称）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">公司英文</td>
					<td class="row">
					<input name="company_en" type="text" value="<!--record_company_en-->" size="50" len="200" />
					<span class="comment">（公司英文名称）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">公司职务</td>
					<td class="row">
					<input name="duty" type="text" value="<!--record_duty-->" size="50" len="30" />
					<span class="comment">（您在公司担任的职务）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">职务英文</td>
					<td class="row">
					<input name="duty_en" type="text" value="<!--record_duty_en-->" size="50" len="50" />
					<span class="comment">（公司职务的英文）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">公司地址</td>
					<td class="row">
					<input name="address" type="text" value="<!--record_address-->" size="50" />
					<span class="comment">（您公司的详细地址）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">Address</td>
					<td class="row">
					<input name="address_en" type="text" value="<!--record_address_en-->" size="50" />
					<span class="comment">（Where is your company?）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">邮政编码</td>
					<td class="row">
					<input name="zipcode" type="text" value="<!--record_zipcode-->" size="50" len="6" need="digital_" />
					<span class="comment">（对应公司地址的邮政编码）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">手机号码</td>
					<td class="row">
					<input name="mobile" type="text" value="<!--record_mobile-->" size="50" len="30" />
					<span class="comment">（请填写本人的手机号码）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">电话区号</td>
					<td class="row">
					<input name="areacode" type="text" value="<!--record_areacode-->" size="50" len="4" need="digital_" />
					<span class="comment">（公司所在地区的电话区号）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">公司电话</td>
					<td class="row">
					<input name="tel" type="text" value="<!--record_tel-->" size="50" len="20" />
					<span class="comment">（公司联络电话）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">传真号码</td>
					<td class="row">
					<input name="fax" type="text" value="<!--record_fax-->" size="50" len="20" />
					<span class="comment">（公司传真号码）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">电子邮件</td>
					<td class="row">
					<input name="email" type="text" value="<!--record_email-->" size="50" len="30" need="email_" />
					<span class="comment">（您常用的电子邮件地址）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">公司网址</td>
					<td class="row">
					<input name="website" type="text" value="<!--record_website-->" size="50" len="150" />
					<span class="comment">（贵公司网站地址）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">饮食习惯</td>
					<td class="row">
					<input name="diet_type" id="i_diet_type_0" type="radio" value="普通饮食" /><label for="i_diet_type_0"> 普通饮食</label>
					<input name="diet_type" id="i_diet_type_1" type="radio" value="穆斯林" /><label for="i_diet_type_1"> 穆斯林</label>
					<input name="diet_type" id="i_diet_type_2" type="radio" value="素食" /><label for="i_diet_type_2"> 素食</label>
					<span class="comment">（您的饮食习惯）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">赞助会议</td>
					<td class="row"><select name="sponsorship">
					<option value="不赞助">不赞助</option>
					<option value="赞助">赞助</option></select>
					<span class="comment">（是否有意赞助）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">备注信息</td>
					<td class="row">
					<textarea name="notes" style="width:100%;height:50px;"><!--record_notes--></textarea>
					</td>
				</tr>
				<tr>
					<td class="cat" colspan="2" align="center">住宿信息</td>
				</tr>
				<tr>
					<td class="cat" width="80">房间类型</td>
					<td class="row"><select name="room_type">
					<option value="不住宿">不住宿</option>
					<option value="单间">单间</option>
					<option value="合住">合住</option></select>
					<span class="comment">（预订房间类型）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">入住时间</td>
					<td class="row">
					<input name="date_checkin" type="text" value="<!--record_date_checkin-->" size="50" len="10" need="date_" />
					<span class="comment">（您入住宾馆的时间）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" width="80">退房时间</td>
					<td class="row">
					<input name="date_checkout" type="text" value="<!--record_date_checkout-->" size="50" len="10" need="date_" />
					<span class="comment">（您离开宾馆的时间）</span>
					</td>
				</tr>
				<tr>
					<td class="cat" colspan="2" align="center">
						<input class="normal" type="Submit" value=" 确 定 " name="Submit">&nbsp;&nbsp;
						<input class="normal" type="reset" value=" 重 置 " name="reset">&nbsp;&nbsp;
						<input class="normal" type="button" value=" 返 回 " name="return" onClick="history.go(-1)">
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
