<TABLE BORDER="0" WIDTH="700" CELLSPACING="1" CELLPADDING="2" ALIGN="center">
	<TR>
		<TD>
			<div style="text-align:center;font-size:20px;font-weight:bold;">����ID��<!--record_id--></div>
			<BR />
			<div>������Ĭ���ʼ������ݣ�����ǰ�����Ը���ʵ��������޸ġ������ͣ�������桰�����ʼ��������ӡ�</div>
			<BR />
			<TEXTAREA COLS="110" ROWS="40" ID="emailcontent">
�𾴵� <!--record_name-->��

��ӭ���μӡ�<!--name-->����

��������Ϣ�Ѿ��յ�����ȷ������ע����Ϣ��ȷ����
<?php
global $record;
foreach($para as $key => $value) {
	if(empty($value['title'])) continue;
	echo $value['title']."��".$record[$key]."\n";
}
?>

ס�޷����뵽�ᵱ����Ƶ�ǰ̨��Ǣ��

�뽫���Ļ���� <!--record_total--> Ԫ�������µ�ַ��
�տλ�� �й�ʳƷ����������̻�
�����У���ͨ���ж���֧��
�ʺţ� 110060194018010001190
����ص㣺����

<!--name-->

Tel: +86-10-87109800
Fax: +86-10-87109800
Email: cccfna@cccfna.org.cn
website: <?=$setting['web']['url']?>
			</TEXTAREA>
		</TD>
	</TR>
	<TR>
		<TD HEIGHT="30" ALIGN="CENTER"><A HREF="#" onClick="formmail(document.getElementById('emailcontent'),'<!--record_email--> ', '<!--name-->');" style="color:red; font-weight:bold;">�����ʼ�</A></TD>
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
