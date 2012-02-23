<?php
/********************************************
*                                           *
* Name    : Image Creator (MagickWand)      *
* Author  : Windy2000                       *
* Time    : 2009-02-06                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$MagickWand = new MagickWand($direct_show)																		//构造函数
	$MagickWand->getImgWand($resource)																						//获取图像对象
	$MagickWand->getColor($color_idx)																							//获取颜色对象
	$MagickWand->setFont($text, $para)																						//获取文字图像
	$MagickWand->addFrame(&$img, $resource, $delay)																//为图像对象添加帧
	$MagickWand->createGif($srcFile, $desFile, $delay)														//多张图片生成动画GIF
	$MagickWand->resizePic($srcFile, $width, $height, $desFile, $zoom_out)				//缩放图像 支持动画GIF
	$MagickWand->fixSize(&$img, $fix_width, $fix_height, $bgcolor, $fix_mode)			//重设画布大小
	$MagickWand->cropPic($srcFile, $width, $height, $desFile, $top, $left)				//裁切图像 支持动画GIF
	$MagickWand->rotatePic($srcFile, $angle, $bgcolor)														//旋转图像 支持动画GIF
	$MagickWand->batchModify(&$img, $func)																				//对多帧图像对象批量操作
	$MagickWand->convertToJpg($srcFile, $quality)																	//转换为JPG图像
	$MagickWand->addTextWatermark($srcFile, $text, $desFile, $para)								//添加文字水印 支持动画GIF
	$MagickWand->addPicWatermark($srcFile, $wmFile, $desFile)											//添加图片水印 支持动画GIF
	$MagickWand->generateImg($img, $mode)																					//显示图片
	$MagickWand->destoryWand()																										//释放对象资源
	$MagickWand->Error($errObj, $exit)																						//处理错误

--------------------------------------------------------------------------------------------------------------------*/

class MagickWand extends class_common { 
	public $direct_show = false;
	
	public function init($direct_show = false) { 
		if(!function_exists('newMagickWand')) $this->Error('No MagickImage extends! ');
		$this->direct_show = $direct_show;
		return;
	}
		
	public function getImgWand($resource="", $size=array()) {
		$result = NewMagickWand();
		if(count($size)==2) MagickSetWandSize($result, $size[0], $size[1]);
		if(IsMagickWand($resource)) {
			$result = CloneMagickWand($resource);
		} elseif(is_array($resource) && count($resource)==3) {
			MagickNewImage($result, $resource[1], $resource[2], $resource[0]);
		} elseif(!empty($resource)) {
			MagickReadImage($result, $resource);
		}
		return $result;
	}
	
	public function getColor($color_idx="", $opacity=1) {
		if(empty($color_idx)) {
			$color_idx = "#";
			$color_idx .= substr("0".dechex(rand(0,255)), 0, 2);
			$color_idx .= substr("0".dechex(rand(0,255)), 0, 2);
			$color_idx .= substr("0".dechex(rand(0,255)), 0, 2);
		}
		$theColor = NewPixelWand($color_idx);
		
		if(is_numeric($opacity)) $opacity = 1;
		if($opacity<0) $opacity = 0;
		if($opacity>1) $opacity = 1;
		if($opacity!=1) PixelSetOpacity($theColor, $opacity);
		
		if(WandHasException($theColor)) $this->Error($theColor);
		return $theColor;
	}
	
