<form id="<!--id-->" method="get" action="module.php?m=search" target="_blank">
<input type="hidden" name="m" value="search" />
<input class="input" type="text" name="k" value="<!--keyword-->" />
<select name="mode">
<!--loop:start-->
	<option value="<!--search_idx-->"><!--search_idx--></option>
<!--loop:end-->
	<option value=""><!--lang_plug_search_local--></option>
</select>
<input class="button" type="submit" value="<!--lang_plug_search_search-->" />
</form>