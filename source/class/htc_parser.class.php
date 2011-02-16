<?php
/**************************************************
*                                                 *
* Name    : Html Transfer Code Parser (HTC)       *
* Version : 2.4.1                                 *
* Author  : Windy2000                             *
* Create  : 2003-09-03                            *
* Modified: 2004-01-15                            *
* Email   : windy_sk@126.com                      *
* HomePage: None (Maybe Soon)                     *
* Notice  : U Can Use & Modify it freely,         *
*           BUT HOLD THIS ITEM PLEASE.            *
*                                                 *
**************************************************/

/*
Please make sure that the following style appear on your style sheet of your page

.glow{
	filter:glow(color=red, strength=2);
}
.dropshadow {
	filter: dropshadow(color=#aaaaaa, offx=5, offy=5, positive=1);
}
.shadow {
	filter: shadow(color=blue,direction=135, strength=1);
}
.quote {
	padding: 5px;
	background-color: #eeeeee;
	border: 1px #999999 solid;
	table-layout: fixed;
}
.watermark {
	position: absolute;
	width: 0px;
	height: 1px;
	overflow: hidden;
}
.tbl_show {
	cursor:default;
	BORDER: black 1px solid;
	background-color:#eeeecc;
	border-collapse:collapse;
	border-Color:#999999;
	text-align:center;
}
@media print {
	.watermark {
		display:none;
	}
}
*/

class HTC_Parser extends class_common {
	public $HTC_str = "";
	public $HTC_transURL = true;
	public $HTC_ignoreList = "";
	public $HTC_nestingParse = false;
	public $HTC_watermark = false;
	public $HTC_watermark_url = "";
	public $HTC_watermark_disturb = array("windy2000");
	public $HTC_watermark_creditStr = "";
	public $HTC_list = array(
		"B"		=> '<b>\1</b>',
		"I"		=> '<i>\1</i>',
		"U"		=> '<u>\1</u>',
		"CENTER"	=> '<center>\1</center>',
		"URL"		=> '<a href="\1" target="_blank">\1</a>',
		"EMAIL"		=> '<a href="mailto:\1">\1</a>',
		"IMG"		=> '<img src="\1" border="0" onclick="window.open(this.src)" style="cursor:pointer; border:1px black solid" />',
		"QUOTE"		=> '<center><table border="0" width="90%" cellspacing="0" cellpadding="0"><tr><td><table width="100%" class="quote"><tr><td>\1</td></tr></table></td></tr></table></center>',
		"IFRAME"	=> '<iframe src="\1" frameborder="0" allowtransparency="true" scrolling="yes" width="400" height="300"></iframe>',
		"MOVE"		=> '<center><marquee width="90%" behavior="alternate" scrollamount="3">\1</marquee><center>',
		"GLOW"		=> '<table><tr><td class="glow">\1</td></tr></table>',
		"SHADOW"	=> '<table><tr><td class="shadow">\1</td></tr></table>',
		"DROPSHADOW"	=> '<table><tr><td class="dropshadow">\1</td></tr></table>',
		"GBMUSIC"	=> '<bgsound src="\1" loop="-1">',
		"MUSIC"		=> '<center><EMBED src="\1" width="200" height="30" type="audio/x-pn-realaudio-plugin" console="ClipNN" loop="false" autostart="true" controls="ControlPanel" border="1" vspace="0" hspace="0"></EMBED><br /><STRONG><A href="\1">下载当前音频文件</A></STRONG></center>',
		"FLASH"		=> '<center><EMBED src="\1" width="400" height="300"></EMBED><br /><STRONG><A href="\1">下载当前动画文件</A></STRONG></center>',
		"SHOCKWAVE"	=> '<center><object classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,0,0" width="400" height="300"><param name="src" value="\1"><embed src="\1" pluginspage="http://www.macromedia.com/shockwave/download/" width="400" height="300"></embed></object><br /><STRONG><A href="\1">下载当前动画文件</A></STRONG></center>',
		"QUICKTIME"	=> '<center><EMBED src="\1" width="400" height="300" autoplay="true" loop="false" controller="true" playeveryframe="false" cache="false" scale="TOFIT" bgcolor="#000000" kioskmode="false" targetcache="false" pluginspage="http://www.apple.com/quicktime/"></EMBED><br /><STRONG><A href="\1">下载当前视频文件</A></STRONG></center>',
		"REALPLAYER"	=> '<center><EMBED name="movie_rm" align="top" src="\1" width="400" height="300" type="audio/x-pn-realaudio-plugin" console="ClipNN" loop="true" autostart="true" controls="ImageWindow,ControlPanel" border="1" vspace="0" hspace="0"></EMBED><br /><STRONG><A href="\1">下载当前视频文件</A></STRONG></center>',
		"MEDIAPLAYER"	=> '<center><object classid="clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95" width="400" height="300"><param name="ShowStatusBar" value="-1"><param name="Filename" value="\1"><embed type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" flename="mp" src="\1" width="400" height="300"></embed></object><br /><STRONG><A href="\1">下载当前视频文件</A></STRONG></center>',
		"LIST"		=> 'exec:$this->get_list_html(\'\1\')',
		"TBL"		=> 'exec:$this->get_tbl_html(\'\1\')',
		);
	public $HTC_list_att = array(
		"ALIGN"		=> '<div align="\1">\2</div>',
		"URL"		=> '<a href="\1" target="_blank">\2</a>',
		"EMAIL"		=> '<a href="mailto:\1">\2</a>',
		"IMG"		=> '<img alt="\1" src="\2" border="0" onclick="window.open(this.src)" style="cursor:pointer; border:1px black solid" />',
		"FONT"		=> '<font face="\1">\2</font>',
		"COLOR"		=> '<font color="\1">\2</font>',
		"SIZE"		=> '<font size="\1">\2</font>',
		"LIST"		=> 'exec:$this->get_list_html(\'\2\', \'\1\')',
		"TBL"		=> 'exec:$this->get_tbl_html(\'\2\', \'\1\')',
		);
	public $HTC_list_spl = array(
		"PHP"		=> 'exec:$this->get_highlight_html(\'\1\', "php")',
		"CSS"		=> 'exec:$this->get_highlight_html(\'\1\', "css")',
		"HTML"		=> 'exec:$this->get_highlight_html(\'\1\', "html")',
		"SCRIPT"	=> 'exec:$this->get_highlight_html(\'\1\', "script")',
		"CODE"		=> 'exec:$this->get_code_html(\'\1\')',
		"EXECUTE"	=> '\1',
		);

