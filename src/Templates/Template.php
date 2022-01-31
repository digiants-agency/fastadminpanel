<?php

namespace Digiants\FastAdminPanel\Templates;

class Template {

    protected function template_add_folder ($path) {

		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}
	}

}