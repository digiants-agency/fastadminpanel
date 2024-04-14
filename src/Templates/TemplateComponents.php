<?php

namespace Digiants\FastAdminPanel\Templates;

class TemplateComponents extends Template
{
	public function import()
	{
		// add converter
		$this->addFolder(public_path('/css'));
		$this->addFolder(public_path('/css/cache'));
		$this->addFolder(public_path('/js'));
		$this->addFolder(public_path('/js/cache'));

		$css = [
			'desktop-src.css',
			'mobile-src.css',
		];

		foreach ($css as $path) {
			copy(
				$this->getPathPackage("/css/$path"),
				public_path("/css/$path")
			);
		}

		// add views
		$this->addFolder(base_path('/resources/views/inc'));
		$this->addFolder(base_path('/resources/views/pages'));
		$this->addFolder(base_path('/resources/views/components'));
		$this->addFolder(base_path('/resources/views/components/inc'));

		$views = [
			'inc/head.blade.php',
			'components/inc/header.blade.php',
			'components/inc/footer.blade.php',
			'components/inc/pagination.blade.php',
			'components/inc/breadcrumbs.blade.php',
			'components/layout.blade.php',
			'pages/index.blade.php',
			'pages/sitemap.blade.php',
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
			$this->getPathPackage("/Controllers/SitemapController.php"),
			base_path("/app/Http/Controllers/SitemapController.php")
		);
		copy(
			$this->getPathPackage("/Controllers/PageController.php"),
			base_path("/app/Http/Controllers/PageController.php")
		);

		if (file_exists(base_path("/app/Http/Controllers/Controller.php")))
			unlink(base_path("/app/Http/Controllers/Controller.php"));

		copy(
			$this->getPathPackage("/Controllers/Controller.php"),
			base_path("/app/Http/Controllers/Controller.php")
		);

		//components
		$this->addFolder(base_path('/app/View'));
		$this->addFolder(base_path('/app/View/Components'));
		$this->addFolder(base_path('/app/View/Components/Inc'));

		copy(
			$this->getPathPackage("/Components/Layout.php"),
			base_path("/app/View/Components/Layout.php")
		);
		copy(
			$this->getPathPackage("/Components/Inc/Breadcrumbs.php"),
			base_path("/app/View/Components/Inc/Breadcrumbs.php")
		);
		copy(
			$this->getPathPackage("/Components/Inc/Footer.php"),
			base_path("/app/View/Components/Inc/Footer.php")
		);
		copy(
			$this->getPathPackage("/Components/Inc/Header.php"),
			base_path("/app/View/Components/Inc/Header.php")
		);
		copy(
			$this->getPathPackage("/Components/Inc/Pagination.php"),
			base_path("/app/View/Components/Inc/Pagination.php")
		);
		
		// rm default view
		if (file_exists(base_path("/resources/views/welcome.blade.php"))) {
			unlink(base_path("/resources/views/welcome.blade.php"));
		}
	}

	protected function getPathPackage($path)
	{
		return base_path("vendor/digiants-agency/fastadminpanel/templates/components" . $path);
	}
}