	public function setFont($para=array()) {
		$textColor = "#000000";
		$textWeight = 120; 
		$textSize = 12; 
		$textFont = "simsun.ttc";
		$textAlpha = 1;
		$textAlign = 1;
		$textStrokeColor = "#FFFFFF";
		$textStrokeWidth = 1;
		$textStrokeOpacity = 0.2;
		if(count($para)>1) extract($para, EXTR_OVERWRITE);
		
		$imgFont = NewDrawingWand();
		$fontColor = $this->getColor($textColor);
		DrawSetTextEncoding($imgFont, "UTF-8"); 
		DrawSetFont($imgFont, $textFont);
		DrawSetFontWeight($imgFont, $textWeight);
		DrawSetFillColor($imgFont, $fontColor);
		DrawSetFontSize($imgFont, $textSize);
		DrawSetGravity($imgFont, $textAlign);
		DrawSetFillAlpha($imgFont, $textAlpha);
		
		if($textStrokeWidth>0 && $textStrokeOpacity>0) {
			$strokeColor = $this->getColor($textStrokeColor);
			DrawSetStrokeColor($imgFont, $strokeColor);
			DrawSetStrokeWidth($imgFont, $textStrokeWidth);
			DrawSetStrokeOpacity($imgFont, $textStrokeOpacity); 
		}
		if(WandHasException($imgFont)) $this->Error($imgFont);
		$this->destoryWand($fontColor);
		return $imgFont;
	}
	
	public function addFrame(&$img, $resource, $delay=100) {
		$frame = $this->getImgWand($resource);
		//MagickSetImageIterations($img, MagickGetNumberImages($img)+1);
		if(MagickGetNumberImages($frame)>1) {
			MagickAddImages($img, $frame);
		} else {
			MagickSetImageDelay($frame, $delay);
			MagickAddImage($img, $frame);
		}
		DestroyMagickWand($frame);
		return;
	}
	
	public function setDummyFrame(&$img, $bgcolor=false) {
		$result = NewMagickWand();
		$frame = NULL;
		$delay = 1;
		$width = MagickGetImageWidth($img);
		$height = MagickGetImageHeight($img);
		MagickResetIterator($img);
		while(MagickNextImage($img)) {
			if($bgcolor) {
				$frame = $this->getImgWand(array($bgcolor, $width, $height));
				MagickSetImageDelay($frame, $delay);
				MagickAddImage($result, $frame);
			} else {
				if(MagickGetImageDelay($img)==$delay) continue;
			}
			MagickAddImage($result, $img);
		}
		$this->destoryWand($img, $frame);
		$img = $result;
		return;
	}
	
	public function createGif($srcFile, $desFile="", $delay=1, $mode=0, $bgcolor="") {
		$width = 0;
		$height = 0;
		$max_count = count($srcFile);
		for($i=0; $i<$max_count; $i++) { 
			$imgTemp = $this->getImgWand($srcFile[$i]);
			if($width < MagickGetImageWidth($imgTemp)) $width = MagickGetImageWidth($imgTemp);
			if($height < MagickGetImageHeight($imgTemp)) $height = MagickGetImageHeight($imgTemp);
			DestroyMagickWand($imgTemp);
			if($mode!=0 && $i==0) break;
		}
		$img = $this->getImgWand("", array($width, $height));
		MagickSetImageBackgroundColor($img, $this->getColor($bgcolor));
		$this->addFrame($img, array("transparent", $width, $height), 1);
		
		for($i=0; $i<$max_count; $i++) {
			$imgTemp = $this->getImgWand($srcFile[$i]);
			$curDelay = MagickGetImageDelay($imgTemp);
			$curdelay = ($curDelay==0 ? $delay*100 : $curDelay);
			if($mode==1) {
				$imgTemp = $this->resizePic($imgTemp, $width, $height);
			} elseif($mode==2) {
				$imgTemp = $this->cropPic($imgTemp, $width, $height);
			}
			$this->addFrame($img, $imgTemp, $curdelay);
			DestroyMagickWand($imgTemp);
		}
		if(!empty($bgcolor)) $this->setDummyFrame($img, $bgcolor);
		$this->generateImg($img, $desFile);
		return;
	}
	 
