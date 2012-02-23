<TABLE BORDER="0" WIDTH="700" CELLSPACING="1" CELLPADDING="2" ALIGN="center">
	<TR>
		<TD>
			<div style="text-align:center;font-size:20px;font-weight:bold;">代表ID：<!--record_id--></div>
			<BR />
			<div>下面是默认邮件的内容，发送前还可以根据实际情况再修改。若发送，请点下面“发送邮件”的链接。</div>
			<BR />
			<TEXTAREA COLS="110" ROWS="40" ID="emailcontent">
尊敬的 <!--record_name-->：

欢迎您参加“<!--name-->”！

您报名信息已经收到。请确认下列注册信息正确无误：
<?php
global $record;
foreach($para as $key => $value) {
	if(empty($value['title'])) continue;
	echo $value['title']."：".$record[$key]."\n";
}
?>

住宿费用请到会当日与酒店前台接洽。

请将您的会议费 <!--record_total--> 元汇至以下地址：
收款单位： 中国食品土畜进出口商会
开户行：交通银行东单支行
帐号： 110060194018010001190
汇入地点：北京

<!--name-->

Tel: +86-10-87109800
Fax: +86-10-87109800
Email: cccfna@cccfna.org.cn
website: <?=$setting['web']['url']?>
			</TEXTAREA>
		</TD>
	</TR>
	<TR>
		<TD HEIGHT="30" ALIGN="CENTER"><A HREF="#" onClick="formmail(document.getElementById('emailcontent'),'<!--record_email--> ', '<!--name-->');" style="color:red; font-weight:bold;">发送邮件</A></TD>
	</TR>
</TABLE>

<script language="JavaScript" type="text/JavaScript">
function formmail(theformitem, mailaddress, mailsubject)	{
	str = theformitem.value;
	re = /&/g;	// 2004-3-11 14:53 还需要转码的有 & 符，因为它用来作查询字符串中参数分隔符，用一个 QueryString 看出来需要把它变成 %26 ！
	str = str.replace(re, "%26");
	re = /\n/g;	//表单项中的文字直接用在mailto:的body 里所有换行都没了，还得用 JavaScript 转换成 %0D%0A 才行！
	newstr = str.replace(re, "%0D%0A");
	//alert(mailsubject.replace(/\s/g, "%20")+newstr);
	//好像标题中有空格符也不灵，会出现邮件内容不能加到发送窗口里的问题，待解决
	window.location="mailto:"+mailaddress+"?subject="+mailsubject.replace(/\s/g, "%20")+"&body="+newstr;
}
</script>
