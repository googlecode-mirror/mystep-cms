<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?update" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
		<tbody style="display:none;">
			<tr>
				<td class="cat" colspan="4">�������ʱ������</td>
			</tr>
			<tr align="center">
				<td class="cat" width="30">���</td>
				<td class="cat">ҳ���ļ��������ڻ����phpҳ�棩</td>
				<td class="cat">������Ч�ڣ���λ���룩</td>
				<td class="cat" width="120">����</td>
			</tr>
<!--loop:start key="expire"-->
			<tr>
				<td class="cat"><!--expire_idx--></td>
				<td class="row"><input name="page[]" type="text" size="10" maxlength="10" value="<!--expire_page-->" need="alpha" /></td>
				<td class="row"><input name="expire[]" type="text" size="10" maxlength="20" value="<!--expire_expire-->" need="digital" /></td>
				<td class="row" align="center">
					<input class="btn" type="button" onclick="add(this)" style="width:50px;" value="����" />
					<input class="btn" type="button" onclick="del(this)" style="width:50px;" value="ɾ��" />
				</td>
			</tr>
<!--loop:end-->
			<tr>
				<td class="row" colspan="4">���ݻ��棺
<?PHP
include(ROOT_PATH."/include/config-detail.php");
echo "<select name=\"cache_mode\">\n";
foreach($setting_type['web']['cache_mode'][1] as $key => $value) {
	$checked = $value==$setting['web']['cache_mode']?"selected":"";
	echo '<option value="'.$value.'" '.$checked.'>'.$key.'</option>'."\n";
}
echo "</select>";
?>
					<span class="comment">�������ݻ��棬���������ظ���ѯ�������Ч��</span>
				</td>
			</tr>
			<tr>
				<td class="row" colspan="4" align="center">
					<input class="btn" type="Submit" value=" ȷ���޸� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �������� " />&nbsp;&nbsp;
				</td>
			</tr>
			</tbody>
			<tr>
				<td class="cat">��������</td>
				<td class="row" colspan="3"><br />
					<input type="checkbox" class="cbox" id="ccache_1" name="ccache[]" value="1" /><label for="ccache_1">ģ�建��</label>&nbsp;&nbsp; 
					<input type="checkbox" class="cbox" id="ccache_2" name="ccache[]" value="2" /><label for="ccache_2">��������</label>&nbsp;&nbsp; 
					<input type="checkbox" class="cbox" id="ccache_3" name="ccache[]" value="3" /><label for="ccache_3">�ű�����</label>
					<br /><br />
					<input type="checkbox" class="cbox" id="ccache_4" name="ccache[]" value="4" /><label for="ccache_4">�������</label>&nbsp;&nbsp; 
					<input type="checkbox" class="cbox" id="ccache_5" name="ccache[]" value="5" /><label for="ccache_5">�Ự����</label>&nbsp;&nbsp; 
					<input type="checkbox" class="cbox" id="ccache_8" name="ccache[]" value="6" /><label for="ccache_8">ͼƬ����</label>
					<br /><br />
					<input type="checkbox" class="cbox" id="ccache_6" name="ccache[]" value="7" checked /><label for="ccache_6">ҳ�滺��</label>&nbsp;&nbsp; 
					<input type="checkbox" class="cbox" id="ccache_7" name="ccache[]" value="8" checked /><label for="ccache_7">���ݻ���</label>&nbsp;&nbsp; 
					<input type="checkbox" class="cbox" id="ccache_all" onclick="checkIt(this.checked)" /><label for="ccache_all">ȫѡ</label>
					<br /><br />
					<input class="btn" type="button" onclick="cclean()" value=" �� �� " />
					&nbsp;&nbsp; 
					<span class="comment">��������ռ�õĴ��̿ռ䣬Ҳ����ʹ��ظ���������Ч</span><br /><br />
				</td>
			</tr>
			<tr>
				<td class="cat">ҳ�滺��</td>
				<td class="row" colspan="3"><br />
					<input type="radio" class="cbox" id="cache_1" name="cache" value="true" <!--cache_1--> /><label for="cache_1">����</label>&nbsp;&nbsp; 
					<input type="radio" class="cbox" id="cache_2" name="cache" value="false" <!--cache_2--> /><label for="cache_2">�ر�</label>
					<br /><br />
					<input class="btn" type="Submit" value=" ȷ �� " />
					&nbsp;&nbsp; 
					<span class="comment">����ҳ�滺�棬���ٹ̶�ʱ���ڵĲ�ѯƵ�ʣ���ǿ��վЧ��</span><br /><br />
				</td>
			</tr>
		</table>
	</form>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
function add(obj) {
	obj = $(obj).parent().parent().clone();
	obj.find("input:first").val("");
	obj.find("td:first").text($("#input_area tr").length - 5);
	$("#input_area tr:last").prev().prev().prev().before(obj);
}

function del(obj) {
	obj = $(obj).parent().parent();
	if(obj.find("input")[0].defaultValue.toLowerCase()!="default") obj.remove();
}

function cclean() {
	loadingShow("���������վ���棬�����ĵȴ���");
	var theForm = $("form").get(0);
	theForm.action = "?clean";
	theForm.submit();
}
function checkIt(mode) {
	$("input[name='ccache[]']").attr("checked", mode);
}
//]]> 
</script>