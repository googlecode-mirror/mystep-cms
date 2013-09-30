<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">2012中国乳制品贸易与产业发展论坛</div>
<hr />
<br />
<script src="script/checkForm.js" Language="JavaScript1.2"></script>
<script src="script/jquery.date_input.js" Language="JavaScript1.2"></script>
<script src="script/jquery.autocomplete.js" Language="JavaScript1.2"></script>
<form name="cf_submit" method="post" ACTION="/module.php?m=cf_submit" ENCTYPE="multipart/form-data" onsubmit="return checkForm(this)">
	<input name="id" type="hidden" value="0" />
	<input name="mid" type="hidden" value="2" />
	<table width="600" border="0" class="cf_form" align="center" cellpadding="2" cellspacing="1">
				<tr>
					<td class="cat" width="80">代表姓名</td>
					<td class="row">
						<input name="name" type="text" value="" size="50" len="50" />
					</td>
				</tr>
				<tr>
					<td class="cat">姓名英文</td>
					<td class="row">
						<input name="name_en" type="text" value="" size="50" len="50" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">性别</td>
					<td class="row">
						<input name="gender" id="i_gender_0" type="radio" value="1" checked /><label for="i_gender_0"> 男</label>
						<input name="gender" id="i_gender_1" type="radio" value="2" /><label for="i_gender_1"> 女</label>
					</td>
				</tr>
				<tr>
					<td class="cat">国家</td>
					<td class="row">
						<input name="country" type="text" class="ac_input" value="中国" size="50" len="30" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">公司中文</td>
					<td class="row">
						<input name="company" type="text" value="" size="50" len="150" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">公司英文</td>
					<td class="row">
						<input name="company_en" type="text" value="" size="50" len="200" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">公司职务</td>
					<td class="row">
						<input name="duty" type="text" value="" size="50" len="30" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">职务英文</td>
					<td class="row">
						<input name="duty_en" type="text" value="" size="50" len="50" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">公司地址</td>
					<td class="row">
						<input name="address" type="text" value="" size="50" len="150" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">地址英文</td>
					<td class="row">
						<input name="address_en" type="text" value="" size="50" len="230" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">邮政编码</td>
					<td class="row">
						<input name="zipcode" type="text" value="" size="50" len="6" need="digital" />
					</td>
				</tr>
				<tr>
					<td class="cat">手机号码</td>
					<td class="row">
						<input name="mobile" type="text" value="" size="50" len="30" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">电话区号</td>
					<td class="row">
						<input name="areacode" type="text" value="" size="50" len="4" need="digital" />
					</td>
				</tr>
				<tr>
					<td class="cat">公司电话</td>
					<td class="row">
						<input name="tel" type="text" value="" size="50" len="20" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">传真号码</td>
					<td class="row">
						<input name="fax" type="text" value="" size="50" len="20" need="" />
					</td>
				</tr>
				<tr>
					<td class="cat">电子邮件</td>
					<td class="row">
						<input name="email" type="text" value="" size="50" len="50" need="email" />
					</td>
				</tr>
				<tr>
					<td class="cat">公司网址</td>
					<td class="row">
						<input name="website" type="text" value="" size="50" len="150" />
					</td>
				</tr>
				<tr>
					<td class="cat">饮食习惯</td>
					<td class="row">
						<input name="diet_type" id="i_diet_type_0" type="radio" value="1" checked /><label for="i_diet_type_0"> 普通饮食</label><br />
						<input name="diet_type" id="i_diet_type_1" type="radio" value="2" /><label for="i_diet_type_1"> 穆斯林</label><br />
						<input name="diet_type" id="i_diet_type_2" type="radio" value="3" /><label for="i_diet_type_2"> 素食</label><br />
					</td>
				</tr>
				<tr>
					<td class="cat">公司类型</td>
					<td class="row">
						<input name="company_type" id="i_company_type_0" type="radio" value="1" /><label for="i_company_type_0"> 生产商</label><br />
						<input name="company_type" id="i_company_type_1" type="radio" value="2" /><label for="i_company_type_1"> 分销商/进口商</label><br />
						<input name="company_type" id="i_company_type_2" type="radio" value="3" /><label for="i_company_type_2"> 经销商/代理商</label><br />
						<input name="company_type" id="i_company_type_3" type="radio" value="4" /><label for="i_company_type_3"> 政府机构/院校/协会/商会</label><br />
						<input name="company_type" id="i_company_type_4" type="radio" value="5" /><label for="i_company_type_4"> 商业顾问/咨询机构</label><br />
						<input name="company_type" id="i_company_type_5" type="radio" value="6" /><label for="i_company_type_5"> 媒体/公关(出版.广播,广告)</label><br />
						<input name="company_type" id="i_company_type_6" type="radio" value="7" /><label for="i_company_type_6"> 其他</label>
					</td>
				</tr>
				<tr>
					<td class="cat">房间类型</td>
					<td class="row"><select name="room_type">
						<option value="1" selected>不住宿</option>
						<option value="2">单间</option>
						<option value="3">合住</option></select>
					</td>
				</tr>
				<tr>
					<td class="cat">入住时间</td>
					<td class="row">
						<input name="date_checkin" type="text" value="" size="50" len="10" need="date_" />
					</td>
				</tr>
				<tr>
					<td class="cat">退房时间</td>
					<td class="row">
						<input name="date_checkout" type="text" value="" size="50" len="10" need="date_" />
					</td>
				</tr>
				<tr>
					<td class="cat">备注信息</td>
					<td class="row">
						<textarea name="notes" style="width:100%;height:50px;"></textarea>
					</td>
				</tr>
	</table>
	<div id="new_list"></div>
	<table width="600" border="0" class="cf_form" align="center" cellpadding="2" cellspacing="1">
		<TR CLASS="row">
			<TD colspan="2"><center><input type="checkbox" name="print" value="y" id="print" /><label for="print"> 打印</label></center></TD>
		</TR>
		<TR CLASS="row">
			<TD colspan="2"><center><input type="submit" value=" 提 交 " /> &nbsp; <input type="reset" value=" 复 位 " /> &nbsp; <input type="button" onclick="add()" value=" 增 加 " /> &nbsp; <input type="button" onclick="del()" value=" 移 除 " /></center></TD>
		</TR>
	</table>
