tinyMCEPopup.requireLangPack();

var BBSCodeDialog = {
	init : function() {
		var f = document.forms[0];
		f.content.value = htm2ubb(tinyMCEPopup.editor.selection.getContent());
	},

	insert : function() {
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, ubb2htm(document.forms[0].content.value));
		tinyMCEPopup.close();
	},

	resize : function() {
		var vp = tinyMCEPopup.dom.getViewPort(window), el;
		el = document.getElementById('content');
		el.style.width  = (vp.w - 20) + 'px';
		el.style.height = (vp.h - 150) + 'px';
	}
};

tinyMCEPopup.onInit.add(BBSCodeDialog.init, BBSCodeDialog);


function ubb2htm(str) {
	str = str.replace(/\r/g,"");
	str = str.replace(/\[(\/)?tbl/ig,"[$1table");
	str = str.replace(/\[(\/)?face\]/ig,"[$1font]");
	str = str.replace(/(\[\w+(=[^\]]+?)\])(\s+)/ig,"$1");
	str = str.replace(/(\s+)(\[\/\w+\])/ig,"$2");
	
	str = str.replace(/\[url=([^\]]*)\]((.|\n)*?)\[\/url\]/img, '<a href="$1">$2</a>');
	str = str.replace(/\[URL\](.*?)\[\/URL\]/img, '<a href="$1">$1</a>');
	str = str.replace(/\[img\](.*?)\[\/img\]/img, '<img src="$1" border="0">');
	str = str.replace(/\[email\](.*?)\[\/email\]/img, '<a href="mailto:$1">$1</a>');
	str = str.replace(/\[QUOTE\]((.|\n)*?)\[\/QUOTE\]/ig, '<blockquote>$1</blockquote>');
	str = str.replace(/\[FLASH\](.*?)\[\/FLASH\]/ig, '<object width="400" height="300" data="$1" type="application/x-shockwave-flash"><param name="src" value="$1" /></object>');
	str = str.replace(/\[REALPLAYER\](.*?)\[\/REALPLAYER\]/ig, '<object classid="clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa" width="400" height="300" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"><param name="src" value="$1" /><embed type="audio/x-pn-realaudio-plugin" width="400" height="300" src="$1"></embed></object>');
	str = str.replace(/\[MEDIAPLAYER\](.*?)\[\/MEDIAPLAYER\]/ig, '<object classid="clsid:6bf52a52-394a-11d3-b153-00c04f79faa6" width="400" height="300" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"><param name="url" value="$1" /><embed type="application/x-mplayer2" width="400" height="300" src="$1"></embed></object>');

	str = str.replace(/\[list(=(.+?))?\]((.|\n)*?)\[\/list\]/img, function(match_str, m1, m2, m3){
										m3=m3.replace(/(^\s+|\s+$)/g, "");
										m3=m3.replace(/\n+/g, "\n");
										m3="<LI>"+m3.replace(/\n/g,"</LI>\n<LI>")+"</LI>";
										if(m2)
											m3="<OL>\n"+m3+"</OL>";
										else
											m3="<UL>\n"+m3+"</UL>";
										return m3;
									});
	str = str.replace(/\[table(=\w+)?]((.|\n)*?)\[\/table\]/img, function(match_str, m1, m2){
										var str = "";
										var line_lst = new Array();
										if(m2) {
											str += '<table style="BORDER-RIGHT: #999999 1px solid; BORDER-TOP: #999999 1px solid; BORDER-LEFT: #999999 1px solid; CURSOR: default; BORDER-BOTTOM: #999999 1px solid; BORDER-COLLAPSE: collapse; BACKGROUND-COLOR: #eeeecc; TEXT-ALIGN: center" cellSpacing=0 cellPadding=4 width="90%" align=center border=1>\n';
											line_lst = m2.split("\n");
											if(m1) m1 = " align"+m1;
											for(var i=1; i<line_lst.length; i++) {
												if(line_lst[i].length==0) continue;
												str += "<tr"+m1+"><td>";
												str += line_lst[i].replace(/,/ig, "</td><td>");
												str += "</td></tr>\n";
											}
											str += "</table>\n";
										}
										return str;
									});

	re = /\[align=([#0-9a-z]+)\]((.(?!\[align=))*?)\[\/align\]/im;
	while(re.test(str)) {
		str = str.replace(re,"<p align=$1>$2</p>");
	}
	str = str.replace(/\[align=([^\]]*)\]((.|\n)*?)\[\/align\]/img,"<p align=$1>$2</align>");
	
	re = /\[color=([#0-9a-z]+)\]((.(?!\[color=))*?)\[\/color\]/im;
	while(re.test(str)) {
		str = str.replace(re,"<font color=$1>$2</font>");
	}
	str = str.replace(/\[color=([^\]]*)\]((.|\n)*?)\[\/color\]/img,"<font color=$1>$2</font>");
	
	re = /\[size=([=\-0-9]+)\]((.(?!\[size=))*?)\[\/size\]/im;
	while(re.test(str)) {
		str = str.replace(re,"<font size=$1>$2</font>");
	}
	str = str.replace(/\[size=([^\]]+)\]((.|\n)*?)\[\/size\]/img,"<font size=$1>$2</font>");
	
	re = /\[font=([\w \u4E00-\u9FA5]+)\]((.(?!\[font=))*?)\[\/size\]/im;
	while(re.test(str)) {
		str = str.replace(re,"<font face=\"$1\">$2</font>");
	}
	str = str.replace(/\[font=([^\]]+)\]((.|\n)*?)\[\/font\]/img,"<font face=\"$1\">$2</font>");
	
	re = /\[(b|i|u)\]((.(?!\[\1\]))*?)\[\/\1\]/im;
	while(re.test(str)) {
		str = str.replace(re,"<$1>$2</$1>");
	}
	str = str.replace(/\[(b|i|u)\]((.|\n)*?)\[\/\1\]/img, "<$1>$2</$1>");
	str = str.replace(/\n/g, "<br />\n");
	str = str.replace(/<(table[^>]+|\/table|\/tr|\/LI|OL|UL)><br \/>/ig, "<$1>");

	return str;
}


function htm2ubb(str) {
	str = str.replace(/\r/g,"");
	str = str.replace(/on(load|click|dbclick|mouseover|mousedown|mouseup)="[^"]+"/ig,"");
	str = str.replace(/<(script|style)[^>]*?>((.|\n)*?)<\/\1>/img,"");

	str = str.replace(/<a href=".*?files\?(\d+)"><img.+?> (.+?)<\/a>/ig, "[attach=$1]$2[/attach]");
	str = str.replace(/<a[^>]+href="mailto:([^"]+)"[^>]*>\1<\/a>/ig,"[EMAIL]$1[/EMAIL]");
	str = str.replace(/<a[^>]+href="([^"]+)"[^>]*>((.|\n)*?)<\/a>/img,"[URL=$1]$2[/URL]");
	str = str.replace(/<img[^>]+src="([^"]+)"[^>]*>/ig,"[IMG]$1[/IMG]");
	str = str.replace(/<EMBED[^>]+src=(")?([^"]+\.swf)\1[^>]*>(<\/EMBED>)?/ig,"[FLASH]$2[/FLASH]");
	str = str.replace(/<EMBED[^>]+src=(")?([^"]+\.(rm|ram|rmvb))\1[^>]*>(<\/EMBED>)?/ig,"[REALPLAYER]$2[/REALPLAYER]");
	str = str.replace(/<EMBED[^>]+src=(")?([^"]+\.(asf|asx|wmv|wma))\1[^>]*>(<\/EMBED>)?/ig,"[MEDIAPLAYER]$2[/MEDIAPLAYER]");
	str = str.replace(/<DIV align="center">\n?<DIV style="border: 1px solid rgb\(153, 153, 153\); padding: 5px; width: 90%; background\-color: rgb\(238, 238, 238\); text\-align: left;">((.|\n)*?)<\/DIV><\/DIV>/ig,"[QUOTE]$1[/QUOTE]");
	str = str.replace(/<DIV align=center>\n?<DIV style="BORDER-RIGHT: #999999 1px solid; PADDING\-RIGHT: 5px; BORDER\-TOP: #999999 1px solid; PADDING\-LEFT: 5px; PADDING\-BOTTOM: 5px; BORDER\-LEFT: #999999 1px solid; WIDTH: 90%; PADDING\-TOP: 5px; BORDER\-BOTTOM: #999999 1px solid; BACKGROUND\-COLOR: #eeeeee; TEXT-ALIGN: left">((.|\n)*?)<\/DIV><\/DIV>/ig,"[QUOTE]$1[/QUOTE]");

	str = str.replace(/<(\/)?li>/img, "");
	str = str.replace(/<ul>([\w\W]+?)<\/ul>/img, "[LIST]$1[/LIST]");
	str = str.replace(/<ol>([\w\W]+?)<\/ol>/img, "[LIST=1]$1[/LIST]");
	
	str = str.replace(/<(table|tr|td)([^>]+?)>/img, "<$1>");
	str = str.replace(/<table>[\w\W]+?<tr>/img, "<table>\n<tr>");
	str = str.replace(/<tr>[\w\W]+?<td>/img, "<tr><td>");
	str = str.replace(/<\/td>[\w\W]+?<td>/img, "</td><td>");
	str = str.replace(/<\/td>[\w\W]+?<\/tr>/img, "</td></tr>");
	str = str.replace(/<\/tr>[\w\W]+?<tr>/img, "</tr>\n<tr>");
	str = str.replace(/<\/tr>[\w\W]+?<\/table>/img, "</tr>\n</table>");
	str = str.replace(/<(\/)?table>/ig, "[$1table]");
	str = str.replace(/<(\/)?tr>/ig, "");

	str = str.replace(/\[table]((.|\n)*?)\[\/table\]/img, function(match_str, m1){
										var str = "";
										str = match_str.replace(/\r/g, "");
										str = str.replace(/\n+/g,"\n");
										//str = str.replace(/,\n/g, ",");
										//str = str.replace(/<\/td><td>/ig, ",::],[::")
										str = str.replace(/<td>/ig, "[::");
										str = str.replace(/<\/td>/ig, "::]");
										str = str.replace(/\:\:\]\[\:\:/g, "::],[::");
										str = str.replace(/\[\:\:\:\:\]/g, "");
										return str;
									});
	str = str.replace(/\[\:\:(.*?)\:\:\]/mg, function(match_str, m1){
										return m1.match(/<br( \/)?>/i) ? match_str : m1;
									});
	str = str.replace(/,/g, ", ");

	re = /<p[^>]+align="?([^ >"]+)[^>]*>((.(?!<p))*?)<\/p>/im;
	while(re.test(str)) {
		str = str.replace(re, "[ALIGN=$1]$2[/ALIGN]");
	}
	
	re = /<(p|div) style="text\-align: (\w+);">((.(?!<div))*?)<\/\1>/im;
	while(re.test(str)) {
		str = str.replace(re, "[ALIGN=$2]$3[/ALIGN]");
	}
	
	re = /<font[^>]+color=([^ >]+)[^>]*>((.(?!<font))*?)<\/font>/im;
	while(re.test(str)) {
		str = str.replace(re, "[COLOR=$1]$2[/COLOR]");
	}
	
	re = /<font[^>]+face=(")?([\w \u4E00-\u9FA5]+)\1[^>]*>((.(?!<font))*?)<\/font>/im;
	while(re.test(str)) {
		str = str.replace(re, function(match_str, m1, m2, m3) {return (m2=="ËÎÌו" ? m3 : "[FONT="+m2+"]"+m3+"[/FONT]")});
	}
	
	re = /<font[^>]+size=([=\-0-9]+)[^>]*>((.(?!<font))*?)<\/font>/im;
	while(re.test(str)) {
		str = str.replace(re, "[SIZE=$1]$2[/SIZE]");
	}

	str = str.replace(/<([\/]?)strong>/img,"<$1b>");
	str = str.replace(/<([\/]?)em>/img,"<$1i>");
	str = str.replace(/<([\/]?)(b|u|i)>/img,"[$1$2]");

	str = str.replace(/&nbsp;/g," ");
	str = str.replace(/&amp;/g,"&");
	str = str.replace(/&quot;/g,"\"");
	str = str.replace(/&lt;/g,"<");
	str = str.replace(/&gt;/g,">");

	str = str.replace(/<br( \/)?>\n*/ig,"\n");
	str = str.replace(/<input[^>]+?value=([^"\s>]+)[^>]*?>/ig,"$1");
	str = str.replace(/<input[^>]+?value="([^"]+)"[^>]*?>/ig,"$1");
	str = str.replace(/<[^>]*?>/g,"");
	str = str.replace(/\[url=([^\]]+)\](\[img\]\1\[\/img\])\[\/url\]/g,"$2");

	return str;
}