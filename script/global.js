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

//if(this.top.location.href.replace(/^(http:\/\/[^\/]+).*$/i,"$1")!=this.location.href.replace(/^(http:\/\/[^\/]+).*$/i,"$1")) top.location.href = location.href;

function reportError(msg, url, line) {
	var str = "You have found an error as below: \n\n";
	str += "Err: " + msg + "on line: " + line;
	alert(str);
	return true;
}

window.onerror = reportError;

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

Array.prototype.clone = function() {
	var copy = new Array();
	for (var i = 0; i < this.length; i++) {
		copy[i] = this[i];
	}
	return copy;
}

Array.prototype.append = function (secondArray) {
	var firstArray = this.clone();
	if(typeof(secondArray.length)=="undefined" || secondArray.length==0) {
		firstArray[firstArray.length] = secondArray;
	} else {
		for (var i = 0; i < secondArray.length; i++) {
			firstArray[firstArray.length] = secondArray[i];
		}
	}
	return firstArray;
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
			alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");
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
		alert("复制成功！")
	} else {
		return false;
	}
	return true;
}