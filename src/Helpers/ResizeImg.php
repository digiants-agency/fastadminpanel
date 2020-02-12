<?php 

namespace Digiants\FastAdminPanel\Helpers;

class ResizeImg {

	public static function get ($path, $width, $height) {

		$site_path = public_path();
		$is_chrome = strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') != false;

		preg_match('/[^\/]+\.(jpg|jpeg|png|JPG|JPEG|PNG)$/', $path, $match);

		if (isset($match[0]))
			$filename = $match[0];
		else return $path;

		if (isset($match[1]))
			$format = $match[1];
		else return $path;

		if ($format != 'jpg' && $format != 'jpeg' && $format != 'png' && $format != 'JPG' && $format != 'JPEG' && $format != 'PNG')
			return $path;

		$path = str_replace($filename, '', $path);

		$real_path = rtrim($site_path, '/').$path;

		if (!file_exists($real_path.$filename))
			return $path.$filename;

		if (!file_exists($real_path.'thumb'))
			mkdir($real_path.'thumb');

		if (file_exists($real_path.'thumb/'.$width.'_'.$filename)) {
			if ($is_chrome)
				return $path.'thumb/'.$width.'_'.str_replace(['.png', '.jpg', '.jpeg', '.PNG', '.JPEG', '.JPG'], '.webp', $filename);
			return $path.'thumb/'.$width.'_'.$filename;
		}

		$imagesize = getimagesize($real_path.$filename);	// getimagesize - read all img and then get it info

		$real_width = $imagesize[0];
		$real_height = $imagesize[1];

		$ratio_resize = $width / $height;
		$ratio_original = $real_width / $real_height;

		if ($ratio_resize < $ratio_original) {
			$width_resize = ($height / $real_height) * $real_width;
			$height_resize = $height;
		}
		else {
			$width_resize = $width;
			$height_resize = ($width / $real_width) * $real_height;
		}

		if ($real_width > $width) {

			$image = imagecreatefromstring(file_get_contents($real_path.$filename));

			if ($image != false) {

				$scaled_img = imagescale($image, $width_resize + 1, $height_resize + 1);

				imagedestroy($image);

				if ($format == 'png')
					imagepng($scaled_img, $real_path.'thumb/'.$width.'_'.$filename);
				else {
					imagejpeg($scaled_img, $real_path.'thumb/'.$width.'_'.$filename, 83);
				}
				imagewebp($scaled_img, $real_path.'thumb/'.$width.'_'.str_replace(['.png', '.jpg', '.jpeg', '.PNG', '.JPEG', '.JPG'], '.webp', $filename));

				imagedestroy($scaled_img);

				return $path.'thumb/'.$width.'_'.str_replace(['.png', '.jpg', '.jpeg', '.PNG', '.JPEG', '.JPG'], '.webp', $filename);
			}
		} else {

			if (!copy($real_path.$filename, $real_path.'thumb/'.$width.'_'.$filename)) {
				return $path.$filename;
			} else {

				$image = imagecreatefromstring(file_get_contents($real_path.$filename));

				if ($image != false)
					imagewebp($image, $real_path.'thumb/'.$width.'_'.str_replace(['.png', '.jpg', '.jpeg', '.PNG', '.JPEG', '.JPG'], '.webp', $filename));
			}

			if ($is_chrome)
				return $path.'thumb/'.$width.'_'.str_replace(['.png', '.jpg', '.jpeg', '.PNG', '.JPEG', '.JPG'], '.webp', $filename);
			return $path.'thumb/'.$width.'_'.$filename;
		}

		return $path.$filename;
	}
}