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
}