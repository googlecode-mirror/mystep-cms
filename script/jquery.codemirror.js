(function($){$.fn.codemirror = function(options, scripts, callback) {
	var result = this;
	var editors = new Array();
	var settings = $.extend( {
		'mode' : 'text/html',
		'lineNumbers' : true,
		'runmode' : false,
		'base_path' : "http://codemirror.net"
	}, options);
	var n = 0;
	var script_list = new Array(
		"/mode/xml/xml.js",
		"/mode/css/css.js",
		"/mode/javascript/javascript.js",
		"/mode/htmlmixed/htmlmixed.js",
		"/lib/util/runmode.js"
	);
	if(Object.prototype.toString.apply(scripts) === '[object Array]' && script_list.concat!=null) script_list = script_list.concat(scripts);
	var m = script_list.length;
	if(typeof(CodeMirror)=="undefined") {
		$("head").append($('<link rel="stylesheet" href="'+settings.base_path+'/lib/codemirror.css" type="text/css" media="screen" />'));
		if(settings.theme!=null) $("head").append($('<link rel="stylesheet" href="'+settings.base_path+'/theme/'+settings.theme+'.css" type="text/css" media="screen" />'));
		$("head").append($('<style type="text/css">.CodeMirror-fullscreen{background-color:#fff;display:block;position:absolute;top:0;left:0;width:100%;height:100%;z-index:9999;margin:0;padding:0;border:0px solid #BBBBBB;opacity:1;}</style>'));
		$.getScript(settings.base_path + "/lib/codemirror.js", function() {
			for(var i=0;i<m;i++) {
				$.getScript(settings.base_path + script_list[i], function(){n++;});
			}
		});
	} else {
		n = m;
	}
	
	$.codemirror_set = function() {
		if (settings.runmode) {
			result.each(function() {
				var obj = $(this);
				var accum = [], gutter = [], size = 0;
				var callback = function(string, style) {
					if (string == "\n") {
						accum.push("<br>");
						gutter.push('<pre>'+(++size)+'</pre>');
					} else if (style) {
						accum.push("<span class=\"cm-" + CodeMirror.htmlEscape(style) + "\">" + CodeMirror.htmlEscape(string) + "</span>");
					}	else {
						accum.push(CodeMirror.htmlEscape(string));
					}
				}
				CodeMirror.runMode(obj.val(), settings.mode, callback);
				$('<div class="CodeMirror">'+(settings.lineNumbers?('<div class="CodeMirror-gutter"><div class="CodeMirror-gutter-text">'+gutter.join('')+'</div></div>'):'<!--gutter-->')+'<div class="CodeMirror-lines">'+(settings.lineNumbers?'<div style="position: relative; margin-left: '+size.toString().length+'em;">':'<div>')+'<pre class="cm-s-default">'+accum.join('')+'</pre></div></div></div>').insertAfter(obj);
				obj.hide();
			});
		} else {
			result.each(function() {
				editors[editors.length] = CodeMirror.fromTextArea(this, settings);
			});
		}
		if(typeof(callback) == "function") callback();
		return;
	}
	
	$.codemirror_get_editor = function(idx) {
		if(idx==null || typeof(editors[idx])=="undefined") {
			return editors;
		} else {
			return editors[idx];
		}
	}
	
	if(n==m) {
		$.codemirror_set();
	} else {
		var timer = setInterval(function(){
			if(n==m) {
				$.codemirror_set();
				clearInterval(timer);
			}
		}, 1000);
	}
	
	return result;
};})( jQuery );

