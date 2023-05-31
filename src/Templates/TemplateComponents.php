<?php

namespace Digiants\FastAdminPanel\Templates;

class TemplateComponents extends Template{

	protected function template_path_package ($path) {

		return base_path("vendor/sv-digiants/fastadminpanel/templates/components" . $path);
	}

	public function import () {

		// add converter
		$this->template_add_folder(public_path('/css'));
		$this->template_add_folder(public_path('/css/cache'));
		$this->template_add_folder(public_path('/js'));
		$this->template_add_folder(public_path('/js/cache'));


		$css = [
			'desktop-src.css',
			'mobile-src.css',
		];

		foreach ($css as $path) {
			copy(
				$this->template_path_package("/css/$path"),
				public_path("/css/$path")
			);
		}

		// add views
		$this->template_add_folder(base_path('/resources/views/inc'));
		$this->template_add_folder(base_path('/resources/views/pages'));
		$this->template_add_folder(base_path('/resources/views/components'));
		$this->template_add_folder(base_path('/resources/views/components/inc'));

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
				$this->template_path_package("/views/$path"),
				base_path("/resources/views/$path")
			);
		}

		// routes
		if (file_exists(base_path("/routes/web.php"))) {
			unlink(base_path("/routes/web.php"));
		}

		copy(
			$this->template_path_package("/web.php"),
			base_path("/routes/web.php")
		);

		// controllers
		copy(
			$this->template_path_package("/Controllers/SitemapController.php"),
			base_path("/app/Http/Controllers/SitemapController.php")
		);
		copy(
			$this->template_path_package("/Controllers/PageController.php"),
			base_path("/app/Http/Controllers/PageController.php")
		);

		if (file_exists(base_path("/app/Http/Controllers/Controller.php")))
			unlink(base_path("/app/Http/Controllers/Controller.php"));

		copy(
			$this->template_path_package("/Controllers/Controller.php"),
			base_path("/app/Http/Controllers/Controller.php")
		);

		//components
		$this->template_add_folder(base_path('/app/View'));
		$this->template_add_folder(base_path('/app/View/Components'));
		$this->template_add_folder(base_path('/app/View/Components/Inc'));

		copy(
			$this->template_path_package("/Components/Layout.php"),
			base_path("/app/View/Components/Layout.php")
		);
		copy(
			$this->template_path_package("/Components/Inc/Breadcrumbs.php"),
			base_path("/app/View/Components/Inc/Breadcrumbs.php")
		);
		copy(
			$this->template_path_package("/Components/Inc/Footer.php"),
			base_path("/app/View/Components/Inc/Footer.php")
		);
		copy(
			$this->template_path_package("/Components/Inc/Header.php"),
			base_path("/app/View/Components/Inc/Header.php")
		);
		copy(
			$this->template_path_package("/Components/Inc/Pagination.php"),
			base_path("/app/View/Components/Inc/Pagination.php")
		);
		
		// rm default view
		if (file_exists(base_path("/resources/views/welcome.blade.php"))) {
			unlink(base_path("/resources/views/welcome.blade.php"));
		}
	}
    
}