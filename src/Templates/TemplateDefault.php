<?php

namespace Digiants\FastAdminPanel\Templates;

class TemplateDefault extends Template
{
	public function import()
	{
		// add converter
		$this->addFolder(public_path('/css'));
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
				$this->getPathPackage("/css/$path"),
				public_path("/css/$path"));
		}

		// add views
		$this->addFolder(base_path('/resources/views/inc'));
		$this->addFolder(base_path('/resources/views/layouts'));
		$this->addFolder(base_path('/resources/views/pages'));
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
				$this->getPathPackage("/views/$path"),
				base_path("/resources/views/$path")
			);
		}

		// routes
		if (file_exists(base_path("/routes/web.php"))) {

			unlink(base_path("/routes/web.php"));
		}

		copy(
			$this->getPathPackage("/web.php"),
			base_path("/routes/web.php")
		);

		// controllers
		copy(
			$this->getPathPackage("/SitemapController.php"),
			base_path("/app/Http/Controllers/SitemapController.php")
		);
		
		copy(
			$this->getPathPackage("/PageController.php"),
			base_path("/app/Http/Controllers/PageController.php")
		);

		if (file_exists(base_path("/app/Http/Controllers/Controller.php"))) {

			unlink(base_path("/app/Http/Controllers/Controller.php"));
		}

		copy(
			$this->getPathPackage("/Controller.php"),
			base_path("/app/Http/Controllers/Controller.php")
		);
		
		// rm default view
		if (file_exists(base_path("/resources/views/welcome.blade.php"))) {

			unlink(base_path("/resources/views/welcome.blade.php"));
		}
	}

	protected function getPathPackage($path)
	{
		return base_path("vendor/digiants-agency/fastadminpanel/templates/default" . $path);
	}
}