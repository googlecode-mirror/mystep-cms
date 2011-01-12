/**************************************************
*                                                 *
* Author  : Windy_sk                              *
* Create  : 2007-12-03                            *
* Email   : windy_sk@126.com                      *
* HomePage: None (Maybe Soon)                     *
* Notice  : U Can Use & Modify it freely,         *
*           BUT PLEASE HOLD THIS ITEM.            *
*                                                 *
**************************************************/

if(typeof(myAjax)=="undefined" && typeof(Ajax)!="undefined") var myAjax = new Ajax();

function markIt(mark, doit) {
	if(mark_ok) return;
	var obj_mark = document.getElementById("rank_mark");
	obj_mark = removeTextNode(obj_mark);
	obj_mark = obj_mark.childNodes;
	for(var i=0; i<obj_mark.length; i++) {
		if(i<mark) {
			obj_mark[i].src = obj_mark[i].src.replace("mark_0", "mark_1");
		} else {
			obj_mark[i].src = obj_mark[i].src.replace("mark_1", "mark_0");
		}
	}
	if(doit) {
		if(loadingJudge()) return;
		var id = document.getElementById("news_id").value;
		//ajax code for mark
		myAjax.init("TEXT", markDone, loadingStart, loadingEnd);
		myAjax.get(web_url+"/ajax.php?job=article_mark", "news_id="+id+"&mark="+mark);
	}
	return;
}

function markDone(mark) {
	if(mark.match(/^\d+$/)) {
		markShow(parseInt(mark));
		mark_ok = true;
	} else if(mark.length!=0) {
		alert(mark);
	}
	return;
}

function markShow(mark) {
	var obj_mark = document.getElementById("rank_info");
	if(mark!=null) mark_total += mark, mark_times++;
	if(mark_times>0) {
		mark = Math.round(mark_total/mark_times);
	} else {
		mark = 0;
	}
	obj_mark.innerHTML = "总分: <font>" + mark_total + "</font> | 平均: <font>" + mark + "</font>";
	markIt(mark);
	return;
}

function jumpIt() {
	if(jump_ok) return;
	if(loadingJudge()) return;
	var id = document.getElementById("news_id").value;
	//ajax code for jump
	myAjax.init("TEXT", jumpDone, loadingStart, loadingEnd);
	myAjax.get(web_url+"/ajax.php?job=article_jump", "news_id="+id);
}

function jumpDone(errMsg) {
	if(errMsg.length!=0) {
		alert(errMsg);
		return;
	}
	var obj_jump = document.getElementById("jump_bar");
	obj_jump = removeTextNode(obj_jump);
	obj_jump = obj_jump.childNodes;
	obj_jump[0].innerHTML = (++jump_times);
	obj_jump[1].innerHTML = "搞定";
	obj_jump[1].style.cursor = "default";
	jump_ok = true;
}

function addquote(the_idx) {
	var obj = document.getElementById("comment_quote");
	var result = "<fieldset>\n";
	result += "	<legend><b>引用 "+the_idx+"楼 发表的评论:</b></legend>\n";
	result += "	<div>"+document.getElementById("comment_" + the_idx).innerHTML+"</div>\n";
	result += "	<div align=\"right\">[<a href=\"###\" onclick=\"document.getElementById('comment_quote').style.display='none';document.form_comment.quote.value='';return false;\">关闭引用</a>]</div>\n";
	result += "	</fieldset>\n";
	obj.style.display = "";
	obj.innerHTML= result;
	document.form_comment.quote.value = the_idx;
	gotoAnchor("post");
	return;
}

function commentPost() {
	if(loadingJudge()) return;
	var content = document.getElementById("comment_text").value;
	content = content.replace(/\r/g, "");
	//content = content.replace(/([^\-]{1,2})\1{3,}/g, "$1$1");
	content = content.replace(/([^\-])\1{3,}/g, "$1$1");
	content = content.replace(/([^\-]{2})\1{3,}/g, "$1$1");
	if(content.length<=6) {
		alert("评论内容过少或重复字符过多！");
		return;
	}
	if(content.length>=300) {
		alert("评论内容过过多，请保持在300个汉字以内！");
		return;
	}
	document.getElementById("comment_text").value = content;
	//ajax code for post comment
	myAjax.init("TEXT", commentDone, loadingStart, loadingEnd);
	myAjax.post_form(web_url+"/ajax.php?job=comment_post", document.getElementById("form_comment"));
	return;
}

