<div class="title">��վ������Ϣ</div>
<div>&nbsp;</div>
<div>
	<table width="900" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td class="cat" width="250">��վ����汾</td>
			<td class="row">
				V<?=$ms_version['ver']?> ��<?=$ms_version['language']?>/<?=$ms_version['charset']?>/<?=$ms_version['date']?>��
				<a href="###" onclick="checkUpdate()">�������</a>
				<a href="###" onclick="checkModify()">����ļ��Ķ�</a>
				<a href="###" onclick="updateModify()">�����ļ�У��</a>
<!--
				 |
				<a href="###" onclick="emptyUpdate()">���������Ϣ</a>
				 |
				<a href="###" onclick="exportUpdate()">����������Ϣ</a>
-->
			</td>
		</tr>
		<tr>
			<td class="cat" width="250">��վ����ʱ��</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">ע���Ա��</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."users")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">��¼��������</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."news_show")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">��ǰ��������</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."user_online")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">�����������</td>
			<td class="row"><?=$db->GetSingleResult("select max(online) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">����ҳ�������</td>
			<td class="row"><?=$db->GetSingleResult("select pv from ".$setting['db']['pre']."counter where date=curdate()")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">�����ҳ�������</td>
			<td class="row"><?=$db->GetSingleResult("select max(pv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">��վҳ���վ�������</td>
			<td class="row"><?=(int)$db->GetSingleResult("select avg(pv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">��վҳ���ܷ�����</td>
			<td class="row"><?=$db->GetSingleResult("select sum(pv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">���� IP ������</td>
			<td class="row"><?=$db->GetSingleResult("select iv from ".$setting['db']['pre']."counter where date=curdate()")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">����� IP ������</td>
			<td class="row"><?=$db->GetSingleResult("select max(iv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">��վ�վ� IP ������</td>
			<td class="row"><?=(int)$db->GetSingleResult("select avg(iv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
		<tr>
			<td class="cat" width="250">��վ�� IP ������</td>
			<td class="row"><?=$db->GetSingleResult("select sum(iv) from ".$setting['db']['pre']."counter")?> ��</td>
		</tr>
	</table>
</div>
<div id="bar_loading"><img src="../images/loading.gif" alt="ϵͳ����"><br / >��ϵͳ���ڸ��£����Ժ�</div>
<script language="javascript">
var cur_ver = <?=toJson($ms_version, $setting['gen']['charset']);?>;
function checkUpdate() {
	loadingShow();
	$.get("update.php?"+Math.random(), function(ver_info){
		loadingShow();
		try {
			if(ver_info.ver>cur_ver.ver) {
				if(confirm("Ŀǰ���·����������°汾Ϊ�� v" + ver_info.ver + "(" + ver_info.date + ")\n\n����ȷ�����Զ����£�����ȡ�������ظ��³���\n" + ver_info.update)) {
					applyUpdate(1);
				} else {
					applyUpdate(0);
				}
			} else {
				alert("ϵͳ��ǰ�汾��Ϊ���£�������£�");
			}
		} catch(e) {
			alert("��ȡ���·�������Ϣʧ�ܣ�����������ã�");
		}
	}, "json");
}
function applyUpdate(mode) {
	loadingShow();
	mode = (mode==1?"update":"download");
	$.get("update.php?"+mode, function(info){
		loadingShow();
		try {
			alert(info.info);
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
function checkModify() {
	$.get("update.php?check", function(info){
		if(info=="error") {
			alert("У��ʧ�ܣ���ȷ��У����Ϣ�Ƿ��ѳɹ�������");
		} else if(info.length==0) {
			alert("δ���ָı���ļ���");
		} else {
			alert("���������ļ������ı䣺\n\n"+info);
		}
	});
}
function updateModify() {
	if(confirm("����У����Ϣ������Զ�����ʱ���ѸĶ��ļ����󸲸ǣ��Ƿ������")==false) return;
	$.get("update.php?build", function(info){
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
</script>
