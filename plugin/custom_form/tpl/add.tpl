<div class="title"><!--title--></div>
<script type="text/javascript" src="../../script/checkForm.js" Language="JavaScript1.2"></script>
<script type="text/javascript" src="../../script/jquery.date_input.js" language="JavaScript1.2"></script>
<div align="left">
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" colspan="2">������Ϣ</td>
			</tr>
			<tr>
				<td class="cat" width="100">������վ��</td>
				<td class="row">
					<select name="web_id" id="webList">
						<option value="0">���������</option>
						<option value="255">ȫ����վ</option>
<!--loop:start key="website"-->
						<option value="<!--website_web_id-->"><!--website_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">�������ƣ�</td>
				<td class="row">
					<input name="name" type="text" value="" maxlength="60" need="" />
					<input type="hidden" name="mid" value="" />
				</td>
			</tr>
			<tr>
				<td class="cat">Ӣ�����ƣ�</td>
				<td class="row">
					<input name="name_en" type="text" value="" maxlength="100" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat">����ʱ�䣺</td>
				<td class="row">
					<input name="expire" type="text" value="<!--expire-->" maxlength="100" need="date_" />
				</td>
			</tr>
			<tr>
				<td class="cat">��ע��Ϣ��</td>
				<td class="row">
					<input name="notes" type="text" value="" maxlength="150" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table width="100%">
						<tr><td class="cat" colspan="4">����Ŀ &nbsp; [<a href="###" onclick="addItem()">���</a>] &nbsp; [<a href="###" onclick="importItem()">����</a>]</td></tr>
						<tr align="center"><td class="cat" width="100">����</td><td class="cat" width="100">����</td><td class="cat">˵��</td><td class="cat" width="200">����</td></tr>
						<tbody id="item_list"></tbody>
					</table>
					<input type="hidden" id="itemlist" name="itemlist" value="" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table width="100%">
						<tr><td class="cat" colspan="2">ҳ��ģ��</td></tr>
						<tr>
							<td class="cat" width="100">���ı�ҳ�棺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_cf_submit_cn" style="width:100%; height:200px;"><!--tpl_cf_submit_cn--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">Ӣ�ı�ҳ�棺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_cf_submit_en" style="width:100%; height:200px;"><!--tpl_cf_submit_en--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat" width="100">���Ĵ�ӡҳ�棺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_cf_print_cn" style="width:100%; height:200px;"><!--tpl_cf_print_cn--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">Ӣ�Ĵ�ӡҳ�棺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_cf_print_en" style="width:100%; height:200px;"><!--tpl_cf_print_en--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">�����б�ҳ�棺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_cf_list_cn" style="width:100%; height:200px;"><!--tpl_cf_list_cn--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">Ӣ���б�ҳ�棺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_cf_list_en" style="width:100%; height:200px;"><!--tpl_cf_list_en--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">�����б�ģ�飺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_block_cf_list_cn" style="width:100%; height:200px;"><!--tpl_block_cf_list_cn--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">Ӣ���б�ģ�飺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_block_cf_list_en" style="width:100%; height:200px;"><!--tpl_block_cf_list_en--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">�����ʼ�ģ�壺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_mail_cn" style="width:100%; height:200px;"><!--tpl_mail_cn--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">Ӣ���ʼ�ģ�壺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_mail_en" style="width:100%; height:200px;"><!--tpl_mail_en--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">���༭ģ�壺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_edit_data" style="width:100%; height:200px;"><!--tpl_edit_data--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">���б�ģ�壺</td>
							<td class="row">
								<textarea class="source_code" type="php" name="tpl_list_data" style="width:100%; height:200px;"><!--tpl_list_data--></textarea>
							</td>
						</tr>
						<tr>
							<td class="cat">�������</td>
							<td class="row">
								<textarea class="source_code" type="php" name="ext_script" style="width:100%; height:200px;"><!--ext_script--></textarea>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="row">
					<input class="btn" type="Submit" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<style type="text/css">
