<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="if(checkForm(this, checkForm_append)){$id('web_id').disabled=false;return true;}else{return false;}">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">所属网站：</td>
				<td class="row">
					<select name="web_id" id="web_id" onchange="setCata()" <!--web_disabled-->>
<!--loop:start key="website"-->
						<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
					<span class="comment">（当前分类所有的子网站）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">所属栏目：</td>
				<td class="row">
					<select name="cat_main" id="cat_main" onchange="changeCata(this.selectedIndex)">
						<option value="0">顶级栏目</option>
<!--loop:start key="catalog"-->
						<option value="<!--catalog_cat_id-->" webid="<!--catalog_web_id-->" <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
					</select>
					<span style="display:<!--show_merge-->;"><input type="checkbox" id="merge" class="cbox" name="merge" value="1" /><label for="merge"> 合并到当前所选栏目</label></span>
					<span class="comment">（当前栏目的父栏目）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">分类名称：<span>*</span></td>
				<td class="row">
					<input class="input" name="cat_name" type="text" size="20" maxlength="30" value="<!--cat_name-->" need="" />
					<input name="cat_id" type="hidden" value="<!--cat_id-->" />
					<span class="comment">（用于显示的栏目名称）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">分类索引：<span>*</span></td>
				<td class="row">
					<input class="input" name="cat_idx" type="text" size="20" maxlength="20" value="<!--cat_idx-->" need="" />
					<span class="comment">（作为栏目网址路径的一部分，不能与其他分类索引相同）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">子 分 类：</td>
				<td class="row">
					<input class="input" name="cat_sub" type="text" size="20" maxlength="80" value="<!--cat_sub-->" />
					<span class="comment">（改分类新闻所能使用的前缀，多个请用半角逗号间隔）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">关 键 字：</td>
				<td class="row">
					<input class="input" name="cat_keyword" type="text" size="20" maxlength="150" value="<!--cat_keyword-->" need="" />
					<span class="comment">（向搜索引擎告知当前栏目的关键词）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">分类描述：</td>
				<td class="row">
					<input class="input" name="cat_comment" type="text" size="20" maxlength="120" value="<!--cat_comment-->" need="" />
					<span class="comment">（向搜索引擎描述当前栏目）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">分类图示：</td>
				<td class="row">
					<input class="input" name="cat_image" type="text" size="40" maxlength="120" value="<!--cat_image-->" />
					<input style="width:60px" class="btn" type="button" onClick="showPop('uploadImage','分类图示上传','url','upload_img.php?cat_image',420, 100)" value="上传" />
					<span class="comment">（用于标识栏目的图标）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">阅读权限：<span>*</span></td>
				<td class="row">
					<input name="view_lvl_org" type="hidden" value="<!--view_lvl-->" />
					<input name="view_lvl" type="text" maxlength="2" value="<!--view_lvl-->" need="digital" />
					<span class="comment">（浏览当前分类文章需要达到的级别，0为不限制）</span></td>
			</tr>
			<tr>
				<td class="cat">显示模板：</td>
				<td class="row">
					<select name="cat_type" onchange="showTpl(this.value)">
						<option value="0" <!--cat_type_0-->>标题列表</option>
						<option value="1" <!--cat_type_1-->>图片展示</option>
						<option value="2" <!--cat_type_2-->>图文混合</option>
						<option value="3" <!--cat_type_3-->>自定义</option>
					</select>
					<span class="comment">（根据栏目内容选择对应的目录页展示方式）</span>
					<div id="tpl">
						<textarea id="template" type="php" name="template" style="width:100%;height:350px;" wrap='off'><!--template--></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td class="cat">显示位置：</td>
				<td class="row">
					<input type="checkbox" id="cat_show_1" class="cbox" name="cat_show[]" value="1" <!--cat_show_1--> /><label for="cat_show_1"> 主导航</label> &nbsp;
					<input type="checkbox" id="cat_show_2" class="cbox" name="cat_show[]" value="2" <!--cat_show_2--> /><label for="cat_show_2"> 列表导航</label> &nbsp;
					<input type="checkbox" id="cat_show_4" class="cbox" name="cat_show[]" value="4" <!--cat_show_4--> /><label for="cat_show_4"> 自定义导航</label> &nbsp;
					<span class="comment">（定义当前分类的显示位置）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">外部链接：</td>
				<td class="row">
					<input class="input" name="cat_link" type="text" size="20" maxlength="150" value="<!--cat_link-->" />
					<span class="comment">（点击栏目将会直接跳转到相关网址）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">提示文字：</td>
				<td class="row">
					<input name="notice_org" type="hidden" value="<!--notice-->" />
					<input class="input" name="notice" type="text" size="20" maxlength="150" value="<!--notice-->" />
					<span class="comment">（显示于当前分类所有文章的提示文字）</span></td>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 提 交 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
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
							//alert("脚本载入失败！");
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
