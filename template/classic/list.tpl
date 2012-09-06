	<div class="page_bar after">
		<div class="fl page_list">
			<div class="box box_list" style="margin-top:0px;">
				<div class="title">今日热门</div>
				<div class="content after">
<!--news_day web_id='$web_id' limit="11" loop="11"-->
				</div>
			</div>
			<div class="box box_list">
				<div class="title">本周热门</div>
				<div class="content after">
<!--news_week web_id='$web_id' limit="11" loop="11"-->
				</div>
			</div>
			<div class="box box_list">
				<div class="title">本月热门</div>
				<div class="content after">
<!--news_month web_id='$web_id' limit="11" loop="11"-->
				</div>
			</div>
		</div>
		<div class="fl page_main" style="width:560px; margin-left:10px;">
			<div class="box">
				<div class="title">当前位置： <a href="<!--web_url-->"><!--title--></a> <!--catalog_txt--> - 列表</div>
				<div class="page after"><!--prefix_list--></div>
				<div class="content" style="min-height:880px;">
					<div>
<!--news cat_id='$cat_id' limit="1" template="mix" show_image="1"-->
<!--news cat_id='$cat_id' limit='$limit' show_date="1" show_catalog="1" condition='$condition' loop='20'-->
					</div>
				</div>
				<div class="page after"><!--page_list--></div>
			</div>
		</div>
		<div class="fr page_list">
			<div class="box box_list" style="margin-top:0px;">
				<div class="title">图片新闻</div>
				<div class="content">
<!--news show_image="1" limit="2,6" template="picture"-->
				</div>
			</div>
		</div>
	</div>
