<?php
/**************************************************
*                                                 *
* Name    : Html Transfer Code Parser (HTC)       *
* Version : 2.4.1                                 *
* Author  : Windy2000                             *
* Create  : 2003-09-03                            *
* Modified: 2004-01-15                            *
* Email   : Windy2000@126.com                     *
* HomePage: www.mysteps.cn                        *
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
	protected
		$HTC_str = "",
		$HTC_transURL = true,
		$HTC_ignoreList = "",
		$HTC_nestingParse = false,
		$HTC_watermark = false,
		$HTC_watermark_url = "",
		$HTC_watermark_disturb = array("windy2000"),
		$HTC_watermark_creditStr = "",
		$HTC_list = array(
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
		),
		$HTC_list_att = array(
			"ALIGN"		=> '<div align="\1">\2</div>',
			"URL"		=> '<a href="\1" target="_blank">\2</a>',
			"EMAIL"		=> '<a href="mailto:\1">\2</a>',
			"IMG"		=> '<img alt="\1" src="\2" border="0" onclick="window.open(this.src)" style="cursor:pointer; border:1px black solid" />',
			"FONT"		=> '<font face="\1">\2</font>',
			"COLOR"		=> '<font color="\1">\2</font>',
			"SIZE"		=> '<font size="\1">\2</font>',
			"LIST"		=> 'exec:$this->get_list_html(\'\2\', \'\1\')',
			"TBL"		=> 'exec:$this->get_tbl_html(\'\2\', \'\1\')',
		),
		$HTC_list_spl = array(
			"PHP"		=> 'exec:$this->get_highlight_html(\'\1\', "php")',
			"CSS"		=> 'exec:$this->get_highlight_html(\'\1\', "css")',
			"HTML"		=> 'exec:$this->get_highlight_html(\'\1\', "html")',
			"SCRIPT"	=> 'exec:$this->get_highlight_html(\'\1\', "script")',
			"CODE"		=> 'exec:$this->get_code_html(\'\1\')',
			"EXECUTE"	=> '\1',
		);

	public function __construct() {
		$argList = func_get_args();
		if(count($argList)>0 ){
			call_user_func_array(array($this, "init"), $argList);
		} else {
			call_user_func(array($this, "init"));
		}
		return;
	}
	
	public function init($str = "", $transURL = true, $ignoreList = "", $nestingParse = false) {
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

	protected function htc2html($str) {
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
		return $str;
	}

	protected function get_code_html($str) {
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

	protected function get_highlight_html($str, $type = "") {
		return "
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
	}

	protected function get_list_html($content, $type = "") {
		$content = preg_replace("/(<br \/>)?[\r\n]+/", "\n", $content);
		$content = preg_replace("/[\r\n]+/", "\n", $content);
		$content = preg_replace("/^[\n]*(.*)[\n]*$/m", "\\1", $content);
		$content = str_replace("\n", "</li><li>", $content);
		$content = "<ul type='$type'><li>$content</li></ul>\n";
		return $content;
	}

	protected function modi_multiline($code) {
		$code = preg_replace("/^(\n+)?(.+?)(\n+)?$/s", "\\2", $code);
		$code = str_replace("\n", "<!--newLine-->", $code);
		return $code;
	}

	protected function get_tbl_html($code, $align = "center") {
		$code = str_replace("\r","",$code);
		$code = str_replace("<br />\n", "\n", $code);
		$code = preg_replace("/\[\:\:(.+?)\:\:\]/es","\$this->modi_multiline('\\1')", $code);
		$temp = explode("\n", $code);
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

	protected function html_trans($str) {
		$search  = array("'",		"\"",		"<",	">",	"  ",		"\t");
		$replace = array("&#39;",	"&quot;",	"&lt;",	"&gt;",	"&nbsp; ",	"&nbsp; &nbsp; ");
		return nl2br(trim(str_replace($search, $replace, $str)));
	}

	protected function link_url($str) {
		$str = preg_replace("/(^|[^'\"=>])((http|https|ftp|mms|rtsp|pnm|mailto):\/\/[\w@:\.\/\?=&;#\-%]+)/i", '\1<a href="\2" target="_blank">\2</a>', $str);
		$str = preg_replace("/(^|[^'\"=>])(\w+@(\w+\.)+[\w]{2,3})/i", '\1<a href="mailto:\2">\2</a>', $str);
		return $str;
	}

	protected function RndKey($lng, $scope=1){
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

	protected function watermark($code, $creditStr=" - Watermark Made by Windy2000", $url=""){
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

	protected function get_watermark_html() {
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
?>