	public function __construct($str = "", $transURL = true, $ignoreList = "", $nestingParse = false) {
		$this->HTC_str = $str;
		$this->HTC_transURL = $transURL;
		$this->HTC_ignoreList = ",".str_replace(" ","",$ignoreList).",";
		$this->HTC_nestingParse = $nestingParse;
	}

	public function watermark_setting($watermark = true, $disturb = "", $creditStr = "", $url = "") {
		$this->HTC_watermark = $watermark;
		$this->HTC_watermark_url = $url;
		if(!empty($disturb)) $this->HTC_watermark_disturb = explode(",",$disturb);
		$this->HTC_watermark_creditStr = $creditStr;
	}

	public function Parse() {
		$this->HTC_str = preg_replace("/\[(\/)?watermark\]/i","",$this->HTC_str);
		$this->HTC_str = preg_replace("/\[(\/)?RM\]/i","[\\1REALPLAYER]",$this->HTC_str);
		$this->HTC_str = preg_replace("/\[(\/)?WMV\]/i","[MEDIAPLAYER\\1]",$this->HTC_str);
		$this->HTC_str = preg_replace("/\[(\/)?face/i","[\\1font",$this->HTC_str);
		$this->HTC_str = preg_replace("/\[(\/)?table/i","[\\1tbl",$this->HTC_str);

		if(empty($this->HTC_str)) return "";
		$this->HTC_str = preg_replace("/(\[\w+(=[^\]]+?)\])(\s+)/ixs","\\1",$this->HTC_str);
		$this->HTC_str = preg_replace("/(\s+)(\[\/\w+\])/ixs","\\2",$this->HTC_str);

		foreach($this->HTC_list_spl as $key => $value) {
			if(strpos(strtoupper($this->HTC_ignoreList), ",".strtoupper($key).",") !== false) continue;
			preg_match_all("/\[$key\](.*)\[\/$key\]/ixsU", $this->HTC_str, $arr_tmp);
			$arr_spl[$key] = $arr_tmp[0];
			$max_count = count($arr_spl[$key]);
			for($i=0; $i<$max_count; $i++) {
				$this->HTC_str = str_replace($arr_spl[$key][$i], "||::{$key}_{$i}::||", $this->HTC_str);
				if(substr($value,0,5)=="exec:"){
					$arr_spl[$key][$i] = preg_replace("/\[$key\](.*)\[\/$key\]/iexsU", substr($value,5), $arr_spl[$key][$i]);
				} else {
					$arr_spl[$key][$i] = preg_replace("/\[$key\](.*)\[\/$key\]/ixsU", "$value", $arr_spl[$key][$i]);
				}
			}
		}
		$this->HTC_str = $this->html_trans($this->HTC_str);
		$this->HTC_str = $this->htc2html($this->HTC_str);
		if($this->HTC_transURL) $this->HTC_str = $this->link_url($this->HTC_str);
		foreach($this->HTC_list_spl as $key => $value) {
			if(strpos(strtoupper($this->HTC_ignoreList), ",".strtoupper($key).",") !== false) continue;
			$max_count = count($arr_spl[$key]);
			for($i=0; $i<$max_count; $i++) {
				$this->HTC_str = str_replace("||::{$key}_{$i}::||", $arr_spl[$key][$i], $this->HTC_str);
			}
		}
		return;
	}

	public function htc2htm_ext($str) {
		if(get_magic_quotes_gpc()) $str = stripslashes($str);
		return $str;
	}

