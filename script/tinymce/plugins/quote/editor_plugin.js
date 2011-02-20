/**
 * @author Windy2000
 */

(function() {
	tinymce.PluginManager.requireLangPack('quote');
	
	tinymce.create('tinymce.plugins.quotePlugin', {
		init : function(ed, url) {
			ed.addCommand('mceQuote', function() {
				var theSel = ed.selection.getContent();
				if(theSel.length==0) return;
				var theStr = "";
				if(theSel.match(/<div class=\"quote\">(.+)<\/div>/i)) {
					theStr = theSel.replace(/<div class=\"quote\">(.+)<\/div>/i, "$1");
				} else {
					theStr = '<div class="quote">'+theSel+'</div>';
				}
				ed.execCommand('mceInsertContent',false,theStr);
			});

			ed.addButton('quote', {
				title : 'quote.title',
				cmd : 'mceQuote',
				image : url + '/img/quote.gif'
			});
			
			ed.onInit.add(function() {
				if (ed.settings.content_css !== false)
					ed.dom.loadCSS(url + "/css/quote.css");
			});
		},

		getInfo : function() {
			return {
				longname : 'Quote Plugin',
				author : 'Windy2000',
				authorurl : '',
				infourl : '',
				version : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('quote', tinymce.plugins.quotePlugin);
})();