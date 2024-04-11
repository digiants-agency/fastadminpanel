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
        $path = $this->getPath($class);

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

    public function update($table, $isMulilanguage, $fields)
    {
        $class = $this->getClass($table);
        $path = $this->getPath($class);
        $model = file_get_contents($path);

        if ($isMulilanguage) {
            $model = str_replace('extends Model', 'extends MultilanguageModel', $model);
        } else {
            $model = str_replace('extends MultilanguageModel', 'extends Model', $model);
        }
        
        $fillable = $this->getFillable($fields);

        $model = preg_replace(
            '/(protected \$fillable = \[)[\s\S]+?(];)/', 
            "$1"."\n\t\t".$fillable."\n\t"."$2", 
            $model
        );

        $relationships  = $this->getRelationships($table, $fields);

        $model = preg_replace(
            '/(#region Relationships)[\s\S]+?(#endregion)/', 
            "$1"."\n\n\t".$relationships."\n\n\t"."$2", 
            $model
        );

        file_put_contents(
            $path, 
            $model,
        );
    }

    public function delete($table)
    {
        $class = $this->getClass($table);
        $path = $this->getPath($class);

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
                '{{ relationships }}'
            ],
            [
                $namespace,
                $uses,
                $class,
                $extends,
                $table,
                $fillable,
                $relationships
            ],
            $stub
        );
    }

    protected function getNamespace()
    {
        $folder = $this->getFolder();

        return 'App\Models'.($folder ? '\\'.$folder : '');
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
        $fillableFields = [];

        foreach ($fields as $field) {

            if (in_array($field->type, ['password'])) {
                
                continue;

            } elseif ($field->type == 'relationship') {
                
                if ($field->relationship_count == 'single') {

                    $fillableFields[] = "'id_".$field->relationship_table_name."'";

                } else {

                    continue;
                }

            } else {
                $fillableFields[] = "'".$field->db_title."'";
            }
        }

        return implode(",\n\t\t", $fillableFields);
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

            } else if ($field->relationship_count == 'many') {

                $relation = new BelongsToMany($table, $field);

            } elseif ($field->relationship_count == 'editable') {

                $relation = new HasMany($table, $field);
            }

            $body = $relation->body();
            $this->usesRelations[] = $relation->uses();

            if (!empty($body)) {
                $relationships[] = $body;
            }
        }

        return implode("\n\n\t", $relationships);
    }

    // TODO: Add folders for models from dropdown names
    protected function getFolder()
    {
        return '';
    }

    protected function getStub()
    {
        $stub = $this->stubPath('model.stub');

        return file_get_contents($stub);
    }

    protected function getPath($name)
    {
        $folder = $this->getFolder();

        return app_path("Models").($folder ? '/'.$folder : '').'/'.$name.'.php';
    }

    public function stubPath($path)
    {
        return __DIR__.'/stubs/'.$path;
    }
}
