	<div class="page_lst after">
		<div class="fl">
			<div class="box box_1">
				<div class="title">标题</div>
				<div class="content after">
<!--news limit="10"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">标题</div>
				<div class="content after">
<!--news show_image="1" cat_id="5" limit="4" template="picture"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">标题</div>
				<div class="content after">
<!--news show_image="1" cat_id="4" limit="4" template="picture"-->
				</div>
			</div>
		</div>
		<div class="fr">
			<div class="box box_2">
				<div class="title"><span class="bar">当前位置： <a href="<!--web_url-->"><!--web_title--></a> <!--catalog_txt--> - 正文<input type="hidden" id="news_id" value="<!--record_news_id-->"></span></div>
				<div class="content after">
					<div class="main">
						<div>
							<h1><!--record_subject--></h1>
							<h3>来源：<!--record_original--> &nbsp; | &nbsp; 时间：<!--record_add_date--></h3>
						</div>
						<div style="text-align:center;">
							<select id="page_sel" onchange="location.href=this.value"></select>
						</div>
						<div id="content">
<img src="<!--record_image-->" class="title_img" />
<!--record_content-->
						</div>
						<div class="bottom">
							上一篇文章：<a href="<!--article_prev_link-->" target="_top"><!--article_prev_text--></a><br />
							下一篇文章：<a href="<!--article_next_link-->" target="_top"><!--article_next_text--></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script language="javascript">
$(function() {
	var subPage = <!--sub_page-->;
	if(subPage.length>0) {
		var obj_select = $id("page_sel");
		var curIndex = 0;
		var selIndex = 0;
		for(var i=0; i<subPage.length; i++) {
			curIndex = obj_select.options.length;
			obj_select.options[curIndex] = new Option(subPage[i]['txt'], subPage[i]['url']);
			if(subPage[i]['selected']=='selected') selIndex = curIndex;
		}
		obj_select.selectedIndex = selIndex;
	} else {
		$("#page_sel").parent().remove();
	}
});
</script>