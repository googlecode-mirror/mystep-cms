	<div class="page_bar after">
		<div class="fl page_list">
			<div>
<!--menu web_id='$web_id' cat_id='$menu_cat_id' deep="2" class="catList" all="yes"-->
			</div>
			<div class="box box_list">
				<div class="title">最新更新</div>
				<div class="content">
<!--news limit="10" loop="10"-->
				</div>
			</div>
			<div class="box box_list">
				<div class="title">本月热门</div>
				<div class="content">
<!--news_month web_id='$web_id' limit="10"-->
				</div>
			</div>
		</div>
		<div class="fr page_main">
			<div class="box">
				<div class="title">当前位置： <a href="<!--web_url-->"><!--title--></a> <!--catalog_txt--> - 列表</div>
				<div class="page after"><!--prefix_list--></div>
				<div class="content">
					<div class="main">
<!--news cat_id='$cat_id' limit='$limit' template="mix" show_date="1" condition='$condition'-->
					</div>
				</div>
				<div class="page after"><!--page_list--></div>
			</div>
		</div>
	</div>
