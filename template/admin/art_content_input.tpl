<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this, checkForm_append)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="120">所属栏目：<span>*</span></td>
				<td class="row" width="680">
					<input type="hidden" name="news_id" value="<!--record_news_id-->" />
					<input id="web_id" type="hidden" name="web_id" value="<!--record_web_id-->" />
					<input type="hidden" name="pages" value="<!--record_pages-->" />
					<select id="cat_id" name="cat_id" onchange="profix_changed(this.value);$id('web_id').value=this.options[this.selectedIndex].getAttribute('web_id');$id('view_lvl').value=this.options[this.selectedIndex].getAttribute('view_lvl');" need="" />
						<option value="">请选择</option>
<!--loop:start key="catalog"-->
						<option value="<!--catalog_cat_id-->" web_id="<!--catalog_web_id-->" view_lvl="<!--catalog_view_lvl-->" <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
					</select> &nbsp;
					<input style="width:80px" class="btn" type="button" onClick="showPop('newsCatalog','多栏目同时发布','id','newsCatalog',200);setMultiCata();" value="多栏目发布" /> <span class="comment">（请选择当前文章所属的类别）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">文章标题：<span>*</span></td>
				<td class="row">
					<input name="subject" type="text" id="title" value="<!--record_subject-->" maxlength="100" need="" /> &nbsp;
					<select id="profix" onchange="title_change()" style="width:80px"></select> &nbsp;
					<input type="checkbox" class="cbox" name="style[]" id="style_b" value="b" <!--check_b--> /><label for="style_b">粗体</label> &nbsp;
					<input type="checkbox" class="cbox" name="style[]" id="style_i" value="i" <!--check_i--> /><label for="style_i">斜体</label> &nbsp;
					<select id="color_list_title" name="style[]" style="width:60px"></select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">关 键 字：<span>*</span></td>
				<td class="row"><input id="keyword" name="tag" type="text" value="<!--record_tag-->" maxlength="100" need="" />
				<span class="comment">（用于搜索相关资讯，多个关键字用逗号分隔）</span></td>
			</tr>
			<tr>
				<td class="cat" width="80">作者出处：</td>
				<td class="row"><input name="original" type="text" maxlength="50" value="<!--record_original-->" /> <span class="comment">（文章来源）</span></td>
			</tr>
			<tr>
				<td class="cat" width="80">跳转网址：</td>
				<td class="row"><input id="link" name="link" type="text" maxlength="150" value="<!--record_link-->" /> <span class="comment">（点击文章标题所链接到的网址）</span></td>
			</tr>
			<tr>
				<td class="cat">文章图示：</td>
				<td class="row">
					<input id="image" name="image" type="text" maxlength="150" value="<!--record_image-->" /> &nbsp;
					<input style="width:60px" class="btn" type="button" onClick="showPop('uploadImage','新闻图示上传','url','upload_img.php?image|240|180',420, 100)" value="上传" />
					<input style="width:60px" class="btn" type="button" onClick="showPop('newsImage','常用新闻图示选择','id','newsImage',570)" value="选择" />
					<input style="width:60px" class="btn" type="button" onClick="insertImg()" value="插入" />
					<span class="comment">（文章标题图形显示）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">阅读权限：<span>*</span></td>
				<td class="row"><input name="view_lvl" id="view_lvl" type="text" maxlength="2" value="<!--record_view_lvl-->" need="digital" /> <span class="comment">（浏览当前文章需要达到的级别，0为不限制）</span></td>
			</tr>
			<tr>
				<td class="cat">提示文字：</td>
				<td class="row"><input name="notice" type="text" size="20" maxlength="150" value="<!--record_notice-->" /> <span class="comment">（显示于文章指定位置的版权、免责、告示等提示文字）</span></td>
			</tr>
			<tr>
				<td class="cat">列表排序：<span>*</span></td>
				<td class="row"><input name="order" type="text" maxlength="3" value="<!--record_order-->" need="digital" /> <span class="comment">（文章排序，序号越大越靠前，可达到文章置顶效果）</span></td>
			</tr>
			<tr>
				<td class="cat">过期时间：</td>
				<td class="row"><input name="expire" type="text" maxlength="20" value="<!--record_expire-->" need="date_" /> <span class="comment">（超过此时间的文章将不在列表中显示，可留空）</span></td>
			</tr>
			<tr>
				<td class="cat" width="80">推送模式：</td>
				<td class="row">
