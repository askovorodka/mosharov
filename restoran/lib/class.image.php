<?php

class Image {
	
	
function resize($src, $dst, $dst_width, $dst_height, $crop = true, $background = "#d3d1c4", $fix_width = false)
{
	if (is_file($src))
	{
		list($src_width, $src_height, $image_type) = @getimagesize($src);

		// Соотношение сторон оригинальной картинки

		$src_ratio = $src_width / $src_height;

		// Соотношение сторон результирующей картинки

		$dst_ratio = $dst_width / $dst_height;

		if ($image_type == IMAGETYPE_JPEG || $image_type == IMAGETYPE_GIF || $image_type == IMAGETYPE_PNG)
		{
			$tmp = tempnam(ROOT . '/tmp', "IR_");

			// Будем по мере поступления записывать консольные комманды в массив, а потом их скопом выполним

			$commands = array();

			// если фотку фиксируем по ширине
			if (!$fix_width)
			{
				// Если картинку нужно обрезать до нужных пропорций
				if ($crop)
				{
					// Определям, как нужно обрезать картинку, сверху-снизу или по бокам и если надо - режем

					if ($src_ratio > $dst_ratio)
					{
						// Исходник более приплюснут, чем результат

						$new_width = floor($src_height * $dst_ratio);
						$x_offset = floor(($src_width - $new_width) / 2);

						$commands[] = "/usr/local/bin/convert -crop {$new_width}x{$src_height}+$x_offset+0 $src $tmp";
					}
					elseif ($src_ratio < $dst_ratio)
					{
						// Исходник менее приплюснут, чем результат

						$new_height = floor($src_width / $dst_ratio);
						$y_offset = floor(($src_height - $new_height) / 2);

						$commands[] = "/usr/local/bin/convert -crop {$src_width}x{$new_height}+0+$y_offset $src $tmp";
					}
					else
					{
						// Одинаковое соотнощение сторон и у исходника и у результата

						$commands[] = "cp $src $tmp";
					}

					// Изменяем размер

					$commands[] = "/usr/local/bin/convert -strip -resize {$dst_width}x{$dst_height} -filter sinc -unsharp 0.5x0.3+1+0.0 $tmp $dst";
				}
				else
				{
					// Если картинку НЕ нужно обрезать

					if ($dst_width > $src_width && $dst_height > $src_height)
					{
						// Если исходник, всяко меньше результата

						$x_border = ceil(($dst_width - $src_width) / 2);
						$y_border = ceil(($dst_height - $src_height) / 2);

						$commands[] = "/usr/local/bin/convert -strip -bordercolor \"$background\" -border {$x_border}x{$y_border} -crop {$dst_width}x{$dst_height}+0+0 $src $dst";
					}
					elseif ($src_ratio > $dst_ratio)
					{
						// Исходник более приплюснут, чем результат

						$y_border = ceil(($dst_height - $dst_width / $src_ratio) / 2);

						$commands[] = "/usr/local/bin/convert -strip -resize {$dst_width}x{$dst_height} -filter sinc -unsharp 0.5x0.3+1+0.0 $src $tmp";
						$commands[] = "/usr/local/bin/convert  -bordercolor \"$background\" -border 0x{$y_border} -crop {$dst_width}x{$dst_height}+0+0 $tmp $dst";
					}
					elseif ($src_ratio < $dst_ratio)
					{
						// Исходник менее приплюснут, чем результат

						$x_border = ceil(($dst_width - $dst_height * $src_ratio) / 2);

						$commands[] = "/usr/local/bin/convert -strip -resize {$dst_width}x{$dst_height} -filter sinc -unsharp 0.5x0.3+1+0.0 $src $tmp";
						$commands[] = "/usr/local/bin/convert -bordercolor \"$background\" -border {$x_border}x0 -crop {$dst_width}x{$dst_height}+0+0 $tmp $dst";
					}
					else
					{
						// Исходник имеет теже соотношения сторон, что результат и больше оного

						$commands[] = "/usr/local/bin/convert -strip -resize {$dst_width}x{$dst_height} -filter sinc -unsharp 0.5x0.3+1+0.0 $src $dst";
					}
				}

			}
			else
			{
				//вычисляем высоту исходя из заданной ширины
				//если фотка для лайтбокса
				if ($dst_width == 1024)
				{
					//если оригинал больше 1024, то хренарим по ширине, 
					//иначе оставляем ее без изменения
					if ($src_width > 1024)
					{
						$dst_height = floor($dst_width / $src_ratio);
					}
					else
					{
						$dst_width = $src_width;
						$dst_height = $src_height;
					}
				}
				//иначе делаем как обычно
				else
				{
					$dst_height = floor($dst_width / $src_ratio);
				}
				//хренарим
				$commands[] = "/usr/local/bin/convert -strip -resize {$dst_width}x{$dst_height} -filter sinc -unsharp 0.5x0.3+1+0.0 $src $dst";
			}

		}

		$commands[] = "rm -f $tmp";

		// Выпоняем комманды

		if (is_array($commands))
		{
			//print_r($commands); exit();
			foreach ($commands as $command)
			{
				system($command);
			}
		}
	}
}
	
	
	
	
	
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