	public function htc2html($str) {
		if(get_magic_quotes_gpc()) $str = stripslashes($str);
		foreach($this->HTC_list as $key => $value) {
			if(strpos(strtoupper($this->HTC_ignoreList), ",".strtoupper($key).",") !== false) continue;
			while(preg_match("/\[$key\](.*)\[\/$key\]/ixs", $str)) {
				if(substr($value,0,5)=="exec:"){
					if($this->HTC_nestingParse) {
						$str = preg_replace("/\[$key\]((.(?!\[$key(\s?=\s?([^\]]+))?\]))*)\[\/$key\]/iexsU", substr($value,5), $str);
					} else {
						$str = preg_replace("/\[$key\](.*)\[\/$key\]/iexsU", substr($value,5), $str);
					}
				} else {
					if($this->HTC_nestingParse) {
						$str = preg_replace("/\[$key\]((.(?!\[$key(\s?=\s?([^\]]+))?\]))*?)\[\/$key\]/ixsU", "$value", $str);
					} else {
						$str = preg_replace("/\[$key\](.*)\[\/$key\]/ixsU", "$value", $str);
					}
				}
			}
		}
		foreach($this->HTC_list_att as $key => $value) {
			if(strpos(strtoupper($this->HTC_ignoreList), ",".strtoupper($key).",") !== false) continue;
			while(preg_match("/\[$key\s?=\s?([^\]]+)\](.*)\[\/$key\]/ixs", $str)) {
				if(substr($value,0,5)=="exec:"){
					if($this->HTC_nestingParse) {
						$str = preg_replace("/\[$key\s?=\s?([^\]]*)\]((.(?!\[$key(\s?=\s?([^\]]+))?\]))*)\[\/$key\]/iesxU", substr($value,5), $str);
					} else {
						$str = preg_replace("/\[$key\s?=\s?([^\]]*)\](.*)\[\/$key\]/iesxU", substr($value,5), $str);
					}
				} else {
					if($this->HTC_nestingParse) {
						$str = preg_replace("/\[$key\s?=\s?([^\]]*)\]((.(?!\[$key(\s?=\s?([^\]]+))?\]))*)\[\/$key\]/isxU", "$value", $str);
					} else {
						$str = preg_replace("/\[$key\s?=\s?([^\]]*)\](.*)\[\/$key\]/isxU", "$value", $str);
					}
				}
			}
		}
		$str = $this->htc2htm_ext($str);
		return $str;
	}

	public function get_code_html($str) {
		if(get_magic_quotes_gpc()) $str = stripslashes($str);
		return "
		<table align='center' width='550'>
		  <tr><td><textarea cols='80' rows='10' name=Code>".htmlspecialchars($str)."</textarea><br />
		    <input type='button' value='运行代码' onClick=\"str=this.parentNode.firstChild.value;code_win=window.open('about:blank');doc=code_win.document;doc.open();doc.write(str);doc.close();code_win.focus();\">
		    <input type='button' value='复制代码' onclick=\"try{window.clipboardData.setData('text',this.parentNode.firstChild.value);alert('Save Codez To The Clipboard !');}catch(e){alert('Please Copy The Selected Codez !');this.parentNode.firstChild.select();}\">
		    <input type='button' value='保存代码' onClick=\"str=this.parentNode.firstChild.value;code_win=window.open('about:blank','_blank','top=10000');code_win.document.writeln(str);code_win.document.execCommand('saveas','','code.html');code_win.close();\">
		    （提示:可以先修改部分代码）
		  </td></tr>
		</table>";
	}

	public function get_highlight_html($str, $type = "") {
		$result = "
		<center><table border='0' width='90%' cellspacing='0' cellpadding='0'>
		<tr><td>代码高亮显示：</td></tr>
		<tr><td>
		  <table width='100%' class='quote'><tr><td>
		  ".$this->html_trans($str)."
		  </td></tr></table>
		<input type='button' value='复制代码' onclick=\"try{window.clipboardData.setData('text',this.parentNode.firstChild.innerText);alert('Save Codez To The Clipboard !');}catch(e){alert('Codez Copy Failed !');}\">
		<input type='button' value='保存代码' onClick=\"try{str=this.parentNode.firstChild.innerText;code_win=window.open('about:blank','_blank','top=10000');code_win.document.writeln(str);code_win.document.execCommand('saveas','','code.html');code_win.close();}catch(e){alert('Codez Save Failed !');}\">
		</td></tr>
		</table></center>
		";
		return $result;
	}

	public function get_list_html($content, $type = "") {
		$content = preg_replace("/(<br \/>)?[\r\n]+/", "\n", $content);
		$content = preg_replace("/[\r\n]+/", "\n", $content);
		$content = preg_replace("/^[\n]*(.*)[\n]*$/m", "\\1", $content);
		$content = str_replace("\n", "</li><li>", $content);
		$content = "<ul type='$type'><li>$content</li></ul>\n";
		return $content;
	}

	public function modi_multiline($code) {
		if(get_magic_quotes_gpc()) $code = stripslashes($code);
		$code = preg_replace("/^(\n+)?(.+?)(\n+)?$/s", "\\2", $code);
		$code = str_replace("\n", "<!--newLine-->", $code);
		return $code;
	}

