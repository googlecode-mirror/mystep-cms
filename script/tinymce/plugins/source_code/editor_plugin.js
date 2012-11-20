/**
 * @author Windy2000
 */

(function() {
	tinymce.PluginManager.requireLangPack('source_code');
	
	tinymce.create('tinymce.plugins.SourceCodePlugin', {
		init : function(ed, url) {
			ed.addCommand('mceSourceCode', function() {
				ed.windowManager.open({
					file : url + '/source_code.htm',
					width : 600,
					height : 480,
					inline : 1,
					maximizable : 1
				}, {
					plugin_url : url
				});
			});

			ed.addButton('source_code', {
				title : 'source_code.title',
				cmd : 'mceSourceCode',
				image : url + '/img/source_code.jpg'
			});

			ed.onNodeChange.add(function(ed, cm, n) {
				return null;
			});
			
			ed.onClick.add(function(ed, e) {
				e = e.target;
				try {
					if (e.nodeName.toLocaleLowerCase() === 'fieldset' && ed.dom.hasClass(e, "source")) {
						ed.selection.select(e);
					} else {
						e = e.parentElement;
						if (e.nodeName.toLocaleLowerCase() === 'fieldset' && ed.dom.hasClass(e, "source")) {
							ed.selection.select(e);
						} else {
							e = e.parentElement;
							if (e.nodeName.toLocaleLowerCase() === 'fieldset' && ed.dom.hasClass(e, "source")) {
								ed.selection.select(e);
							}
						}
					}
				} catch(e) {}
			});
		},

		createControl : function(n, cm) {
			return null;
		},

		getInfo : function() {
			return {
				longname : 'Source Code plugin',
				author : 'Windy2000',
				authorurl : '',
				infourl : '',
				version : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('source_code', tinymce.plugins.SourceCodePlugin);
})();