<?php

namespace App\FastAdminPanel\Models\File;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// this is created for git versions of cruds and dropdowns
// TODO: add validation
// TODO: remove static ?
// TODO: refactor
abstract class JsonModel extends Model implements \JsonSerializable
{
    protected static $files = [];

    protected static $fileName;

    protected static $jsonPrimaryKey;

    protected static $path;

    public static function init()
    {
        if (isset(static::$files[static::$fileName])) {

            return;
        }

        static::$path = static::$fileName.'.json';

        if (! Storage::exists(static::$path)) {

            Storage::put(static::$path, '[]');
        }

        $fileContent = Storage::get(static::$path);

        static::$files[static::$fileName] = collect(json_decode($fileContent))
            ->map(function ($o) {
                $model = new static;
                $model->forceFill((array) $o);
                $model->syncOriginal();

                return $model;
            });
    }

    public static function get()
    {
        static::init();

        return static::$files[static::$fileName];
    }

    public static function overwrite($data)
    {
        static::init();

        static::$files[static::$fileName] = collect($data)
            ->map(function ($o) {
                $model = new static;
                $model->forceFill($o);
                $model->syncOriginal();

                return $model;
            });

        static::store();
    }

    public static function create($data)
    {
        static::init();

        $key = $data[static::$jsonPrimaryKey];

        foreach (static::$files[static::$fileName] as $model) {

            if ($model->{static::$jsonPrimaryKey} == $key) {

                throw new \Exception("Cant create JsonModel, key '$key' exists");
            }
        }

        $newModel = new static;
        $newModel->forceFill($data);
        $newModel->syncOriginal();

        static::$files[static::$fileName][] = $newModel;

        static::store();

        $newModel->fireModelEvent('created');

        return $newModel;
    }

    public static function findOrFail($key)
    {
        static::init();

        foreach (static::$files[static::$fileName] as $i => $model) {

            if ($model->{static::$jsonPrimaryKey} == $key) {

                return static::$files[static::$fileName][$i];
            }
        }

        abort(404);
    }

    public function save(array $options = [])
    {
        static::store();
        // $this->fireModelEvent('updated');
    }

    public function update(array $attributes = [], array $options = [])
    {
        foreach ($attributes as $key => $attribute) {

            if (isset($this->$key)) {
                $this->$key = $attribute;
            }
        }

        $key = $this->{static::$jsonPrimaryKey};

        foreach (static::$files[static::$fileName] as $i => $model) {

            if ($model->{static::$jsonPrimaryKey} == $key) {

                $model = static::$files[static::$fileName][$i];

                static::store();

                $this->fireModelEvent('updated');

                return;
            }
        }

        throw new \Exception("Cant update JsonModel, key '$key' not found");
    }

    public function delete()
    {
        $key = $this->{static::$jsonPrimaryKey};

        foreach (static::$files[static::$fileName] as $i => $model) {

            if ($model->{static::$jsonPrimaryKey} == $key) {

                unset(static::$files[static::$fileName][$i]);

                static::$files[static::$fileName] = static::$files[static::$fileName]->values();

                static::store();

                $this->fireModelEvent('deleted');

                return;
            }
        }

        throw new \Exception("Cant delete JsonModel, key '$key' not found");
    }

    // public function jsonSerialize(): mixed
    // {
    // 	return $this->toArray();
    // }

    protected static function store()
    {
        $content = json_encode(static::$files[static::$fileName], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        Storage::put(static::$path, $content);
    }
}