	public function get_tbl_html($code, $align = "center") {
		$code = str_replace("\r","",$code);
		$code = str_replace("<br />\n", "\n", $code);
		$code = preg_replace("/\[\:\:(.+?)\:\:\]/es","\$this->modi_multiline('\\1')", $code);
		$temp = split("\n", $code);
		$line = array();
		$max_row = 0;
		$max_col = 0;
		$max_count = count($temp);
		for($i=0; $i<$max_count; $i++) {
			if(preg_replace("/\s+/", "", $temp[$i]) != "") {
				$this_line = preg_split("/\t|,/",$temp[$i]);
				if(count($this_line)>$max_col) $max_col = count($this_line);
				$line[] = $this_line;
			}
		}
		$max_row = count($line);
		$result = "<table align='center' width=90% border=1 cellSpacing=2 cellPadding=4 class='tbl_show'>\n";
		$rowspan = 0;
		for($i=0; $i<$max_row; $i++) {
			if(preg_match("/^\[(#?[\w]{3,8})\]/", $line[$i][0], $matches)) {
				if(strtolower($matches[1])!="img" && strtolower($matches[1])!="quote" && strtolower($matches[1])!="url" && strtolower($matches[1])!="image") {
					$line[$i][0] = str_replace("[{$matches[1]}]", "", $line[$i][0]);
					$result .= "<tr align='{$align}' bgColor='{$matches[1]}'>\n";
				} else {
					$result .= "<tr align='{$align}'>\n";
				}
			} else {
				$result .= "<tr align='{$align}'>\n";
			}
			if($i==0) {
				if(preg_match("/^\[([\d]{1,2})\]/", $line[$i][0], $matches)) {
					$line[$i][0] = str_replace("[{$matches[1]}]", "", $line[$i][0]);
					$rowspan = $matches[1];
				}
			} else {
				if($rowspan!=0 && $rowspan>$i) {
					if($i==1) $max_col -= 1;
				} else {
					if($i==$rowspan) $max_col += 1;
					$rowspan = 0;
				}
			}
			for($j=0; $j<$max_col; $j++) {
				$colspan = 1;
				if(isset($line[$i][$j])) {
					$value = $line[$i][$j];
					while($j<$max_col-1) {
						if(isset($line[$i][$j+1])) {
							if(empty($line[$i][$j+1])) {
								$colspan++;
								$j++;
							} else {
								break;
							}
						} else {
							$colspan++;
							$j++;
						}
					}
				} else {
					$value = "&nbsp;";
				}
				$the_width = "";
				if(preg_match("/^\[([\d]{2,3})\]/", $value, $matches)) {
					$value = str_replace("[{$matches[1]}]", "", $value);
					$the_width = "width='{$matches[1]}'";
				}
				$value = str_replace("<!--newLine-->", "<br />\n", $value);
				if($i==0 && $j==0 && $rowspan!=0) {
					$result .= "<td rowspan='{$rowspan}' colspan='{$colspan}' {$the_width}>{$value}</td>\n";
				} else {
					$result .= "<td colspan='{$colspan}' {$the_width}>{$value}</td>\n";
				}
			}
			$result .= "</tr>\n";
		}
		$result .= "</table>\n";
		return $result;
	}

	public function html_trans($str) {
		$search  = array("'",		"\"",		"<",	">",	"  ",		"\t");
		$replace = array("&#39;",	"&quot;",	"&lt;",	"&gt;",	"&nbsp; ",	"&nbsp; &nbsp; ");
		return nl2br(trim(str_replace($search, $replace, $str)));
	}

	public function link_url($str) {
		$str = preg_replace("/(^|[^'\"=>])((http|https|ftp|mms|rtsp|pnm|mailto):\/\/[\w@:\.\/\?=&;#\-%]+)/i", '\1<a href="\2" target="_blank">\2</a>', $str);
		$str = preg_replace("/(^|[^'\"=>])(\w+@(\w+\.)+[\w]{2,3})/i", '\1<a href="mailto:\2">\2</a>', $str);
		return $str;
	}

	public function RndKey($lng, $scope=1){
		//Coded By Windy200020020501 v1.0
		$Rnd_Key	= "";
		$char_list	= array();
		$char_list[]	= "1234567890";
		$char_list[]	= "abcdefghijklmnopqrstuvwxyz";
		$char_list[]	= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$char_list[]	= "!@^()_:+\-";
		if($scope > count($char_list)-1) $scope = count($char_list)-1;
		if($scope>=0 && $scope<count($char_list)) {
			for($i=1; $i<=$lng; $i++){
				$Rnd_Str  = $char_list[mt_rand(1,$scope) - 1];
				$Rnd_Key .= substr($Rnd_Str, mt_rand(0,strlen($Rnd_Str)-1), 1);
			}
		} else {
			for($i=1; $i<=$lng; $i++){
				$Rnd_Key .= mt_rand(1, 10)>8 ? $this->HTC_watermark_disturb[mt_rand(0,count($this->HTC_watermark_disturb) - 1)] : chr(mt_rand(0xb0,0xe0)).chr(mt_rand(0xa0,0xff));
			}
		}
		return $Rnd_Key;
	}

