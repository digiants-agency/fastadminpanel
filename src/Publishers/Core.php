<?php

namespace Digiants\FastAdminPanel\Publishers;

class Core
{
	public function publish()
	{
		$this->publishPartsFolder(
			$this->pathPackage('/core/storage'),
			base_path('/storage/app')
		);

		$this->publishPartsFolder(
			$this->pathPackage('/core/FastAdminPanel'),
			base_path('/app/FastAdminPanel')
		);

		$this->publishPartsFolder(
			$this->pathPackage('/core/views'),
			base_path('/resources/views/fastadminpanel')
		);

		$this->publishPartsFolder(
			$this->pathPackage('/core/migrations'),
			base_path('/database/migrations')
		);

		$this->publishPartsFolder(
			$this->pathPackage('/core/lang'),
			base_path('/lang')
		);

		$this->publishPartsFolder(
			$this->pathPackage('/public'),
			public_path('/vendor/fastadminpanel')
		);

		copy(
			$this->pathPackage('/core/routes.php'),
			base_path('/routes/fap.php')
		);

		copy(
			$this->pathPackage('/core/api.php'),
			base_path('/routes/fapi.php')
		);

		copy(
			$this->pathPackage('/core/config.php'),
			base_path('/config/fap.php')
		);
	}

	protected function pathPackage($path)
	{
		return base_path("/vendor/digiants-agency/fastadminpanel" . $path);
	}

	protected function publishPartsFolder($source, $destination)
	{
		if (!is_dir($destination)) {
			mkdir($destination, 0777, true);
		}

		$files = scandir($source);

		foreach ($files as $file) {

			if ($file == '.' || $file == '..')
				continue;

			if (is_dir($source . '/' . $file)) {

				$this->publishPartsFolder($source . '/' . $file, $destination . '/' . $file);

			} else {

				copy(
					$source . '/' . $file,
					$destination . '/' . $file
				);
			}
		}
	}
}