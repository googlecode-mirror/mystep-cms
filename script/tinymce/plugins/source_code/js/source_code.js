tinyMCEPopup.requireLangPack();

var SourceCodeDialog = {
	init : function() {
		var f = document.forms[0];
		var content = tinyMCEPopup.editor.selection.getContent();
		if(content.match(/^<fieldset[\w\W]+?<textarea.+?type\="(\w+)">([\w\W]+)<\/textarea>[\w\W]*<\/fieldset>$/im)) {
			document.forms[0].code_type.value = RegExp.$1;
			content = HTMLDecode(RegExp.$2);
		}
		f.content.value = content;
	},

	insert : function() {
		var result = "\n";
		result += '<fieldset class="source">\n';
		result += "<legend>" + document.forms[0].code_type.options[document.forms[0].code_type.selectedIndex].text +"</legend>\n";
		result += '<textarea class="source_code" type="'+document.forms[0].code_type.value+'">';
		result += HTMLEncode(document.forms[0].content.value);
		result += '</textarea>\n';
		result += '</fieldset>\n\n';
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, result);
		var content = tinyMCE.get('content').getContent();
		content = content.replace('<fieldset class="source"><fieldset class="source">', '<fieldset class="source">');
		content = content.replace('</fieldset></fieldset>', '</fieldset>');
		content = content.replace(/<p.*?>.*?<fieldset(.+?)fieldset>.*?<\/p>/ig, "<fieldset$1fieldset>");
		tinyMCE.get('content').setContent(content);
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;
		el = document.getElementById('content');
		el.style.width  = (vp.w - 20) + 'px';
		el.style.height = (vp.h - 150) + 'px';
	}
};

tinyMCEPopup.onInit.add(SourceCodeDialog.init, SourceCodeDialog);

function HTMLEncode(input) {
	var converter = document.createElement("DIV");
	converter.innerText = input;
	var output = converter.innerHTML;
	converter = null;
	return output.replace(/<br( \/)?>/ig, "\n");
}

function HTMLDecode(input) {
	var converter = document.createElement("DIV");
	converter.innerHTML = input;
	var output = converter.innerText;
	converter = null;
	return output;
}