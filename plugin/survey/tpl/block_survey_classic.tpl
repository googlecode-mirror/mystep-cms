<FORM name="form_vote_<!--id-->" action="" method="post" onsubmit="return false;">
	<ul class="vote">
<!--loop:start-->
		<li style="background-image:url();">
			<input id="vote_<!--vote_id-->_<!--vote_idx-->" type="<!--vote_type-->" name="vote" value="<!--vote_idx-->" />
			<label for="vote_<!--vote_id-->_<!--vote_idx-->">
				<em><!--vote_catalog--></em>
				<a href="<!--vote_url-->" target="_blank"><!--vote_title--></a>
				<i>������ <!--vote_vote--> Ʊ��</i>
			</label>
		</li>
<!--loop:end-->
	</ul>
	<div style="text-align:center;margin-top:20px;">
		<input type="hidden" name="id" value="<!--id-->">
		<input type="hidden" name="max_select" value="<!--max_select-->">
		<input type="button" value=" Ͷ Ʊ " onclick="voteIt(<!--id-->, this);"> &nbsp; &nbsp;
		<input type="reset" value=" �� λ "> &nbsp; &nbsp;
	</div>
</FORM>
