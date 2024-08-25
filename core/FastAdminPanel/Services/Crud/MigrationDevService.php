<?php

namespace App\FastAdminPanel\Services\Crud;

use App\FastAdminPanel\Models\Crud;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MigrationDevService
{
	public function removeMigrationFiles(Crud $crud, array $methods)
	{
		$path = database_path("migrations");
		$files = scandir($path);

		foreach ($methods as $method) {

			foreach ($files as $file) {
	
				if (str_ends_with($file, "{$method}_{$crud->table_name}.php") ||
					str_ends_with($file, "{$method}_{$crud->table_name}_table.php")) {
	
					unlink($path . DIRECTORY_SEPARATOR . $file);

					$migration = str_replace('.php', '', $file);

					DB::statement("DELETE FROM migrations WHERE migration = '$migration'");
				}
			}
		}
	}

	public function updateOldMigration(Crud $crud, MigrationService $migrationService)
	{
		$filename = $this->findCreateMigration($crud);
		
		if ($filename) {

			$migrationService->create($crud, $filename);
		}
	}

	protected function findCreateMigration(Crud $crud)
	{
		$path = database_path("migrations");
		$files = scandir($path);

		foreach ($files as $file) {

			if (str_ends_with($file, "create_{$crud->table_name}.php") ||
				str_ends_with($file, "create_{$crud->table_name}_table.php")) {

				return $file;
			}
		}

		return null;
	}
}