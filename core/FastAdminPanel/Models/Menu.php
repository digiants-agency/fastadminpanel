<?php

namespace App\FastAdminPanel\Models;

use App\FastAdminPanel\Generators\Models\Relations\BelongsTo;
use App\FastAdminPanel\Generators\Models\Relations\BelongsToMany;
use App\FastAdminPanel\Generators\Models\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Schema;
use DB;

class Menu extends Model
{
    protected $table = 'menu';   

	protected $fillable = [
		'title',
		'table_name',
		'fields',
		'is_dev',
		'multilanguage',
		'is_soft_delete',
		'sort',
		'dropdown_id',
		'icon',
		'model',
	];

    public function getTitlesMenuByTable($table)
	{
        $menu = $this->select('title', 'fields')
        ->where('table_name', $table)
        ->first();

        $fields = json_decode($menu->fields);

        $fields_titles = [];
        foreach ($fields as $field) {
            
            if (isset($field->db_title))
                $fields_titles[$field->db_title] = $field->title;
            else 
                $fields_titles[$field->relationship_table_name] = $field->title;
        }

        return [
            'fields_titles' => $fields_titles,
            'menu_title'    => $menu->title,
        ];
    }

	public function getFields($withDefaults = true)
    {
        $fields = [];

		if ($withDefaults) {
			$fields[] = 'id';
		}

        foreach (json_decode($this->fields) as $field) {

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

	# TODO: remove DRY
	public function getFieldsType()
    {
        $fields = [];

        foreach (json_decode($this->fields) as $field) {

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

	# TODO: remove DRY
	public function getFieldsRequired()
    {
        $fields = [];

        foreach (json_decode($this->fields) as $field) {

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

	# TODO: remove DRY
	public function getVisibleFields()
    {
        $fields = [];

		foreach (json_decode($this->getOriginal('fields')) as $field) {

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

	public function getRelations()
	{
		$relations = [];

		foreach (json_decode($this->fields) as $field) {
            
            if ($field->type != 'relationship') {
                continue;
            }

            if ($field->relationship_count == 'single') {

                $relation = new BelongsTo($field);

            } else if ($field->relationship_count == 'many') {

                $relation = new BelongsToMany($this->table_name, $field);

            } elseif ($field->relationship_count == 'editable') {

                $relation = new HasMany($this->table_name, $field);
            }

            $relations[] = $relation->name();
        }

		return $relations;
	}
    
	public function removeTables($tag)
	{
		$menu = $this->select('table_name', 'multilanguage')->get();

		foreach ($menu as $elm) {

			if ($elm->multilanguage == 1) {

				Schema::dropIfExists("{$elm->table_name}_$tag");
			}
		}
	}

	public function addTables($tag, $main_tag)
	{
		$menu = $this->select('table_name', 'multilanguage')->get();

		foreach ($menu as $elm) {

			if ($elm->multilanguage == 1) {

				Schema::dropIfExists("{$elm->table_name}_$tag");
				DB::statement("CREATE TABLE {$elm->table_name}_$tag LIKE {$elm->table_name}_$main_tag");
				DB::statement("INSERT {$elm->table_name}_$tag SELECT * FROM {$elm->table_name}_$main_tag");
			}
		}
	}
}
