<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="if(checkForm(this)){$id('web_id').disabled=false;return true;}else{return false;}">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">������վ��</td>
				<td class="row">
					<select name="web_id" id="web_id" onchange="$id('cat_main').selectedIndex=0" <!--web_disabled-->>
<!--loop:start key="website"-->
						<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">������Ŀ��</td>
				<td class="row">
					<select name="cat_main" id="cat_main" onchange="changeCata(this.selectedIndex)">
						<option value="0">������Ŀ</option>
<!--loop:start key="catalog"-->
						<option value="<!--catalog_cat_id-->" webid=<!--catalog_web_id--> <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">�������ƣ�<span>*</span></td>
				<td class="row">
					<input class="input" name="cat_name" type="text" size="20" maxlength="30" value="<!--cat_name-->" need="" />
					<input name="cat_id" type="hidden" value="<!--cat_id-->" />
				</td>
			</tr>
			<tr>
				<td class="cat">����������<span>*</span></td>
				<td class="row">
					<input class="input" name="cat_idx" type="text" size="20" maxlength="20" value="<!--cat_idx-->" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat">�� �� �ࣺ</td>
				<td class="row">
					<input class="input" name="cat_sub" type="text" size="20" maxlength="80" value="<!--cat_sub-->" />
					<span class="comment">���ķ�����������ʹ�õ�ǰ׺��������ð�Ƕ��ż����</span>
				</td>
			</tr>
			<tr>
				<td class="cat">����������<span>*</span></td>
				<td class="row">
					<input class="input" name="cat_comment" type="text" size="20" maxlength="120" value="<!--cat_comment-->" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat">����ͼʾ��</td>
				<td class="row">
					<input class="input" name="cat_image" type="text" size="40" maxlength="120" value="<!--cat_image-->" />
					<input style="width:60px" class="btn" type="button" onClick="showPop('uploadImage','����ͼʾ�ϴ�','url','upload_img.php?cat_image',420, 100)" value="�ϴ�" />
				</td>
			</tr>
			<tr>
				<td class="cat">�Ķ�Ȩ�ޣ�<span>*</span></td>
				<td class="row">
					<input name="view_lvl_org" type="hidden" value="<!--view_lvl-->" /> 
					<input name="view_lvl" type="text" maxlength="2" value="<!--view_lvl-->" need="digital" /> 
					<span class="comment">�������ǰ����������Ҫ�ﵽ�ļ���</span></td>
			</tr>
			<tr>
				<td class="cat">��ʾģʽ��</td>
				<td class="row">
					<select name="cat_type">
						<option value="0" <!--cat_type_0-->>�����б�</option>
						<option value="1" <!--cat_type_1-->>ͼƬ���</option>
						<option value="2" <!--cat_type_2-->>ͼƬչʾ</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">��ʾλ�ã�</td>
				<td class="row">
					<input type="checkbox" id="cat_show_1" class="cbox" name="cat_show[]" value="1" <!--cat_show_1--> /><label for="cat_show_1"> ������</label> &nbsp;
					<input type="checkbox" id="cat_show_2" class="cbox" name="cat_show[]" value="2" <!--cat_show_2--> /><label for="cat_show_2"> �б���</label> &nbsp;
					<input type="checkbox" id="cat_show_4" class="cbox" name="cat_show[]" value="4" <!--cat_show_4--> /><label for="cat_show_4"> �Զ��嵼��</label> &nbsp;
					<input1 class="input" name="cat_show" type="text" size="20" maxlength="7" value="<!--cat_show-->" />
				</td>
			</tr>
			<tr>
				<td class="cat">�ⲿ���ӣ�</td>
				<td class="row">
					<input class="input" name="cat_link" type="text" size="20" maxlength="150" value="<!--cat_link-->" />
				</td>
			</tr>
			<tr>
				<td class="cat">��ʾ���֣�</td>
				<td class="row">
					<input name="notice_org" type="hidden" value="<!--notice_org-->" />
					<input class="input" name="notice" type="text" size="20" maxlength="150" value="<!--notice-->" />
					<span class="comment">����ʾ�ڵ�ǰ�����������µ���ʾ���֣�</span></td>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="row">
					<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script Language="JavaScript1.2">
if(typeof($.setupJMPopups)=="undefined") $.getScript("../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});
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
	if("<!--web_disabled-->"=="disabled") $id("web_id").disabled = true;
}
</script>
