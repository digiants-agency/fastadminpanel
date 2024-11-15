<?php 

namespace App\FastAdminPanel\Helpers;

class ResizeImg
{
	/*
	* Resizes and optimizes images for web display.
	*
	* This function takes an image URL, width, and height as input parameters. It checks if the WebP
	* image format is supported, and if not, it returns the original URL. It then extracts the filename
	* and path from the provided URL, and creates the necessary directories if they do not exist.
	*
	* If the thumbnail image already exists, it returns the URL to the thumbnail image in WebP format.
	* Otherwise, it reads the original image, calculates the optimal dimensions for resizing, and creates
	* a thumbnail image in WebP format. It then returns the URL to the thumbnail image in WebP format.
	*
	* @param string $url     The original image URL.
	* @param int    $width   The desired width of the thumbnail image.
	* @param int    $height  The desired height of the thumbnail image.
	*
	* @return string The URL to the thumbnail image in WebP format. If the WebP format is not supported,
	*                it returns the original URL.
	*/
	public static function get($url, $width, $height)
	{
		if (!function_exists('imagewebp')) {
			return $url;
		}

		preg_match('/[^\/]+\.(jpg|jpeg|png)$/i', $url, $pathMatch);

		if (empty($pathMatch[0]) || empty($pathMatch[1])) {
			return $url;
		}

		$filename = $pathMatch[0];
		$format = $pathMatch[1];

		$path = str_replace($filename, '', $url);

		$realPath = rtrim(public_path(), '/').$path;

		if (!file_exists($realPath.$filename))
			return $path.$filename;

		if (!file_exists($realPath.'thumb'))
			mkdir($realPath.'thumb');

		$webpFilename = substr_replace($filename, 'webp', -strlen($format));

		if (file_exists($realPath.'thumb/'.$width.'_'.$filename)) {

			return $path.'thumb/'.$width.'_'.$webpFilename;
		}

		$imagesize = getimagesize($realPath.$filename);	// getimagesize - read all img and then get it info

		$realWidth = $imagesize[0];
		$realHeight = $imagesize[1];

		$ratioResize = $width / $height;
		$ratioOriginal = $realWidth / $realHeight;

		if ($ratioResize < $ratioOriginal) {
			$widthResize = ($height / $realHeight) * $realWidth;
			$heightResize = $height;
		} else {
			$widthResize = $width;
			$heightResize = ($width / $realWidth) * $realHeight;
		}

		$image = imagecreatefromstring(file_get_contents($realPath.$filename));

		if (!$image) return $url;

		if ($realWidth > $width) {

			$scaled_img = imagescale($image, $widthResize + 1, $heightResize + 1);

			imagedestroy($image);

			imagewebp($scaled_img, $realPath.'thumb/'.$width.'_'.$webpFilename);

			imagedestroy($scaled_img);

			return $path.'thumb/'.$width.'_'.$webpFilename;

		} else {

			imagewebp($image, $realPath.'thumb/'.$width.'_'.$webpFilename);

			imagedestroy($image);

			return $path.'thumb/'.$width.'_'.$webpFilename;
		}

		return $url;
	}
}
