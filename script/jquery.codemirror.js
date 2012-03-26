/*
jquery.codemirror.js
By windy2000<windy2006@gmail.com> from www.mysteps.cn
*/
(function($){$.fn.codemirror = function(options, callback_func) {
	var result = this;
	var editors = new Array();
	var settings = $.extend( {
		type : 'htmlmixed',
		mode : 'text/html',
		lineNumbers : true,
		lineWrapping : true,
		matchBrackets : true,
		tabSize : 2,
		indentUnit : 2,
		indentWithTabs : true,
		runmode : false,
		readOnly : false,
		base_path : "http://codemirror.net"
	}, options);
	var mode_list = new Object();
	mode_list.clike = "text/x-csrc";
	mode_list.clojure = "text/x-clojure";
	mode_list.coffeescript = "text/x-coffeescript";
	mode_list.css = "text/css";
	mode_list.diff = "text/x-diff";
	mode_list.ecl = "text/x-ecl";
	mode_list.gfm = "gfm";
	mode_list.go = "text/x-go";
	mode_list.groovy = "text/x-groovy";
	mode_list.haskell = "text/x-haskell";
	mode_list.htmlembedded = "application/x-ejs";
	mode_list.htmlmixed = "text/html";
	mode_list.javascript = "text/javascript";
	mode_list.jinja2 = {name: "jinja2", htmlMode: true};
	mode_list.less = "text/less";
	mode_list.lua = "text/x-lua";
	mode_list.markdown = "markdown";
	mode_list.mysql = "text/x-mysql";
	mode_list.ntriples = "text/n-triples";
	mode_list.pascal = "text/x-pascal";
	mode_list.perl = "text/x-perl";
	mode_list.php = "application/x-httpd-php";
	mode_list.plsql = "text/x-plsql";
	mode_list.properties = "text/x-properties";
	mode_list.python = {name: "python",version: 2,singleLineStringErrors: false};
	mode_list.r = "text/x-rsrc";
	mode_list.rpm_changes = {name: "changes"};
	mode_list.rpm_spec = {name: "spec"};
	mode_list.rst = "text/x-rst";
	mode_list.ruby = "text/x-ruby";
	mode_list.rust = "text/x-rustsrc";
	mode_list.scheme = "text/x-scheme";
	mode_list.smalltalk = "text/x-stsrc";
	mode_list.sparql = "application/x-sparql-query";
	mode_list.stex = "text/x-stex";
	mode_list.tiddlywiki = "tiddlywiki";
	mode_list.velocity = "text/velocity";
	mode_list.verilog = "text/x-verilog";
	mode_list.xml = {name: "xml", alignCDATA: true};
	mode_list.xmlpure = {name: "xmlpure"};
	mode_list.yaml = "text/x-yaml";

	var type_list = new Object();
	type_list.clike = ["/mode/clike/clike.js"];
	type_list.clojure = ["/mode/clojure/clojure.js"];
	type_list.coffeescript = ["/mode/coffeescript/coffeescript.js"];
	type_list.css = ["/mode/css/css.js"];
	type_list.diff = ["/mode/diff/diff.js"];
	type_list.diff.css = ["/mode/diff/diff.css"];
	type_list.ecl = ["/mode/ecl/ecl.js"];
	type_list.gfm = [
										"/mode/xml/xml.js",
										"/mode/markdown/markdown.js",
										"/mode/gfm/gfm.js"
									];
	type_list.go = ["/mode/go/go.js"];
	type_list.groovy = ["/mode/groovy/groovy.js"];
	type_list.haskell = ["/mode/haskell/haskell.js"];
	type_list.htmlembedded = [
										"/mode/xml/xml.js",
										"/mode/javascript/javascript.js",
										"/mode/css/css.js",
										"/mode/htmlmixed/htmlmixed.js",
										"/mode/htmlembedded/htmlembedded.js",
									];
	type_list.htmlmixed = [
										"/mode/xml/xml.js",
										"/mode/javascript/javascript.js",
										"/mode/css/css.js",
										"/mode/htmlmixed/htmlmixed.js",
									];
	type_list.javascript = ["/mode/javascript/javascript.js"];
	type_list.jinja2 = ["/mode/jinja2/jinja2.js"];
	type_list.less = ["/mode/less/less.js"];
	type_list.lua = ["/mode/lua/lua.js"];
	type_list.markdown = [
										"/mode/xml/xml.js",
										"/mode/markdown/markdown.js",
									];
	type_list.mysql = ["/mode/mysql/mysql.js"];
	type_list.ntriples = ["/mode/ntriples/ntriples.js"];
	type_list.pascal = ["/mode/pascal/pascal.js"];
	type_list.perl = ["/mode/perl/perl.js"];
	type_list.php = [
										"/mode/xml/xml.js",
										"/mode/javascript/javascript.js",
										"/mode/css/css.js",
										"/mode/clike/clike.js",
										"/mode/php/php.js",
									];
	type_list.plsql = ["/mode/plsql/plsql.js"];
	type_list.properties = ["/mode/properties/properties.js"];
	type_list.properties.css = ["/mode/properties/properties.css"];
	type_list.python = ["/mode/python/python.js"];
	type_list.r = ["/mode/r/r.js"];
	type_list.rpm_changes = ["/mode/rpm/changes/changes.js"];
	type_list.rpm_spec = ["/mode/rpm/spec/spec.js"];
	type_list.rpm_spec.css = ["/mode/rpm/spec/spec.css"];
	type_list.rst = ["/mode/rst/rst.js"];
	type_list.ruby = ["/mode/ruby/ruby.js"];
	type_list.rust = ["/mode/rust/rust.js"];
	type_list.scheme = ["/mode/scheme/scheme.js"];
	type_list.smalltalk = ["/mode/smalltalk/smalltalk.js"];
	type_list.sparql = ["/mode/sparql/sparql.js"];
	type_list.stex = ["/mode/stex/stex.js"];
	type_list.tiddlywiki = ["/mode/tiddlywiki/tiddlywiki.js"];
	type_list.tiddlywiki.css = ["/mode/tiddlywiki/tiddlywiki.css"];
	type_list.velocity = ["/mode/velocity/velocity.js"];
	type_list.verilog = ["/mode/verilog/verilog.js"];
	type_list.xml = ["/mode/xml/xml.js"];
	type_list.xmlpure = ["/mode/xmlpure/xmlpure.js"];
	type_list.yaml = ["/mode/yaml/yaml.js"];
	
	if(typeof(loaded)=="undefined") loaded = new Array();
	var script_list = new Array();
	if(settings.runmode && loaded.indexOf('/lib/util/runmode.js')==-1) script_list.push("/lib/util/runmode.js");
	var the_type = "";
	for(var n=0, m=this.length;n<m;n++) {
		the_type = $(this.get(n)).attr('type');
		if(the_type!="" && typeof(type_list[the_type])!="undefined") {
			script_list = script_list.concat(type_list[the_type]);
		}
	}
	n=0;
	m = script_list.length;
	if(loaded.indexOf('/lib/codemirror.css')==-1) {
		$("head").append($('<link rel="stylesheet" href="'+settings.base_path+'/lib/codemirror.css" type="text/css" media="screen" />'));
		loaded.push('/lib/codemirror.css');
	}
	if(typeof(type_list[settings.type].css)!="undefined") {
		if(loaded.push(type_list[settings.type].css)==-1) {
			$("head").append($('<link rel="stylesheet" href="' + settings.base_path + type_list[settings.type].css + '" type="text/css" media="screen" />'));
			loaded.push(type_list[settings.type].css);
		}
	}
	if(settings.theme!=null) {
		if(loaded.indexOf('/theme/'+settings.theme+'.css')==-1) {
			$("head").append($('<link rel="stylesheet" href="'+settings.base_path+'/theme/'+settings.theme+'.css" type="text/css" media="screen" />'));
			loaded.push('/theme/'+settings.theme+'.css');
		}
	}
	if(settings.ext_css!=null) $("head").append($('<style type="text/css">' + settings.ext_css + '</style>'));
	
	if(loaded.indexOf("/lib/codemirror.js")==-1) {
		loaded.push("/lib/codemirror.js");
		$.getScript(settings.base_path + "/lib/codemirror.js", function() {
			for(var i=0;i<m;i++) {
				loaded.push(script_list[i]);
				$.getScript(settings.base_path + script_list[i], function(){n++;});
			}
		});
	} else {
		for(var i=0;i<m;i++) {
			if(loaded.push(script_list[i])==-1) {
				$.getScript(settings.base_path + script_list[i], function(){n++;});
			} else {
				n++;
			}
		}
	}
	
	/*
	var script_list = new Array();
	if(settings.runmode) script_list.push("/lib/util/runmode.js");
	var the_type = "";
	for(var n=0, m=this.length;n<m;n++) {
		the_type = $(this.get(n)).attr('type');
		if(the_type!="" && typeof(type_list[the_type])!="undefined") {
			script_list = script_list.concat(type_list[the_type]);
		}
	}
	n=0;
	m = script_list.length;
	if(typeof(CodeMirror)=="undefined") {
		$("head").append($('<link rel="stylesheet" href="'+settings.base_path+'/lib/codemirror.css" type="text/css" media="screen" />'));
		if(typeof(type_list[settings.type].css)!="undefined") $("head").append($('<link rel="stylesheet" href="' + settings.base_path + type_list[settings.type].css + '" type="text/css" media="screen" />'));
		if(settings.theme!=null) $("head").append($('<link rel="stylesheet" href="'+settings.base_path+'/theme/'+settings.theme+'.css" type="text/css" media="screen" />'));
		if(settings.ext_css!=null) $("head").append($('<style type="text/css">' + settings.ext_css + '</style>'));
		$.getScript(settings.base_path + "/lib/codemirror.js", function() {
			for(var i=0;i<m;i++) {
				$.getScript(settings.base_path + script_list[i], function(){n++;});
			}
		});
	} else {
		n = m;
	}
	*/
	
	$.codemirror_set = function() {
		if(settings.runmode) {
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
				
				var the_type = $(this).attr('type');
				if(the_type!="" && typeof(mode_list[the_type])!="undefined") {
					settings.mode = mode_list[the_type];
				}
				var the_content = obj.val();
				if(the_content.length==0) the_content = obj.text();
				the_content += "\n";
				CodeMirror.runMode(the_content.replace(/\t/g, String.fromCharCode(160)+" "), settings.mode, callback);
				var new_obj = $('<div class="CodeMirror">'+(settings.lineNumbers?('<div class="CodeMirror-gutter"><div class="CodeMirror-gutter-text">'+gutter.join('')+'</div></div>'):'<!--gutter-->')+'<div class="CodeMirror-lines">'+(settings.lineNumbers?'<div style="position: relative; margin-left: '+size.toString().length+'em;">':'<div>')+'<pre class="cm-s-default">'+accum.join('')+'</pre></div></div></div><div class="CodeMirror_scroll"></div>').insertAfter(obj);
				$(".CodeMirror").css({"position":"relative"});
				if(the_type=="mysql") {
					new_obj.find(".CodeMirror-lines").css({"margin-left":"14px"});
				} else if(the_type=="css") {
					new_obj.find(".CodeMirror-lines").css({"margin-left":"-14px"});
				}
				new_obj.css("overflow-x","hidden");
				obj.hide();
			});
			$('.CodeMirror-lines pre').css("overflow","hidden");
			$('.CodeMirror_scroll').each(function(){
				$(this).html($(this).prev().find(".CodeMirror-lines").html());
				$(this).prev().find(".CodeMirror-gutter").height($(this).css("height"));
				$(this).html($(this).prev().find(".CodeMirror-lines").find("pre:first").html());
				$(this).css({"width":($(this).prev().css("width")+3),"height":"16px","overflow-x":"scroll","overflow-y":"hidden"});
				$(this).css({"white-space":"nowrap"});
				$(this).scroll(function(){
					var theLeft = $(this).scrollLeft();
					if(theLeft!=0) theLeft += 80;
					$(this).prev().find('.CodeMirror-lines pre').scrollLeft(theLeft);
				});
			});
		} else {
			result.each(function() {
				var the_type = $(this).attr('type');
				if(the_type!="" && typeof(mode_list[the_type])!="undefined") {
					settings.mode = mode_list[the_type];
				}
				this.value = this.value.replace(/\t/g,  String.fromCharCode(160)+" ");
				editors[editors.length] = CodeMirror.fromTextArea(this, settings);
			});
		}
		if(typeof(callback_func) == "function") callback_func();
		return;
	}
	
	$.codemirror_get_editor = function(idx) {
		if(idx==null || typeof(editors[idx])=="undefined") {
			return (editors.length>1)?editors[0]:null;
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