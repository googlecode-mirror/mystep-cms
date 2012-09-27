	<div class="page_lst after">
		<div class="fl">
			<div class="box box_1">
				<div class="title">子 栏 目</div>
				<div class="menu after">
<!--menu web_id='$web_id' cat_id='$cat_id' deep="2" class="catList"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">本月热贴</div>
				<div class="content after">
<!--news_month web_id='$web_id' limit="9"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">好评推荐</div>
				<div class="content after">
<!--news_mark web_id='$web_id' limit="9"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">图片新闻</div>
				<div class="content after">
<!--news show_image="1" limit="4" template="picture"-->
				</div>
			</div>
		</div>
		<div class="fr">
			<div class="box box_2">
				<div class="title"><span class="bar">当前位置： <a href="<!--web_url-->"><!--title--></a> <!--catalog_txt--> - 文章检索 - <!--keyword--></div>
				<div class="content after">
					<div class="main">
<!--news limit='$limit' show_date="1" show_catalog="1" condition='$condition' loop='30' no_expire="y"-->
					</div>
				</div>
				<div class="page after"><!--page_list--></div>
			</div>
		</div>
	</div>
