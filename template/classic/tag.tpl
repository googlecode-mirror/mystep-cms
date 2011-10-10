	<div class="page_bar after">
		<div class="fl page_list">
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
				<div class="taglist">
					<h4>热门标签</h4>
					<div>
<!--tag limit="50" order="id desc"-->
					</div>
				</div>
				<div class="content after">
					<div class="main">
<!--news tag='$tag' limit='$limit' show_date="1" show_catalog="1"-->
					</div>
				</div>
				<div class="page after"><!--page_list--></div>
			</div>
		</div>
	</div>
