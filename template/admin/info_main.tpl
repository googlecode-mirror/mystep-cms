<div class="title">��վ������Ϣ</div>
<div id="info">&nbsp;</div>
<div>
	<table id="list_area" width="900" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td class="cat" width="120">��վ����汾</td>
			<td class="row">
				V<?=$ms_version['ver']?> ��<?=$ms_version['language']?>/<?=$ms_version['charset']?>/<?=$ms_version['date']?>��
				<a href="###" onclick="confirm('��ѡ��У�鷽ʽ��\n\n����У�飺ͨ���������ɵ�У����ϢУ����վ�ļ�\n\n����У�飺ͨ�����·������ϵ�У���ļ�У��', 'checkModify', ['����У��','����У��'], '�ļ�У��')">����ļ��Ķ�</a>
				 |
				<a href="###" onclick="confirm('����У����Ϣ������Զ�����ʱ���ѸĶ��ļ����󸲸ǣ�\n&nbsp;\n�Ƿ������', 'updateModify', ['ȷ ��','ȡ ��'], '���±���У��')">���±���У��</a>
				<span style="display:<?=(file_exists("../update/")?"inline":"none")?>">
					 |
					<a href="###" onclick="emptyUpdate()">���������Ϣ</a>
					 |
					<a href="###" onclick="exportUpdate()">����������Ϣ</a>
					 |
					<a href="/_maker/log.txt" target="_blank">�鿴���ؼ�¼</a>
				</span>
			</td>
		</tr>
		<tr>
			<td class="cat">��վ����ʱ��</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat">ע���Ա��</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."users")?> ��</td>
		</tr>
		<tr>
			<td class="cat">��¼��������</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."news_show")?> ��</td>
		</tr>
		<tr>
			<td class="cat">��ǰ��������</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."user_online")?> ��</td>
		</tr>
		<tr>
			<td class="cat">�����������</td>
			<td class="row"><?=$db->GetSingleResult("select max(online) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat">����ҳ�������</td>
			<td class="row"><?=$db->GetSingleResult("select pv from ".$setting['db']['pre']."counter where date=curdate()")?> ��</td>
		</tr>
		<tr>
			<td class="cat">�����ҳ�������</td>
			<td class="row"><?=$db->GetSingleResult("select max(pv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat">��վҳ���վ�������</td>
			<td class="row"><?=(int)$db->GetSingleResult("select avg(pv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat">��վҳ���ܷ�����</td>
			<td class="row"><?=$db->GetSingleResult("select sum(pv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat">���� IP ������</td>
			<td class="row"><?=$db->GetSingleResult("select iv from ".$setting['db']['pre']."counter where date=curdate()")?> ��</td>
		</tr>
		<tr>
			<td class="cat">����� IP ������</td>
			<td class="row"><?=$db->GetSingleResult("select max(iv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat">��վ�վ� IP ������</td>
			<td class="row"><?=(int)$db->GetSingleResult("select avg(iv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat">��վ�� IP ������</td>
			<td class="row"><?=$db->GetSingleResult("select sum(iv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
	</table>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
var cur_ver = <?=toJson($ms_version, $setting['gen']['charset']);?>;
var update_info = null;
function checkUpdate() {
	if(update_info==null) {
		alert("ϵͳ��ǰ�汾��Ϊ���£�������£�");
		return;
	}
	var result = "";
	result += '\
<div align="center">\
	<span style="font-weight:bold;font-size:16px;">��������</span><br /><br />\
</div>\
<hr />\
';
	try {
		for(var ver in update_info) {
			result += '\
<div>\
	<div style="font-weight:bold;">Version: '+ver+'</div>\
	<div>'+update_info[ver].info.replace(/[\r\n]+/g, "<br />")+'</div>\
	<div>&nbsp;</div>\
	<div><a href="###" onclick="showFiles($(this).next())">[�鿴�����ļ�]</a><div style="display:none;">'+update_info[ver].file.join("<br />")+'</div></div>\
</div>\
<hr />\
';
		}
		confirm(result, "applyUpdate", [" ���ظ��� ", " �Զ����� "], "ϵͳ����", false);
	} catch(e) {
		alert("��ȡ���·�������Ϣ������ˢ�����ԣ�");
	}
}
function showFiles(obj) {
	var theObj=$("#popupLayer_info_show_content").find(".info");
	if(theObj.css("overflow-y")!="scroll") {
		if(obj.is(":visible")) {
			theObj.css({"height":"auto","width":theObj.width()+10});
		} else {
			theObj.css({"height":theObj.height()+20,"width":theObj.width()-10});
		}
	}
	obj.toggle();
}
function applyUpdate(mode) {
	loadingShow("ϵͳ���ڻ�ȡ���£������ĵȴ���");
	mode = (mode==1?"update":"download");
	$.get("update.php?"+mode, function(info){
		loadingShow();
		try {
			alert_org(info.info);
			if(info.link.length>2) {
				window.open(info.link);
			}
			window.top.location.reload();
		} catch(e) {
			alert("���»�ȡʧ�ܣ�����������ã�");
		}
	}, "json");
}
function emptyUpdate() {
	$.get("update.php?empty", function(info){
		if(info.length==0) {
			alert("������������գ�");
		} else {
			alert(info);
		}
	});
}
function checkModify(mode) {
	loadingShow("���ڼ��ϵͳ�ļ��ı���������ȴ���");
	var url = "update.php?check_server";
	if(mode==0) url = "update.php?check";
	$.get(url, function(info){
		loadingShow();
		if(info==false) {
			if(mode==0) {
				alert("У��ʧ�ܣ���ȷ��У����Ϣ�Ƿ��ѳɹ�������");
			} else {
				alert("����������ʧ�ܣ��򲻴��ڱ���վ��Ӧ�ַ�����У����Ϣ");
			}
		} else {
			var result = "";
			if(info['new']!=null) {
				result += "<b>���� " + info['new'].length + " �������ļ���</b>\n";
				result += info['new'].join("\n");
				result += "\n&nbsp;\n";
			}
			if(info['mod']!=null) {
				result += "<b>���� " + info['mod'].length + " ���ļ������ı䣺</b>\n";
				result += info['mod'].join("\n");
				result += "\n&nbsp;\n";
			}
			if(info['miss']!=null) {
				result += "<b>���� " + info['miss'].length + " ���ļ���ɾ����</b>\n";
				result += info['miss'].join("\n");
				result += "\n&nbsp;\n";
			}
		}
		if(result.length==0) {
			alert("δ���ָı���ļ���");
		} else {
			alert(result, true);
		}
	}, "json");
}
function updateModify(mode) {
	if(mode==1) return;
	loadingShow("���ڸ���ϵͳ�ļ�У����Ϣ����ȴ���");
	$.get("update.php?build", function(info){
		loadingShow();
		if(info.length==0) {
			alert("�ѳɹ����µ�ǰϵͳ�ļ�У����Ϣ��");
		} else {
			alert("У����Ϣ����ʧ�ܣ�");
		}
	});
}
function exportUpdate() {
	window.open("update.php?export");
}
$(function(){
	$.get("update.php?"+Math.random(), function(ver_info){
		if(ver_info==null) return;
		$('<a href="###" onclick="checkUpdate()">ϵͳ���°汾�ɸ��£���������Ӳ鿴���飡</a>').appendTo("#info");
		$("#info").css({'text-align':'center','padding':'10px','font-size':'18px','font-weight':'bold'});
		update_info = ver_info;
	}, "json");
});
//]]> 
</script>