	public function resizePic($srcFile, $width, $height, $desFile="", $zoom_out=true, $sample=false) {
		if(empty($desFile) && !$this->direct_show) $desFile = $srcFile;
		$img = $this->getImgWand($srcFile);
		$theWidth = MagickGetImageWidth($img);
		$theHeight = MagickGetImageHeight($img);
		$ratio = doubleval($theWidth) / doubleval($width);
		if ($height * $ratio < $theHeight) { 
			$ratio = doubleval($theHeight) / doubleval($height);
		}
		if(!$zoom_out && $ratio < 1) $ratio = 1;
		if($ratio!=1) {
			$theWidth = floor($theWidth/$ratio);
			$theHeight = floor($theHeight/$ratio);
			if($sample) {
				$this->batchModify($img, "MagickSampleImage", array($theWidth, $theHeight));
			} else {
				$this->batchModify($img, "MagickScaleImage", array($theWidth, $theHeight));
			}
			//MagickResizeImage($img, $arrSize[0], $arrSize[1], 1, 1);
		}
		return IsMagickWand($srcFile) ? $img : ($this->generateImg($img, $desFile));
	}
	
	public function fixSize(&$img, $fix_width=0, $fix_height=0, $fix_top = 0, $fix_left = 0, $bgcolor="white", $fix_mode=false) {
		if($fix_width==0 && $fix_height==0) return;
		$width = MagickGetImageWidth($img);
		$height = MagickGetImageHeight($img);
		if($fix_mode) {
			$fix_width += $width;
			$fix_height += $height;
		} else {
			if($fix_width==0) $fix_width = $width;
			if($fix_height==0) $fix_height = $height;
		}
		$result = NewMagickWand();
		
		MagickResetIterator($img);
		while(MagickNextImage($img)) {
			$drawWand = NewDrawingWand();
			DrawComposite($drawWand, MW_AddCompositeOp, $fix_left, $fix_top, $width, $height, $img);
			$frame = $this->getImgWand(array($bgcolor, $fix_width, $fix_height));
			MagickDrawImage($frame, $drawWand);
			MagickSetImageDelay($frame, MagickGetImageDelay($img));
			MagickAddImage($result, $frame);
		}
		$this->destoryWand($img, $imgTemp, $drawWand);
		$img = $result;
		return;
	}
	
	public function cropPic($srcFile, $width, $height, $desFile="", $top=0, $left=0) {
		if(empty($desFile) && !$this->direct_show) $desFile = $srcFile;
		$img = $this->getImgWand($srcFile);
		$this->batchModify($img, "MagickCropImage", array($width, $height, $top, $left));
		if(MagickGetImageFormat($img)=="GIF") $this->fixSize($img, $width, $height, $top, $left);
		return IsMagickWand($srcFile) ? $img : ($this->generateImg($img, $desFile));
	}
	
	public function rotatePic($srcFile, $angle=90, $bgcolor="transparent") {
		if(empty($desFile) && !$this->direct_show) $desFile = $srcFile;
		$img = $this->getImgWand($srcFile);
		$this->batchModify($img, "MagickRotateImage", array($this->getColor($bgcolor), $angle));
		return IsMagickWand($srcFile) ? $img : ($this->generateImg($img, $desFile));
	}
	
	public function batchModify(&$img, $func, $paras=array()) {
		if(MagickGetNumberImages($img)>1) { 
			MagickResetIterator($img);
			while(MagickNextImage($img)) {
				call_user_func_array($func, array_merge((array)$img, $paras));
			}
		} else {
			call_user_func_array($func, array_merge((array)$img, $paras));
		}
		return WandHasException($img);
	}
	
	public function convertToJpg($srcFile, $desFile="", $quality=60) {
		if(empty($desFile)) $desFile = str_replace(substr(strrchr($srcFile, "."), 1), "", $srcFile)."jpg";
		$img = $this->getImgWand($srcFile);
		if(MagickGetNumberImages($img)>1) {
			MagickResetIterator($img);
			MagickNextImage($img);
			$frame = $this->getImgWand();
			MagickAddImage($frame, $img);
			DestroyMagickWand($img);
			$img = $frame;
		}
		MagickSetFormat($img, 'JPG');
		MagickSetImageCompression($img, MW_JPEGCompression);
		MagickSetImageCompressionQuality($img, $quality);
		$this->generateImg($img, $desFile);
		return $desFile;
	}
	
