<?php

namespace App\FastAdminPanel\Services;

use Illuminate\Support\Facades\File;

class FilesService
{
	public function getFilesFromResources($folder)
	{
		$path = resource_path($folder);
		$files = File::files($path);
		return collect($files)->map(fn ($f) => str_replace('.blade.php', '', $f->getFilename()));
	}
}