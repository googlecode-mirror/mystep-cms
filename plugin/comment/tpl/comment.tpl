<a name="news_comment"></a>
<div class="box">
	<div class="title">�������� ���� <b id="comment_count">0</b> ����</div>
	<div class="content">
		<div id="comment_quote"></div>
		<div class="after">
			<form name="form_comment" id="form_comment" method="post" onsubmit="return false;">
				<div class="l">
					<input type="hidden" name="news_id" value="<!--news_id-->" />
					<input type="hidden" name="web_id" value="<!--web_id-->" />
					<input type="hidden" name="quote" id="quote_no" value="0" />
					<textarea name="comment" id="comment_text"></textarea>
				</div>
				<div class="r">
					<img id="vcode_img" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()" alt="���ͼƬ������֤��" height="40" /><br />
					<input type="text" name="vcode" size="10" value="������������֤��" onclick="vcode_click(this)" onblur="vcode_blur(this)" /><br />
					<button onclick="commentPost();">��������</button>
				</div>
			</form>
		</div>		
	</div>
	<div class="page after">������������ֻ������˹۵㣬��������վ��</div>
	<div id="comment">
		<div class="loading"><img src="images/loading.gif" alt="���ڶ�ȡ��ǰ�������ۣ�"><br / >���ڶ�ȡ��ǰ�������ۣ�</div>
	</div>
	<div class="page after" id="comment_page_list"></div>
	<div id="comment_tpl">
		<div class="info after"><span><b>�� [comment_no] ¥</b> - [comment_user_name] ������ [comment_add_date]</span></div>
		<div class="detail after">
			[comment_quote]
			<pre id="comment_[comment_no]">[comment_comment]</pre>
		</div>
		<div class="func after">
			<a href="###" onclick="return commentQuote('[comment_no]', '[comment_user_name]');">����</a> &nbsp; &nbsp;
			<a href="###" onclick="return commentReport('[comment_id]', 1)">֧��</a> <span>[[comment_agree]]</span> &nbsp; &nbsp;
			<a href="###" onclick="return commentReport('[comment_id]', 2)">����</a> <span>[[comment_oppose]]</span> &nbsp; &nbsp;
			<a href="###" onclick="return commentReport('[comment_id]', 3)">�ٱ�</a> <span>[[comment_report]]</span> &nbsp; &nbsp;
		</div>
	</div>
</div>
<script language="javascript">
var comment_page_current = 1;
var comment_page_size = <!--comment_page_size-->;
var comment_page_count = 1;
var commentFile = "plugin/comment/cache/"+<!--web_id-->+"/"+(Math.ceil(<!--news_id-->/1000)*1000)+"/"+<!--news_id-->+".txt";
var commentData = null;
function vcode_click(obj) {
	obj.value='';
	obj.style.color='#000000';
	$id('vcode_img').src='vcode.php?'+Math.random();
}
function vcode_blur(obj) {
	if(obj.value=="") {
		obj.value=obj.defaultValue;
		obj.style.color='#aaaaaa';
	}
}
</script>
<script language="javascript" src="plugin/comment/comment.js"></script>