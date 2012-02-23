<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" width="400" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="80">所属子站：</td>
				<td class="row">
					<select name="web_id">
						<option value="0">未限定</option>
<!--loop:start key="website"-->
						<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
					<span class="comment">（当前文章图示可用于那个子站）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">图示名称：<span>*</span></td>
				<td class="row">
					<input name="id" type="hidden" value="<!--id-->" />
					<input name="name" type="text" size="20" maxlength="30" value="<!--name-->" need="" />
					<span class="comment">（方便记忆和辨别的名称）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">关 键 字：<span>*</span></td>
				<td class="row">
					<input name="keyword" type="text" value="<!--keyword-->" maxlength="100" need="" />
					<span class="comment">（本关键字将会直接被带入选择当前图示的文章的关键字栏目）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">图示地址：<span>*</span></td>
				<td class="row">
					<input style="width:200px" name="image" type="text" maxlength="80" value="<!--image-->" need="" /> &nbsp;
					<input style="width:60px" class="btn" type="button" onClick="showPop('uploadImage','新闻图示上传','url','upload_img.php?image',420, 100)" value="上传" />
					<span class="comment">（相关图片，可上传或直接给出图片网址）</span>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
if(typeof($.setupJMPopups)=="undefined") $.getScript("../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});
</script>
