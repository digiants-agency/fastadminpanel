<?php

namespace App\FastAdminPanel\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';   

    public function get_titles_menu_by_table($table) {
        
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
    
}
