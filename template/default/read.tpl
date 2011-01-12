<link href="images/htc.css" rel="stylesheet" type="text/css" />
	<div class="page_lst after">
		<div class="fl">
			<div class="hslice box_1">
				<div class="entry-title">最新资讯</div>
				<div class="entry-content after">
<!--news limit="10"-->
				</div>
			</div>
			<div class="hslice box_1">
				<div class="entry-title">教练阵容</div>
				<div class="entry-content after">
<!--news show_image="1" cat_id="5" limit="4" template="picture"-->
				</div>
			</div>
			<div class="hslice box_1">
				<div class="entry-title">营员风采</div>
				<div class="entry-content after">
<!--news show_image="1" cat_id="4" limit="4" template="picture"-->
				</div>
			</div>
		</div>
		<div class="fr">
			<div class="hslice box_2">
				<div class="entry-title">
					<div class="c1"><img src="images/default/bar_pic1.png" /></div>
					<div class="c2">当前位置： <a href="<!--web_url-->"><!--web_title--></a> <!--catalog_txt--> - 正文<input type="hidden" id="news_id" value="<!--record_news_id-->"></div>
				</div>
				<div class="entry-content">
					<div class="content after">
						<h1><!--record_subject--></h1>
						<h3><!--record_add_date-->     来源：<!--record_original--></h3>
						<div style="text-align:center; display:<!--page_show-->">
							<select name="page_sel" onchange="location.href=this.value">
<!--loop:start key="page_sel"-->
								<option value="<!--page_sel_url-->" <!--page_sel_selected-->><!--page_sel_txt--></option>
<!--loop:end-->
							</select>
						</div>
						<span id="content">
<!--record_image-->
<!--record_content-->
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>