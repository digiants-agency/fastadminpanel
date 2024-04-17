<?php

namespace Digiants\FastAdminPanel\Publishers;

use Illuminate\Support\Facades\File;

class CoreRemover
{
	public function remove()
	{
		$baseFolders = [
			'/app/FastAdminPanel',
			'/resources/views/fastadminpanel',
			'/database/migrations',
			// '/lang',
		];

		$publicFolders = [
			'/vendor/fastadminpanel',
		];

		$baseFiles = [
			'/config/fap.php',
			'/routes/fap.php',
			'/routes/fapi.php',
		];

		File::put(base_path('/routes/web.php'), '');

		foreach ($baseFolders as $baseFolder) {

			if (File::exists(base_path($baseFolder))) {
				File::deleteDirectories(base_path($baseFolder));
			}
		}

		foreach ($publicFolders as $publicFolder) {

			if (File::exists(public_path($publicFolder))) {
				File::deleteDirectories(public_path($publicFolder));
			}
		}

		foreach ($baseFiles as $baseFile) {
			
			if (File::exists(base_path($baseFile))) {
				File::delete(base_path($baseFile));
			}
		}
	}
}