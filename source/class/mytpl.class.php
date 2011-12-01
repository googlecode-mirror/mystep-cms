<?php
/********************************************
*                                           *
* Name    : My Template                     *
* Author  : Windy2000                       *
* Time    : 2010-12-12                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$tpl->init($tpl_info, $error_handle, $cache_setting)	// Set the Template Class
	$tpl->Set_Loop($key, $value, $fullset)											// Set values for loop-blocks (in turn or batch)
	$tpl->Set_If($key, $value)																	// Set the judging conditions for if-blocks
	$tpl->Set_Switch($key, $value)															// Set the switch conditions for switch-blocks
	$tpl->Set_Variable($name, $value)														// Set value for one variable
	$tpl->Set_Variables($values, $key, $reset)									// Set value for multiple variables or all variables
	$tpl->Get_TPL_Cache()																				// Make the executable php cache file for the current Template (cache file will be generate automaticly when the template file changed)
	$tpl->Reg_Tag($tag_name, $tag_func)													// Regist tag-parser for the custom tags
	$tpl->Reg_Tags($tag_list) 																	// Regist tag-parser for the custom tags in batch
	$tpl->Is_Cached()																						// Check if the current template with the define idx has been cached as a static html file
	$tpl->Read_Cache()																					// Directly get file content from cached html file
	$tpl->Get_Content($global_para)															// Get result content compile by the template engine ('$global_para' ara the parameters needed in php cache file)
	
	External Method : $tpl->GetFile, $tpl->WriteFile
--------------------------------------------------------------------------------------------------------------------*/

class MyTpl extends class_common {
	protected
		$tags = array(),
		$cache = array(
					'use' => false,
					'file' => '',
					'expire' => 300
			);
			
	public
		$allow_script = false,
		$hash = "",
		$delimiter_l = "<!--",
		$delimiter_r = "-->",
		$tpl_info = array();

	public function init($tpl_info, $cache_setting = false){
		if(!isset($tpl_info['idx'])) $tpl_info['idx'] = "";
		if(!isset($tpl_info['style'])) $tpl_info['style'] = "default";
		if(!isset($tpl_info['path'])) $tpl_info['path'] = "./";
		$this->tpl_info = $tpl_info;
		$this->tpl_info['file'] = $tpl_info['path']."/".$tpl_info['style']."/".$tpl_info['idx'].".tpl";
		if(!file_exists($this->tpl_info['file'])) $this->tpl_info['file'] = $tpl_info['path']."/default/".$tpl_info['idx'].".tpl";
		$this->tpl_info['content'] = $this->Get_TPL($this->tpl_info['file']);
		
		global $tpl_para;
		$this->hash = "t".substr(md5($this->tpl_info['file']), 0, 10);
		if(!isset($tpl_para[$this->hash])) {
			$tpl_para[$this->hash] = array();
			$tpl_para[$this->hash]['para'] = array();
			$tpl_para[$this->hash]['loop'] = array();
			$tpl_para[$this->hash]['if'] = array();
		}
		
		if($cache_setting) {
			$this->cache['use'] = true;
			if(!isset($cache_setting['idx'])) $cache_setting['idx'] = "";
			if(!isset($cache_setting['path'])) $cache_setting['path'] = "";
			if(!isset($cache_setting['ext'])) $cache_setting['ext'] = ".html";
			if(!isset($cache_setting['expire'])) $cache_setting['expire'] = 300;
			$this->cache['file'] = $cache_setting['path']."/".$cache_setting['idx'].$cache_setting['ext'];
			$this->cache['expire'] = $cache_setting['expire'];
		}
	}
	
	public function Set_Loop($key, $value, $fullset = false) {
		global $tpl_para;
		if($fullset) {
			$tpl_para[$this->hash]['loop'][$key] = $value;
		} else {
			if(!isset($tpl_para[$this->hash]['loop'][$key])) $tpl_para[$this->hash]['loop'][$key] = array();
			$tpl_para[$this->hash]['loop'][$key][] = $value;
		}
	}
	
	public function Set_If($key, $value=true) {
		global $tpl_para;
		$tpl_para[$this->hash]['if'][$key] = $value;
	}
	
	public function Set_Switch($key, $value=true) {
		global $tpl_para;
		$tpl_para[$this->hash]['switch'][$key] = $value;
	}
	
	public function Set_Variable($name, $value) {
		global $tpl_para;
		$tpl_para[$this->hash]['para'][$name] = $value;
	}

