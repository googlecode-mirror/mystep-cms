<div class="title">��վ������Ϣ</div>
<div>&nbsp;</div>
<div>
	<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
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