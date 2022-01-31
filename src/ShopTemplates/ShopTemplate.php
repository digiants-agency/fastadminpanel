<?php

namespace Digiants\FastAdminPanel\ShopTemplates;

class ShopTemplate {
    
    protected function template_add_folder ($path) {

		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}
	}
}