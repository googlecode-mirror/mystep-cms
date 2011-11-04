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

function voteIt(vote_id, vote_button) {
	//vote_button.disable = true;
	var theForm = document.forms['form_vote_'+vote_id];
	var item_list = $(theForm).find("input[name=vote]").get();
	var vote_count = 0;
	var theList = "";
	var vote_limit = $(theForm).find("input[name=max_select]").get(0).value;
	for(var i=0; i<item_list.length; i++) {
		if(item_list[i].checked) {
			vote_count++;
			theList += "&vote[]=" + item_list[i].value;
		}
		if(vote_limit!=0 && vote_count>vote_limit) {
			alert(printf(language.plugin_survey_info_selection, vote_limit));
			vote_button.disable=false;
			return false;
		}
	}
	if(vote_count==0) {
		alert(language.plugin_survey_info_chooseone);
		vote_button.disable=false;
		return false;
	}
	var theData = "id="+vote_id+theList;
	loadingShow();
	$.post("ajax.php?func=vote&return=json", theData, function(data){
		alert(data.info);
		if(data.done) {
			//location.reload();
			location.href = "module.php?m=survey&id="+vote_id;
		} else {
			vote_button.disable=false;
			theForm.reset();
			loadingShow();
		}
	}, "json");
	return false;
}