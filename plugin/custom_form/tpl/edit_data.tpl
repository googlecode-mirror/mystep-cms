<div class="title"><!--title--></div>
<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	<!--custom_form_name-->
</div>
<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
<script src="../../script/jquery.date_input.js" Language="JavaScript1.2"></script>
<table id="tbl_main" width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
	<tr>
		<td align="center">
		<br />
		<div align="center">
			�ؼ��֣�<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?mid=<!--mid-->&keyword='+this.value" /><input type="button" value="����" onclick="location.href='?mid=<!--mid-->&keyword='+this.previousSibling.value" />
		</div>
		<br />
		<div align="center"><b>������ڣ�</b> <!--record_add_date--> ��ID��<!--record_id-->��</div>
		<br />
		<div align="center">
			��<a href="?method=confirm&mid=<!--mid-->&id=<!--record_id-->" target="_blank">����ȷ���ʼ�</a>��
			&nbsp; &nbsp; &nbsp; 
			��<a href="?&mid=<!--mid-->">�����б�ҳ��</a>��
		</div>
		<br />
		<form name="cf_<!--method-->" method="post" action="?method=<!--method-->_ok" ENCTYPE="multipart/form-data" onsubmit="return checkForm(this)">
			<div align="left">
			<input name="id" type="hidden" value="<!--record_id-->" />
			<input name="mid" type="hidden" value="<!--mid-->" />
			<table cellspacing="0" cellpadding="0" align="center">
<?php
global $record;
foreach($para as $key => $value) {
	if(empty($value['title'])) $value['title'] = $value['title_en'];
	if(empty($value['comment'])) $value['comment'] = $value['comment_en'];
	if(empty($value['comment'])) $value['comment'] = "��ע��";
	echo <<<mystep
				<tr>
					<td class="cat" width="80">{$value['title']}</td>
					<td class="row">
mystep;
	switch($value['type']) {
		case "text":
			$format = "";
			if($value['format']!="." && $value['format']!="") $format = ' need="'.$value['format'].'_"';
			$format = str_replace("__", "_", $format);
			$length = "";
			if($value['length']!="") $length = ' len="'.$value['length'].'"';
			echo <<<mystep
						<input name="{$key}" type="text" value="{$record[$key]}" size="50"{$length}{$format} />
mystep;
			break;
		case "file":
			echo <<<mystep
						<input name="{$key}" type="file" value="" size="50" />
mystep;
			if(!empty($record[$key])) {
				$value['comment'] = "<a href='file.php?mid=".$mid."&id=".$id."&f=".$key."' target='_blank'>������Ƭ</a>";
			}
			break;
		case "radio":
			for($i=0; $i<count($value['value']['cn']); $i++) {
				$selected = ($value['value']['cn'][$i]==$record[$key]?" checked":"");
				echo <<<mystep
						<label><input name="{$key}" type="radio" value="{$value['value']['cn'][$i]}"{$selected} /> {$value['value']['cn'][$i]}</label>
mystep;
			}
			break;
		case "select":
			echo "<select name=\"{$key}\">";
			for($i=0; $i<count($value['value']['cn']); $i++) {
				$selected = ($value['value']['cn'][$i]==$record[$key]?" selected":"");
				echo <<<mystep
						<option value="{$value['value']['cn'][$i]}"{$selected}>{$value['value']['cn'][$i]}</option>
mystep;
			}
			echo "</select>";
			break;
		case "checkbox":
			for($i=0; $i<count($value['value']['cn']); $i++) {
				$selected = (strpos($record[$key], $value['value']['cn'][$i])!==false?" checked":"");
				echo <<<mystep
						<label><input name="{$key}[]" type="checkbox" value="{$value['value']['cn'][$i]}"{$selected} /> {$value['value']['cn'][$i]}</label><br />
mystep;
			}
			break;
		case "textarea":
			echo <<<mystep
						<textarea name="{$key}" style="width:100%;height:50px;">{$record[$key]}</textarea><br />
mystep;
			break;
		default:
			echo "��ʽ���ʹ���";
			break;
	}
	echo <<<mystep
						<span class="comment">��{$value['comment']}��</span>
					</td>
				</tr>
mystep;
}
?>
				<tr>
					<td class="cat" colspan="4" align="center">
						<input type="hidden" name="keyword" value="<!--keyword-->" />
						<input class="normal" type="Submit" value=" ȷ �� " name="Submit" />&nbsp;&nbsp;
						<input class="normal" type="reset" value=" �� �� " name="reset" />&nbsp;&nbsp;
						<input class="normal" type="button" value=" �� �� " name="return" onClick="history.go(-1)" />
					</td>
				</tr>
			</table>
			</div>
		</form>
		</td>
	</tr>
</table>
<br />