<form class="search" id="<!--id-->" method="get" action="module.php?m=search" target="_blank" onsubmit="return (this.k.value!=this.k.defaultValue)">
	<input type="hidden" name="m" value="search" />
	<input class="input" type="text" name="k" value="<!--keyword-->" onclick="if(this.value==this.defaultValue)this.value='';this.style.color='#000';" onblur="if(this.value=='')this.value=this.defaultValue;this.style.color='#c1c1c1';" />
	<select name="mode">
<!--loop:start-->
		<option value="<!--search_idx-->"><!--search_idx--></option>
<!--loop:end-->
		<option value=""><!--lang_plug_search_local--></option>
	</select>
	<input class="button" type="submit" value="  " />
</form>
