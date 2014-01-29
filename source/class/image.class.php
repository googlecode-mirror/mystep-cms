<?php
/********************************************
*																						*
* Name		: Image Creator										*
* Author	: Windy2000												*
* Time		: 2007-06-26											*
* Email	 : windy2006@gmail.com							*
* HomePage: www.mysteps.cn									*
* Notice	: U Can Use & Modify it freely,		*
*					 BUT HOLD THIS ITEM PLEASE.				*
*																						*
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

	How To Use:
	$imageCreator = new imageCreator($width, $height, $cr)				//构造函数
	$imageCreator->createImage($trueImage, $background)					//生成画板
	$imageCreator->setTile($image, $point, $width, $height)				//设置区域贴图
	$imageCreator->setTransparent($color)								//设置透明色（可为点、索引色和数组色）
	$imageCreator->randomColor($rand)									//随机颜色
	$imageCreator->loadImage($image, &$data)							//读取图片文件，并返回图片信息
	$imageCreator->rotateImage($angle, $img)							//旋转画布
	$imageCreator->resizeImage($rate, $return, $img)					//按比例缩放画布（可选择返回图像源）
	$imageCreator->cropImage($point, $width, $height, $return, $img)	//截取画布的一部分（可选择返回图像源）
	$imageCreator->pasteImage($img, $point, $alpha, $gray)				//将一图像源粘贴到画布的某一位置
	$imageCreator->setLine($thickness, $style, $brush)					//设定画线的粗细、风格、笔刷
	$imageCreator->setFilter($filtertype, $img, $arg)					//为图像添加滤镜效果
	$imageCreator->getSize($img)										//返回图像源的宽、高
	$imageCreator->getColor($point, $mode)								//取得画布某点的颜色
	$imageCreator->setColor($idx)										//设置颜色
	$imageCreator->setAlphaColor($idx, $alpha)							//设置透明色
	$imageCreator->checkPoint()											//检测点的有效性
	$imageCreator->checkImage()											//检测图像源的有效性
	$imageCreator->fillImage($point, $color, $color_border)				//从一点向画布右下填充
	$imageCreator->drawLine($p_start, $p_end, $color)													//画线
	$imageCreator->drawRectangle($point, $width, $height, $color_line, $color_fill)						//画矩形
	$imageCreator->drawPolygon($points, $color_line, $color_fill)										//画多边形
	$imageCreator->drawFiveSidedStar($point, $radius, $color_line, $color_fill, $star, $spiky)			//画五角星
	$imageCreator->drawEllipse($point, $width, $height, $color, $fill)									//画椭圆
	$imageCreator->drawEllipseStroke($point, $width, $height, $color, $color_side)						//画椭圆并描边
	$imageCreator->drawArc($point, $width, $height, $arc, $color, $fill)								//画椭圆弧
	$imageCreator->drawArcStroke($point, $width, $height, $arc, $color, $color_side)					//画椭圆弧并描边
	$imageCreator->drawPie($data, $point, $width, $height, $mask, $ext_value, $distance, $start_angle)	//画饼图
	$imageCreator->drawZigzag($points, $color_line)														//画折线
	$imageCreator->drawString($text, $point, $color, $font, $font_size, $angle)							//添加文字
	$imageCreator->setFont($font)																		//设置字体
	$imageCreator->getFontSize($text, $size, $angle)													//取得字符串的占位大小
	$imageCreator->addNoise($number)																	//添加干扰点
	$imageCreator->makeImage($type, $file, $img)														//输出图像源到浏览器或文件
	$imageCreator->destroyImage($img)																	//释放图像源
	$imageCreator->transString($str)																	//字符集转换
	$imageCreator->imagecreatefrombmp($filename)
	$imageCreator->imagebmp($im, $fn = false)
	$imageCreator->gif_info($filename)

--------------------------------------------------------------------------------------------------------------------*/

class imageCreator extends class_common {
	public 
		$img = NULL,
		$width = 0,
		$height = 0,
		$color_lst = array(),
		$font = "";

	public function __construct() {
		$argList = func_get_args();
		if(count($argList)>0 ){
			call_user_func_array(array($this, "init"), $argList);
		} else {
			call_user_func(array($this, "init"));
		}
		return;
	}
	
	public function init($width = 400, $height = 400, $cr = false) {
		$this->width = $width;
		$this->height = $height;
		if($cr) $this->createImage();
		return;
	}

	public function createImage($trueImage = true, $background = NULL) {
		if($this->checkImage()) return;
		$this->img = $trueImage ? imagecreatetruecolor($this->width, $this->height) : imagecreate($this->width, $this->height);
		$this->setColor("red",255,0,0);
		$this->setColor("green",0,255,0);
		$this->setColor("blue",0,0,255);
		$this->setColor("yellow",255,255,0);
		$this->setColor("white", 255,255,255);
		$this->setColor("black", 0,0,0);
		$this->setColor("transparent", 0,0,0);

		$color_pie = array();
		$color_pie[] = array(0, 62, 136);
		$color_pie[] = array(0, 115, 106);
		$color_pie[] = array(220, 101, 29);
		$color_pie[] = array(189, 24, 51);
		$color_pie[] = array(214, 0, 127);
		$color_pie[] = array(98, 1, 96);
		$color_pie[] = array(82, 56, 47);
		$color_pie[] = array(255, 153, 204);
		$color_pie[] = array(137, 91, 74);
		$color_pie[] = array(255, 203, 3);
		$color_pie[] = array(153, 204, 0);
		if(!function_exists("color_cmp")) {
			function color_cmp($a, $b) {return (rand(0, 10) > 7) ? -1 : 1;};
		}
		uksort($color_pie, "color_cmp");
		$i = 1;
		foreach($color_pie as $value) {
			$this->setColor("pie_{$i}", $value);
			$i++;
		}
		if(!is_null($background)) {
			if(is_array($background)) {
				$this->setColor("background", $background[0], $background[1], $background[2]);
				$this->fillImage(array(0,0),"background");
			} elseif(file_exists($background)) {
				$this->setTile($background);
			} else {
				$this->fillImage(array(0,0),$background);
			}
		} else {
			$this->fillImage(array(0,0),"transparent");
		}
		return;
	}

