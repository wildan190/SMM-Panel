<?php
/*
* Project name: BRI Captcha Bypasser
* Class name: imageOCR
* Author: Diki Agustin (dickyagustin@gmail.com)
*/


class imageOCR{
	public function getImageInfo($image){
		$w = imagesx($image);
		$h = imagesy($image);
		return array("w" => $w, "h" => $h);
	}
	
	public function hex2rgb($hex = null){
		$hex = str_replace("#" , "", $hex);
		if(strlen($hex) == 3){
			$r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
			$g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
			$b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
		}else{
			$r = hexdec(substr($hex, 0, 2));
			$g = hexdec(substr($hex, 2, 2));
			$b = hexdec(substr($hex, 4, 2));
		}
		$rgb = array($r, $g, $b);
		return $rgb;
	}
	
	public function bypass($type='file', $image = null){
      if($type == "file"){
         $img1 = imagecreatefrompng($image);
      }elseif($type == "string"){
         $img1 = imagecreatefromstring($image);
      }

      $size = @$this->getImageInfo($img1);

		if($size['w'] == 60 AND $size['h'] == 30){
			$imgW = 60;
			$imgH = 30;  
			$img2 = imagecreatetruecolor($imgW, $imgH);
			$img3 = imagecreatetruecolor($imgW, $imgH);
			$this->img3 = $img3;
			$this->data = json_decode(implode("", file("data.json")), true);
			
			imagecopyresampled($img2, $img1, 0, 0, 0, 0, $imgW, $imgH, $imgW, $imgH);
			imagefill($img3, 0, 0, imagecolorallocate($img3, 255, 255, 255));
					
			for($x=0; $x<$imgW; $x++){
				for($y=0; $y<$imgH; $y++){
					$color = $this->hex2rgb(imagecolorat($img2, $x, $y));
					if(implode("-", $color) == "0-0-0"){
						imagesetpixel($img3, $x, $y, imagecolorallocate($img3, $color[0],$color[1],$color[2]));
					}
				}
			}

			for($i=1; $i<=4; $i++){
				$result[$i] = "";
				for($j=0; $j<=9; $j++){
					$result[$i] .= $this->bypassPart($i, $j);
				}
				if($result[$i] == "") $result[$i] = "*";
			}
			
			$result = substr(implode("", $result), 0, 4);
			if(substr_count($result, "*") > 0){
				$status = "error";
				$reason = "beberapa digit dalam captcha tidak dapat dibaca";
			}else{
				$status = "success";
			}
		}else{
			$status = "error";
			$reason = "proses bypass captcha gagal";
		}
		
		if($status == "success"){
			return array("status" => $status, "result" => $result);
		}else{
			return array("status" => $status, "reason" => $reason);
		}
	}
	
	
	public function bypassPart($digit=null, $number=null){
		$img3  = $this->img3;
		$data  = $this->data;
		$dataA = $data[$digit-1][$number]['coord'][0];
		$dataB = $data[$digit-1][$number]['coord'][1];
		
		foreach($dataA as $dtA){
			if(imagecolorat($img3, $dtA['x'], $dtA['y']) != "0-0-0") $error[0] = "-";
		}
		if(!isset($error[0])) $result = $number;
		foreach($dataB as $dtB){
			if(imagecolorat($img3, $dtB['x'], $dtB['y']) != "0-0-0") $error[1] = "-";
		}
		if(!isset($error[1])) $result = $number;
		if(isset($result)) return $result;
	}
}


//$ocr = new imageOCR;
//$result = $ocr->bypass("file", "captchaTest.png");
//print_r($result);
