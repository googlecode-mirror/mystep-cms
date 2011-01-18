<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/check_form.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="if(checkForm(this)){$id('web_id').disabled=false;return true;}else{return false;}">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">所属网站：</td>
				<td class="row">
					<select name="web_id" id="web_id" onchange="$id('cat_main').selectedIndex=0" <!--web_disabled-->>
						<option value="0">非网站栏目</option>
<!--loop:start key="website"-->
						<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">所属栏目：</td>
				<td class="row">
					<select name="cat_main" id="cat_main" onchange="changeCata(this.selectedIndex)">
						<option value="0">顶级栏目</option>
<!--loop:start key="catalog"-->
						<option value="<!--catalog_cat_id-->" webid=<!--catalog_web_id--> <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">分类名称：</td>
				<td class="row">
					<input class="input" name="cat_name" type="text" size="20" maxlength="20" value="<!--cat_name-->" need="">
					<input name="cat_id" type="hidden" value="<!--cat_id-->">
				</td>
			</tr>
			<tr>
				<td class="cat">分类索引：</td>
				<td class="row">
					<input class="input" name="cat_idx" type="text" size="20" maxlength="20" value="<!--cat_idx-->" need="">
				</td>
			</tr>
			<tr>
				<td class="cat">子 分 类：</td>
				<td class="row">
					<input class="input" name="cat_sub" type="text" size="20" maxlength="80" value="<!--cat_sub-->">
				</td>
			</tr>
			<tr>
				<td class="cat">分类描述：</td>
				<td class="row">
					<input class="input" name="cat_comment" type="text" size="20" maxlength="50" value="<!--cat_comment-->" need="">
				</td>
			</tr>
			<tr>
				<td class="cat">分类图示：</td>
				<td class="row">
					<input class="input" style="width:205px" name="cat_image" type="text" size="40" maxlength="50" value="<!--cat_image-->">
					<input class="btn" type="button" onClick="openDialog('upload_img.php?cat_image', 400, 180, 1)" value="上传" />
				</td>
			</tr>
			<tr>
				<td class="cat">显示模式：</td>
				<td class="row">
					<select name="cat_type">
						<option value="0" <!--cat_type_0-->>标题列表</option>
						<option value="1" <!--cat_type_1-->>图片简介</option>
						<option value="2" <!--cat_type_2-->>图片展示</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">显示位置：</td>
				<td class="row">
					<input type="checkbox" id="cat_show_1" class="cbox" name="cat_show[]" value="1" <!--cat_show_1-->><label for="cat_show_1"> 主页导航</label> &nbsp;
					<input type="checkbox" id="cat_show_2" class="cbox" name="cat_show[]" value="2" <!--cat_show_2-->><label for="cat_show_2"> 列表页导航</label> &nbsp;
					<input type="checkbox" id="cat_show_4" class="cbox" name="cat_show[]" value="4" <!--cat_show_4-->><label for="cat_show_4"> 内容页导航</label> &nbsp;
					<input1 class="input" name="cat_show" type="text" size="20" maxlength="7" value="<!--cat_show-->">
				</td>
			</tr>
			<tr>
				<td class="cat">外部链接：</td>
				<td class="row">
					<input class="input" name="cat_link" type="text" size="20" maxlength="100" value="<!--cat_link-->">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div align="center"><br>
						<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
						<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
						<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'">
					</div>
				</td>
			</tr>
		</table>
	</form>
</div>
<script Language="JavaScript1.2">
function changeCata(idx) {
	var web_id=$id("cat_main").options[idx].getAttribute("webid");
	if(web_id!=null) {
		$id("web_id").disabled = true;
		for(var i=0; i<$id("web_id").options.length; i++) {
			if($id("web_id").options[i].value==web_id) {
				$id("web_id").selectedIndex = i;
				break;
			}
		}
	} else {
		$id("web_id").disabled = false;
	}
}
</script>