	public function setTile($image, $point = NULL, $width = NULL, $height = NULL) {
		$tile = $this->loadImage($image);
		if($tile) {
			if(!$this->checkPoint($point)) $point = array(0 , 0);
			if(is_null($width)) $width = $this->width;
			if(is_null($height)) $height = $this->height;
			imagesettile($this->img, $tile);
			imageFilledRectangle ($this->img, $point[0], $point[1], $point[0] + $width, $point[1] + $height, IMG_COLOR_TILED);
			$this->destroyImage($tile);
			return true;
		} else {
			return false;
		}
	}

	public function setTransparent($color) {
		$result = 0;
		if($this->checkPoint($color)) {
			$result = imagecolortransparent($this->img, $this->getColor($color));
		} elseif(isset($this->color_lst[$color])) {
			$result = imagecolortransparent($this->img, $this->color_lst[$color]);
		} else {
			$result = imagecolortransparent($this->img, $color);
		}
		return $result;
	}

	public function randomColor($rand = false, $alpha = true) {
		if(!$this->checkImage()) return false;
		if(count($this->color_lst)>0 && $rand) {
			return $this->color_lst[array_rand($this->color_lst)];
		} else {
			return $alpha ? imagecolorallocatealpha($this->img, rand(0,255), rand(0,255), rand(0,255), rand(0,127)) : imagecolorallocate($this->img, rand(0,255), rand(0,255), rand(0,255));
		}
	}

	public function loadImage($image, &$data = array()) {
		if(!file_exists($image)) return false;
		$data = getimagesize($image);
		if(!$data) return false;
		switch(true) {
			case ($data[2]==1 && (imagetypes() & IMG_GIF)):
				$img = imagecreatefromgif($image);
				break;
			case ($data[2]==2 && (imagetypes() & IMG_JPG)):
				$img = imagecreatefromjpeg($image);
				break;
			case ($data[2]==3 && (imagetypes() & IMG_PNG)):
				$img = imagecreatefrompng($image);
				break;
			case ($data[2]==6):
				$img = $this->ImageCreateFromBMP($image);
				break;
			case ($data[2]==15 && (imagetypes() & IMG_WBMP)):
				$img = imagecreatefromwbmp($image);
				break;
			default:
				return false;
			break;
		}
		return $img;
	}

	public function rotateImage($angle, $img = NULL) {
		if(is_null($img)) {
			$new_img = imagerotate($this->img, $angle, 0);
			$this->destroyImage();
			$this->img = $new_img;
			if(fmod($angle,90)!==0) $this->setTransparent(array(0,0));
			list($this->width, $this->height) = $this->getSize();
			return true;
		} else {
			return imagerotate($img, $angle, IMG_COLOR_TRANSPARENT);
		}
	}

