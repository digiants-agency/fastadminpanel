<?php

namespace App\FastAdminPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Schema;
use DB;

class Menu extends Model
{
    protected $table = 'menu';   

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
