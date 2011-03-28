	<div class="page_lst after">
		<div class="fl">
			<div class="box box_1">
				<div class="title">最新文章</div>
				<div class="content after">
<!--news limit="10"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">本月热贴</div>
				<div class="content after">
<!--news_month limit="10"-->
				</div>
			</div>
			<div class="box box_1">
				<div class="title">好评推荐</div>
				<div class="content after">
<!--news_mark limit="10"-->
				</div>
			</div>
		</div>
		<div class="fr">
			<div class="box box_2">
				<div class="title"><span class="bar">当前位置： <a href="<!--web_url-->"><!--title--></a> - 文章标签 - <!--tag--></span></div>
				<div class="taglist">
					<h4>热门标签</h4>
					<div>
<!--tag limit="30" order="id desc"-->
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
