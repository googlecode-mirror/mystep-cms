/**************************************************
*                                                 *
* Author  : Windy_sk                              *
* Create  : 2003-05-03                            *
* Modified: 2004-1-9                              *
* Email   : windy_sk@126.com                      *
* HomePage: None (Maybe Soon)                     *
* Notice  : U Can Use & Modify it freely,         *
*           BUT PLEASE HOLD THIS ITEM.            *
*                                                 *
**************************************************/

var rlt_path = location.href.replace("http://"+location.hostname+"/", "").replace(/\/[^\/]+$/, "/").replace(/[^\/]+/g, "..");
if(rlt_path==".." || rlt_path=="") rlt_path = "./";

function $id(id) {
	return document.getElementById(id);
}

function $name(name, idx) {
	var objs = document.getElementsByName(name);
	if(idx=="first") {
		return objs[0];
	} else if(idx=="last") {
		return objs[objs.length-1];
	} else if(!isNaN(idx)) {
		return objs[idx];
	} else {
		return objs;
	}
}

function $tag(name, theOLE) {
	if(typeof(theOLE)!="object") theOLE = document;
	return theOLE.getElementsByTagName(name);
}

function $class(name, theOLE) {
	if(typeof(theOLE)!="object") theOLE = document;
	return theOLE.getElementsByClassName(name);
}

function arr2json(theArr) {
	var result = {};
	for (var item in theArr) {
		if (typeof (result[theArr[item].name]) == 'undefined') {
			result[theArr[item].name] = theArr[item].value;
		}	else {
			result[theArr[item].name] += "," + theArr[item].value;
		}
	}
	return result;
}

String.prototype.Tlength = function() {
	var arr=this.match(/[^\x00-\xff]/ig);
	return this.length+(arr==null?0:arr.length);
}

Date.prototype.format = function(format){  //eg:format="YYYY-MM-dd hh:mm:ss";
 	var o = {
		"M+" :  this.getMonth()+1,  //month
		"d+" :  this.getDate(),     //day
		"h+" :  this.getHours(),    //hour
		"m+" :  this.getMinutes(),  //minute
		"s+" :  this.getSeconds(), //second
		"q+" :  Math.floor((this.getMonth()+3)/3),  //quarter
		"S"  :  this.getMilliseconds() //millisecond
	}
	if(/(y+)/i.test(format)) {
		format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
	}
	for(var k in o) {
		if(new RegExp("("+ k +")").test(format)) {
			format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
		}
	}
	return format;
}

Array.prototype.append = function (newArray) {
	if(typeof(newArray.length)=="undefined" || newArray.length==0) {
		this[this.length] = newArray;
	} else {
		for (var i = 0; i < newArray.length; i++) {
			this[this.length] = newArray[i];
		}
	}
	return;
}

function openDialog(url, width, height, mode) {
	var sOrnaments = "dialogWidth:"+width+"px;dialogHeight:"+height+"px;center:1;dialogLeft:200;dialogTop:100;dialogHide:0;edge:raised;help:0;resizable:0;scroll:0;status:0;unadorned:0;center:1;";
	var win = null;
	try {
		if(mode){
			win = window.showModalDialog(url, window, sOrnaments);
		}else{
			win = window.showModelessDialog(url, window, sOrnaments);
		}
	} catch(e) {
		win = OpenWindow(url, width, height);
	}
	return win;
}

function openWindow(url,width,height) {
	var win = window.open(url, "showIt","height="+height+", width="+width+", top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no, modal=yes");
	return win;
}

function sleep(the_time) {
	var over_time = new Date(new Date().getTime() + the_time);
	while(over_time > new Date()) {}
}

