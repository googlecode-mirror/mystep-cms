	<div class="page_bar after">
		<div class="fl page_list">
			<div class="box box_list" style="margin-top:0px;">
				<div class="title">��������</div>
				<div class="content after">
<!--news_day limit="11" loop="11"-->
				</div>
			</div>
			<div class="box box_list">
				<div class="title">��������</div>
				<div class="content after">
<!--news_week limit="11" loop="11"-->
				</div>
			</div>
			<div class="box box_list">
				<div class="title">��������</div>
				<div class="content after">
<!--news_month limit="11" loop="11"-->
				</div>
			</div>
		</div>
		<div class="fr page_main">
			<div class="box">
				<div class="title">��ǰλ�ã� ͶƱ - <!--record_subject--></div>
				<div class="page after"><!--prefix_list--></div>
				<div class="content">
					<div class="main">
						<div>
							<h1><!--record_subject--></h1>
							<h3>���� <!--record_times--> �˲���ͶƱ &nbsp; | &nbsp; ��ѡ <!--record_max_select--> �� &nbsp; | &nbsp; ʱ�䣺<!--record_add_date--> &nbsp; | &nbsp; ���ڣ�<!--record_expire--></h3>
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