	public function watermark($code, $creditStr=" - Watermark Made by Windy2000", $url=""){
		//Coded By Windy200020041202 v2.0
		if(!empty($this->HTC_watermark_creditStr)) $creditStr = $this->HTC_watermark_creditStr;
		if(!empty($this->HTC_watermark_url)) $url = $this->HTC_watermark_url;
		$file_line = preg_split("/<br( +\/)?>/", $code);
		$max_count = count($file_line);
		for($i=0; $i<$max_count; $i++) {
			$this_str = "";
			preg_match_all("/((<([^>]+?)>)|(&[\w#]+;)|(\|\|::[a-z]+_\d{1,2}::\|\|))/isU", $file_line[$i], $arr_tag);
			$arr_tag = $arr_tag[0];
			$file_line[$i] = str_replace($arr_tag, chr(0), $file_line[$i]);
			preg_match_all("/[\x80-\xff]?./", $file_line[$i], $arr_char);
			$arr_char = $arr_char[0];
			$max_count2 = count($arr_char);
			for($j=0; $j<$max_count2; $j++) {
				if(ord($arr_char[$j])==0) {
					$this_str .= array_shift($arr_tag);
				} elseif(mt_rand(1, 10)>9) {
					$this_str .= "<span class=watermark>".$this->RndKey(mt_rand(1, 2),-1)."</span>".$arr_char[$j];
				} else {
					$this_str .= $arr_char[$j];
				}

			}
			$this_str .= "<span class=watermark>".$this->RndKey(mt_rand(1, 4),-1)." </span>";
			$file_line[$i] = $this_str.((mt_rand(1, 10)>8 && !empty($url))?"<a href='{$url}' target='_blank'>(HIT)</a>":"<span class=watermark>{$creditStr}</span>");
		}
		return join("<br />\n", $file_line);
	}

	public function get_watermark_html() {
		$str = $this->HTC_str;
		if($this->HTC_watermark) {
			if(preg_match("/<textarea/i", $str)) {
				preg_match_all("/<textarea.+<\/textarea>/ixsU", $str, $arr_tmp);
				$arr_tmp = $arr_tmp[0];
				$max_count = count($arr_tmp);
				for($i=0; $i<$max_count; $i++) {
					$str = str_replace($arr_tmp[$i], "||::textarea_{$i}::||", $str);
				}
				$str = $this->watermark($str);
				for($i=0; $i<$max_count; $i++) {
					$str = str_replace("||::textarea_{$i}::||", $arr_tmp[$i], $str);
				}
			} else {
				$str = $this->watermark($str);
			}
		}
		return $str;
	}

	public function get_result() {
		return $this->get_watermark_html();
	}
}