	public function Set_Variables($values, $key="", $reset = false) {
		global $tpl_para;
		
		if($reset) {
			$tpl_para[$this->hash]['para'] = $values;
		} else {
			if(is_array($values)) {
				if(!empty($key)) {
					$values_new = array();
					foreach($values as $the_key => $the_value) {
						$values_new["{$key}_{$the_key}"] = $the_value;
					}
					$tpl_para[$this->hash]['para'] = array_merge($tpl_para[$this->hash]['para'], $values_new);
				} else {
					$tpl_para[$this->hash]['para'] = array_merge($tpl_para[$this->hash]['para'], $values);
				}
			}
		}
	}
	
	public function Get_TPL($file1, $file2="") {
		if(file_exists($file1)) {
			return $this->GetFile($file1);
		} elseif(!empty($file2) && file_exists($file2)) {
			return $this->GetFile($file2);
		} else {
			$file1 = $this->tpl_info['path']."/default/".basename($file1);
			if(file_exists($file1)) {
				return $this->GetFile($file1);
			} else {
				if(!empty($file2)) {
					$file2 = $this->tpl_info['path']."/default/".basename($file2);
					if(file_exists($file2)) {
						return $this->GetFile($file2);
					}
				}
			}
		}
		$this->Error("Cannot find template file '".basename($file1)."' !");
		return "";
	}
	