	public function addTextWatermark($srcFile, $text, $desFile="", $para=array(), $fixsize=true) { 
		if(empty($desFile) && !$this->direct_show) $desFile = $srcFile;
		if(!file_exists($srcFile)) return false;
		if(!isset($para['textAlign'])) $para['textAlign'] = 1;
		$imgFont = $this->setFont($para);
		$img = $this->getImgWand($srcFile);
		$string_info = MagickQueryFontMetrics($img, $imgFont, $text, true);
		$string_width = $string_info[4];
		$string_height = $string_info[5];
		if(MagickGetImageWidth($img) < $string_width) return false;
		switch($para['textAlign']) {
			case 1:
			case 2:
			case 3:
				$angle = 0;
				$fix_width = 0;
				$fix_height = $string_height;
				$fix_top = $string_height;
				$fix_left = 0;
			case 1:
				$textX = 10;
				$textY = 10;
				break;
			case 2:
				$textX = 0;
				$textY = 10;
				break;
			case 3:
				$textX = 10;
				$textY = -10;
				break;
			case 4:
				$textX = $string_height/2 + 10;
				$textY = -MagickGetImageHeight($img)/2 + 10;
				$angle = 90;
				$fix_width = $string_height;
				$fix_height = 0;
				$fix_top = 0;
				$fix_left = $string_height;
				break;
			case 5:
				$textX = 0;
				$textY = 0;
				$angle = 0;
				$fix_width = 0;
				$fix_height = 0;
				$fix_top = 0;
				$fix_left = 0;
				break;
			case 6:
				$textX = $string_height/2 + 10;
				$textY = MagickGetImageHeight($img)/2 - 10;
				$angle = 90;
				$fix_width = $string_height;
				$fix_height = 0;
				$fix_top = 0;
				$fix_left = 0;
				break;
			case 7:
			case 8:
			case 9:
				$angle = 0;
				$fix_width = 0;
				$fix_height = $string_height;
				$fix_top = 0;
				$fix_left = 0;
			case 7:
				$textX = 20;
				$textY = 10;
				break;
			case 8:
				$textX = 00;
				$textY = 10;
				break;
			case 9:
				$textX = -20;
				$textY = 10;
				break;
			default:
				$textX = 0;
				$textY = 0;
				$angle = 0;
				$fix_width = 0;
				$fix_height = 0;
				$fix_top = 0;
				$fix_left = 0;
				if(isset($para['textX'])) $textX = $para['textX'];
				if(isset($para['textY'])) $textY = $para['textY'];
				if(isset($para['fix_width'])) $fix_width = $para['fix_width'];
				if(isset($para['fix_height'])) $fix_height = $para['fix_height'];
				break;
		}
		$fix_color = "#000000";
		if(isset($para['fix_color'])) $fix_color = $para['fix_color'];
		$text = iconv("gb2312", "utf-8", $text);
		if($fixsize) $this->fixSize($img, $fix_width, $fix_height, $fix_top, $fix_left, $fix_color, true);
		$this->batchModify($img, "MagickAnnotateImage", array($imgFont, $textX, $textY, $angle, $text));
		$this->destoryWand($imgFont);
		$this->generateImg($img, $desFile);
		return true;
	}
	
