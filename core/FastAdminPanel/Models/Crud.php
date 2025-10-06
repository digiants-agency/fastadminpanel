<?php

namespace App\FastAdminPanel\Models;

use App\FastAdminPanel\Casts\Fields;
use App\FastAdminPanel\Facades\Lang;
use App\FastAdminPanel\Generators\Models\Relations\BelongsTo;
use App\FastAdminPanel\Generators\Models\Relations\BelongsToMany;
use App\FastAdminPanel\Generators\Models\Relations\HasMany;
use App\FastAdminPanel\Models\File\JsonModel;
use App\FastAdminPanel\Observers\CrudObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

#[ObservedBy(CrudObserver::class)]
class Crud extends JsonModel
{
    public $timestamps = false;

    protected $table = 'cruds';

    protected static $fileName = 'cruds';

    protected static $jsonPrimaryKey = 'table_name';

    protected $fillable = [
        'title',
        'table_name',
        'fields',
        'is_dev',
        'multilanguage',
        'is_soft_delete',
        'sort',
        'dropdown_slug',
        'icon',
        'is_docs',
        'is_statistics',
        'model',
        'default_order',
    ];

    protected $casts = [
        'fields' => Fields::class,
    ];

    public function getTableAttribute()
    {
        if ($this->multilanguage == 1) {

            return $this->table_name.'_'.Lang::get();
        }

        return $this->table_name;
    }

    // TODO: move to App\FastAdminPanel\Casts\Entities\Field.php
    public function getFields($withDefaults = true)
    {
        $fields = [];

        if ($withDefaults) {
            $fields[] = 'id';
        }

        foreach ($this->fields as $field) {

            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {
                    $fields[] = 'id_'.$field->relationship_table_name;
                }

            } else {
                $fields[] = $field->db_title;
            }
        }

        if ($withDefaults) {
            $fields[] = 'created_at';
            $fields[] = 'updated_at';
        }

        return $fields;
    }

    // TODO: move to App\FastAdminPanel\Casts\Entities\Field.php
    public function getFieldsType()
    {
        $fields = [];

        foreach ($this->fields as $field) {

            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {
                    $fields['id_'.$field->relationship_table_name] = $field->type;
                }

            } else {
                $fields[$field->db_title] = $field->type;
            }
        }

        return $fields;
    }

    // TODO: move to App\FastAdminPanel\Casts\Entities\Field.php
    public function getFieldsRequired()
    {
        $fields = [];

        foreach ($this->fields as $field) {

            $required = $field->required == 'optional' ? 'nullable' : 'required';

            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {
                    $fields['id_'.$field->relationship_table_name] = $required;
                }

            } else {
                $fields[$field->db_title] = $required;
            }
        }

        return $fields;
    }

    // TODO: move to App\FastAdminPanel\Casts\Entities\Field.php
    public function getVisibleFields()
    {
        $fields = [];

        foreach ($this->getOriginal('fields') as $field) {

            if ($field->show_in_list !== 'yes') {
                continue;
            }

            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {
                    $fields[] = 'id_'.$field->relationship_table_name;
                }

            } else {
                $fields[] = $field->db_title;
            }
        }

        return $fields;
    }

    // TODO: move to App\FastAdminPanel\Casts\Entities\Field.php
    public function getRelations()
    {
        $relations = [];

        foreach ($this->fields as $field) {

            if ($field->type != 'relationship') {
                continue;
            }

            if ($field->relationship_count == 'single') {

                $relation = new BelongsTo($field);

            } elseif ($field->relationship_count == 'many') {

                $relation = new BelongsToMany($this->table_name, $field);

            } elseif ($field->relationship_count == 'editable') {

                $relation = new HasMany($this->table_name, $field);
            }

            $relations[] = $relation->name();
        }

        return $relations;
    }

    // TODO: move
    public function removeTables($tag)
    {
        $crud = static::get();

        foreach ($crud as $elm) {

            if ($elm->multilanguage == 1) {

                Schema::dropIfExists("{$elm->table_name}_$tag");
            }
        }
    }

    // TODO: move
    public function addTables($tag, $main_tag)
    {
        $crud = static::get();

        foreach ($crud as $elm) {

            if ($elm->multilanguage == 1) {

                Schema::dropIfExists("{$elm->table_name}_$tag");
                DB::statement("CREATE TABLE {$elm->table_name}_$tag LIKE {$elm->table_name}_$main_tag");
                DB::statement("INSERT {$elm->table_name}_$tag SELECT * FROM {$elm->table_name}_$main_tag");
            }
        }
    }
}
