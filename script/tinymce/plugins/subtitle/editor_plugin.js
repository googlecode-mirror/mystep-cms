/**
 * @author Windy2000
 */

(function() {
	tinymce.create('tinymce.plugins.SubtitlePlugin', {
		init : function(ed, url) {
			ed.addCommand('mceSubtitle', function() {
				var theSel = ed.selection.getContent();
				var theStr = "";
				theStr = ed.selection.getContent({format : 'text'});
				if(!theSel.match(/^(<(\w+)>)?<span class=\"mceSubtitle\">(.+)<\/span>(<\/\2>)?$/i) && theStr.length>0) {
					theStr = '<span class="mceSubtitle">'+theStr+'</span>';
				}
				ed.execCommand('mceInsertContent',false,theStr);
			});

			ed.addButton('Subtitle', {
				title : '设置子标题',
				cmd : 'mceSubtitle',
				image : url + '/img/Subtitle.gif'
			});
			
			ed.onInit.add(function() {
				if (ed.settings.content_css !== false)
					ed.dom.loadCSS(url + "/css/subtitle.css");
			});
			
			ed.onClick.add(function(ed, e) {
				e = e.target;
				if (e.nodeName === 'SPAN' && ed.dom.hasClass(e, "mceSubtitle")) {
					ed.selection.select(e);
				}
			});
			
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('subtitle', n.nodeName == 'SPAN' && ed.dom.hasClass(n, "mceSubtitle"));
			});
		},

		getInfo : function() {
			return {
				longname : 'Subtitle plugin',
				author : 'Windy2000',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com/',
				version : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('subtitle', tinymce.plugins.SubtitlePlugin);
})();