<?php

namespace Digiants\FastAdminPanel\ShopTemplates;

class ShopTemplate {
    
    protected function template_add_folder ($path) {

		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}
	}

	protected function folder_files($dir)
	{
		return array_values(array_diff(scandir($dir), array('..', '.')));
	}

	protected function copy_folder($from, $to) {

		$this->template_add_folder($to);

		if ($from[strlen($from) - 1] != '/')
			$from .= '/';
		
		if ($to[strlen($to) - 1] != '/')
			$to .= '/';

		$files = $this->folder_files($from);

		foreach ($files as $file) {

			if (is_dir($from.$file)) {
				$this->copy_folder($from.$file, $to.$file);
			} else {

				if (file_exists($to.$file))
            		unlink($to.$file);

				copy(
					$from.$file,
					$to.$file
				);
			}
		}

	}
}