class HTC_Parser_Highlight extends HTC_Parser {
	public function __construct($str = "", $transURL = true, $ignoreList = "", $nestingParse = false) {
		$this->HTC_str = $str;
		$this->HTC_transURL = $transURL;
		$this->HTC_ignoreList = $ignoreList;
		$this->HTC_nestingParse = $nestingParse;
	}
	public function get_highlight_html($str, $type = "php") {
		$type = strtolower($type);
		$result = "<center><table border='0' width='90%' cellspacing='0' cellpadding='0'>";
		$result .= "
		<tr><td>高亮显示 <font color='red'>".strtoupper($type)."</font> 代码：</td></tr>
		<tr><td>
		  <table width='100%' class='quote'><tr><td>
		  ";
		switch ($type) {
			case "html":
				$result .= $this->html_highlight($str);
				break;
			case "css":
				$result .= $this->css_highlight($str);
				break;
			case "script":
				$result .= $this->script_highlight($str);
				break;
			case "php":
				$result .= $this->php_highlight($str);
				break;
		}
		$result .= "
		  </td></tr></table>
		".($type=="html"?"<input type='button' value='运行代码' onclick=\"str=this.parentNode.firstChild.innerText;if(str==undefined){alert('Execute Codez Failed !');return;}code_win=window.open('about:blank');doc=code_win.document;doc.open();doc.write(str);doc.close();code_win.focus();\" />":"")."
		<input type='button' value='复制代码' onclick=\"try{window.clipboardData.setData('text',this.parentNode.firstChild.innerText);alert('Save Codez To The Clipboard !');}catch(e){alert('Codez Copy Failed !');}\">
		<input type='button' value='保存代码' onClick=\"try{str=this.parentNode.firstChild.innerText;code_win=window.open('about:blank','_blank','top=10000');code_win.document.writeln(str);code_win.document.execCommand('saveas','','code.html');code_win.close();}catch(e){alert('Codez Save Failed !');}\">
		</td></tr>
		</table></center>
		";
		return $result;
	}

	public function php_highlight($str) {
		if(get_magic_quotes_gpc()) $str = stripslashes($str);
		return highlight_string($str, true);
	}

	public function css_highlight($str, $nl = true) {
		$color_1 = "red";
		$color_2 = "green";
		$color_3 = "blue";
		if(get_magic_quotes_gpc()) $str = stripslashes($str);
		$str = str_replace("\r", "", $str);
		preg_match_all("/[\\\*\.\w#: ]+\{[^\{\}]+\}/", $str, $arr_css);
		$arr_css = $arr_css[0];
		$max_count = count($arr_css);
		for($i=0; $i<$max_count; $i++) {
			$head = preg_replace("/([\\\*\.\w#: ]+\{)[^\{\}]+\}/", "<font color='{$color_1}'>\\1</font>".($nl?"<br />\n":""), $arr_css[$i]);
			$unit = preg_replace("/[\\\*\.\w#: ]+\{([^\{\}]+)\}/", "\\1", $arr_css[$i]);
			$unit_list = preg_split("/;\s*/", $unit);
			$unit = "\n";
			$max_count2 = count($unit_list);
			for($j=0; $j<$max_count2; $j++) {
				if(strlen($unit_list[$j])>0)
					$unit .= "&nbsp; &nbsp; " . preg_replace("/\s*([\w\-]+)\s*:\s*(.*)/e", "'<font color=\'{$color_2}\'>\\1</font> : <font color=\'{$color_3}\'>'.htmlspecialchars('\\2').'</font> ; '", $unit_list[$j]) . ($nl?"<br />\n":"\n");
			}
			$arr_css[$i] = $head . $unit . "<font color='{$color_1}'>}</font>";
		}
		return join(($nl?"\n<br /><br />\n":"\n\n"), $arr_css);
	}

	public function script_highlight_note($str, $mode = true) {
		$color_note = "gray";
		if(get_magic_quotes_gpc()) $str = stripslashes($str);
		$str = preg_replace("/<font color='[a-z]+'>(.*)<\/font>/isU", "\\1", $str);
		$str = $mode?"/*{$str}*/":"//{$str}";
		return "<font color='{$color_note}'>{$str}</font>";
	}

	public function script_highlight($str, $nl = true) {
		$color_1 = "red";
		$color_2 = "blue";
		$color_3 = "brown";
		$color_4 = "green";
		if(get_magic_quotes_gpc()) $str = stripslashes($str);
		$str = htmlspecialchars($str);
		$str = str_replace("=","&equal;",$str);
		$str = str_replace("|","&vertical;",$str);
		$keywords = array(
				"{$color_1}"	=> array("null", "true", "false", "NaN"),
				"{$color_2}"	=> array("var", "for", "if", "else", "switch", "case", "function", "loop", "continue", "break", "&lt;", "&gt;", "!&equal;", "&equal;&equal;", "&equal;", "&amp;&amp;", "&vertical;&vertical;"),
				"{$color_3}"	=> array("window", "self", "this", "event", "document", "opener", "Navigator", "Math", "Array", "String", "Object", "Function", "Number"),
				);
		foreach($keywords as $key => $value) {
			$max_count = count($value);
			for($i=0; $i<$max_count; $i++) {
				$str = preg_replace("/(\W)(".$value[$i].")(\W)/", "\\1<font color='{$key}'>\\2</font>\\3", $str);
			}
		}
		$str = preg_replace("/(\.|\s)([a-z]+)\(/i" ,"\\1<font color='{$color_4}'>\\2</font>(", $str);
		$str = preg_replace("/\.(\w+)(?!\()/i" ,".<font color='{$color_3}'>\\1</font>", $str);
		$str = preg_replace("/\/\/([^\n]*)\n/e" ,'$this->script_highlight_note("\1", false)', $str);
		$str = preg_replace("/\/\*(.*?)\*\//es" ,'$this->script_highlight_note("\1")', $str);
		$str = str_replace("\t", "&nbsp; &nbsp; ", $str);
		$str = str_replace("&equal;","=",$str);
		$str = str_replace("&vertical;","|",$str);
		return $nl?nl2br($str):$str;
	}

	public function html_highlight_attr($att) {
		$color_1 = "red";
		$color_2 = "brown";
		$color_3 = "black";
		$att = str_replace("\\\"","\"",$att);
		$att = str_replace("\"\"","\" \"",$att);
		preg_match_all("/\s*\w+(\s*=\s*((([\"']).*?[^\\\\]{1}\\4)|\w+))?\s*/is", $att, $att_list);
		$att_list = $att_list[0];
		$max_count = count($att_list);
		for($i=0; $i<$max_count; $i++) {
			$att_list[$i] = str_replace("\" \"","\"\"",$att_list[$i]);
			$att_list[$i] = preg_replace("/(\s*)(\w+)((\s*=\s*)((([\"']).*?[^\\\\]{1}\\7)|\w+))?(\s*)/is", "\\1<font color='{$color_2}'>\\2</ font><font color='{$color_1}'>\\4</ font><font color='{$color_3}'>\\5</ font>\\8", $att_list[$i]);
		}
		return join("", $att_list);
	}

	public function html_highlight($str) {
		$color_1 = "red";
		$color_2 = "blue";
		$color_3 = "gray";
		if(get_magic_quotes_gpc()) $str = stripslashes($str);
		preg_match_all("/<script([^>]*)>(.*)<\/script>/isU", $str, $arr_tmp);
		$arr_script = $arr_tmp[0];
		$max_count = count($arr_script);
		for($i=0; $i<$max_count; $i++) {
			$str = str_replace($arr_script[$i], "||::script_{$i}::||", $str);
			$arr_script[$i] = preg_replace("/<script([^>]*)>(.*)<\/script>/iseU", "'<font color=\'{$color_2}\'>&lt;SCRIPT '.\$this->html_highlight_attr('\\1').'&gt;</font><br />'.\$this->script_highlight(str_replace('\\\"','\"','\\2'), false).'<font color=\'{$color_2}\'>&lt;/SCRIPT&gt;</font>'", $arr_script[$i]);
		}
		$str = preg_replace("/(<textarea[^>]*>)(.*)(<\/textarea>)/ieU" ,"'\\1'.htmlspecialchars('\\2').'\\3'", $str);
		$str = preg_replace("/<!\-\-(.*)\-\->/seU" ,"'<!--'.htmlspecialchars('\\1').'-->'", $str);
		$str = preg_replace("/<style([^>]*)>(.*)<\/style>/isU" ,"<!style\\1>\\2</style!>", $str);

		if($this->HTC_nestingParse)
			$str = preg_replace("/<((\w+:)?\w+)\s*(((\w+(\s*=\s*(([\"']?)[^\\8]*?\\8))?)|\s)*?)(\/\s*)?>/ise", "'<font color=\'{$color_2}\'>&lt;\\1 '.\$this->html_highlight_attr('\\3').'\\9&gt;</ font>'", $str);
		else
			$str = preg_replace("/<((\w+:)?\w+)\s*(.*?)(\/\s*)?>/ise" ,"'<font color=\'{$color_2}\'>&lt;\\1 '.\$this->html_highlight_attr('\\3').'\\4&gt;</ font>'", $str);

		$str = preg_replace("/<(\/((\w+:)?\w+))>/i" ,"<font color='{$color_2}'>&lt;\\1&gt;</font>", $str);
		$str = preg_replace("/<(!\-\-.*\-\-)>/sU" ,"<font color='{$color_3}'>&lt;\\1&gt;</font>", $str);
		$str = preg_replace("/<!style([^>]*)>(.*)<\/style!>/iseU" ,"'<font color=\'{$color_2}\'>&lt;STYLE '.\$this->html_highlight_attr('\\1').'&gt;</font><br />'.\$this->css_highlight(str_replace('\\\"','\"','\\2'), false).'<br /><font color=\'{$color_2}\'>&lt;/STYLE&gt;</font>'", $str);
		$max_count = count($arr_script);
		for($i=0; $i<$max_count; $i++) {
			$str = str_replace("||::script_{$i}::||", $arr_script[$i], $str);
		}
		$str = str_replace("</ font>", "</font>", $str);
		$str = str_replace("</ b>", "</b>", $str);
		$str = str_replace(" &gt;", "&gt;", $str);
		$str = str_replace("  "," &nbsp;",$str);
		$str = str_replace("\t"," &nbsp; &nbsp;",$str);
		return nl2br($str);
	}
}