function commentDone(errMsg) {
	document.getElementById('vcode_img').src = web_url+"/vcode.php?"+Math.random();
	document.form_comment.vcode.value = "";
	if(errMsg.length!=0) {
		alert(errMsg);
		return;
	}
	document.getElementById("comment_text").value = document.getElementById("comment_text").defaultValue;
	//getComment();
	gotoAnchor("comment");
	location.reload();
	return;
}

function reportIt(e, idx, theType) {
	if(loadingJudge()) return;
	myAjax.init("TEXT", reportDone, loadingStart, loadingEnd);
	myAjax.get(web_url+"/ajax.php?job=comment_report", "comment_id=" + idx + "&type=" + theType);
	var obj = e.srcElement?e.srcElement:e.target;
	if(theType!=3) {
		var val = parseInt(obj.nextSibling.innerHTML.replace(/[^\d]/g, ""));
		obj.nextSibling.innerHTML = "&nbsp; [ " + (val+1) + " ]";
	}
	obj.onclick = new Function("return false");
	return;
}

function reportDone(errMsg) {
	if(errMsg.length!=0) {
		alert(errMsg);
	}
	gotoAnchor("##");
	return;
}

function setFontSize(the_size) {
	var the_obj= document.getElementById("article");
	the_obj.style.fontSize = the_size+"px";
	the_obj.style.lineHeight=(the_size+6)+'px';
	return;
}

function commentPageList(page, page_size, show) {
	if(page==null) page = 1;
	if(page_size==null) page_size = 10;
	if(show==null) show = 6;
	var page_count = Math.ceil(comment_count/page_size);
	var obj_1 = document.getElementById("comment_page_list_1");
	var obj_2 = document.getElementById("comment_page_list_2");
	obj_1.innerHTML = "";
	obj_2.innerHTML = "";
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
		page_more_end = '<i>……</i> ';
	} else if(page+show>page_count) {
		page_start = page_count - show;
		page_end = page_count;
		page_more_start = '<i>……</i> ';
	} else {
		page_start = page - show/2;
		page_end = page + show/2 + 1;
		page_more_start = '<i>……</i> ';
		page_more_end = '<i>……</i> ';
	}

	var list = "";
	if(page==1) {
		list += '<em>上一页</em> ';
	} else {
		list += '<a href="###" onclick="getComment(' + (page-1) + ', ' + page_size + ')">上一页</a> ';
	}
	list += (page==1 ? '<strong>1</strong> ' : '<a href="###" onclick="getComment(1, ' + page_size + ')">1</a> ');
	list += page_more_start;
	
	for(var i=page_start; i<page_end; i++) {
		if(page==i) {
			list += '<strong>' + i + '</strong> ';
		} else {
			list += '<a href="###" onclick="getComment(' + i + ', ' + page_size + ')">' + i + '</a> ';
		}
	}
	
	list += page_more_end;
	list += (page==page_count ? '<strong>'+page_count+'</strong> ' : '<a href="###" onclick="getComment('+page_count+', ' + page_size + ')">'+page_count+'</a> ');
	if(page==page_count) {
		list += '<em>下一页</em> ';
	} else {
		list += '<a href="###" onclick="getComment(' + (page+1) + ', ' + page_size + ')">下一页</a> ';
	}
	obj_1.innerHTML = obj_2.innerHTML = list;
	return;
}

function getComment(page, page_size) {
	if(page==null) page = 1;
	if(page_size==null) page_size = 10;
	//ajax code for get comment
	myAjax.init("TEXT", putComment, loadingStart, loadingEnd);
	myAjax.get(web_url+"/ajax.php?job=comment_show&news_id="+document.getElementById("news_id").value+"&page="+page+"&page_size="+page_size);
	commentPageList(page, page_size);
	return;
}

function putComment(content) {
	if(content.length>50) document.getElementById("comment_list").innerHTML = content;
	return;
}