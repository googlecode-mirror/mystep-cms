	<div class="page_lst after">
		<div class="fl">
			<div class="box box_1">
				<div class="title">��������</div>
				<div class="content after">
<!--news limit="10"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">ͼƬ����</div>
				<div class="content after">
<!--news cat_id='$cat_id' show_image="1" limit="4" template="picture"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">��������</div>
				<div class="content after">
<!--news_month cat_id='$cat_id' limit="10"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">�����Ƽ�</div>
				<div class="content after">
<!--news_mark cat_id='$cat_id' limit="10"-->
				</div>
			</div>
		</div>
		<div class="fr">
			<div class="box box_2">
				<div class="title"><span class="bar">��ǰλ�ã� <a href="<!--web_url-->"><!--web_title--></a> <!--catalog_txt--> - ����<input type="hidden" id="news_id" value="<!--record_news_id-->"></span></div>
				<div class="content after">
					<div class="main">
						<div>
							<h1><!--record_subject--></h1>
							<h3>��Դ��<!--record_original--> &nbsp; | &nbsp; ʱ�䣺<!--record_add_date--> &nbsp; | &nbsp; �����<!--record_views--></h3>
						</div>
						<div style="text-align:center;">
							<select id="page_sel" style="display:none;" onchange="location.href=this.value"></select>
						</div>
						<div id="content">
<img src="<!--record_image-->" class="title_img" />
<!--record_content-->
						</div>
						<div class="page after"><!--page_list--></div>
						<div>
							<div style="float:left;">
								<!--news_jump news_id='$news_id' cat_id='$cat_id'-->
							</div>
							<div style="float:right;">
								<!--news_rank news_id='$news_id' cat_id='$cat_id'-->
							</div>
						</div>
						
						<div class="bottom">
							��һƪ���£�<a href="<!--article_prev_link-->" target="_top"><!--article_prev_text--></a><br />
							��һƪ���£�<a href="<!--article_next_link-->" target="_top"><!--article_next_text--></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
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
		$("#page_sel").parent().remove();
	}
});
//]]> 
</script>