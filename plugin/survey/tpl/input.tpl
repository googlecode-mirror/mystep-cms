<div class="title"><!--title--></div>
<div align="left">
	<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="80">调查主题：</td>
				<td class="row">
				<input type="hidden" name="id" value="<!--record_id-->" />
				<input type="text" name="subject" value="<!--record_subject-->" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">调查描述：</td>
				<td class="row">
				<input type="text" name="describe" value="<!--record_describe-->" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">可选数量：</td>
				<td class="row">
				<input type="text" name="max_select" value="<!--record_max_select-->" need="digital" />
				<font>（0-不限制，1-单选，其他多选）</font>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">用户级别：</td>
				<td class="row">
				<input type="text" name="user_lvl" value="<!--record_user_lvl-->" need="digital" />
				<font>（用户投票需要达到的等级）</font>
				</td>
			</tr>
			<tr>
				<td class="cat">有效时间：</td>
				<td class="row">
				<select name="expire">
				<!--record_expire-->
				<option value="0">永久</option>
				<option value="1">一天</option>
				<option value="2">两天</option>
				<option value="3">三天</option>
				<option value="4">四天</option>
				<option value="5">五天</option>
				<option value="6">六天</option>
				<option value="7">一周</option>
				<option value="30">一月</option>
				<option value="90">一季</option>
				<option value="180">半年</option>
				<option value="365">一年</option>
				</select>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 确 定 " name="Submit">&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " name="reset">&nbsp;&nbsp;
					<input class="btn" type="button" value=" 清 空 " name="empty" onClick="location.href='?method=empty&id=<!--record_id-->'">&nbsp;&nbsp;
					<input class="btn" type="button" value=" 导 出 " name="export" onClick="location.href='?method=export&id=<!--record_id-->'">&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " name="return" onClick="history.go(-1)">
				</td>
			</tr>
		</table>
	</form>
</div>
<div style="display:<!--show_item-->">
	<div class="title">调查项目维护</div>
	<div align="center">
		<form name="add_item" method="post" action="?method=add_item" onsubmit="return checkForm(this)">
			<table id="input_area" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td class="cat" colspan="2">项目添加<input name="id" type="hidden" value="<!--record_id-->"><input name="vote" type="hidden" value="0"></td>
				</tr>
				<tr>
					<td class="cat" width="80">调查项目：</td>
					<td class="row"><input name="title" type="text" maxlength="100" need="" value=""> &nbsp; <font>（调查内容，必填）</font></td>
				</tr>
				<tr>
					<td class="cat" width="80">选项分类：</td>
					<td class="row"><input name="catalog" type="text" maxlength="20" value=""> &nbsp; <font>（选项归类，可选）</font></td>
				</tr>
				<tr>
					<td class="cat" width="80">项目图示：</td>
					<td class="row"><input name="image" type="text" maxlength="100" value=""> &nbsp; <font>（项目图示，可选）</font></td>
				</tr>
				<tr>
					<td class="cat" width="80">链接地址：</td>
					<td class="row"><input name="url" type="text" maxlength="100" need="url_" value=""> &nbsp; <font>（相关网址，可选）</font></td>
				</tr>
				<tr class="row">
					<td colspan="2" align="center">
						<input class="btn" type="Submit" value=" 确 定 " name="Submit">&nbsp;&nbsp;
						<input class="btn" type="reset" value=" 重 置 " name="reset">&nbsp;&nbsp;
					</td>
				</tr>
			</table>
		</form>
		<form name="batch_import" method="post" action="?method=import" ENCTYPE="multipart/form-data" onSubmit="return checkForm(this)">
			<table id="input_area" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td class="cat" width="80">批量导入：</td>
					<td class="row">
						<input name="id" type="hidden" value="<!--record_id-->">
						<input type='hidden' name='MAX_FILE_SIZE' value='<!--upload_max_filesize-->'>
						<input type="file" name="the_file" style="width:500px;" need="">
						<input class="btn" type="Submit" value=" 确 定 " name="Submit" />
					</td>
				</tr>
			</table>
		</form>
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
<!--loop:start key="item_list"-->
			<tr>
				<td class="cat" width="80">项目 <!--item_list_no-->：</td>
				<td class="row"><!--item_list_catalog--> <a href="<!--item_list_url-->" target="_blank"><!--item_list_title--></a> （<!--item_list_vote-->票）</td>
				<td class="row" width="40" align="center"><a href="?method=del_item&id=<!--record_id-->&idx=<!--item_list_idx-->"><b>删除</b></a></td>
			</tr>
<!--loop:end-->
		</table>
	</div>
</div>