.item_edit td {padding:0px 5px 10px 5px;}
.item_edit input {width:390px;}
.item_edit select {width:200px;}
</style>
<div id="item_edit" class="popshow">
	<table class="item_edit" cellspacing="0" cellpadding="0">
		<tr>
			<td>��Ŀ������</td>
			<td><input class="item" name="idx" type="text" value="" /><input type="hidden" name="idx_org" value="" /></td>
		</tr>
		<tr>
			<td width="60">�������ͣ�</td>
			<td>
				<select class="item" name="type">
					<option value="text">�����ı�</option>
					<option value="textarea">�����ı�</option>
					<option value="radio">��ѡ</option>
					<option value="checkbox">��ѡ</option>
					<option value="select">����ѡ��</option>
					<option value="file">�����ϴ�</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>ѡ�����ģ�</td>
			<td><textarea class="item" name="value_cn" style="width:100%; height:100px;"></textarea></td>
		</tr>
		<tr>
			<td>ѡ��Ӣ�ģ�</td>
			<td><textarea class="item" name="value_en" style="width:100%; height:100px;"></textarea></td>
		</tr>
		<tr>
			<td>Ĭ��ֵ��</td>
			<td><input class="item" name="default" type="text" value="" /></td>
		</tr>
		<tr>
			<td>Ĭ��Ӣ�ģ�</td>
			<td><input class="item" name="default_en" type="text" value="" /></td>
		</tr>
		<tr>
			<td>���ݸ�ʽ��</td>
			<td>
				<select class="item" name="format">
					<option value="">�����ʽ</option>
					<option value="email">�����ʼ�</option>
					<option value="url">��ַ</option>
					<option value="digital">������</option>
					<option value="number">ʵ��</option>
					<option value="alpha">Ӣ�ļ�����</option>
					<option value="word">�Ϸ�Ӣ�ĵ���</option>
					<option value="name">��Ӣ������</option>
					<option value="date">�Ϸ�����</option>
					<option value="time">�Ϸ�ʱ��</option>
					<option value="tel">�绰����</option>
					<option value="fax">�������</option>
				</select> &nbsp;
				<input name="needed" type="checkbox" style="width:20px;" />������
			</td>
		</tr>
		<tr>
			<td>�������ƣ�</td>
			<td><input class="item" name="length" type="text" value="" /></td>
		</tr>
		<tr>
			<td>�������ƣ�</td>
			<td><input class="item" name="title" type="text" value="" /></td>
		</tr>
		<tr>
			<td>Ӣ�����ƣ�</td>
			<td><input class="item" name="title_en" type="text" value="" /></td>
		</tr>
		<tr>
			<td>����˵����</td>
			<td><input class="item" name="comment" type="text" value="" /></td>
		</tr>
		<tr>
			<td>Ӣ��˵����</td>
			<td><input class="item" name="comment_en" type="text" value="" /></td>
		</tr>
	</table>
	<div style="text-align:center;margin-top:10px;">
		<input type="checkbox" class="item" name="search" /> ���ڼ���
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
		<input type="checkbox" class="item" name="manager" /> ������Ŀ
		<br /><br />
		<input type="hidden" name="item" value="" /><input class="btn" type="button" onClick="confirmItem(this.previousSibling.value)" value=" �� �� " />
	</div>
</div>
<div id="item_import" class="popshow">
	<textarea style="width:96%;height:500px;"></textarea>
	<div style="text-align:center;margin-top:10px;"><input class="btn" type="button" onClick="confirmImport()" value=" �� �� " /></div>
