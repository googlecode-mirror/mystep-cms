<FORM name="form_vote_<!--id-->" action="" method="post" onsubmit="return false;">
	<ul class="vote">
<!--loop:start-->
		<li style="background-image:url();list-style:none;">
			<input id="vote_<!--vote_id-->_<!--vote_idx-->" type="<!--vote_type-->" name="vote" value="<!--vote_idx-->" />
			<label for="vote_<!--vote_id-->_<!--vote_idx-->"><!--vote_title--></label>
		</li>
<!--loop:end-->
	</ul>
	<div style="text-align:center;margin-top:10px;">
		<input type="hidden" name="id" value="<!--id-->">
		<input type="hidden" name="max_select" value="<!--max_select-->">
		<input type="button" value=" ͶƱ " onclick="voteIt(<!--id-->, this);">
		<input type="button" value=" �鿴 " onclick="window.open('module.php?m=survey&id=<!--id-->');">
		<input type="reset" value=" ��λ ">
	</div>
</FORM>
