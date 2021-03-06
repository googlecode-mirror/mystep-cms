<?php
class MyZip extends ZipArchive {
	public function addDir($path) {
		$this->addEmptyDir($path);
		$nodes = glob($path . '/*');
		foreach($nodes as $node) {
			if(is_dir($node)) {
				$this->addDir($node);
			} elseif(is_file($node))  {
				$this->addFile($node);
			}
		}
	}
	
	public function open($file, $write=false) {
		return parent::open($file, $write?(ZIPARCHIVE::OVERWRITE):(ZIPARCHIVE::CHECKCONS));
	}
}

function zip($file, $zipfile="", $basedir="") {
	$zip = new MyZip;
	$res = false;
	MakeDir(dirname($zipfile));
	if(is_dir($file)) {
		if(empty($zipfile)) $zipfile = basename(rtrim($file, '/')).".zip";
		$res = $zip->open($zipfile, ZIPARCHIVE::CREATE);
		if($res === TRUE) {
			$zip->addDir($file);
			$zip->close();
		}
	} elseif(is_file($file)) {
		if(empty($zipfile)) $zipfile = str_replace(pathinfo($file, PATHINFO_EXTENSION), "zip", basename($file));
		$res = $zip->open($zipfile, ZIPARCHIVE::CREATE);
		if($res === TRUE) {
			$zip->addFile($file);
			$zip->close();
		}
	} elseif(is_array($file)) {
		if(empty($zipfile)) $zipfile = tempnam(dirname($_SERVER['PHP_SELF']), "").".zip";
		$res = $zip->open($zipfile, ZIPARCHIVE::CREATE);
		if($res === TRUE) {
			foreach($file as $theFile) {
				if(is_dir($theFile)) {
					$zip->addDir($theFile);
				} elseif(is_file($theFile)) {
					$zip->addFile($theFile);
				}
			}
			$zip->close();
		}
	}
	if(empty($basedir)) $basedir = dirname($zipfile)."/";
	if($res) {
		$zip->open($zipfile);
		for($i=0; $i<$zip->numFiles; $i++) {
			$theName = $zip->getNameIndex($i);
			$newName = str_replace($basedir, "", $theName);
			$newName = preg_replace("/\/+/", "/", $newName);
			$zip->renameName($theName, $newName);
		}
		$zip->close();
	}
	return $res ? $zipfile : false;
}

function unzip($file, $dir="./") {
	$zip = new MyZip;
	$res = $zip->open($file);
	if($res === TRUE) {
    $zip->extractTo($dir);
		$zip->close();
		return true;
	} else {
		return $res;
	}
}
?>