<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="if(checkForm(this, checkForm_append)){$id('web_id').disabled=false;return true;}else{return false;}">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">������վ��</td>
				<td class="row">
					<select name="web_id" id="web_id" onchange="setCata()" <!--web_disabled-->>
<!--loop:start key="website"-->
						<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
					<span class="comment">����ǰ�������е�����վ��</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">������Ŀ��</td>
				<td class="row">
					<select name="cat_main" id="cat_main" onchange="changeCata(this.selectedIndex)">
						<option value="0">������Ŀ</option>
<!--loop:start key="catalog"-->
						<option value="<!--catalog_cat_id-->" webid="<!--catalog_web_id-->" <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
					</select>
					<span style="display:<!--show_merge-->;"><input type="checkbox" id="merge" class="cbox" name="merge" value="1" /><label for="merge"> �ϲ�����ǰ��ѡ��Ŀ</label></span>
					<span class="comment">����ǰ��Ŀ�ĸ���Ŀ��</span>
				</td>
			</tr>
			<tr>
				<td class="cat">�������ƣ�<span>*</span></td>
				<td class="row">
					<input class="input" name="cat_name" type="text" size="20" maxlength="30" value="<!--cat_name-->" need="" />
					<input name="cat_id" type="hidden" value="<!--cat_id-->" />
					<span class="comment">��������ʾ����Ŀ���ƣ�</span>
				</td>
			</tr>
			<tr>
				<td class="cat">����������<span>*</span></td>
				<td class="row">
					<input class="input" name="cat_idx" type="text" size="20" maxlength="20" value="<!--cat_idx-->" need="" />
					<span class="comment">����Ϊ��Ŀ��ַ·����һ���֣���������������������ͬ��</span>
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
				<td class="cat">�� �� �֣�</td>
				<td class="row">
					<input class="input" name="cat_keyword" type="text" size="20" maxlength="150" value="<!--cat_keyword-->" need="" />
					<span class="comment">�������������֪��ǰ��Ŀ�Ĺؼ��ʣ�</span>
				</td>
			</tr>
			<tr>
				<td class="cat">����������</td>
				<td class="row">
					<input class="input" name="cat_comment" type="text" size="20" maxlength="120" value="<!--cat_comment-->" need="" />
					<span class="comment">������������������ǰ��Ŀ��</span>
				</td>
			</tr>
			<tr>
				<td class="cat">����ͼʾ��</td>
				<td class="row">
					<input class="input" name="cat_image" type="text" size="40" maxlength="120" value="<!--cat_image-->" />
					<input style="width:60px" class="btn" type="button" onClick="showPop('uploadImage','����ͼʾ�ϴ�','url','upload_img.php?cat_image',420, 100)" value="�ϴ�" />
					<span class="comment">�����ڱ�ʶ��Ŀ��ͼ�꣩</span>
				</td>
			</tr>
			<tr>
				<td class="cat">�Ķ�Ȩ�ޣ�<span>*</span></td>
				<td class="row">
					<input name="view_lvl_org" type="hidden" value="<!--view_lvl-->" />
					<input name="view_lvl" type="text" maxlength="2" value="<!--view_lvl-->" need="digital" />
					<span class="comment">�������ǰ����������Ҫ�ﵽ�ļ���0Ϊ�����ƣ�</span></td>
			</tr>
			<tr>
				<td class="cat">��ʾģ�壺</td>
				<td class="row">
					<select name="cat_type" onchange="showTpl(this.value)">
						<option value="0" <!--cat_type_0-->>�����б�</option>
						<option value="1" <!--cat_type_1-->>ͼƬչʾ</option>
						<option value="2" <!--cat_type_2-->>ͼ�Ļ��</option>
						<option value="3" <!--cat_type_3-->>�Զ���</option>
					</select>
					<span class="comment">��������Ŀ����ѡ���Ӧ��Ŀ¼ҳչʾ��ʽ��</span>
					<div id="tpl">
						<textarea id="template" type="php" name="template" style="width:100%;height:350px;" wrap='off'><!--template--></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td class="cat">��ʾλ�ã�</td>
				<td class="row">
					<input type="checkbox" id="cat_show_1" class="cbox" name="cat_show[]" value="1" <!--cat_show_1--> /><label for="cat_show_1"> ������</label> &nbsp;
					<input type="checkbox" id="cat_show_2" class="cbox" name="cat_show[]" value="2" <!--cat_show_2--> /><label for="cat_show_2"> �б���</label> &nbsp;
					<input type="checkbox" id="cat_show_4" class="cbox" name="cat_show[]" value="4" <!--cat_show_4--> /><label for="cat_show_4"> �Զ��嵼��</label> &nbsp;
					<span class="comment">�����嵱ǰ�������ʾλ�ã�</span>
				</td>
			</tr>
			<tr>
				<td class="cat">�ⲿ���ӣ�</td>
				<td class="row">
					<input class="input" name="cat_link" type="text" size="20" maxlength="150" value="<!--cat_link-->" />
					<span class="comment">�������Ŀ����ֱ����ת�������ַ��</span>
				</td>
			</tr>
			<tr>
				<td class="cat">��ʾ���֣�</td>
				<td class="row">
					<input name="notice_org" type="hidden" value="<!--notice-->" />
					<input class="input" name="notice" type="text" size="20" maxlength="150" value="<!--notice-->" />
					<span class="comment">����ʾ�ڵ�ǰ�����������µ���ʾ���֣�</span></td>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
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
var flag = false;
function showTpl(val) {
	if(val==3) {
		if(flag) {
			$('#template').codemirror({
						lineWrapping: false,
						height: 350
				}, function(){
						if($.codemirror_error) {
							//alert("�ű�����ʧ�ܣ�");
						} else {
							$('.CodeMirror').css({width:'680px','overflow':"hidden","text-align":"left","border":"1px solid #cccccc"});
							$('#template').parent(".row").css("padding","0px");
							flag = false;
						}
				});
		}
		$("#tpl").show();
	} else {
		$("#tpl").hide();
	}
}

function setCata(){
	var webid = $id("web_id").value;
	$("#cat_main > option").hide();
	$("#cat_main > option:first").show();
	$("#cat_main > option[webid="+webid+"]").show();
	$id('cat_main').selectedIndex=0;
}

function checkForm_append(theForm) {
	if(theForm.cat_idx.value=="") theForm.cat_idx.value = theForm.cat_name.value;
	if(theForm.cat_keyword.value=="") theForm.cat_keyword.value = theForm.cat_name.value;
	if(theForm.cat_comment.value=="") theForm.cat_comment.value = theForm.cat_name.value;
	return true;
}

$(function(){
	setCata();
	$.getScript("../script/jquery.codemirror.js", function(){
		flag=true;
		showTpl(<!--cat_type-->);
	});
});
//]]> 
</script>
