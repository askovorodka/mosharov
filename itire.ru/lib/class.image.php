<?php

class Image {
	
	function image_resize($src, $dest, $width, $height, $quality=90) {
		
		if (!file_exists($src)) return false;
		
		$size = getimagesize($src);
		
		if ($size === false) return false;

		$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
		$w=$size[0];
		$h=$size[1];
		
		if ($width<$w && $w>$h) {
			$new_width=$width;
			$coef=$w/$width;
			$new_height=round($h/$coef);
		}
		elseif ($h==$w) {
			$new_height=min($height,$width);
			$new_width=$new_height;
		}
		else {
			$new_height=$height;
			$coef=$h/$height;
			$new_width=round($w/$coef);
		}
		
		if ($width>$w && $height>$h) {
			$new_width=$w;
			$new_height=$h;
		}
		
		if ($format=='jpeg') $image_src = imagecreatefromjpeg($src);
		if ($format=='png') $image_src = imagecreatefrompng($src);
		if ($format=='gif') $image_src = imagecreatefromgif($src);
		
		$image_dest = imagecreatetruecolor($new_width, $new_height);
		$image_dest2 = imagecreatetruecolor($w, $h);

		imagecopyresampled($image_dest, $image_src, 0, 0, 0, 0, $new_width, $new_height, $w, $h);
		//imagecopyresampled($image_dest2, $image_src, 0, 0, 0, 0, $w, $h, $w, $h);

		imagecolorset($image_dest, 0, 255, 255, 255);
		if ($format=='jpeg') imagejpeg($image_dest, $dest, $quality);
		if ($format=='png') imagepng($image_dest, $dest, $quality);
		if ($format=='gif') imagegif($image_dest, $dest, $quality);
		//echo imagecolorat($image_dest,1,1).'<br>src='.imagecolorat($image_dest2,1,1);exit;
		//imagecolortransparent($image_dest, "#000000");
		
		
		
		imagedestroy($image_src);
		imagedestroy($image_dest);
		
		return true;
	
	}
	
	function image_details ($image) {
		
		$size = getimagesize($image);
		
		$result['format']=str_replace("image/","",$size['mime']);
		$result['width']=$size[0];
		$result['height']=$size[1];
			
		return $result;
		
	}

	
}

?>