	<div class="page_bar after">
		<div class="fl page_list">
			<div>
<!--menu web_id='$web_id' cat_id='$menu_cat_id' deep="2" class="catList" all="yes"-->
			</div>
			<div class="box box_list">
				<div class="title">最新更新</div>
				<div class="content">
<!--news limit="12" loop="12"-->
				</div>
			</div>
			<div class="box box_list">
				<div class="title">图片新闻</div>
				<div class="content">
<!--news show_image="1" limit="4" template="picture"-->
				</div>
			</div>
		</div>
		<div class="fr page_main">
			<div class="box">
				<div class="title">当前位置： <a href="<!--web_url-->"><!--title--></a> <!--catalog_txt--> - 列表</div>
				<div class="search after">
					<div>网站检索：</div>
					<div><!--search id="search_form" keyword='$keyword'--></div>
					<div> &nbsp; （常用关键字：<!--keyword limit="3"-->）</div>
				</div>
				<div class="content">
					<div class="main">
<!--news limit='$limit' show_date="1" show_catalog="1" condition='$condition' loop='20'-->
					</div>
				</div>
				<div class="page after"><!--page_list--></div>
			</div>
		</div>
	</div>
