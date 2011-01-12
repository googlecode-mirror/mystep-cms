	<div class="page_lst after">
		<div class="fl">
			<div class="hslice box_1">
				<div class="entry-title">最新资讯</div>
				<div class="entry-content after">
<!--news limit="10"-->
				</div>
			</div>
			<div class="hslice box_1">
				<div class="entry-title">教练阵容</div>
				<div class="entry-content after">
<!--news show_image="1" cat_id="5" limit="4" template="picture"-->
				</div>
			</div>
			<div class="hslice box_1">
				<div class="entry-title">营员风采</div>
				<div class="entry-content after">
<!--news show_image="1" cat_id="4" limit="4" template="picture"-->
				</div>
			</div>
		</div>
		<div class="fr">
			<div class="hslice box_2">
				<div class="entry-title">
					<div class="c1"><img src="images/default/bar_pic1.png" /></div>
					<div class="c2">当前位置： <a href="<!--web_url-->"><!--title--></a> - 在线报名</div>
				</div>
				<div class="entry-content">
					<div class="regist" align="center">

					<h1 align=center>参会代表资料登记表</h1>
					<br /><hr />
					<center><a href="Registration Form.doc"><b>点击此处下载报名表</b></a></center>
					<br />
					<script src="script/check_form.js" Language="JavaScript1.2"></script>
					<form name="regist" method="post" ACTION="?" ENCTYPE="multipart/form-data" onsubmit="return Check_form(this)">
				  <table width="500" border="0" id="tbl_reg" align="center" cellpadding="2" cellspacing="1">
				    <tr>
				      <td colspan="2"><b>企业资料</b></td>
				    </tr>
				    <tr>
				      <td width="100">姓名： </td><td><input name="name" type="text" size="40" value="" need="" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>姓名英文： </td><td><input name="name_en" type="text" size="40" value="" need="" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>性别： </td><td>
				      	<input name="gender" type="radio" value="0" checked /> 男 &nbsp;
				      	<input name="gender" type="radio" value="1" /> 女
				      </td>
				    </tr>
				    <tr>
				      <td>国家： </td><td><input name="country" type="text" size="40" value="" need="" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>公司： </td><td><input name="company" type="text" size="40" value="" need="" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>公司英文： </td><td><input name="company_en" type="text" size="40" value="" need="" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>职务： </td><td><input name="duty" type="text" size="40" value="" need="" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>职务英文： </td><td><input name="duty_en" type="text" size="40" value="" need="" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>地址： </td><td><input name="address" type="text" size="40" value="" need="" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>地址英文： </td><td><input name="address_en" type="text" size="40" value="" need="" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>邮编： </td><td><input name="zipcode" type="text" size="40" value="" maxlength="6" need="digital" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>区号： </td><td><input name="areacode" type="text" size="40" value="" maxlength="5" need="digital" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>电话： </td><td><input name="tel" type="text" size="40" value="" need="tel" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>传真： </td><td><input name="fax" type="text" size="40" value="" need="fax" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>手机： </td><td><input name="mobile" type="text" size="40" value="" need="digital" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>邮件： </td><td><input name="email" type="text" size="40" value="" need="email" /> <font color="red">**</font></td>
				    </tr>
				    <tr>
				      <td>网址： </td><td><input name="website" type="text" size="40" value="" /></td>
				    </tr>
				    <tr>
				      <td>备注： </td><td><input name="notes" type="text" size="40" value="" /></td>
				    </tr>

				    <tr>
				      <td colspan="2"><hr /></td>
				    </tr>
				    
				    <tr>
				      <td colspan="2"><b>旅游</b></td>
				    </tr>
				    <tr>
				      <td>半日游： </td><td>
				         <input name="if_travel_1" type="radio" id="if_travel_1_1" value="1" /><label for="if_travel_1_1">参加</label> &nbsp;
				         <input name="if_travel_1" type="radio" id="if_travel_1_0" value="0" checked /><label for="if_travel_1_0">不参加</label>
				      </td>
				    </tr>
				    <tr>
				      <td>会后游： </td><td>
				         <select name="if_travel_2">
				         	<option value="0">不参加</option>
				         	<option value="1">参加 - 单住</option>
				         	<option value="2">参加 - 合住</option>
				         </select>
				      </td>
				    </tr>

				    <tr>
				      <td colspan="2"><hr /></td>
				    </tr>
				    
				    <tr>
				      <td colspan="2"><b>住宿</b></td>
				    </tr>

				    <tr>
				      <td>房间类型： </td><td>
				         <select name="room_type">
				         	<option value="0">不住宿</option>
				         	<option value="1">合住</option>
				         	<option value="2">单住大床房</option>
				         	<option value="3">单住双床标间</option>
				         </select>
				         （稻香楼宾馆）
				      </td>
				    </tr>
				    <tr>
				      <td>入住时间： </td><td><input name="date_checkin" type="text" value="" need="date_" />(YYYY/MM/DD)</td>
				    </tr>
				    <tr>
				      <td>退房时间： </td><td><input name="date_checkout" type="text" value="" need="date_" />(YYYY/MM/DD)</td>
				    </tr>
				    
						<TR CLASS="tdlight">
							<TD colspan="2"><center><input type="submit" value="提  交"> &nbsp; <input type="reset" value="复  位"></center></TD>
						</TR>
				  </table>
					</form>

					</div>
				</div>
				<div class="page after"><!--page_list--></div>
			</div>
		</div>
	</div>