	public function addPicWatermark($srcFile, $wmFile, $desFile="", $mode=5) {
		if(empty($desFile) && !$this->direct_show) $desFile = $srcFile;
		if(!file_exists($srcFile) || !file_exists($wmFile)) return false;
		$img = $this->getImgWand($srcFile);
		$width = MagickGetImageWidth($img);
		$height = MagickGetImageHeight($img);
		$img_mw = $this->getImgWand($wmFile);
		$img_mw = $this->resizePic($img_mw, $width/4, $height/4);
		switch($mode) {
			case 1:
				$offset_x = 0;
				$offset_y = 0;
				break;
			case 2:
				$offset_x = $width - MagickGetImageWidth($img_mw);
				$offset_y = 0;
				break;
			case 3:
				$offset_x = ($width - MagickGetImageWidth($img_mw))/2;
				$offset_y = ($height - MagickGetImageHeight($img_mw))/2;
				break;
			case 4:
				$offset_x = 0;
				$offset_y = $height - MagickGetImageHeight($img_mw);
				break;
			case 5:
				$offset_x = $width - MagickGetImageWidth($img_mw);
				$offset_y = $height - MagickGetImageHeight($img_mw);
				break;
			default:
				if(is_array($mode) && count($mode)==2) {
					$offset_x = $mode[0];
					$offset_y = $mode[1];
				} else {
					$offset_x = $width - MagickGetImageWidth($img_mw);
					$offset_y = $height - MagickGetImageHeight($img_mw);
				}
				break;
		}
		$this->batchModify($img, "MagickCompositeImage", array($img_mw, MW_AtopCompositeOp, $offset_x, $offset_y));
		$this->destoryWand($img_mw);
		$this->generateImg($img, $desFile);
		return true;
	}

	public function generateImg($img, $desFile="") {
		MagickCommentImage($img, "Image Creator (MagickWand) By Windy2000");
		$type = MagickGetImageFormat($img);
		$frame_count = MagickGetNumberImages($img);
		if(empty($type)) $type = $frame_count>1 ? "GIF" : "JPG";
		if(strpos("tile,gradient,caption,label,logo,netscape,rose", strtolower($type))!==false) $type = "PNG";
		MagickSetFormat($img, $type);
		if(empty($desFile)) { 
			//header("Content-Type: ".MagickGetMimeType($img));
			if($frame_count>1) {
				MagickEchoImagesBlob($img);
			} else {
				MagickEchoImageBlob($img);
			}
		} else {
			if($frame_count>1) {
				MagickWriteImages($img, $desFile, MagickTrue);
			} else {
				MagickWriteImage($img, $desFile);
			}
		}
		if(WandHasException($img)) $this->Error($img);
		$result = MagickGetExceptionType($img);
		DestroyMagickWand($img);
		return $result;
	}
	
	public function destoryWand() {
		$numargs = func_num_args();
		$arg_list = func_get_args();
		for($i = 0; $i < $numargs; $i++) {
			switch(true) {
				case IsMagickWand($arg_list[$i]):
					DestroyMagickWand($arg_list[$i]);
					break;
				case IsDrawingWand($arg_list[$i]):
					DestroyDrawingWand($arg_list[$i]);
					break;
				case IsPixelWand($arg_list[$i]):
					DestroyPixelWand($arg_list[$i]);
					break;
				case IsPixelIterator($arg_list[$i]):
					DestroyPixelIterator($arg_list[$i]);
					break;
				default:
					break;
			}
    }
		return;
	}
		
	protected function Error($errObj, $exit=false) {
		$str = "Image Creator (MagickWand) Error Message";
		$err_msg = "";
		//$err_msg .= WandGetExceptionString($errObj);
		switch(true) {
			case IsMagickWand($errObj):
				$err_msg .= MagickGetExceptionString($errObj);
				break;
			case IsDrawingWand($errObj):
				$err_msg .= DrawGetExceptionString($errObj);
				break;
			case IsPixelWand($errObj):
			case IsPixelIterator($errObj):
				$err_msg .= PixelGetExceptionString($errObj);
				break;
			default:
				$err_msg .= $errObj;
		}
		if(!empty($err_msg)) $str .= "(".$err_msg.")";
		parent::Error($str, $exit);
		return;
	}
}
?>