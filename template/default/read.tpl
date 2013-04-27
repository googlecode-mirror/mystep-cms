		<div class="page_lst after">
		<div class="fl">
			<div class="box box_1">
				<div class="title">最新文章</div>
				<div class="content after">
<!--news limit="9"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">图片文章</div>
				<div class="content after">
<!--news cat_id='$cat_id' show_image="1" limit="4" template="picture"-->
				</div>
			</div>
		</div>
		<div class="fr">
			<div class="box box_2">
				<div class="title"><span class="bar">当前位置： <a href="<!--web_url-->"><!--web_title--></a> <!--catalog_txt--> - 正文<input type="hidden" id="news_id" value="<!--record_news_id-->"></span></div>
				<div class="content after">
					<div class="main" style="min-height:700px;">
						<div>
							<h1><!--record_subject--></h1>
							<h3>来源：<!--record_original--> &nbsp; | &nbsp; 时间：<!--record_add_date--> &nbsp; | &nbsp; 浏览：<!--record_views--></h3>
						</div>
						<div class="page after">
							<select id="page_sel" style="display:none;" onchange="location.href=this.value"></select>
						</div>
						<div id="content">
<img src="<!--record_image-->" class="title_img" />
<!--record_content-->
							<div class="notice"><!--record_notice--></div>
						</div>
						<div class="page after"><!--page_list--><br /><br /><a href="<!--link_all-->">显示全部内容</a></div>
						<div>
							<div style="float:left;">
								<!--news_jump news_id='$news_id' cat_id='$cat_id'-->
							</div>
							<div style="float:right;">
								<!--news_rank news_id='$news_id' cat_id='$cat_id'-->
							</div>
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
<script language="JavaScript" type="text/javascript">
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
		obj_select.style.display = "";
	} else {
		$(".page").remove();
	}
	$("#content").after('<div id="showImage"></div>');
	$("#content").showImage({"img_width":120,"img_height":80,"ole_id":"showImage","interval":5,"pos_adjust":1,"remove_org":false,"ole_width":640,"img_show_height":420,"step_adjust":-10});
	$("#content").powerImage();
	if($(".title_img").attr("src").indexOf("dummy")!=-1) $(".title_img").remove();
	if($('.source_code').length>0) {
		$.getScript("script/jquery.codemirror.js", function(){
			$('.source_code').codemirror({
					runmode : true,
					height : 200,
					ext_css : ".CodeMirror{border:1px #ccc solid;}"
				});
		});
	}
});
</script>