<!--loop:start key="setop_mode"-->
					<input type="radio" id="setop_mode_<!--setop_mode_key-->" class="cbox" name="setop_mode" value="<!--setop_mode_key-->" <!--setop_mode_checked--> /><label for="setop_mode_<!--setop_mode_key-->" /> <!--setop_mode_value--></label> &nbsp;
<!--loop:end--> <span class="comment">（文章推送模式）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">推送位置：</td>
				<td class="row">
<!--loop:start key="setop"-->
				<input type="checkbox" id="setop_<!--setop_key-->" class="cbox" name="setop[]" value="<!--setop_key-->" <!--setop_checked--> /><label for="setop_<!--setop_key-->" /> <!--setop_value--></label> &nbsp;
<!--loop:end--> <span class="comment">（文章推送位置，可复选）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">文章描述：<span>*</span><br /><br />（限120字）</td>
				<td class="row">
					<textarea name="describe" style="width:100%;height:54px;" need=""><!--record_describe--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80" valign="top">主要内容：</td>
				<td class="row">
					<input name="get_remote_file" class="cbox" id="get_remote_file" type="checkbox" value="1" <!--get_remote_file--> /><label for="get_remote_file">自动复制外网图片到本地</label>
					&nbsp; &nbsp;
					[<a href="javascript:" onclick="attach_mine()">我的附件</a>]
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>
						<textarea id="content" name="content" style="width:100%; height:400px;"><!--record_content--></textarea>
					</div>
				<td>
			</tr>
			<tr>
				<td class="row" colspan="2">
					<span class="comment">提示：双击图片可自动设置为标题图片，双击链接可自动设置为跳转链接！</span>
				<td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="hidden" name="attach_list" value="|">
					<input class="btn" type="hidden" name="multi_cata" value="">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 附 件 " onclick="attach_edit()" />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>

<div id="newsImage" class="popshow">
<!--loop:start key="news_image"-->
	<dl>
		<dt><img src="<!--news_image_image-->" title="<!--news_image_keyword-->"	onclick="putImage(this)" /></dt>
		<dd><!--news_image_name--></dd>
	</dl>
<!--loop:end-->
</div>

<div id="newsCatalog" class="popshow">
	<div style="width:190px; height:200px; overflow-y:auto;">
<!--loop:start key="catalog"-->
		<input type="checkbox" name="multi_cata" value="<!--catalog_cat_id-->," /> <!--catalog_cat_name--> <br />
<!--loop:end-->
	</div>
	<div style="text-align:center;margin-top:10px;"><input class="btn" type="button" onClick="putMultiCata()" value=" 确 定 " /></div>
</div>

<script language="JavaScript" type="text/javascript" src="../script/tinymce/jquery.tinymce.js"></script>
<script language="JavaScript" type="text/javascript" src="../script/jquery.powerupload.js"></script>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
var news_id = "<!--news_id-->";
var upload_limit = "<!--MaxSize-->";
var web_url = "<!--web_url-->";
var cat_sub_list = new Array();
<!--loop:start key="cat_sub"-->
cat_sub_list['<!--cat_sub_cat_id-->'] = "<!--cat_sub_cat_sub-->";
<!--loop:end-->

function checkForm_append(theForm) {
	if(theForm.describe.value=="") theForm.describe.value = theForm.subject.value;
	if(theForm.link.value!="" && $id("content").value=="") {
		$id("content").value = theForm.link.value;
	}
	var flag = true;
	var theLen = theForm.describe.value.Tlength();
	if(theLen>240) {
		alert(printf("当前描述长度为 %1 字节，请限制在 %2 字节内！", theLen, 240));
		flag = false;
	}
	return flag;
}

$(function(){
	add_color($id("color_list_title"), "<!--check_c-->");
	profix_changed(<!--record_cat_id-->);
	tinyMCE_init("content");
});
//]]> 
</script>