</form>
<table id="new_one" style="display:none;margin:10px auto;" width="600" border="0" class="cf_form" align="center" cellpadding="2" cellspacing="1">
	<tr>
		<td class="cat" width="80">新加代表 <span>0</span></td>
		<td class="cat"></td>
	</tr>
	<tr>
		<td class="cat" width="80">代表姓名</td>
		<td class="row">
			<input name="name" type="text" value="" size="50" len="50" need="" />
		</td>
	</tr>
	<tr>
		<td class="cat">姓名英文</td>
		<td class="row">
			<input name="name_en" type="text" value="" size="50" len="50" need="" />
		</td>
	</tr>
	<tr>
		<td class="cat">性别</td>
		<td class="row">
			<input name="gender" id="i_gender_0" type="radio" value="1" checked /><label for="i_gender_0"> 男</label>
			<input name="gender" id="i_gender_1" type="radio" value="2" /><label for="i_gender_1"> 女</label>
		</td>
	</tr>
	<tr>
		<td class="cat">国家</td>
		<td class="row">
			<input name="country" type="text" class="ac_input" value="中国" size="50" len="30" need="" />
		</td>
	</tr>
	<tr>
		<td class="cat">公司职务</td>
		<td class="row">
			<input name="duty" type="text" value="" size="50" len="30" need="" />
		</td>
	</tr>
	<tr>
		<td class="cat">职务英文</td>
		<td class="row">
			<input name="duty_en" type="text" value="" size="50" len="50" need="" />
		</td>
	</tr>
	<tr>
		<td class="cat">手机号码</td>
		<td class="row">
			<input name="mobile" type="text" value="" size="50" len="30" need="" />
		</td>
	</tr>
	<tr>
		<td class="cat">电子邮件</td>
		<td class="row">
			<input name="email" type="text" value="" size="50" len="50" need="email" />
		</td>
	</tr>
	<tr>
		<td class="cat">房间类型</td>
		<td class="row"><select name="room_type">
			<option value="1" selected>不住宿</option>
			<option value="2">单间</option>
			<option value="3">合住</option></select>
		</td>
	</tr>
	<tr>
		<td class="cat">入住时间</td>
		<td class="row">
			<input name="date_checkin" type="text" value="" size="50" len="10" need="_date" />
		</td>
	</tr>
	<tr>
		<td class="cat">退房时间</td>
		<td class="row">
			<input name="date_checkout" type="text" value="" size="50" len="10" need="_date" />
		</td>
	</tr>
	<tr>
		<td class="row" colspan="2">
			<center><input type="button" onclick="del(this)" value=" 移 除 " /></center>
		</td>
	</tr>
</table>
<script Language="JavaScript1.2">
var uTime = (new Date()).getTime();
var date = new Date();
date.setTime(uTime+10*60*1000);
$.cookie('cf_time', null);
$.cookie('cf_time', Math.round(date.getTime()/1000), {expires: date, path: '/', domain: '<?=$setting['cookie']['domain']?>'});

function add() {
	var obj = $("#new_one").clone();
	var num = $("#new_list").find(".cf_form").length;
	var the_html = obj.html();
	the_html = the_html.replace(/ name\="(\w+)"/ig, ' name="append['+num+'][$1]"');
	the_html = the_html.replace(/ need="_date"/ig, ' need="date"');
	obj.html(the_html);
	obj.attr("id", "");
	obj.find("span:first").text(num+1);
	obj.appendTo("#new_list");
	obj.show();
	obj.find("input[need=date]").attr("readonly", true);
	obj.find("input[need=date]").date_input();
}

function del() {
	$("#new_list").find(".cf_form:last").remove();
}
</script>