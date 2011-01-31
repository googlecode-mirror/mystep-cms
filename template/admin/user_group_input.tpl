<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td class="cat" width="120">组群名称：</td>
				<td class="row">
					<input name="group_id" type="hidden" value="<!--group_id-->" />
					<input id="group_name" name="group_name" type="text" maxlength="20" value="<!--group_name-->" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat" onclick="$('#power_func').toggle(1000);">管理权限：</td>
				<td class="row">
					<div id="power_func" style="width:500px;">
						<input type="checkbox" onclick="checkAll('power_func')" id="power_func_all" class="cbox" name="power_func[]" value="all" <!--power_func_all_checked--> /><label for="power_func_all"> 全部权限</label> <br />
<!--loop:start key="power_func"-->
						<input type="checkbox" onclick="checkFunc(<!--power_func_key-->);checkStatus('power_func');" id="power_func_<!--power_func_key-->" class="cbox" name="power_func[]" pid="<!--power_func_pid-->" value="<!--power_func_key-->" <!--power_func_checked--> /><label for="power_func_<!--power_func_key-->" /> <!--power_func_value--></label> <br />
<!--loop:end-->
					</div>
				</td>
			</tr>
			<tr> 
				<td class="cat" onclick="$('#power_web').toggle(1000);">网站权限：</td>
				<td class="row">
					<div id="power_web" style="width:500px;">
						<input type="checkbox" onclick="checkAll('power_web');" id="power_web_all" class="cbox" name="power_web[]" value="all" <!--power_web_all_checked--> /><label for="power_web_all"> 全部权限</label> <br />
<!--loop:start key="power_web"-->
						<input type="checkbox" onclick="checkWeb(<!--power_web_web_id-->);checkStatus('power_web');" id="power_web_<!--power_web_web_id-->" class="cbox" name="power_web[]" value="<!--power_web_web_id-->" <!--power_web_checked--> /><label for="power_web_<!--power_web_web_id-->" /> <!--power_web_name--></label> <br />
<!--loop:end-->
					</div>
				</td>
			</tr>
			<tr> 
				<td class="cat" onclick="$('#power_cat').toggle(1000);">栏目权限：</td>
				<td class="row">
					<div id="power_cat" style="width:500px;">
						<input type="checkbox" onclick="checkAll('power_cat')" id="power_cat_all" class="cbox" name="power_cat[]" value="all" <!--power_cat_all_checked--> /><label for="power_cat_all"> 全部权限</label> <br />
<!--loop:start key="power_cat"-->
						<input type="checkbox" onclick="checkCat(<!--power_cat_cat_id-->);checkCat_p(<!--power_cat_cat_id-->, <!--power_cat_cat_main-->);checkStatus('power_cat')" id="power_cat_<!--power_cat_cat_id-->" class="cbox" webid="<!--power_cat_web_id-->" name="power_cat[]" pid="<!--power_cat_cat_main-->" value="<!--power_cat_cat_id-->" <!--power_cat_checked--> /><label for="power_cat_<!--power_cat_cat_id-->" /> <!--power_cat_cat_name--></label> <br />
<!--loop:end-->
					</div>
				</td>
			</tr>
			<tr> 
				<td align="center" colspan="2" class="cat"> 
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script Language="JavaScript1.2">
function checkFunc(pid) {
	var objs = document.getElementsByName("power_func[]");
	var flag = $id("power_func_"+pid).checked;
	for(var i=0; i<objs.length; i++) {
		if(objs[i].getAttribute("pid")==pid) {
			objs[i].checked = flag;
		}
	}
}

function checkWeb(webid) {
	var objs = document.getElementsByName("power_cat[]");
	var flag = $id("power_web_"+webid).checked;
	for(var i=0; i<objs.length; i++) {
		if(objs[i].getAttribute("webid")==webid) {
			objs[i].checked = flag;
		}
	}
	checkStatus('power_cat');
}

function checkCat(catid) {
	var objs = document.getElementsByName("power_cat[]");
	var flag = $id("power_cat_"+catid).checked;
	var subObj = null;
	for(var i=0; i<objs.length; i++) {
		if(objs[i].getAttribute("pid")==catid) {
			objs[i].checked = flag;
			subObj = $("#power_cat input[pid="+objs[i].getAttribute("value")+"]");
			if(subObj.length>0) checkCat(objs[i].getAttribute("value"));
		}
	}
}

function checkCat_p(catid, pid) {
	var objs = document.getElementsByName("power_cat[]");
	var flag = $id("power_cat_"+catid).checked;
	var obj = $("#power_cat input[value="+pid+"]")[0];
	if(flag && pid!=0) {
		obj.checked = true;
		if(obj.getAttribute("pid")!=0) checkCat_p(pid, obj.getAttribute("pid"));
	}
}

function checkAll(checkSet, sign) {
	var objs = document.getElementsByName(checkSet + "[]");
	var flag = $id(checkSet+"_all").checked;
	for(var i=0; i<objs.length; i++) {
		objs[i].checked = flag;
	}
	if(checkSet=='power_web' && sign==undefined) {
		objs = document.getElementsByName("power_cat[]");
		for(var i=0; i<objs.length; i++) {
			if(objs[i].getAttribute("webid")>0) {
				objs[i].checked = flag;
			}
		}
		checkStatus('power_cat');
	}
}

function checkStatus(checkSet) {
	var objs = document.getElementsByName(checkSet + "[]");
	if(objs.length<2) return;
	var curStatus = objs[1].checked;
	var flag = curStatus?1:0;
	for(var i=1; i<objs.length; i++) {
		if(objs[i].checked==curStatus) continue;
		flag = 2;
		break;
	}
	var obj = $id(checkSet+"_all");
	if(flag==2) {
		$id(checkSet+"_all").checked = false;
		$id(checkSet+"_all").indeterminate = true;
	} else {
		$id(checkSet+"_all").checked = (flag==1);
		$id(checkSet+"_all").indeterminate = false;
	}
}

$(function(){
	$id('power_func_all').checked ? checkAll('power_func') : checkStatus('power_func');
	$id('power_cat_all').checked ? checkAll('power_cat') : checkStatus('power_cat');
	$id('power_web_all').checked ? checkAll('power_web', false) : checkStatus('power_web');
});
</script>