class HTC_Parser_Append extends HTC_Parser {
	public $HTC_list_ext = array(
		"IMAGE"		=> '<img src="\1" border="0" style="cursor:pointer; border:1px black solid" />',
		"DOWNLOAD"	=> 'exec:$this->get_dl_html(\'\1\')',
		);

	public $HTC_list_att_ext = array(
		"IMAGE"		=> '<img alt="\1" src="\2" border="0" style="cursor:pointer; border:1px black solid" />',
		"DOWNLOAD"	=> 'exec:$this->get_dl_html(\'\1\', \'\2\')',
		"ATTACH"	=> 'exec:$this->get_attach_html(\'\2\', \'\1\')',
		);

	public function __construct($str = "", $transURL = true, $ignoreList = "", $nestingParse = false) {
		$this->HTC_str = $str;
		$this->HTC_transURL = $transURL;
		$this->HTC_ignoreList = $ignoreList;
		$this->HTC_nestingParse = $nestingParse;
		$this->HTC_list = array_merge($this->HTC_list_ext, $this->HTC_list);
		$this->HTC_list_att = array_merge($this->HTC_list_att_ext, $this->HTC_list_att);
	}

	public function htc2htm_ext($str) {
		if(get_magic_quotes_gpc()) $str = stripslashes($str);
		foreach($this->HTC_list_ext as $key => $value) {
			if(strpos(strtoupper($this->HTC_ignoreList), ",".strtoupper($key).",") !== false) continue;
			while(preg_match("/\[$key\](.*)\[\/$key\]/ixs", $str)) {
				if(substr($value,0,5)=="exec:"){
					if($this->HTC_nestingParse)
						$str = preg_replace("/\[$key\]((.(?!\[$key(\s?=\s?([^\]]+))?\]))*)\[\/$key\]/iexsU", substr($value,5), $str);
					else
						$str = preg_replace("/\[$key\](.*)\[\/$key\]/iexsU", substr($value,5), $str);
				} else {
					if($this->HTC_nestingParse)
						$str = preg_replace("/\[$key\]((.(?!\[$key(\s?=\s?([^\]]+))?\]))*?)\[\/$key\]/ixsU", "$value", $str);
					else
						$str = preg_replace("/\[$key\](.*)\[\/$key\]/ixsU", "$value", $str);
				}
			}
		}
		foreach($this->HTC_list_att_ext as $key => $value) {
			if(strpos(strtoupper($this->HTC_ignoreList), ",".strtoupper($key).",") !== false) continue;
			while(preg_match("/\[$key\s?=\s?([^\]]+)\](.*)\[\/$key\]/ixs", $str)) {
				if(substr($value,0,5)=="exec:"){
					if($this->HTC_nestingParse)
						$str = preg_replace("/\[$key\s?=\s?([^\]]*)\]((.(?!\[$key(\s?=\s?([^\]]+))?\]))*)\[\/$key\]/iesxU", substr($value,5), $str);
					else
						$str = preg_replace("/\[$key\s?=\s?([^\]]*)\](.*)\[\/$key\]/iesxU", substr($value,5), $str);
				} else {
					if($this->HTC_nestingParse)
						$str = preg_replace("/\[$key\s?=\s?([^\]]*)\]((.(?!\[$key(\s?=\s?([^\]]+))?\]))*)\[\/$key\]/isxU", "$value", $str);
					else
						$str = preg_replace("/\[$key\s?=\s?([^\]]*)\](.*)\[\/$key\]/isxU", "$value", $str);
				}
			}
		}
		
		//additional
		$str = preg_replace("/\[swf\](\S+?)\[\/swf\]/is","<OBJECT CLASSID=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" WIDTH=400 HEIGHT=300><PARAM NAME=MOVIE VALUE=\\1><PARAM NAME=PLAY VALUE=TRUE><PARAM NAME=LOOP VALUE=TRUE><PARAM NAME=QUALITY VALUE=HIGH><EMBED SRC=\\1 WIDTH=400 HEIGHT=300 PLAY=TRUE LOOP=TRUE QUALITY=HIGH></EMBED></OBJECT><br />[<a target=_blank href=\\1>全屏播放</a>]",$str);
		$str = preg_replace("/(\[swf=)(\S+?)([\,\| ]+)(\S+?)(\])(\S+?)(\[\/swf\])/is","<OBJECT CLASSID=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" WIDTH=\\2 HEIGHT=\\4><PARAM NAME=MOVIE VALUE=\\6><PARAM NAME=PLAY VALUE=TRUE><PARAM NAME=LOOP VALUE=TRUE><PARAM NAME=QUALITY VALUE=HIGH><EMBED SRC=\\6 WIDTH=\\2 HEIGHT=\\4 PLAY=TRUE LOOP=TRUE QUALITY=HIGH></EMBED></OBJECT><br />[<a target=_blank href=\\6>全屏播放</a>]", $str);
		return $str;
	}

	public function get_file_pic($filename) {
		global $root_path, $web_url;
		$ext = str_replace(".","",strrchr($filename,"."));
		$pic = $web_url."/images/mime_type/{$ext}.gif";
		return file_exists($root_path.$pic) ? $pic : "{$web_url}/images/mime_type/attch.gif";
	}

	public function get_dl_html($filename, $str = "") {
		return "<img src='".get_file_pic($filename)."' border='0'> <a href='$filename'>".(empty($str)?basename($filename):$str)."</a>";
	}

	public function get_attach_html($filename, $id) {
		global $web_url;
		$ext = strrchr($filename, ".");
		$add_str = $web_url."/files?$id";
		switch(strtolower($ext)) {
			case ".jpeg":
			case ".jpg":
			case ".gif":
			case ".png":
			case ".bmp":
				$add_str = "[image=".str_replace($ext, "", $filename)."]{$add_str}[/image]";
				break;
			case ".wav":
			case ".mid":
			case ".mp3":
			case ".mp2":
				$add_str = "[music]{$add_str}[/music]";
				break;
			case ".wma":
			case ".wmv":
			case ".avi":
			case ".asx":
			case ".asf":
			case ".mpg":
			case ".mpeg":
				$add_str = "[mediaplayer]{$add_str}[/mediaplayer]";
				break;
			case ".rm":
			case ".ram":
			case ".rmvb":
				$add_str = "[realplayer]{$add_str}[/realplayer]";
				break;
			case ".qt":
			case ".mov":
				$add_str = "[quicktime]{$add_str}[/quicktime]";
				break;
			case ".swf":
				$add_str = "[flash]{$add_str}[/flash]";
				break;
			case ".dcr":
				$add_str = "[shockwave]{$add_str}[/shockwave]";
				break;
			default:
				$add_str = "<img src='".$this->get_file_pic($filename)."' border='0'> <a href='{$add_str}'>$filename</a>";
		}
		return $add_str;
	}

	public function get_result() {
		return $this->get_watermark_html();
	}
}
?>