	public function Get_TPL_Cache() {
		$cache_file = $this->tpl_info['path']."/cache/".str_replace("../", "", $this->tpl_info['style'])."/".$this->tpl_info['idx'].".php";
		if(file_exists($cache_file)) {
			$tpl_time = preg_replace("/^.+?(\d+).+$/", "\\1", $this->GetFile($cache_file, 18));
			if($tpl_time==filemtime($this->tpl_info['file'])) {
				return $cache_file;
			} else {
				unlink($cache_file);
			}
		}

		global $tpl_para;
		$tpl_cache = $this->tpl_info['content'];
		
		if(!$this->allow_script) {
			$tpl_cache = preg_replace("/<\?php.+?\?>/is", "", $tpl_cache);
		}
		
		preg_match_all("/".preg_quote($this->delimiter_l)."(\w+):start(\s+\w+\s*=\s*(\"|')[^\\3]+\\3)*".preg_quote($this->delimiter_r).".*".preg_quote($this->delimiter_l)."\\1:end".preg_quote($this->delimiter_r)."/isU", $tpl_cache, $block_all);
		$max_count = count($block_all[0]);
		for($i=0; $i<$max_count; $i++) {
			$cur_attrib = array();
			$cur_content = "";
			$cur_result = "";
			preg_replace("/".preg_quote($this->delimiter_l)."(\w+):start((\s+\w+\s*=\s*(\"|')[^\\4]+\\4)*)".preg_quote($this->delimiter_r)."(.*)".preg_quote($this->delimiter_l)."\\1+:end".preg_quote($this->delimiter_r)."/iesU","\$this->Get_Block('\\2', '\\5', \$cur_attrib, \$cur_content)", $block_all[0][$i]);
			switch($block_all[1][$i]) {
				case "loop":
					$time = isset($cur_attrib["time"]) ? $cur_attrib["time"] : 0;
					$time += 0;
					if(!is_numeric($time)) $time = 0;
					$loop = isset($cur_attrib["loop"]) ? $cur_attrib["loop"] : true;
					$key = isset($cur_attrib["key"]) ? $cur_attrib["key"] : "";
					$key_exist = false;
					$unit_blank = preg_replace("/".preg_quote($this->delimiter_l).".*?".preg_quote($this->delimiter_r)."/is", "", $cur_content);
					$unit_blank = preg_replace("/<(td|li|p|dd|dt)([^>]*?)>.*?<\/\\1>/is", "<\\1\\2>&nbsp;</\\1>", $unit_blank);
					$unit = $cur_content;
					if(isset($tpl_para[$this->hash]['loop'][$cur_attrib['key']]) && count($tpl_para[$this->hash]['loop'][$cur_attrib['key']])>0) {
						foreach($tpl_para[$this->hash]['loop'][$cur_attrib['key']][0] as $the_key => $the_value) {
							$unit = str_replace($this->delimiter_l.$key."_".$the_key.$this->delimiter_r, "{\$tpl_para['{$this->hash}']['loop']['{$key}'][\$i]['{$the_key}']}", $unit);
						}
					} else {
						$tpl_para[$this->hash]['loop'][$cur_attrib['key']] = array();
						$unit = preg_replace("/".preg_quote($this->delimiter_l).preg_quote($cur_attrib['key'])."_(\w+)".preg_quote($this->delimiter_r)."/U", "{\$tpl_para['{$this->hash}']['loop']['".$cur_attrib['key']."'][\$i]['\\1']}", $unit);
					}
					$cur_result = <<<mytpl
<?php
\$time = $time - 1;
\$max_count = count(\$tpl_para['{$this->hash}']['loop']['{$cur_attrib['key']}']);
for(\$i=0; \$i<\$max_count; \$i++) {
	echo <<<content
$unit
content;
	echo "\\n";
	if(\$i>=\$time && \$time>0) break;
}
mytpl;
					if($loop) {
							$cur_result .= <<<mytpl

for(\$i=\$max_count-1; \$i<\$time; \$i++) {
	echo <<<content
$unit_blank
content;
	echo "\\n";
}
mytpl;
					}
					$cur_result .= "\n?>";
					break;
				case "if":
					$part = explode("<!--else-->", $cur_content);
					if(isset($cur_attrib['key'])) {
						if(!isset($tpl_para[$this->hash]['if'][$cur_attrib['key']])) $tpl_para[$this->hash]['if'][$cur_attrib['key']] = false;
						$cur_result = <<<mytpl
<?php
if(\$tpl_para['{$this->hash}']['if']['{$cur_attrib['key']}']) {
	echo <<<content
{$part[0]}
content;
}
mytpl;
						if(count($part)>1) {
							$cur_result .= <<<mytpl
 else {
	echo <<<content
{$part[1]}
content;
}
mytpl;
						}
						$cur_result .= "\n?>";
					}
					break;
				case "switch":
					preg_match_all("/<!--(.*)-->(.*)<!--break-->/isU", $cur_content, $part);
					$cur_result = <<<mytpl
<?php
switch(\$tpl_para['{$this->hash}']['switch']['{$cur_attrib['key']}']) {

mytpl;
					$max_count2 = count($part[0]);
					for($j=0; $j<$max_count2; $j++) {
						$part[1][$j] = addslashes($part[1][$j]);
						$part[2][$j] = addslashes($part[2][$j]);
						$cur_result .= <<<mytpl
	case "{$part[1][$j]}":
		echo "{$part[2][$j]}";
		break;

mytpl;
					}
					$cur_result .= <<<mytpl
}
?>
mytpl;
					break;
				case "random":
					if(!get_magic_quotes_gpc()) $cur_content = addslashes($cur_content);
					$cur_result =  <<<mytpl
<?php
\$part = explode("<!--next-->", "{$cur_content}");
echo \$part[rand(0, count(\$part)-1)];
?>
mytpl;
					break;
				default:
					$cur_result = "";
					break;	
			}
			$cur_result = preg_replace("/".preg_quote($this->delimiter_l)."(\w+?)".preg_quote($this->delimiter_r)."/", "{\$tpl_para['{$this->hash}']['para']['\\1']}", $cur_result);
			$tpl_cache = str_replace($block_all[0][$i], $cur_result, $tpl_cache);
			unset($cur_attrib, $cur_content);
		}
		
		$tpl_cache = $this->Parse_Tags($tpl_cache);
		/*
		foreach($tpl_para[$this->hash]['para'] as $key => $value) {
			$tpl_cache = str_replace($this->delimiter_l.$key.$this->delimiter_r, "<?=\$tpl_para['{$this->hash}']['para']['{$key}']?>", $tpl_cache);
		}
		*/
		$tpl_cache = preg_replace("/".preg_quote($this->delimiter_l)."(\w+)".preg_quote($this->delimiter_r)."/", "<?=\$tpl_para['{$this->hash}']['para']['\\1']?>", $tpl_cache);
		$tpl_cache = preg_replace("/[\r\n]+/", "\n", $tpl_cache);
		$tpl_cache = "<!--".filemtime($this->tpl_info['file'])."-->".$tpl_cache;
		$this->WriteFile($cache_file, $tpl_cache, 'wb');
		return $cache_file;
	}
	
	protected function Get_Block($attrib, $content, &$block_attrib, &$block_content) {
		$block_content =stripslashes($content);
		$attrib = stripslashes($attrib);
		preg_match_all("/(\w+\s*=\s*(\"|')[^\\2]+\\2)/isU", $attrib, $att_list);
		$att_list = $att_list[1];
		$max_count = count($att_list);
		for($i=0; $i<$max_count; $i++) {
			if(empty($att_list[$i])) continue;
			$tmp = explode("=", trim($att_list[$i]));
			eval("\$block_attrib['" . strtolower(trim($tmp[0])) . "'] = {$tmp[1]};");
		}
	}
	
