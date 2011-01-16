<div class="title"><!--title--></div>
<div align="center">
	<table id="input_area" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td class="cat" style="font-size:16px; font-weight:bold; text-align:center; padding:10px"><!--err_msg--></td>
		</tr>
<!--loop:start key="err"-->
		<tr>
			<td class="<!--err_class-->"><!--err_content--></td>
		</tr>
<!--loop:end-->
		<tr>
			<td align="center">
				<input type="button" class="btn" value="清空错误数据" onclick="location.href='?method=clear'"	<!--err_output--> /> &nbsp; 
				<input type="button" class="btn" value="保存错误数据" onclick="location.href='?method=download'" <!--err_output--> />
			</td>
		</tr>
	</table>
</div>