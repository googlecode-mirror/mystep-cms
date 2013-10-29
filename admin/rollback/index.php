<?php
header("Content-type: text/html; charset=gbk");
function MultiCopy($source, $destination, $overwrite = false) {
	//Coded By Windy2000 20131028 v1.0
	if(!file_exists($source)) return false;
	if(substr($source, -1)=="/" || substr($source, -1)=="\\") $destination = $destination."/".basename($source);
	if(is_dir($destination)) {
		if(is_file($source)) {
			$file_name = basename($source);
			if(is_file($destination."/".$file_name)) {
				if($overwrite) {
					unlink($destination."/".$file_name);
				} else {
					rename($destination."/".$file_name, $destination."/".$file_name.".".time());
				}
			}
		}
	} elseif(is_file($destination)) {
		if($overwrite) {
			unlink($destination);
		} else {
			rename($destination, $destination.".".time());
		}
	} else {
		if(is_file($source)) {
			$info = pathinfo($destination);
			if(isset($info['extension'])) {
				mkdir($info['dirname'], 0777);
			} else {
				mkdir($destination, 0777);
				$destination = $destination."/".basename($source);
			}
		} else {
			mkdir($destination, 0777);
		}
	}
	
	if(is_file($source)) {
		copy($source, $destination);
	} elseif(is_dir($source)) {
		$handle=dir($source);
		while(false !== ($file=$handle->read())) {
			if($file=="." || $file=="..") continue;
			if(is_dir($source."/".$file)) {
				MultiCopy($source."/".$file, $destination."/".$file, $overwrite);
			} else {
				if(file_exists($destination."/".$file) && !$overwrite) {
					rename($destination."/".$file, $destination."/".$file.".".time());
				}
				copy($source."/".$file, $destination."/".$file);
			}
		}
	} else {
		return false;
	}
	return true;
}
function MultiDel($dir, $file_list="") {
	//Coded By Windy2000 20031001 v1.0
	if(is_dir($dir)) {
		$mydir = opendir($dir);
		while(($file = readdir($mydir)) !== false) {
			if($file!="." && $file!="..") {
				$the_name = $dir."/".$file;
				if(is_dir($the_name)) {
					if(empty($file_list) || strpos($file_list, $file)!==false) {
						MultiDel($the_name);
					} else {
						MultiDel($the_name, $file_list);
					}
				} else {
					if(empty($file_list) || strpos($file_list, $file)!==false) {
						@unlink($the_name);
					}
				}
				//is_dir($the_name) ? MultiDel($the_name) : @unlink($the_name);
			}
		}
		closedir($mydir);
		@rmdir($dir);
	}else{
		if(is_file($dir)) unlink($dir);
	}
	return;
}

$handle = dir("./");
$dir_list = array();
while (false !== ($file = $handle->read())) {
	if($file=="." || $file=="..") continue;
	if(is_dir($file)) {
		$dir_list[] = $file;
	}
}
$handle->close();

$msg = "��ѡ����Ҫ�ָ���ϵͳ�汾���ָ��󣬱������ݽ���ɾ����";
if(count($_POST)>0) {
	$content = file_get_contents("../../include/config.php");
	preg_match("/[\w]{32}/", $content, $match);
	if(md5($_POST['psw'])!=$match[0]) {
		$msg = "������������";
	} else {
		$n = 0;
		for($i=count($dir_list)-1;$i>=0;$i--) {
			$n++;
			MultiCopy($dir_list[$i], "../../", true);
			MultiDel($dir_list[$i]);
			if($dir_list[$i]==$_POST["ver"]) break;
		}
		if($n>0) {
			$msg = "�ѳɹ��ظ� ".$n." ��ϵͳ�汾����ǰ�汾��".$dir_list[$i];
		}
	}
	
	$handle = dir("./");
	$dir_list = array();
	while (false !== ($file = $handle->read())) {
		if($file=="." || $file=="..") continue;
		if(is_dir($file)) {
			$dir_list[] = $file;
		}
	}
	$handle->close();
}


if(count($dir_list)==0) {
	if(count($_POST)>0) echo $msg."<br /><br />";
	die("���޿ɹ��ָ������ݣ�");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" >
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
<title>���»ع�</title>
</head>
<body>
	<div style="padding-bottom:10px;font-weight:bold;"><?=$msg?></div>
	<form method="post" action="index.php">
		�汾ѡ��<select name="ver">
<?php
for($i=0,$m=count($dir_list);$i<$m;$i++) {
	echo "<option>".$dir_list[$i]."</option>\n";
}
?>
		</select><br />
		�������룺<input type="text" name="psw" /><br />
		<input type="submit" />
	</form>
</body>
</html>