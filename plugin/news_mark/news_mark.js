$(function(){
	$("#rank_bar dl").each(function(index, domEle) {
		$(domEle).bind('mouseover', function(){
			$("#rank_bar dt:gt("+index+")").css("background-position", "0 0");
			$("#rank_bar dt:lt("+(index+1)+")").css("background-position", "0 -30px");
		});
		$(domEle).bind('mouseout', function(){
			$("#rank_bar dt").css("background-position", "0 0");
		});
		$(domEle).bind('click', function(){
			var theData = arr2json($(this).parent().find("form").serializeArray());
			var theTime = $.cookie("rank_"+theData.web_id+"_"+theData.news_id);
			if(theTime!=null) {
				theTime = new Date(theTime*1000);
				alert(printf(language.plugin_news_mark_rank_done, theTime.format("YYYY-MM-dd hh:mm:ss")));
				return;
			}
			loadingShow();
			theData.value = $(domEle).text();
			var theObj = $(this).parent().children(".cur_rank");
			$.post("ajax.php?func=rank&return=json", theData, function(data){
				$.cookie("rank_"+theData.web_id+"_"+theData.news_id, data.rank_time, {expires:1});
			  var rank_min = $("#rank_bar dl").first().text();
			  var rank_max = $("#rank_bar dl").last().text();
			  var average = Math.ceil((data.rank_total/data.rank_times-rank_min+1)*100/(rank_max-rank_min+1));
				theObj.css("width", average+"%");
				theObj.parent().children("dl").attr("title", language.plugin_news_mark_rank_average + " " + (Math.round(data.rank_total/data.rank_times*100)/100));
				alert(language.plugin_news_mark_rank_ok);
				loadingShow();
			}, 'json');
		});
	});
	$("#rank_bar").bind('mouseover mouseout', function(){
		$("#rank_bar .cur_rank").toggle();
	});
	$("#jump_bar .t A").bind("click", function(){
		var theData = arr2json($(this).parent().parent().find("form").serializeArray());
		var theTime = $.cookie("jump_"+theData.web_id+"_"+theData.news_id);
		if(theTime!=null) {
			theTime = new Date(theTime*1000);
			alert(printf(language.plugin_news_mark_jump_done, theTime.format("YYYY-MM-dd hh:mm:ss")));
			return;
		}
		loadingShow();
		theData.type = "down";
		var theObj = $(this).parentsUntil("#jump_bar").parent().children(".l");
		$.post("ajax.php?func=jump&return=json", theData, function(data){
			$.cookie("jump_"+theData.web_id+"_"+theData.news_id, data.jump_time, {expires:1});
			var theValue = data.jump;
		  theObj.text(theValue);
			alert(language.plugin_news_mark_jump_ok);
			loadingShow();
		}, "json");
		return false;
	});
	$("#jump_bar .b A").bind("click", function(){
		var theData = arr2json($(this).parent().parent().find("form").serializeArray());
		var theTime = $.cookie("jump_"+theData.web_id+"_"+theData.news_id);
		if(theTime!=null) {
			theTime = new Date(theTime*1000);
			alert(printf(language.plugin_news_mark_jump_done, theTime.format("YYYY-MM-dd hh:mm:ss")));
			return;
		}
		loadingShow();
		theData.type = "up";
		var theObj = $(this).parentsUntil("#jump_bar").parent().children(".l");
		$.post("ajax.php?func=jump&return=json", theData, function(data){
			$.cookie("jump_"+theData.web_id+"_"+theData.news_id, data.jump_time, {expires:1});
			var theValue = data.jump;
		  theObj.text(theValue);
			alert(language.plugin_news_mark_jump_ok);
			loadingShow();
		}, "json");
		return false;
	});
});
