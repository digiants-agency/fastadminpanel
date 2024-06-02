<?php

namespace App\FastAdminPanel\Models\Json;

use Illuminate\Support\Facades\Storage;

// this is created for git versions of cruds and dropdowns
// TODO: add validation
// TODO: remove static
abstract class JsonModel implements \JsonSerializable
{
	protected static $files = [];

	protected static $fileName;
	
	protected static $primaryKey;

	protected static $path;

	public static function get()
	{
		return collect(self::$files[self::$fileName])
		->map(fn ($o) => new static($o));
	}

	public static function overwrite($data)
	{
		self::$files[self::$fileName] = $data;
	
		self::store();
	}

	public static function create($data)
	{
		$newModel = new static($data);

		self::$files[self::$fileName][] = $newModel;

		self::store();

		return $newModel;
	}

	public static function findOfFail($key)
	{
		foreach (self::$files[self::$fileName] as $i => $model) {

			if ($model[self::$primaryKey] == $key) {

				$fields = self::$files[self::$fileName][$i];

				return new static($fields);
			}
		}

		abort(404);
	}

	protected static function store()
	{
		$content = json_encode(self::$files[self::$fileName], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		
		Storage::put(self::$path, $content);
	}

	public function __construct()
	{
		if (isset(self::$files[self::$fileName])) {

			return;
		}

		self::$path = "app/".self::$fileName.".json";

		if (!Storage::exists(self::$path)) {

			Storage::put(self::$path, '[]');
		}

		$fileContent = Storage::get(self::$path);

		self::$files[self::$fileName] = json_decode($fileContent);
	}

	public function getProperites()
	{
		return collect($this->jsonSerialize());
	}

	public function save()
	{
		$fields = $this->getProperites();
		
		$key = $fields->{self::$primaryKey};
		
		foreach (self::$files[self::$fileName] as $i => $model) {

			if ($model[self::$primaryKey] == $key) {

				self::$files[self::$fileName][$i] = $fields;

				self::store();

				return;
			}
		}

		throw new \Exception("Cant save JsonModel, key '".self::$primaryKey."' not found");
	}

	public function update($data)
	{
		$fields = $this->getProperites();
		
		$key = $fields->{self::$primaryKey};
		
		foreach (self::$files[self::$fileName] as $i => $model) {

			if ($model[self::$primaryKey] == $key) {

				self::$files[self::$fileName][$i] = $fields;

				self::store();

				return;
			}
		}

		throw new \Exception("Cant update JsonModel, key '".self::$primaryKey."' not found");
	}

	public function delete()
	{
		
	}
}