function gotoAnchor(theAnchor) {
	var the_url = location.href;
	if(theAnchor==null) {
		location.href = the_url + "#";
	} else {
		theAnchor = "#" + theAnchor;
		location.href = the_url.replace(/#+\w*$/, "") + theAnchor;
	}
	return false;
}

function printf() {
  var num = arguments.length;
  var oStr = arguments[0];
  for (var i = 1; i < num; i++) {
    var pattern = "%" + i;
    var re = new RegExp(pattern, "g");
    oStr = oStr.replace(re, arguments[i]);
  }
  return oStr;
}

function copyStr(txt) {
	if(window.clipboardData) {
		window.clipboardData.clearData();
		window.clipboardData.setData("Text", txt);
	} else if(navigator.userAgent.indexOf("Opera") != -1) {
		window.location = txt;
	} else if (window.netscape) {
		try {
			netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
		} catch (e) {
			alert("In 'about:config' set the parameter 'signed.applets.codebase_principal_support' to 'true' !");
		}
		var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		if(!clip) return false;
		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if(!trans) return false;
		trans.addDataFlavor('text/unicode');
		var str = new Object();
		var len = new Object();
		var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
		var copytext = txt;
		str.data = copytext;
		trans.setTransferData("text/unicode",str,copytext.length*2);
		var clipid = Components.interfaces.nsIClipboard;
		if(!clip) return false;
		clip.setData(trans,null,clipid.kGlobalClipboard);
		alert("¸´ÖÆ³É¹¦£¡")
	} else {
		return false;
	}
	return true;
}

function GetRndNum(Min,Max){
	if(typeof(Min)=="undefined") return Math.random();
	if(typeof(Max)=="undefined") Max = Min, Min = 0;
	var Range = Max - Min;
	var Rand = Math.random();
	return(Min + Math.round(Rand * Range));
}

function rnd_str(len, t_lst, c_lst) {
	var str = "";
	var upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var lower = "abcdefghijklmnopqrstuvwxyz";
	var number = "1234567890";
	var cn = false;
	var char_lst = new Array();
	var i = 0, rnd_num = 0;
	if(typeof(t_lst)=="undefined") t_lst = "";
	t_lst += "0000";
	if(t_lst.charAt(0)=="1") char_lst = char_lst.concat(upper.split(/\B/));
	if(t_lst.charAt(1)=="1") char_lst = char_lst.concat(lower.split(/\B/));
	if(t_lst.charAt(2)=="1") char_lst = char_lst.concat(number.split(/\B/));
	cn = (t_lst.charAt(3)=="1");
	if(typeof(c_lst)=="undefined") {
		c_lst = new Array();
	} else if(typeof(c_lst)!="object") {
		c_lst = [c_lst];
	}
	for(i=0; i<len; i++) {
		rnd_num = GetRndNum(10);
		if(c_lst.length>0 && rnd_num>7) {
			str += c_lst[GetRndNum(c_lst.length-1)];
		}	else if(cn && rnd_num>3) {
			str += String.fromCharCode(GetRndNum(19968, 40869));
		} else if(char_lst.length>0){
			str += char_lst[GetRndNum(char_lst.length-1)];
		}
	}
	return str;
}

function watermark(obj, rate, copyright, char_c, jam_tag) {
	var i = 0;
	var c_cur = "", result = "", str="";
	var c_lst = new Array(), u_lst = new Array();
	var m_start = "", m_end = "";
	var jam_flag = true;
	
	if(typeof(obj)=="object") {
		str = obj.innerHTML;
	} else {
		str = obj.toString();
	}
	if(rate==null) rate = 5;
	if(copyright==null) copyright = "WaterMark Maker, Coded by Windy2000";
	if(char_c!=null) c_lst = char_c.split(",");
	if(jam_tag==null) jam_tag = false;

	str = str.replace(/<(script|style)[^>]*?>([\w\W]*?)<\/\1>/ig,"");
	u_lst = str.match(/(<(.+?)>)|(&[\w#]+;)/g);
	str = str.replace(/(<(.+?)>)|(&[\w#]+;)/g,String.fromCharCode(0));
	m_start = "<span class='watermark'>";
	m_end = "</span>";
	
	for(i=0;i<str.length;i++) {
		c_cur = str.charCodeAt(i);
		if(c_cur==0) {
			result += u_lst.shift();
		} else if(c_cur==10) {
			result += m_start + rnd_str(8, "1111", c_lst) + m_end;
			result += m_start + "[" + copyright + "]" + m_end + "\n";
		} else {
			result += String.fromCharCode(c_cur);
			if(jam_tag && GetRndNum(10)>rate) {
				result += jam_flag?"<span>":"</span>";
				jam_flag = !jam_flag;
			}
			if(GetRndNum(10)>rate) result += m_start + rnd_str(4, "1111", c_lst) + m_end;
		}
	}
	if(!jam_flag) result += "</span>";
	
	if(typeof(obj)=="object") {
		obj.innerHTML = result;
	}
	return result;
}

function setSlide() {
	var objs = $(".slide");
	var items = null;
	var temp_num = "";
	for(var i=0; i<objs.length; i++) {
		items = objs[i].getElementsByTagName("DL");
		if(items.length>0) {
			temp_num = "";
			for(var j=0, m=items.length; j<m; j++){
				temp_num += "<li>"+(j+1)+"</li>";
			}
			temp_num = "<ul>"+temp_num+"</ul>";
			$("<div/>").addClass("slide-num").html(temp_num).appendTo(objs[i]);
		}
		$("<div/>").addClass("slide-show").appendTo(objs[i]);
		
		$(".slide li").click(function(){
			var theObj = $(this).parentsUntil(".slide").parent();
			clearTimeout(theObj.data("timeout"));
			theObj = theObj[0];
			theObj.slide(parseInt(this.innerHTML)-1);
		});
		
		objs[i].slide = function(idx) {
			var max = $(this).find("dl").length;
			if(idx>=max) idx = 0;
			$(this).find("DL").hide();
			var item = $(this).find("DL").eq(idx);
			$(this).find(".slide-show").html(item.find("dt").html());
			$(this).find(".slide-num li").removeClass("selected");
			$(this).find(".slide-num li").eq(idx).addClass("selected");
			item.animate({opacity: 'toggle'}, 2000);
			var self = this;
			$(this).data("timeout", setTimeout(function(){self.slide(idx+1)}, 5000));
		}
		objs[i].slide(0);
	}
}

function reportError(msg, url, line) {
	var str = "You have found an error as below: \n\n";
	str += "Err: " + msg + "on line: " + line;
	if(typeof(ms_setting)!="undefined" && ms_setting.debug) alert(str);
	return true;
}
window.onerror = reportError;
if(typeof(ms_setting)=="undefined") $.getScript(rlt_path + "script/setting.js.php");