<?php

namespace Digiants\FastAdminPanel\Templates;

class TemplateDefault extends Template{

	public function import_default_template () {

		// add converter
		$this->template_add_folder(public_path('/css'));
		$css = [
			'converter-desktop.php', 
			'converter-mobile.php',
			'desktop-src.css',
			'mobile-src.css',
			'desktop.css',
			'mobile.css',
		];
		foreach ($css as $path) {
			copy(
				$this->template_path_package("/css/$path"),
				public_path("/css/$path"));
		}

		// add views
		$this->template_add_folder(base_path('/resources/views/inc'));
		$this->template_add_folder(base_path('/resources/views/layouts'));
		$this->template_add_folder(base_path('/resources/views/pages'));
		$views = [
			'layouts/app.blade.php',
			'inc/footer.blade.php',
			'inc/header.blade.php',
			'inc/head.blade.php',
			'inc/pagination.blade.php',
			'pages/index.blade.php',
		];
		foreach ($views as $path) {
			copy(
				$this->template_path_package("/views/$path"),
				base_path("/resources/views/$path")
			);
		}

		// routes
		if (file_exists(base_path("/routes/web.php")))
			unlink(base_path("/routes/web.php"));
		copy(
			$this->template_path_package("/web.php"),
			base_path("/routes/web.php")
		);

		// controllers
		copy(
			$this->template_path_package("/SitemapController.php"),
			base_path("/app/Http/Controllers/SitemapController.php")
		);
		copy(
			$this->template_path_package("/PagesController.php"),
			base_path("/app/Http/Controllers/PagesController.php")
		);
		if (file_exists(base_path("/app/Http/Controllers/Controller.php")))
			unlink(base_path("/app/Http/Controllers/Controller.php"));
		copy(
			$this->template_path_package("/Controller.php"),
			base_path("/app/Http/Controllers/Controller.php")
		);
		
		// rm default view
		if (file_exists(base_path("/resources/views/welcome.blade.php")))
			unlink(base_path("/resources/views/welcome.blade.php"));
	}
    
}