<?php

namespace App\FastAdminPanel\Generators\Models;

use App\FastAdminPanel\Generators\Models\Relations\BelongsTo;
use App\FastAdminPanel\Generators\Models\Relations\BelongsToMany;
use App\FastAdminPanel\Generators\Models\Relations\HasMany;
use Str;

class ModelGenerator
{
    protected $usesRelations = [];

    public function create($table, $isMulilanguage, $fields)
    {
        $class = $this->getClass($table);
        $path = $this->getPathByClass($class);

        $namespace = $this->getNamespace();
        $extends = $this->getExtends($isMulilanguage);
        $fillable = $this->getFillable($fields);
        $relationships = $this->getRelationships($table, $fields);
        $uses = $this->getUses();

        file_put_contents(
            $path,
            $this->populateStub($namespace, $uses, $class, $extends, $table, $fillable, $relationships)
        );

        return '\\'.$namespace.'\\'.$class;
    }

    public function update($table, $modelPath, $isMulilanguage, $fields)
    {
        $path = $this->getPathByModel($modelPath);

        if (! file_exists($path)) {
            return;
        }

        $model = file_get_contents($path);

        if ($isMulilanguage) {
            $model = str_replace('extends Model', 'extends MultilanguageModel', $model);
        } else {
            $model = str_replace('extends MultilanguageModel', 'extends Model', $model);
        }

        $fillable = $this->getFillable($fields);

        $model = preg_replace(
            '/(protected \$fillable = \[)[\s\S]+?(];)/',
            '$1'."\n        ".$fillable."\n    ".'$2',
            $model
        );

        $relationships = $this->getRelationships($table, $fields);

        $model = preg_replace(
            '/(#region Relationships)[\s\S]+?(#endregion)/',
            '$1'."\n\n    ".$relationships."\n\n    ".'$2',
            $model
        );

        file_put_contents(
            $path,
            $model,
        );
    }

    public function delete($modelPath)
    {
        $path = $this->getPathByModel($modelPath);

        if (! file_exists($path)) {
            return;
        }

        unlink($path);
    }

    protected function populateStub($namespace, $uses, $class, $extends, $table, $fillable, $relationships)
    {
        $stub = $this->getStub();

        return str_replace(
            [
                '{{ namespace }}',
                '{{ uses }}',
                '{{ class }}',
                '{{ extends }}',
                '{{ table }}',
                '{{ fillable }}',
                '{{ relationships }}',
            ],
            [
                $namespace,
                $uses,
                $class,
                $extends,
                $table,
                $fillable,
                $relationships,
            ],
            $stub
        );
    }

    protected function getNamespace()
    {
        return 'App\Models';
    }

    protected function getClass($table)
    {
        return Str::studly(Str::singular($table));
    }

    protected function getUses()
    {
        $uses = [
            'use App\FastAdminPanel\Models\MultilanguageModel;',
        ];

        $uses = array_merge($uses, array_unique($this->usesRelations));

        return implode(PHP_EOL, $uses);
    }

    protected function getExtends($isMulilanguage)
    {
        return $isMulilanguage ? 'MultilanguageModel' : 'Model';
    }

    protected function getFillable($fields)
    {
        $fillableFields = collect([]);

        foreach ($fields as $field) {

            $fillable = $field->getFillable();

            if ($fillable) {

                $fillableFields[] = "'$fillable'";
            }
        }

        return $fillableFields->implode(",\n        ").',';
    }

    protected function getRelationships($table, $fields)
    {
        $relationships = [];

        foreach ($fields as $field) {

            if ($field->type != 'relationship') {
                continue;
            }

            $body = '';

            if ($field->relationship_count == 'single') {

                $relation = new BelongsTo($field);

            } elseif ($field->relationship_count == 'many') {

                $relation = new BelongsToMany($table, $field);

            } elseif ($field->relationship_count == 'editable') {

                $relation = new HasMany($table, $field);
            }

            $body = $relation->body();
            $this->usesRelations[] = $relation->uses();

            if (! empty($body)) {
                $relationships[] = $body;
            }
        }

        return implode("\n\n    ", $relationships);
    }

    protected function getStub()
    {
        $stub = $this->stubPath('model.stub');

        return file_get_contents($stub);
    }

    protected function getPathByClass($name)
    {
        return app_path('Models').'/'.$name.'.php';
    }

    protected function getPathByModel($modelPath)
    {
        $parts = explode('\\', $modelPath);
        $path = '';

        for ($i = 1, $count = count($parts) - 1; $i < $count; $i++) {

            $path .= strtolower($parts[$i]).'/';
        }

        $modelName = array_pop($parts);

        return base_path($path).$modelName.'.php';
    }

    public function stubPath($path)
    {
        return __DIR__.'/stubs/'.$path;
    }
}