</div>
<script language="JavaScript">
var cf_item=<!--cf_item-->;
$(function(){
	refreshItem();
	$id("itemlist").value = $.toJSON(cf_item);
});
function refreshItem() {
	var ole = $("#item_list");
	var curItem = null;
	ole.empty();
	for(var item in cf_item) {
		curItem = $('<tr id="item_'+item+'"><td class="cat">'+item+'</td><td class="row">'+(cf_item[item].title.length>0?cf_item[item].title:cf_item[item].title_en)+'</td><td class="row">'+(cf_item[item].comment.length>0?cf_item[item].comment:cf_item[item].comment_en)+'</td><td class="row" align="center"><a href="###" onclick="orderItem(\''+item+'\', 1)">����</a> &nbsp; <a href="###" onclick="orderItem(\''+item+'\', 0)">�½�</a> &nbsp; <a href="###" onclick="editItem(\''+item+'\')">�༭</a> &nbsp; <a href="###" onclick="removeItem(\''+item+'\')">ɾ��</a></td></tr>');
		curItem.appendTo(ole);
		curItem = null;
	}
}
function addItem() {
	showPop('addItem','��ӱ���Ŀ','id','item_edit',500);
	$("#popupLayer_addItem_content input[name='item']").val("add");
	return;
}
function importItem() {
	showPop('importItem','�������Ŀ','id','item_import',500);
	$("#popupLayer_importItem_content textarea").val($.toJSON(cf_item));
	return;
}
function confirmImport() {
	$id("itemlist").value = $("#popupLayer_importItem_content textarea").val();
	cf_item = $.secureEvalJSON($("#popupLayer_importItem_content textarea").val());
	refreshItem();
	$.closePopupLayer();
	return;
}
function editItem(item) {
	showPop('editItem','�޸ı���Ŀ','id','item_edit',500);
	$("#popupLayer_editItem input[name='item']").val("edit");
	$("#popupLayer_editItem input[name='idx']").val(item);
	$("#popupLayer_editItem input[name='idx_org']").val(item);
	$("#popupLayer_editItem select[name='type']").val(cf_item[item]['type']);
	if(typeof(cf_item[item]['value'].cn)!="undefined") $("#popupLayer_editItem textarea[name='value_cn']").val(cf_item[item]['value'].cn.join("\n"));
	if(typeof(cf_item[item]['value'].en)!="undefined") $("#popupLayer_editItem textarea[name='value_en']").val(cf_item[item]['value'].en.join("\n"));
	$("#popupLayer_editItem input[name='default']").val(cf_item[item]['default']);
	$("#popupLayer_editItem input[name='default_en']").val(cf_item[item]['default_en']);
	if(cf_item[item]['format']==".") {
		$("#popupLayer_editItem select[name='format']").val("");
	} else if(cf_item[item]['format']=="") {
		$("#popupLayer_editItem select[name='format']").val("");
		$("#popupLayer_editItem input[name='needed']")[0].checked = true;
	} else {
		if(cf_item[item]['format'].indexOf("_")==-1) $("#popupLayer_editItem input[name='needed']")[0].checked = true;
		$("#popupLayer_editItem select[name='format']").val(cf_item[item]['format'].replace("_", ""));
	}
	$("#popupLayer_editItem input[name='length']").val(cf_item[item]['length']);
	$("#popupLayer_editItem input[name='title']").val(cf_item[item]['title']);
	$("#popupLayer_editItem input[name='title_en']").val(cf_item[item]['title_en']);
	$("#popupLayer_editItem input[name='comment']").val(cf_item[item]['comment']);
	$("#popupLayer_editItem input[name='comment_en']").val(cf_item[item]['comment_en']);
	$("#popupLayer_editItem input[name='search']").attr("checked", cf_item[item]['search']=="true");
	$("#popupLayer_editItem input[name='manager']").attr("checked", cf_item[item]['manager']=="true");
	return;
}
function removeItem(item) {
	if(confirm("�Ƿ�ȷ��ɾ����Ŀ��"+item)==false) return;
	delete cf_item[item];
	$("#item_"+item).remove();
	$id("itemlist").value = $.toJSON(cf_item);
	return;
}
function orderItem(item, mode) {
	var pre_item = null;
	var nxt_item = null;
	var new_order = new Object();
	var tmp = null
	for(var i in cf_item) {
		new_order[i] = cf_item[i];
		if(nxt_item!=null) {
			if($.browser.msie) {
				//For a IE BUG
				tmp = copyObj(new_order);
				tmp[nxt_item] = cf_item[nxt_item];
				delete new_order;
				new_order = copyObj(tmp);
				delete tmp;
			} else {
				new_order[nxt_item] = cf_item[nxt_item];
			}
			nxt_item = null;
		}
		if(i==item) {
			if(mode==1 && pre_item!=null) {
				delete new_order[pre_item];
				if($.browser.msie) {
					//For a IE BUG
					tmp = copyObj(new_order);
					tmp[pre_item] = cf_item[pre_item];
					delete new_order;
					new_order = copyObj(tmp);
					delete tmp;
				} else {
					new_order[pre_item] = cf_item[pre_item];
				}
			} else {
				delete new_order[i];
				nxt_item = i;
			}
		}
		pre_item = i;
	}
	cf_item = new_order;
	$id("itemlist").value = $.toJSON(cf_item);
	refreshItem();
	return;
}
function copyObj(obj) {
	var new_obj = new Object();
	for(var i in obj) {
		new_obj[i] = obj[i];
	}
	return new_obj;
}
function confirmItem(mode) {
	switch(mode) {
		case "add":
			var idx = "";
			var new_item = new Object();
			var objs = $("#popupLayer_addItem .item");
			for(var i=0;i<objs.length;i++) {
				switch(objs[i].name) {
					case "idx":
						idx = objs[i].value;
						break;
					case "format":
						new_item['format'] = objs[i].value;
						if($("#popupLayer_addItem input[name='needed']")[0].checked===false) {
							new_item['format'] += "_";
						}
						if(new_item['format']=="_") new_item['format'] = ".";
						break;
					case "value_cn":
						objs[i].value = objs[i].value.replace(/[\r\n]+/g, "\n");
						objs[i].value = objs[i].value.replace(/^[\r\n\s]*/, "");
						objs[i].value = objs[i].value.replace(/[\r\n\s]*$/, "");
						new_item["value"] = new Object();
						new_item["value"].cn = objs[i].value.split("\n");
						break;
					case "value_en":
						objs[i].value = objs[i].value.replace(/[\r\n]+/g, "\n");
						objs[i].value = objs[i].value.replace(/^[\r\n\s]*/, "");
						objs[i].value = objs[i].value.replace(/[\r\n\s]*$/, "");
						new_item["value"].en = objs[i].value.split("\n");
						break;
					case "search":
					case "manager":
						new_item[objs[i].name] = objs[i].checked?"true":"false";
						break;
					default:
						new_item[objs[i].name] = objs[i].value;
						break;
				}
			}
			if(idx=="") return;
			if(new_item["value"].cn.length<2) new_item["value"] = "";
			cf_item[idx] = new_item;
			$('<tr id="item_'+idx+'"><td class="cat">'+idx+'</td><td class="row">'+(cf_item[idx].title.length>0?cf_item[idx].title:cf_item[idx].title_en)+'</td><td class="row">'+(cf_item[idx].comment.length>0?cf_item[idx].comment:cf_item[idx].comment_en)+'</td><td class="row" align="center"><a href="###" onclick="editItem(\''+idx+'\')">�༭</a> &nbsp; <a href="###" onclick="removeItem(\''+idx+'\')">ɾ��</a></td></tr>').appendTo($("#item_list"));
			break;
		case "edit":
			var idx = "";
			var new_item = new Object();
			var objs = $("#popupLayer_editItem .item");
			var idx_org = $("#popupLayer_editItem input[name='idx_org']").val();
			for(var i=0;i<objs.length;i++) {
				switch(objs[i].name) {
					case "idx":
						idx = objs[i].value;
						break;
					case "format":
						new_item['format'] = objs[i].value;
						if($("#popupLayer_editItem input[name='needed']")[0].checked===false) {
							new_item['format'] += "_";
						}
						if(new_item['format']=="_") new_item['format'] = ".";
						break;
					case "value_cn":
						objs[i].value = objs[i].value.replace(/[\r\n]+/g, "\n");
						objs[i].value = objs[i].value.replace(/^[\r\n\s]*/, "");
						objs[i].value = objs[i].value.replace(/[\r\n\s]*$/, "");
						new_item["value"] = new Object();
						new_item["value"].cn = objs[i].value.split("\n");
						break;
					case "value_en":
						objs[i].value = objs[i].value.replace(/[\r\n]+/g, "\n");
						objs[i].value = objs[i].value.replace(/^[\r\n\s]*/, "");
						objs[i].value = objs[i].value.replace(/[\r\n\s]*$/, "");
						new_item["value"].en = objs[i].value.split("\n");
						break;
					case "search":
					case "manager":
						new_item[objs[i].name] = objs[i].checked?"true":"false";
						break;
					default:
						new_item[objs[i].name] = objs[i].value;
						break;
				}
			}
			if(new_item["value"].cn.length<2) new_item["value"] = "";
			if(idx=="") return;
			if(idx!=idx_org) delete cf_item[idx_org];
			cf_item[idx] = new_item;
			$("#item_"+idx_org).replaceWith('<tr id="item_'+idx+'"><td class="cat">'+idx+'</td><td class="row">'+(new_item.title.length>0?new_item.title:new_item.title_en)+'</td><td class="row">'+(new_item.comment.length>0?new_item.comment:new_item.comment_en)+'</td><td class="row" align="center"><a href="###" onclick="editItem(\''+idx+'\')">�༭</a> &nbsp; <a href="###" onclick="removeItem(\''+idx+'\')">ɾ��</a></td></tr>');
			break;
		default:
			return;
	}
	$.closePopupLayer();
	$id("itemlist").value = $.toJSON(cf_item);
	refreshItem();
	return;
}
$.getScript("../../script/jquery.codemirror.js", function(){
	$('.source_code').codemirror({
				lineWrapping: true,
				height: 250
		}, function(){
				if($.codemirror_error) {
					alert("�ű�����ʧ�ܣ�");
				} else {
					$('.source_code').parent(".row").css("padding","0px");
					$('.CodeMirror').css({width:'680px',height:'auto','overflow':"hidden","text-align":"left"});
				}
			});
});
</script>