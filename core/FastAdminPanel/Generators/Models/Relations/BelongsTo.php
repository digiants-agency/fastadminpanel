<?php

namespace App\FastAdminPanel\Generators\Models\Relations;

use Str;

class BelongsTo implements Relation
{
    protected $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    public function body()
    {
        $body = "public function ".$this->name()."() \n";

        $body .= "\t{\n";

        $body .= "\t\t";

        $body .= 'return $this->belongsTo(';

        $body .= $this->relatedClassName().'::class, ';

        $body .= "'".$this->foreignKey()."'";

        $body .= ");\n";

        $body .= "\t}";

        return $body;
    }

    public function name()
    {
        return Str::camel(Str::singular($this->field->relationship_table_name));
    }

    public function uses()
    {
        return 'use '.$this->relatedNamespace().'\\'.$this->relatedClassName().';';
    }

    protected function relatedClassName()
    {
        return Str::studly(Str::singular($this->field->relationship_table_name));
    }

    protected function relatedNamespace()
    {
        return 'App\Models';
    }

    protected function foreignKey()
    {
        return 'id_'.$this->field->relationship_table_name;
    }

    public function returnType()
    {
        return \Illuminate\Database\Eloquent\Relations\BelongsTo::class;
    }
}