$(function(){
	commentQuery();
});

function commentQuery(page) {
	$.ajax({
		type: "get",
		dataType: "json",
		url: commentFile,
		beforeSend: function(XMLHttpRequest){
			$("#comment .loading").show();
		},
		success: function(data, textStatus){
			commentData = data;
			comment_page_count = Math.ceil(commentData.length/comment_page_size);
			$id("comment_count").innerHTML = commentData.length;
			commentShow(page);
		},
		complete: function(XMLHttpRequest, textStatus){
			if(textStatus!="error") $("#comment .loading").hide();
		},
		error: function(){
			$("#comment .loading").html(language.plugin_comment_empty);
		}
	});
}

function commentShow(page) {
	if(page==null) page = comment_page_current;
	if(page=="last") page = comment_page_count;
	comment_page_current = page;
	$('#comment').empty();
	var tpl = $id("comment_tpl").innerHTML;
	var cur_comment = "";
	if(comment_page_size==0) comment_page_size = commentData.length;
	for(var i=(page-1)*comment_page_size, m=page*comment_page_size; i<m; i++) {
		if(i>=commentData.length) break;
		if(commentData[i].user_name.length==0) commentData[i].user_name = commentData[i].ip;
		cur_comment = tpl;
		cur_comment = cur_comment.replace(/\[comment_no\]/g, i+1);
		cur_comment = cur_comment.replace(/\[comment_id\]/g, commentData[i].id);
		cur_comment = cur_comment.replace(/\[comment_user_name\]/g, commentData[i].user_name);
		cur_comment = cur_comment.replace("[comment_add_date]", commentData[i].add_date);
		cur_comment = cur_comment.replace("[comment_quote]", commentData[i].quote_txt);
		cur_comment = cur_comment.replace("[comment_comment]", commentData[i].comment);
		cur_comment = cur_comment.replace("[comment_agree]", commentData[i].agree);
		cur_comment = cur_comment.replace("[comment_oppose]", commentData[i].oppose);
		cur_comment = cur_comment.replace("[comment_report]", commentData[i].report);
		$("<div>").addClass("item").html(cur_comment).appendTo($('#comment'));
	}
	commentPageList(page);
}

function commentPost() {
	var content = $id("comment_text").value;
	content = content.replace(/\r/g, "");
	content = content.replace(/([^\-])\1{3,}/g, "$1$1");
	content = content.replace(/([^\-]{2})\1{3,}/g, "$1$1");
	if(content.length<=6) {
		alert(language.plugin_comment_error_content_1);
		return;
	}
	if(content.length>=300) {
		alert(language.plugin_comment_error_content_2);
		return;
	}
	if(document.form_comment.vcode.value.length==0 || document.form_comment.vcode.value==document.form_comment.vcode.defaultValue) {
		alert(language.plugin_comment_error_novcode);
		document.form_comment.vcode.value='';
		document.form_comment.vcode.style.color='#000000';
		document.form_comment.vcode.focus();
		return;
	}
	loadingShow();
	$id("comment_text").value = content;
	var theData = arr2json($("#form_comment").serializeArray());
	$.post("ajax.php?func=comment_post&return=json", theData, function(data){
		alert(data.info);
		if(data.done) {
			document.form_comment.quote.value = "";
			$id("comment_quote").innerHTML = "";
			$id("comment_text").value = "";
			$("#comment .loading").remove();
			commentQuery('last');
			gotoAnchor("bottom");
		}
		document.form_comment.vcode.value=document.form_comment.vcode.defaultValue;
		document.form_comment.vcode.style.color='#aaaaaa';
		loadingShow();
	}, "json");
	document.form_comment.vcode.blur();
}

function commentQuote(the_no, the_user) {
	var obj = $id("comment_quote");
	if(the_no==null) {
		$(obj).hide();
		$id("quote_no").value='';
	} else {
		var result = "";
		result += "	<div><b>"+printf(language.plugin_comment_quote_js, the_no, the_user)+"</b> [<a href=\"###\" onclick=\"return commentQuote();\">"+language.plugin_comment_close_quote+"</a>]</div>\n";
		result += "	<pre>"+$id("comment_" + the_no).innerHTML+"</pre>\n";
		obj.innerHTML= result;
		$(obj).show();
		$id("quote_no").value = the_no;
		gotoAnchor("news_comment");
	}
	return false;
}

function commentReport(id, type) {
	loadingShow();
	$.post("ajax.php?func=comment_report&return=json", "comment_id="+id+"&type="+type, function(data){
		alert(data.info);
		commentQuery();
		loadingShow();
	}, "json");
	return false;
}

function commentPageList(page, show) {
	if(page==null) page = 1;
	if(show==null) show = 6;
	var page_size = comment_page_size;
	if(page_size==0) return;
	var page_count = comment_page_count;
	if(page_count<=1) return;
	var page_start = 0;
	var page_end = page_count;
	var page_more_start = '';
	var page_more_end = '';
	
	if(page_count<=show+2) {
		if(page_count>1) {
			page_start = 2;
			page_end = page_count;
		}
	} else if(page<show) {
		page_start = 2;
		page_end = show + 1;
		page_more_end = '<i>&#8230;</i> ';
	} else if(page+show>page_count) {
		page_start = page_count - show;
		page_end = page_count;
		page_more_start = '<i>&#8230;</i> ';
	} else {
		page_start = page - show/2;
		page_end = page + show/2 + 1;
		page_more_start = '<i>&#8230;</i> ';
		page_more_end = '<i>&#8230;</i> ';
	}

	var list = "";
	if(page==1) {
		list += '<em>'+language.link_prev+'</em> ';
	} else {
		list += '<a href="###" onclick="commentShow('+(page-1)+')">'+language.link_prev+'</a> ';
	}
	list += (page==1 ? '<strong>1</strong> ' : '<a href="###" onclick="commentShow(1)">1</a> ');
	list += page_more_start;
	
	for(var i=page_start; i<page_end; i++) {
		if(page==i) {
			list += '<strong>'+i+'</strong> ';
		} else {
			list += '<a href="###" onclick="commentShow('+i+')">'+i+'</a> ';
		}
	}
	
	list += page_more_end;
	list += (page==page_count ? '<strong>'+page_count+'</strong> ' : '<a href="###" onclick="commentShow('+page_count+')">'+page_count+'</a> ');
	if(page==page_count) {
		list += '<em>'+language.link_next+'</em> ';
	} else {
		list += '<a href="###" onclick="commentShow('+(page+1)+')">'+language.link_next+'</a> ';
	}
	$id("comment_page_list").innerHTML = list;
	return;
}
