/**
 * @author Windy2000
 */

(function() {
	tinymce.PluginManager.requireLangPack('bbscode');
	
	tinymce.create('tinymce.plugins.BBSPlugin', {
		init : function(ed, url) {
			ed.addCommand('mceBBSCode', function() {
				ed.windowManager.open({
					file : url + '/bbscode.htm',
					width : 450,
					height : 400,
					inline : 1,
					maximizable : 1
				}, {
					plugin_url : url
				});
			});

			ed.addButton('bbscode', {
				title : 'bbscode.title',
				cmd : 'mceBBSCode',
				image : url + '/img/bbscode.gif'
			});

			ed.onNodeChange.add(function(ed, cm, n) {
				return null;
			});
		},

		createControl : function(n, cm) {
			return null;
		},

		getInfo : function() {
			return {
				longname : 'BBSCode plugin',
				author : 'Windy2000',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com',
				version : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('bbscode', tinymce.plugins.BBSPlugin);
})();