	public function resizeImage($rate, $return = false, $img = NULL) {
		if(is_null($img)) $img = $this->img;
		if(!$this->checkImage($img)) {
			$img = $this->loadImage($img);
			if($img===false) return false;
		}
		list($width, $height) = $this->getSize($img);
		if(is_float($rate)) {
			$new_width = $width * $rate;
			$new_height = $height * $rate;
		} elseif(is_array($rate)) {
			list($new_width, $new_height) = $rate;
			$new_width = min($new_width, $width);
			$new_height = min($new_height, $height);
			$rate = min($new_width/$width, $new_height,$height);
			$new_width = $width * $rate;
			$new_height = $height * $rate;
		} else {
			return false;
		}
		if(function_exists("imagecopyresampled")) {
			$new_img = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($new_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		} else {
			$new_img = imagecreate($new_width, $new_height);
			imagecopyresized($new_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		}
		if($return) {
			return $new_img;
		} else {
			$this->destroyImage();
			$this->img = $new_img;
			$this->width = $new_width;
			$this->height = $new_height;
			return true;
		}
	}

	public function cropImage($point, $width, $height, $return = false, $img = NULL) {
		if(!$this->checkPoint($point)) return false;
		if(is_null($img)) $img = $this->img;
		if(!$this->checkImage($img)) {
			$img = $this->loadImage($img);
			if($img===false) return false;
		}
		$new_img = imagecreatetruecolor($width, $height);
		imagecopyresampled($new_img, $img, 0, 0, $point[0], $point[1], $width, $height, $width, $height);
		if($return) {
			return $new_img;
		} else {
			$this->destroyImage();
			$this->img = $new_img;
			return true;
		}
	}

	public function pasteImage($img, $point = array(0, 0), $alpha = 100) {
		if(!$this->checkImage()) return false;
		if(!$this->checkPoint($point)) $point = array(0, 0);
		if($alpha <= 0) {
			return imagecopymergegray($this->img, $img, $point[0], $point[1], 0, 0, imagesx($img), imagesy($img), $alpha);
		} elseif($alpha > 0 && $alpha <= 100) {
			return imagecopymerge($this->img, $img, $point[0], $point[1], 0, 0, imagesx($img), imagesy($img), $alpha);
		} else {
			return imagecopy($this->img, $img, $point[0], $point[1], 0, 0, imagesx($img), imagesy($img));
		}
	}

	public function setLine($thickness = 1, $style = NULL, $brush = NULL) {
		if(!$this->checkImage()) return false;
		imagesetthickness($this->img, $thickness);
		if(is_array($style)) {
			$style_lst = array();
			$max_count = count($style);
			for($i=0; $i<$max_count; $i++) {
				if(isset($this->color_lst[$style[$i]])) $style_lst[] = $this->color_lst[$style[$i]];
			}
			imagesetstyle($this->img, $style_lst);
		}
		if(!is_null($brush)) {
			if(!$this->checkImage($brush)) $brush = loadImage($brush);
			if($brush) imagesetbrush($this->img, $brush);
		}
		return;
	}

	public function setFilter($filtertype, $img = NULL, $arg = NULL) {
		if(is_null($img)) $img = $this->img;
		if(!$this->checkImage($img)) return false;
		$result = false;
		if($filtertype == IMG_FILTER_COLORIZE) {
			imagefilter($img, $filtertype, $arg[0], $arg[1], $arg[2]);
		} else {
			imagefilter($img, $filtertype, $arg);
		}
		return $result;
	}

	public function getSize($img = NULL) {
		if(is_null($img)) $img = $this->img;
		if(!$this->checkImage($img)) return false;
		return array(imagesx($img), imagesy($img));
	}

	public function getColor($point, $mode = true) {
		if(!$this->checkImage()) return false;
		if(!$this->checkPoint($point)) return false;
		$color_index = imagecolorat($this->img, $point[0], $point[1]);
		$color_tran = array_values(imagecolorsforindex($this->img, $color_index));
		if($mode && isset($color_tran[2])) {
			return imagecolorallocate($this->img, $color_tran[0], $color_tran[1], $color_tran[2]);
		} else {
			return $color_tran;
		}
	}

	public function setColor($idx = "") {
		if(!$this->checkImage()) return false;
		if(empty($idx)) $idx = "idx_".(count($this->color_lst)+1);
		$color = array();
		$alpha = 0;
		if(func_num_args()==2) {
			$color = func_get_arg(1);
		} elseif(func_num_args()==3) {
			$color = func_get_arg(1);
			$alpha = func_get_arg(2);
		} elseif(func_num_args()==4) {
			$color = array_slice(func_get_args(), 1);
		} elseif(func_num_args()==5) {
			$color = array_slice(func_get_args(), 1, -1);
			$alpha = func_get_arg(4);
		} elseif(func_num_args()==0 || func_num_args()==1 ) {
			$color = array(0, 0, 0);
			$alpha = 127;
		} else {
			return false;
		}
		imagealphablending($this->img, true);
		imagesavealpha($this->img, true);
		if(isset($this->color_lst[$idx])) imagecolordeallocate($this->img, $this->color_lst[$idx]);
		$this->color_lst[$idx] = imagecolorallocatealpha($this->img, $color[0], $color[1], $color[2], $alpha);
		$color_mask = array();
		$color_mask[0] = $color[0]<50 ? 0 : $color[0]-50;
		$color_mask[1] = $color[1]<50 ? 0 : $color[1]-50;
		$color_mask[2] = $color[2]<50 ? 0 : $color[2]-50;
		if(isset($this->color_lst["{$idx}_mask"])) imagecolordeallocate($this->img, $this->color_lst["{$idx}_mask"]);
		$this->color_lst["{$idx}_mask"] = imagecolorallocatealpha($this->img, $color_mask[0], $color_mask[1], $color_mask[2], $alpha);
		return true;
	}

	public function setAlphaColor($idx = "", $alpha = 64) {
		if(!$this->checkImage()) return false;
		$color = array();
		if(func_num_args()==3) {
			$color = func_get_arg(2);
		} elseif (func_num_args()==5) {
			$color = array_slice(func_get_args(), 2);
		} else {
			return false;
		}
		if(empty($idx)) $idx = "idx_".(count($this->color_lst)+1);
			$color_mask = array();
			$color_mask[0] = $color[0]<50 ? 0 : $color[0]-50;
			$color_mask[1] = $color[1]<50 ? 0 : $color[1]-50;
			$color_mask[2] = $color[2]<50 ? 0 : $color[2]-50;
			if(isset($this->color_lst[$idx])) imagecolordeallocate($this->img, $this->color_lst[$idx]);
		$this->color_lst[$idx] = imagecolorallocatealpha($this->img, $color[0], $color[1], $color[2], $alpha);
			if(isset($this->color_lst["{$idx}_mask"])) imagecolordeallocate($this->img, $this->color_lst["{$idx}_mask"]);
		$this->color_lst["{$idx}_mask"] = imagecolorallocatealpha($this->img, $color_mask[0], $color_mask[1], $color_mask[2], $alpha);
		return true;
	}

	public function checkPoint() {
		$count = func_num_args();
		if($count==0) return false;
		for($i=0; $i<$count; $i++) {
			$point = func_get_arg($i);
			if(!is_array($point)) return false;
			if(count($point)!=2) return false;
			if(!is_numeric($point[0]) || !is_numeric($point[1])) return false;
		}
		return true;
	}

	public function checkPoints($points) {
		if(!is_array($points)) return false;
		$max_count = count($points);
		for($i=0; $i<$max_count; $i++) {
			if(!$this->checkPoint($points[$i])) return false;
		}
		return true;
	}

	public function checkImage($img = NULL) {
		if(is_null($img)) $img = $this->img;
		return (is_resource($img) && get_resource_type($img)=="gd");
	}

	public function fillImage($point = array(0,0), $color = "", $color_border = NULL) {
		if(!$this->checkImage()) return false;
		$color = isset($this->color_lst[$color]) ? $this->color_lst[$color] : $this->randomColor();
		if(is_null($color_border)) {
			return imagefill($this->img, $point[0], $point[1], $color);
		} else {
			return imagefilltoborder($this->img, $point[0], $point[1], $color_border, $color);
		}
	}

	public function drawLine($p_start, $p_end, $color=""){
		if(!$this->checkImage()) return false;
		if(!$this->checkPoint($p_start, $p_end)) return false;
		if($color=="style") {
			imageline($this->img, $p_start[0], $p_start[1], $p_end[0], $p_end[1], IMG_COLOR_STYLED);
		} elseif($color=="brush") {
			imageline($this->img, $p_start[0], $p_start[1], $p_end[0], $p_end[1], IMG_COLOR_BRUSHED);
		} elseif($color=="style_brush") {
			imageline($this->img, $p_start[0], $p_start[1], $p_end[0], $p_end[1], IMG_COLOR_STYLEDBRUSHED);
		} else {
			$color = isset($this->color_lst[$color]) ? $this->color_lst[$color] : $this->randomColor();
			imageline($this->img, $p_start[0], $p_start[1], $p_end[0], $p_end[1], $color);
		}
		return true;
	}

	public function drawRectangle($point, $width, $height, $color_line = "", $color_fill = "") {
		if(!$this->checkImage()) return false;
		if(!$this->checkPoint($point)) return false;
		if(!empty($color_fill)) {
			$color = isset($this->color_lst[$color_fill]) ? $this->color_lst[$color_fill] : $this->randomColor();
			imagefilledrectangle($this->img, $point[0], $point[1], $point[0]+$width, $point[1]+$height, $color);
		}
		$color = isset($this->color_lst[$color_line]) ? $this->color_lst[$color_line] : $this->randomColor();
		imagerectangle($this->img, $point[0], $point[1], $point[0]+$width, $point[1]+$height, $color);
		return true;
	}

	public function drawPolygon($points, $color_line = "", $color_fill = "") {
		if(!$this->checkImage()) return false;
		if(!$this->checkPoints($points)) return false;
		if(count($points)==1) {
			$color = isset($this->color_lst[$color_line]) ? $this->color_lst[$color_line] : $this->randomColor();
			imagesetpixel($this->img, $points[0][0], $points[0][1], $color);
			return true;
		}	elseif(count($points)==2) {
			$this->drawLine($points[0], $points[1], $color_line);
			return true;
		} else {
			$point_lst = array();
			$count = 0;
			foreach($points as $value) {
				if($this->checkPoint($value)) {
					$point_lst = array_merge($point_lst, $value);
					$count++;
				}
			}
			if(!empty($color_fill)) {
				$color = isset($this->color_lst[$color_fill]) ? $this->color_lst[$color_fill] : $this->randomColor();
				imagefilledpolygon($this->img, $point_lst, $count, $color);
			}

			if($color_line=="style") {
				imagepolygon($this->img, $point_lst, $count, IMG_COLOR_STYLED);
			} elseif($color_line=="brush") {
				imagepolygon($this->img, $point_lst, $count, IMG_COLOR_BRUSHED);
			} elseif($color_line=="style_brush") {
				imagepolygon($this->img, $point_lst, $count, IMG_COLOR_STYLEDBRUSHED);
			} else {
				$color = isset($this->color_lst[$color_line]) ? $this->color_lst[$color_line] : $this->randomColor();
				imagepolygon($this->img, $point_lst, $count, $color);
			}
		}
		return true;
	}

	public function drawFiveSidedStar($point, $radius, $color_line = "", $color_fill = "", $star=true, $spiky=NULL) {
		$x = $point[0];
		$y = $point[1];
		$angle = 360/5;
		$points = array();
		$points[0][0] = $x;
		$points[0][1] = $y - $radius;
		$points[2][0] = $x + ($radius * cos(deg2rad(90 - $angle)));
		$points[2][1] = $y - ($radius * sin(deg2rad(90 - $angle)));
		$points[4][0] = $x + ($radius * sin(deg2rad(180 - ($angle*2))));
		$points[4][1] = $y + ($radius * cos(deg2rad(180 - ($angle*2))));
		$points[6][0] = $x - ($radius * sin(deg2rad(180 - ($angle*2))));
		$points[6][1] = $y + ($radius * cos(deg2rad(180 - ($angle*2))));
		$points[8][0] = $x - ($radius * cos(deg2rad(90 - $angle)));
		$points[8][1] = $y - ($radius * sin(deg2rad(90 - $angle)));
		if($star) {
			 if($spiky == NULL) $spiky = 0.5;	// degree of spikiness, default to 0.5
			 $indent = $radius * $spiky;
			 $points[1][0] = $x + ($indent * cos(deg2rad(90 - $angle/2)));
			 $points[1][1] = $y - ($indent * sin(deg2rad(90 - $angle/2)));
			 $points[3][0] = $x + ($indent * sin(deg2rad(180 - $angle)));
			 $points[3][1] = $y - ($indent * cos(deg2rad(180 - $angle)));
			 $points[5][0] = $x;
			 $points[5][1] = $y + ($indent * sin(deg2rad(180 - $angle)));
			 $points[7][0] = $x - ($indent * sin(deg2rad(180 - $angle)));
			 $points[7][1] = $y - ($indent * cos(deg2rad(180 - $angle)));
			 $points[9][0] = $x - ($indent * cos(deg2rad(90 - $angle/2)));
			 $points[9][1] = $y - ($indent * sin(deg2rad(90 - $angle/2)));
		}
		ksort($points);
		$point_lst = array();
		foreach($points as $value) {
			$point_lst[] = $value;
		}
		return $this->drawPolygon($point_lst, $color_line, $color_fill);
	}

	public function drawEllipse($point, $width, $height, $color = "", $fill = false) {
		if(!$this->checkImage()) return false;
		if(!$this->checkPoint($point)) return false;
		$color = isset($this->color_lst[$color]) ? $this->color_lst[$color] : $this->randomColor();
		$func = $fill ? "imagefilledellipse" : "imageellipse";
		return $func($this->img, $point[0], $point[1], $width, $height, $color);
	}

	public function drawEllipseStroke($point, $width, $height, $color = "", $color_side = "") {
		$this->drawEllipse($point, $width, $height, $color, true);
		$this->drawEllipse($point, $width, $height, $color_side, false);
	}

	public function drawArc($point, $width, $height, $arc = array(0, 360), $color = "", $fill = NULL) {
		if(!$this->checkImage()) return false;
		if(!$this->checkPoint($point)) return false;
		$color = isset($this->color_lst[$color]) ? $this->color_lst[$color] : $this->randomColor();
		if(is_null($fill)) {
			return imagearc($this->img, $point[0], $point[1], $width, $height, $arc[0], $arc[1], $color);
		} else {
			return imagefilledarc($this->img, $point[0], $point[1], $width, $height, $arc[0], $arc[1], $color, $fill);
		}
	}

	public function drawArcStroke($point, $width, $height, $arc = array(0, 360), $color = "", $color_side = "") {
		$this->drawArc($point, $width, $height, $arc, $color, 0);
		$this->drawArc($point, $width, $height, $arc, $color_side, 6);
	}

	public function drawPie($data, $point, $width, $height, $mask = 20, $ext_value = 0, $distance = 0, $start_angle = 0) {
		if(!$this->checkPoint($point)) return false;
		$data_sum = array_sum($data) + $ext_value;
		$angle = array();
		$angle_sum = array($start_angle);
		$max_count = count($data);
		for($i=0; $i<$max_count; $i++) {
			$angle[] = (($data[$i] / $data_sum) * 360);
	 		$angle_sum[] = array_sum($angle) + $start_angle;
		}

		for($i=$point[1]+$mask; $i>$point[1]; $i--) {
			$max_count = count($data);
			for($j=1; $j<=$max_count; $j++) {
				if($angle_sum[$j-1] == $angle_sum[$j]) continue;
				$point_cur = $point;
				if($distance>0) {
					$point_cur[0] += round($distance * cos(deg2rad($angle_sum[$j] - $angle[$j-1] / 2)));
					$point_cur[1] = $i + round($distance * sin(deg2rad($angle_sum[$j] - $angle[$j-1] / 2)));
				} else {
					$point_cur[1] = $i;
				}
				$this->drawArc($point_cur, $width, $height, array($angle_sum[$j-1], $angle_sum[$j]), "pie_{$j}_mask", IMG_ARC_PIE);
			}
		}
		
		$max_count = count($data);
		for($j=1; $j<=$max_count; $j++) {
			if($angle_sum[$j-1] == $angle_sum[$j]) continue;
			$point_cur = $point;
			if($distance>0) {
				$point_cur[0] += round($distance * cos(deg2rad($angle_sum[$j] - $angle[$j-1] / 2)));
				$point_cur[1] += round($distance * sin(deg2rad($angle_sum[$j] - $angle[$j-1] / 2)));
				//$this->drawLine($point, $point_cur, "r");
			}
			$this->drawArc($point_cur, $width, $height, array($angle_sum[$j-1], $angle_sum[$j]), "pie_{$j}", IMG_ARC_PIE);
		}
		return true;
	}

	public function drawZigzag($points, $color_line = "") {
		if(!$this->checkImage()) return false;
		if(!$this->checkPoints($points)) return false;
		if(count($points)==1) {
			$color = isset($this->color_lst[$color_line]) ? $this->color_lst[$color_line] : $this->randomColor();
			imagesetpixel($this->img, $points[0][0], $points[0][1], $color);
			return true;
		}	elseif(count($points)==2) {
			$this->drawLine($points[0], $points[1], $color_line);
			return true;
		} else {
			$point = array(0, 0);
			$max_count = count($points)-1;
			for($i=0; $i<$max_count; $i++) {
				$this->drawLine($points[$i], $points[$i+1], $color_line);
			}
		}
		return true;
	}

	public function drawString($text, $point, $color="", $font="", $font_size = 12, $angle = 0){
		if(!$this->checkImage()) return false;
		if(!$this->checkPoint($point)) return false;
		$color = isset($this->color_lst[$color]) ? $this->color_lst[$color] : $this->randomColor();
		$func = ($font == "up" ? "imagestringup" : "imagestring");
		if(empty($font) || $font=="up") $font = $this->font;
		if(empty($font)) {
			$font_size = floor($font_size/3);
			return $func($this->img, $font_size, $point[0], $point[1], $text, $color);
		} else {
			return imagettftext($this->img, $font_size, $angle, $point[0], $point[1], $color, $font, $text);
		}
	}

	public function setFont($font) {
		if(file_exists($font)) {
			$this->font = realpath($font);
			return true;
		} else {
			return false;
		}
	}

	public function getFontSize($text, $size = 12, $angle = 0) {
		if($size == 0 || empty($this->font)) {
			$result = array(imagefontwidth((INT)$text), imagefontheight((INT)$text));
		} else {
			$points = imagettfbbox($size, $angle, $this->font, $text);
			$result = array(($points[2]- $points[0]), ($points[3]- $points[5]));
			/*
			$point_lst = array();
			$point_lst[] = array($points[6], $points[7]);
			$point_lst[] = array($points[4], $points[5]);
			$point_lst[] = array($points[2], $points[3]);
			$point_lst[] = array($points[0], $points[1]);
			*/
		}
		return $result;
	}

	public function addNoise($number) {
		for ($i=0; $i<$number; $i++) {
			imageSetPixel($this->img, rand(0, $this->width), rand(0, $this->height), $this->randomColor(true));
		}
		return;
	}

	public function makeImage($type="png", $file="", $img=NULL) {
		$func = "";
		$contentType = "";

		if(is_null($img)) $img = $this->img;
		if(!$this->checkImage($img)) return false;
		switch(true) {
			case (strtolower($type)=="gif" && (imagetypes() & IMG_GIF)):
				$func = "imagegif";
				$contentType = "image/gif";
				break;
			case (strtolower($type)=="png" && (imagetypes() & IMG_PNG)):
				$func = "imagepng";
				$contentType = "image/png";
				break;
			case (strtolower($type)=="wbmp" && (imagetypes() & IMG_WBMP)):
				$func = "imagewbmp";
				$contentType = "image/vnd.wap.wbmp";
				break;
			case (strtolower($type)=="bmp"):
				$func = "imagebmp";
				$contentType = "image/bmp";
				break;
			default:
				$type="jpg";
				$func = "imagejpeg";
				$contentType = "imagejpeg";
			break;
		}

		//imagegammacorrect($img, 1.0, 1.6);

		if(empty($file)) {
			header("Content-type: {$contentType}");
			if($func == "imagebmp") {
				$this->imagebmp($img);
			} else	{
				$func($img);
			}
		} else {
			$this->MakeDir(dirname($file));
			if($func == "imagebmp") {
				$this->imagebmp($img, $file);
			} else	{
				$func($img, $file);
			}
		}
		$this->destroyImage($img);
		return;
	}

	public function destroyImage($img = NULL) {
		if(is_null($img)) $img = $this->img;
		if(!$this->checkImage($img)) return false;
		imagedestroy($img);
		return true;
	}

	public function transString($str, $charset = "gbk") {
		return function_exists("iconv") ? iconv($charset, "UTF-8//IGNORE", $str) : $str;
	}

	/*--- Functions From Others Start ---*/
	public function imagecreatefrombmp($filename) {
		//Code by admin@dhkold.com
		//Ouverture du fichier en mode binaire
		if (! $f1 = fopen($filename,"rb")) return FALSE;

		//1 : Chargement des enttes FICHIER
		$FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
		if ($FILE['file_type'] != 19778) return FALSE;

		//2 : Chargement des enttes BMP
		$BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
							'/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
							'/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
		$BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
		if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
		$BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
		$BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
		$BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
		$BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
		$BMP['decal'] = 4-(4*$BMP['decal']);
		if ($BMP['decal'] == 4) $BMP['decal'] = 0;

		//3 : Chargement des couleurs de la palette
		$PALETTE = array();
		if ($BMP['colors'] < 16777216){
		$PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
		}

		//4 : Cration de l'image
		$IMG = fread($f1,$BMP['size_bitmap']);
		$VIDE = chr(0);

		$res = imagecreatetruecolor($BMP['width'],$BMP['height']);
		$P = 0;
		$Y = $BMP['height']-1;
		while ($Y >= 0){
			$X=0;
			while ($X < $BMP['width']){
				if ($BMP['bits_per_pixel'] == 24) {
					$COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
				} elseif ($BMP['bits_per_pixel'] == 16) {
					$COLOR = unpack("n",substr($IMG,$P,2));
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				} elseif ($BMP['bits_per_pixel'] == 8) {
					$COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				} elseif ($BMP['bits_per_pixel'] == 4){
					$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
					if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				} elseif ($BMP['bits_per_pixel'] == 1) {
					$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
					if		(($P*8)%8 == 0) $COLOR[1] =	$COLOR[1]			>>7;
					elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
					elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
					elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
					elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
					elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
					elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
					elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				}	else {
					return FALSE;
				}
				imagesetpixel($res,$X,$Y,$COLOR[1]);
				$X++;
				$P += $BMP['bytes_per_pixel'];
			}
			$Y--;
			$P+=$BMP['decal'];
		}

		//Fermeture du fichier
		fclose($f1);
		return $res;
	}

	public function imagebmp($im, $fn = false) {
		if (!$im) return false;
		if ($fn === false) $fn = 'php://output';
		$f = fopen ($fn, "w");
		if (!$f) return false;

		//Image dimensions
		$biWidth = imagesx ($im);
		$biHeight = imagesy ($im);
		$biBPLine = $biWidth * 3;
		$biStride = ($biBPLine + 3) & ~3;
		$biSizeImage = $biStride * $biHeight;
		$bfOffBits = 54;
		$bfSize = $bfOffBits + $biSizeImage;

		//BITMAPFILEHEADER
		fwrite ($f, 'BM', 2);
		fwrite ($f, pack ('VvvV', $bfSize, 0, 0, $bfOffBits));

		//BITMAPINFO (BITMAPINFOHEADER)
		fwrite ($f, pack ('VVVvvVVVVVV', 40, $biWidth, $biHeight, 1, 24, 0, $biSizeImage, 0, 0, 0, 0));

		$numpad = $biStride - $biBPLine;
		for ($y = $biHeight - 1; $y >= 0; --$y)	{
			for ($x = 0; $x < $biWidth; ++$x) {
					$col = imagecolorat ($im, $x, $y);
					fwrite ($f, pack ('V', $col), 3);
			}
			for ($i = 0; $i < $numpad; ++$i) {
					fwrite ($f, pack ('C', 0));
			}
		}
		fclose($f);
		return true;
	}

	public function gif_info($filename) {
		$fp = fopen($filename,'rb');
		$result = fread($fp,13);
		$file['signatur'] = substr($result,0,3);
		$file['version'] = substr($result,3,3);
		$file['width'] = ord(substr($result,6,1))+ord(substr($result,7,1))*256;
		$file['height'] = ord(substr($result,8,1))+ord(substr($rsult,9,1))*256;
		$file['flag'] = ord(substr($result,10,1))>>7;
		$file['trans_red'] = ord(substr($result,ord(substr($result,11))*3,1));
		$file['trans_green'] = ord(substr($result,ord(substr($result,11))*3+1,1));
		$file['trans_blue'] = ord(substr($result,ord(substr($result,11))*3+2,1)) ;
		fclose($fp);
		return $file;
	}
	/*--- Functions From Others End ---*/
}

/*--------------------------------------------------------------------------------------------------------------------

	How To Use:
	$coordinateMaker = new coordinateMaker($width, $height, $origin, $cr)				//构造函数
	$coordinateMaker->setOrigin($point)													//设置原点位置
	$coordinateMaker->setPara()															//设置坐标参数
	$coordinateMaker->setPoint($point)													//取得相对原点坐标的实际位置
	$coordinateMaker->setScalePoint($point, $trans)										//俺比例取得相对原点坐标的实际位置
	$coordinateMaker->buileCoordinate($padding)											//绘制坐标系
	$coordinateMaker->drawZigzag($data_lst, $color_lst, $data_str, $show_value, $legend_point)								//画折线
	$coordinateMaker->drawBar($data_lst, $color_lst, $data_str, $show_value, $legend_point)									//画柱
	$coordinateMaker->drawPie($data, $data_str, $point, $width, $height, $mode, $mask, $ext_value, $distance, $start_angle)	//画饼

--------------------------------------------------------------------------------------------------------------------*/
class coordinateMaker extends imageCreator {
	public
		$origin = array(0, 0),
		$scale_x = 1,
		$scale_y = 1,
		$distance_x = 0,
		$distance_y = 0,
		$start_x = 0,
		$start_y = 0,
		$title_x = array(),
		$title_y = array(),
		$text_x = "X",
		$text_y = "Y",
		$fix_x = 10,
		$fix_y = -10;

	public function __construct() {
		$argList = func_get_args();
		if(count($argList)>0 ){
			call_user_func_array(array($this, "init"), $argList);
		} else {
			call_user_func(array($this, "init"));
		}
		return;
	}

	public function init($width = 400, $height = 400, $origin = array(0, 0), $cr = false) {
		$this->width = $width;
		$this->height = $height;
		if($cr) $this->createImage();
		$this->setOrigin($origin);
		return;
	}

	public function setOrigin($point) {
		if(!$this->checkPoint($point)) return false;
		$this->origin = $point;
		return true;
	}

	public function setPara($scale_x = 1, $scale_y = 1, $distance_x = 0, $distance_y = 0, $start_x = 0, $start_y = 0, $text_x = "X", $text_y = "Y", $font = "") {
		if(!is_numeric($scale_x) || !is_numeric($scale_y)) return false;
		if(!is_numeric($distance_x) || !is_numeric($distance_y)) return false;
		if(!is_numeric($start_x) || !is_numeric($start_y)) return false;
		$this->scale_x = $scale_x;
		$this->scale_y = $scale_y;
		$this->distance_x = $distance_x;
		$this->distance_y = $distance_y;
		$this->start_x = $start_x;
		$this->start_y = $start_y;
		$this->text_x = $this->transString($text_x);
		$this->text_y = $this->transString($text_y);
		if(!empty($font))$this->font = $font;
		return true;
	}

	public function setPoint($point) {
		if(!$this->checkPoint($point)) return false;
		return array(($this->origin[0]+$point[0]), $this->origin[1]-$point[1]);
	}

	public function setScalePoint($point, $trans = true) {
		if(!$this->checkPoint($point)) return false;
		$point_new = array(($point[0]-$this->start_x)*$this->scale_x, ($point[1]-$this->start_y)*$this->scale_y);
		if(abs($point[0]) < abs($this->start_x)) $point_new[0] = 0;
		if(abs($point[1]) < abs($this->start_y)) $point_new[1] = 0;
		if($trans) $point_new = $this->setPoint($point_new);
		return $point_new;
	}

	public function buileCoordinate($padding = 20) {
		$axis_x_start = array($padding, $this->origin[1]);
		$axis_x_end = array($this->width - $padding, $this->origin[1]);
		$axis_y_start = array($this->origin[0], $padding);
		$axis_y_end = array($this->origin[0], $this->height - $padding);

		//axis x
		$this->drawLine($axis_x_start, $axis_x_end, "black");
		$this->drawLine($axis_x_end, array($axis_x_end[0]-10, $axis_x_end[1]+5), "black");
		$this->drawLine($axis_x_end, array($axis_x_end[0]-10, $axis_x_end[1]-5), "black");
		$this->drawString($this->text_x, array($axis_x_end[0] + 10, $axis_x_end[1]+5), "black", $this->font);
		$this->drawString(0, $this->setPoint(array(-10, -15)), "black", $this->font);
		if($this->distance_x!=0) {
			$step = $this->distance_x * $this->scale_x;
			$step_length = $step;
			$positive = true;
			$negative	= true;
			$i = 1;
			while($positive || $negative) {
				if($positive && $step_length >= $this->width - $this->origin[0] - $padding) $positive = false;
				if($negative && $step_length >= $this->origin[0] - $padding) $negative = false;
				if($positive) {
					$point_start = $this->setPoint(array($step_length, 0));
					$point_end = $this->setPoint(array($step_length, 5));
					$this->drawLine($point_start, $point_end, "black");
					$title = isset($this->title_x[$i-1])?$this->transString($this->title_x[$i-1]):$i*$this->distance_x+$this->start_x;
					list($t_width, $t_height) = $this->getFontSize($title);
					$this->drawString($title, array($point_start[0] - $t_width/2, $point_start[1] + $t_height + $this->fix_x), "black", $this->font);
				}
				if($negative) {
					$point_start = $this->setPoint(array(-$step_length, 0));
					$point_end = $this->setPoint(array(-$step_length, 5));
					$this->drawLine($point_start, $point_end, "black");
					$title = isset($this->title_x[$i-1])?$this->transString($this->title_x[$i-1]):-$i*$this->distance_x-$this->start_x;
					list($t_width, $t_height) = $this->getFontSize($title);
					$this->drawString($title, array($point_start[0] - $t_width/2, $point_start[1] + $t_height + $this->fix_x), "black", $this->font);
				}
				$step_length += $step;
				$i++;
			}
		}

		//axis y
		$this->drawLine($axis_y_start, $axis_y_end, "black");
		$this->drawLine($axis_y_start, array($axis_y_start[0]-5, $axis_y_start[1]+10), "black");
		$this->drawLine($axis_y_start, array($axis_y_start[0]+5, $axis_y_start[1]+10), "black");
		$this->drawString($this->text_y, array($axis_y_start[0] - 10, $axis_y_start[1] - 10), "black", $this->font);
		if($this->distance_y!=0) {
			$step = $this->distance_y * $this->scale_y;
			$step_length = $step;
			$positive = true;
			$negative	= true;
			$i = 1;
			while($positive || $negative) {
				if($positive && $step_length >= $this->origin[1] - $padding) $positive = false;
				if($negative && $step_length >= $this->height - $this->origin[1] - $padding) $negative = false;
				if($positive) {
					$point_start = $this->setPoint(array(0, $step_length));
					$point_end = $this->setPoint(array(5, $step_length));
					$this->drawLine($point_start, $point_end, "black");
					$cur_scale = (String)($i * $this->distance_y + $this->start_y);
					$title = isset($this->title_y[$i-1])?$this->transString($this->title_y[$i-1]):$cur_scale;
					list($t_width, $t_height) = $this->getFontSize($title);
					$this->drawString($title, array($point_start[0] - $t_width + $this->fix_y, $point_start[1] + $t_height/2), "black", $this->font);
				}
				if($negative) {
					$point_start = $this->setPoint(array(0, -$step_length));
					$point_end = $this->setPoint(array(5, -$step_length));
					$this->drawLine($point_start, $point_end, "black");
					$cur_scale = (String)(-$i * $this->distance_y - $this->start_y);
					$title = isset($this->title_y[$i-1])?$this->transString($this->title_y[$i-1]):$cur_scale;
					list($t_width, $t_height) = $this->getFontSize($title);
					$this->drawString($title, array($point_start[0] - $t_width + $this->fix_y, $point_start[1] + $t_height/2), "black", $this->font);
				}
				$step_length += $step;
				$i++;
			}
		}
		return;
	}

	public function drawZigzag($data_lst, $color_lst="", $data_str="", $show_value = true, $legend_point = NULL) {
		if(is_string($color_lst)) {
			$points_new = array();
			$points = $data_lst;
			$distance = $this->start_x;
			$max_count = count($points);
			for($i=0; $show_value && $i<$max_count; $i++) {
				$distance += $this->distance_x;
				$point = array($distance, $points[$i]);
				$point = $this->setScalePoint($point, true);
				$points_new[] = $point;
				$this->drawString($points[$i], $point, "black");
				$this->drawEllipse($point, 5, 5, $color_lst, true);
			}
			parent::drawZigzag($points_new, $color_lst);
		} else {
			$cnt = min(count($data_lst), count($data_str), count($color_lst));
			for($n=0; $n<$cnt; $n++) {
				$points_new = array();
				$points = $data_lst[$n];
				$distance = $this->start_x;
				$max_count = count($points);
				for($i=0; $show_value && $i<$max_count; $i++) {
					$distance += $this->distance_x;
					$point = array($distance, $points[$i]);
					$point = $this->setScalePoint($point, true);
					$points_new[] = $point;
					$this->drawString($points[$i], $point, "black");
					$this->drawEllipse($point, 5, 5, $color_lst[$n], true);
				}
				parent::drawZigzag($points_new, $color_lst[$n]);
			}

			if(is_null($legend_point)) $legend_point = array($this->width - 150, 20);
			$line_len = 50;
			$max_count = count($data_str);
			for($i = 0; $i < $max_count; $i++) {
				$this->drawLine($legend_point, array($legend_point[0]+$line_len, $legend_point[1]), $color_lst[$i]);
				$this->drawEllipse(array($legend_point[0]+$line_len/2, $legend_point[1]), 5, 5, $color_lst[$i], true);
				$data_str[$i] = $this->transString($data_str[$i]);
				$this->drawString($data_str[$i], array($legend_point[0]+$line_len+10, $legend_point[1]+5), "black", $this->font);
				$legend_point[1] += 30;
			}
		}
		return;
	}

	public function drawBar($data_lst, $color_lst="", $data_str="", $show_value = false, $legend_point = NULL) {
		$distance = $this->start_x;
		list($font_width, $font_height) = $this->getFontSize(4, 0);
		if(is_string($color_lst)) {
			$cnt = count($data_lst);
			$bar_width = 30;
			$point = array();
			for($i=0; $i<$cnt; $i++) {
				$distance += $this->distance_x;
				$point = $this->setScalePoint(array($distance, $data_lst[$i]), false);
				$point[0] -= $bar_width/2;
				$this->drawRectangle($this->setPoint($point), $bar_width, $point[1], "black", $color_lst);
				if($show_value) {
					$point = $this->setPoint($point);
					$point[0] -= ($font_width * strlen((STRING)$data_lst[$i])-$bar_width)/2;
					$point[1] -= $font_height;
					$this->drawString($data_lst[$i], $point, "black");
				}
			}
		} else {
			$cnt = min(count($data_lst[0]), count($data_str), count($color_lst));
			$bar_width = ceil(($this->distance_x*$this->scale_x - 100)/$cnt);
			if($bar_width > 20) $bar_width = 20;
			$max_count = count($data_lst);
			for($n=0; $n<$max_count; $n++) {
				$point = array();
				$distance += $this->distance_x;
				for($i=0; $i<$cnt; $i++) {
					$point = $this->setScalePoint(array($distance, $data_lst[$n][$i]), false);
					$point[0] = $point[0] - ($bar_width*$cnt)/2 + $bar_width*$i;
					$this->drawRectangle($this->setPoint($point), $bar_width, $point[1], "black", $color_lst[$i]);
					if($show_value) {
						$point = $this->setPoint($point);
						$point[0] -= ($font_width * strlen((STRING)$data_lst[$n][$i])-$bar_width)/2;
						$point[1] -= $font_height;
						$this->drawString($data_lst[$n][$i], $point, "black");
					}
				}
			}

			if(is_null($legend_point)) $legend_point = array($this->width - 150, 20);
			$max_count = count($data_str);
			for($i = 0; $i < $max_count; $i++) {
				$this->drawRectangle($legend_point, 15, 15, "black", $color_lst[$i]);
				$data_str[$i] = $this->transString($data_str[$i]);
				$this->drawString($data_str[$i], array($legend_point[0]+30, $legend_point[1]+14), "black", $this->font);
				$legend_point[1] += 30;
			}
		}
		return;
	}

	public function drawPie($data, $data_str, $point, $width, $height, $mode = 1, $legend = 0, $mask = 20, $ext_value = 0, $distance = 0, $start_angle = 0) {
		parent::drawPie($data, $point, $width, $height, $mask, $ext_value, $distance, $start_angle);
		$data_sum = array_sum($data) + $ext_value;
		$angle = array();
		$angle_sum = array($start_angle);
		$max_count = count($data);
		for($i=0; $i<$max_count; $i++) {
			$angle[] = (($data[$i] / $data_sum) * 360);
	 		$angle_sum[] = array_sum($angle);
		}
		$radius = ($width + $height) / 4 + $distance + 20;
		if($legend==1) {
			$legend_left = $point[0]+$width/2 + 80 + $distance;
			$legend_top = $point[1]-$height/2;
		} else {
			$legend_left = $distance;
			$legend_top = $point[1] + $height - 60;
		}
		
		$max_count = count($data);
		for($i=0; $i<$max_count; $i++) {
			if($mode==0) {
				$value = $data[$i];
			} else {
				$value = ceil($data[$i]*100/$data_sum)."%";
			}
			$value_show = $data_str[$i]."\n".$value;
			$radian = deg2rad($angle_sum[$i]+$angle[$i]/2);
			$the_point = array(ceil($point[0]+$radius*cos($radian)*($width/$height)), ceil($point[1]+$radius*sin($radian)));
			$this->drawString($value_show, array($the_point[0]+1, $the_point[1]+1), "white");
			$this->drawString($value_show, $the_point, "black");

			if($legend!=0) {
				$the_point = array($legend_left, $legend_top);
				$this->drawRectangle($the_point, 15, 15, "black", "pie_".($i+1));
				$the_point[0] += 20;
				$the_point[1] += 14;
				$data_str[$i] .= " - {$value}";
				$data_str[$i] = $this->transString($data_str[$i]);
				$this->drawString($data_str[$i], array($the_point[0]+1, $the_point[1]+1), "white", $this->font);
				$this->drawString($data_str[$i], $the_point, "black", $this->font);
				$legend_top += 30;
			}
		}
		return;
	}
}

/*--------------------------------------------------------------------------------------------------------------------

	How To Use:
	$imageCreator_file = new imageCreator_file($file)
	
	Just a image file open extend for imagecreate
--------------------------------------------------------------------------------------------------------------------*/

class imageCreator_file extends imageCreator {
	public
		$file = "",
		$file_date = array(),
		$true_color = false;

	public function __construct() {
		$argList = func_get_args();
		if(count($argList)>0 ){
			call_user_func_array(array($this, "init"), $argList);
		}
		return;
	}

	public function init($file) {
		$data = array();
		$this->img = $this->loadImage($file, $data);
		if(!$this->img) {
			$this->Error("Cannot read image file: {$file}");
			return;
		}
		list($this->width, $this->height, $type) = $data;
		if($type == 2) imageinterlace($this->img, 0);
		$this->file_date = $data;
		$this->file = $file;
		$this->true_color = imageistruecolor($this->img);
		return;
	}

	public function createImage() {
		return;
	}
}
?>