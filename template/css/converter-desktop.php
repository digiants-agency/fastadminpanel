<?php 


$width = 1440;
$style_source_path = 'css/desktop-src.css';
$style_result_path = 'css/desktop.css';

$time_source = filemtime($style_source_path);
$time_result = filemtime($style_result_path);

if ($time_source > $time_result) {
	
	$css_px = file_get_contents($style_source_path);

	preg_match_all('/[ :]{1}[-]{0,1}[0-9\.]+px/', $css_px, $matches);

	for ($i = 0; $i < count($matches[0]); $i++) {

		if ($matches[0][$i] == ' 1px' || $matches[0][$i] == ' 2px' || $matches[0][$i] == ' 3px' || $matches[0][$i] == ' -1px' || $matches[0][$i] == ' -2px' || $matches[0][$i] == ' -3px')
			continue;

		$val = floatval($matches[0][$i]);

		$vw = round($val / $width * 100, 4);

		$css_px = str_replace($matches[0][$i], ' '.$vw.'vw', $css_px);
	}

	file_put_contents($style_result_path, $css_px);
}

echo "/$style_result_path?v=$time_source";