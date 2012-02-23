<TABLE BORDER="0" WIDTH="700" CELLSPACING="1" CELLPADDING="2" ALIGN="center">
	<TR>
		<TD>
			<div style="text-align:center;font-size:20px;font-weight:bold;">代表ID：<!--record_id--></div>
			<BR />
			<div>下面是默认邮件的内容，发送前还可以根据实际情况再修改。若发送，请点下面“发送邮件”的链接。</div>
			<BR />
			<TEXTAREA COLS="110" ROWS="50" ID="emailcontent">
Dear <!--record_name--> :

Welcome to "<!--name_en-->"！

Your online registration has been received. Please confirm the following information has been recorded correctly:
<?php
global $record;
foreach($para as $key => $value) {
	if(empty($value['title_en'])) continue;
	if(is_array($value['value'])) {
		$idx = array_search($record[$key], $value['value']['cn']);
		if(!is_null($idx)) {
			$record[$key] = $value['value']['en'][$idx];
		}
	}
	echo $value['title_en']."：".$record[$key]."\n";
}
?>

Please check-in and pay for your room charge at the hotel's reception on your arrival.

Please remit your registration fee <!--record_total--> RMB:
Beneficiary Name: CFNA
Account No.110060194145300004859 (for USD)
					110060194385300004948 (for EUR)
Name of Bank: Bank of Communications Beijing Branch
Address of Bank: No.33, Jinrong Str., Xicheng Dist.,Beijing, 100032 China
Swift Code: COMMCNSHBJG

<!--name_en-->

Tel: +86-10-87109800
Fax: +86-10-87109800
Email: cccfna@cccfna.org.cn
website: <?=$setting['web']['url']?>
			</TEXTAREA>
		</TD>
	</TR>
	<TR>
		<TD HEIGHT="30" ALIGN="CENTER"><A HREF="#" onClick="formmail(document.getElementById('emailcontent'),'<!--record_email--> ', '<!--name_en-->');" style="color:red; font-weight:bold;">发送邮件</A></TD>
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
