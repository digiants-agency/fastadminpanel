<?php

namespace Digiants\FastAdminPanel\Templates;

class Template {

    protected function template_add_folder ($path) {

		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}
	}

    protected function template_path_package ($path) {

		return base_path("/vendor/sv-digiants/fastadminpanel/template" . $path);
	}

}