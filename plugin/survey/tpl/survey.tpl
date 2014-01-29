	<div class="page_bar after">
		<div class="fl page_list">
			<div class="box box_list" style="margin-top:0px;">
				<div class="title">今日热门</div>
				<div class="content after">
<!--news_day limit="11" loop="11"-->
				</div>
			</div>
			<div class="box box_list">
				<div class="title">本周热门</div>
				<div class="content after">
<!--news_week limit="11" loop="11"-->
				</div>
			</div>
			<div class="box box_list">
				<div class="title">本月热门</div>
				<div class="content after">
<!--news_month limit="11" loop="11"-->
				</div>
			</div>
		</div>
		<div class="fr page_main">
			<div class="box">
				<div class="title">当前位置： 投票 - <!--record_subject--></div>
				<div class="page after"><!--prefix_list--></div>
				<div class="content">
					<div class="main">
						<div>
							<h1><!--record_subject--></h1>
							<h3>共有 <!--record_times--> 人参与投票 &nbsp; | &nbsp; 限选 <!--record_max_select--> 项 &nbsp; | &nbsp; 时间：<!--record_add_date--> &nbsp; | &nbsp; 过期：<!--record_expire--></h3>
						</div>
						<div align="center"><a href="module.php?m=survey&id=1&show" target="_blank"><img id="chart" src="module.php?m=survey&id=1&show" width="200" /></a></div>
						<div id="content"><!--record_describe--></div>
						<div class="reset">
<!--survey id='$survey_id' order="catalog desc"-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script language="JavaScript">
$("#chart").hover(
	function(){this.width = "500";},
	function(){this.width = "200";}
);
</script>