	public function Reg_Tag($tag_name, $tag_func) {
		if(is_callable($tag_func)) $this->tags[$tag_name] = $tag_func;
	}
	
	public function Reg_Tags($tag_list) {
		foreach($tag_list as $key => $value) {
			if(is_callable($value)) $this->tags[$key] = $value;
		}
	}
	
	protected function Parse_Tags($content) {
		preg_match_all("/".preg_quote($this->delimiter_l)."(\w+)((\s+\w+\s*=\s*(\"|')[^\\4]+\\4)+)".preg_quote($this->delimiter_r)."/isU", $content, $tag_all);
		$max_count = count($tag_all[0]);
		for($i=0; $i<$max_count; $i++) {
			$cur_result = "";
			$cur_attrib = array();
			if(isset($this->tags[$tag_all[1][$i]])) {
				preg_match_all("/(\w+\s*=\s*(\"|')[^\\2]+\\2)/isU", $tag_all[2][$i], $att_list);
				$att_list = $att_list[1];
				$max_count1 = count($att_list);
				for($j=0; $j<$max_count1; $j++) {
					if(empty($att_list[$j])) continue;
					$tmp = explode("=", trim($att_list[$j]));
					$tmp[1] = preg_replace('/\$(\w+)/', '{$GLOBALS[\1]}', $tmp[1]);
					$tmp[1] = preg_replace('/#(\w+)/', '$GLOBALS["\1"]', $tmp[1]);
					$tmp[1] = preg_replace('/\&(\w+)/', '<?=$GLOBALS["\1"]?>', $tmp[1]);
					eval("\$cur_attrib['" . strtolower(trim($tmp[0])) . "'] = {$tmp[1]};");
				}
				$cur_result = call_user_func($this->tags[$tag_all[1][$i]], $this, $cur_attrib);
			}
			$content = str_replace($tag_all[0][$i], $cur_result, $content);
		}
		return $content;
	}

	public function Is_Cached() {
		if(!$this->cache['use']) return false;
		if(!file_exists($this->cache['file'])) return false;
		if(filemtime($this->cache['file'])+$this->cache['expire'] < $_SERVER['REQUEST_TIME']) {
			unlink($this->cache['file']);
			return false;
		}
		return true;
	}

	protected function Read_Cache() {
		$content = "";
		if($this->cache['use'] && $this->Is_Cached()) {
			$content = $this->GetFile($this->cache['file']);
		}
		return $content;
	}
	
	public function Get_Content($global_para = "", $minify = false) {
		global $tpl_para;
		if(!empty($global_para)) {
			eval("global ".$global_para.";");
		}
		if(isset($GLOBALS['language'])) $this->Set_Variables($GLOBALS['language'], "lang");
		$content = "";
		if($this->cache['use']) $content = $this->Read_Cache();
		if(empty($content)) {
			if(headers_sent()) $this->Error("Headers have already been sent, content create failed....");
			if(count(ob_list_handlers())==0) {
				ob_start();
				include($this->Get_TPL_Cache());
				$content = ob_get_contents();
				if(count(ob_list_handlers())>0) ob_end_clean();	
			} else {
				if(ob_get_length()) {
					$temp = ob_get_contents();
					if(count(ob_list_handlers())>0) ob_clean();
					include($this->Get_TPL_Cache());
					$content = ob_get_contents();
					if(count(ob_list_handlers())>0) ob_clean();
					echo $temp;
				} else {
					include($this->Get_TPL_Cache());
					$content = ob_get_contents();
					if(count(ob_list_handlers())>0) ob_clean();
				}
			}
			if($minify) {
				$content = preg_replace("/".preg_quote($this->delimiter_l).".+?".preg_quote($this->delimiter_r)."/", "", $content);
				$content = preg_replace("/\/\/[\w\s]+([\r\n]+)/", '\1', $content);
				$content = preg_replace("/\s+/", " ", $content);
			}
			$content = preg_replace("/^".preg_quote($this->delimiter_l)."\d+".preg_quote($this->delimiter_r)."[\r\n]*/", "", $content);
			if($this->cache['use'] && $this->cache['expire'] > 0) $this->WriteFile($this->cache['file'], $content, 'w');
		}
		return $content;
	}
}
?>