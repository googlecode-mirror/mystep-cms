<TABLE BORDER="0" WIDTH="700" CELLSPACING="1" CELLPADDING="2" ALIGN="center">
	<TR>
		<TD>
			<div style="text-align:center;font-size:20px;font-weight:bold;">����ID��<!--record_id--></div>
			<BR />
			<div>������Ĭ���ʼ������ݣ�����ǰ�����Ը���ʵ��������޸ġ������ͣ�������桰�����ʼ��������ӡ�</div>
			<BR />
			<TEXTAREA COLS="110" ROWS="50" ID="emailcontent">
Dear <!--record_name--> :

Welcome to "<!--name_en-->"��

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
	echo $value['title_en']."��".$record[$key]."\n";
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
		<TD HEIGHT="30" ALIGN="CENTER"><A HREF="#" onClick="formmail(document.getElementById('emailcontent'),'<!--record_email--> ', '<!--name_en-->');" style="color:red; font-weight:bold;">�����ʼ�</A></TD>
	</TR>
</TABLE>

<script language="JavaScript" type="text/JavaScript">
function formmail(theformitem, mailaddress, mailsubject)	{
	str = theformitem.value;
	re = /&/g;	// 2004-3-11 14:53 ����Ҫת����� & ������Ϊ����������ѯ�ַ����в����ָ�������һ�� QueryString ��������Ҫ������� %26 ��
	str = str.replace(re, "%26");
	re = /\n/g;	//�����е�����ֱ������mailto:��body �����л��ж�û�ˣ������� JavaScript ת���� %0D%0A ���У�
	newstr = str.replace(re, "%0D%0A");
	//alert(mailsubject.replace(/\s/g, "%20")+newstr);
	//����������пո��Ҳ���飬������ʼ����ݲ��ܼӵ����ʹ���������⣬�����
	window.location="mailto:"+mailaddress+"?subject="+mailsubject.replace(/\s/g, "%20")+"&body="+newstr;
}
</script>
