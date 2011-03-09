<div class="title">网站基本信息</div>
<div>&nbsp;</div>
<div>
	<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td class="cat" width="250">网站运行时间</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."counter")?> 天</td>
		</tr>
		<tr>
			<td class="cat" width="250">注册会员数</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."users")?> 人</td>
		</tr>
		<tr>
			<td class="cat" width="250">登录新闻数量</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."news_show")?> 条</td>
		</tr>
		<tr>
			<td class="cat" width="250">当前在线人数</td>
			<td class="row"><?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."user_online")?> 人</td>
		</tr>
		<tr>
			<td class="cat" width="250">最高在线人数</td>
			<td class="row"><?=$db->GetSingleResult("select max(online) from ".$setting['db']['pre']."counter")?> 人</td>
		</tr>
		<tr>
			<td class="cat" width="250">今日页面访问量</td>
			<td class="row"><?=$db->GetSingleResult("select pv from ".$setting['db']['pre']."counter where date=curdate()")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">最高日页面访问量</td>
			<td class="row"><?=$db->GetSingleResult("select max(pv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">网站页面日均访问量</td>
			<td class="row"><?=(int)$db->GetSingleResult("select avg(pv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">网站页面总访问量</td>
			<td class="row"><?=$db->GetSingleResult("select sum(pv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">今日 IP 访问量</td>
			<td class="row"><?=$db->GetSingleResult("select iv from ".$setting['db']['pre']."counter where date=curdate()")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">最高日 IP 访问量</td>
			<td class="row"><?=$db->GetSingleResult("select max(iv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">网站日均 IP 访问量</td>
			<td class="row"><?=(int)$db->GetSingleResult("select avg(iv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
		<tr>
			<td class="cat" width="250">网站总 IP 访问量</td>
			<td class="row"><?=$db->GetSingleResult("select sum(iv) from ".$setting['db']['pre']."counter")?> 次</td>
		</tr>
	</table>
</div>