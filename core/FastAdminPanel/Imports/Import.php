<?php

namespace App\FastAdminPanel\Imports;

use App\FastAdminPanel\Models\Menu;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use DB;
use Lang;
use Str;
use Illuminate\Http\Exceptions\HttpResponseException;

HeadingRowFormatter::default('none');

class Import implements OnEachRow, WithHeadingRow
{
    protected $table;
    protected $realTable;
    protected $menuItem;
    protected $singles;

    public function __construct($table)
    {
        $this->menuItem = Menu::where('table_name', $table)->first();

        $this->table = $table;
        $this->realTable = $this->menuItem->multilanguage ? $table.'_'.Lang::get() : $table;

        $this->singles = $this->getSingleRelations();
    }

    public function onRow(Row $row)
    {
        $row = array_map('strval', $row->toArray());

        $toUpdate = [];

        foreach (Lang::getLangs() as $lang) {
            $toUpdate[$lang->tag] = [];
        }
        
        $headingLangs = $this->getLangByHeading();
        $headingFields = $this->getDbTitleByHeading();
        $headingFieldTypes = $this->getFieldTypesByHeading();

        foreach (array_keys($row) as $rowKey) {
            
            if ($rowKey == 'ID') {
                continue;
            }

            $headingLang = $headingLangs[$rowKey];
            $headingField = $headingFields[$rowKey];
            $headingFieldType = $headingFieldTypes[$rowKey];

            $value = $row[$rowKey];

            if (in_array($headingField, array_keys($this->singles))) {
                
                if (!isset($this->singles[$headingField][$value])) {
                    throw new HttpResponseException(
                        response()->json([
                            'error' => 'Value "'.$value.'" for "'.$rowKey.'" is not exist in ID = '.$row['ID'],
                        ], 422)
                    );
                }

                $value = $this->singles[$headingField][$value]->id;
            }

            if ($headingFieldType == 'checkbox' && empty($value)) {
                $value = 0;
            }
            
            if (!empty($headingLang)) {
            
                $toUpdate[$headingLang][$headingField] = $value;
            
            } else {

                foreach (Lang::getLangs() as $lang) {

                    $toUpdate[$lang->tag][$headingField] = $value;
                }
            }
        }

        foreach ($toUpdate as $langTag => $toUpdateItem) {

            $table = $this->menuItem->multilanguage ? $this->table.'_'.$langTag : $this->table;

            DB::table($table)->updateOrInsert([
                'id' => $row['ID'],
            ], $toUpdateItem);
        }
    }

    protected function getLangByHeading()
    {
        $headings = [];
        
        foreach (json_decode($this->menuItem->fields) as $field) {

            if ($field->type == 'password') {
                continue;
            }

            if ($field->type != 'relationship') {

                if ($field->lang) {

                    foreach (Lang::getLangs() as $lang) {
                        $headings[$field->title.' '.Str::upper($lang->tag)] = $lang->tag;
                    }

                } else {

                    $headings[$field->title] = '';
                }

            } else {

                if ($field->relationship_count == 'single') {
                    $headings[$field->title] = '';
                }
            }
        }

        return $headings;
    }

    protected function getDbTitleByHeading()
    {
        $headings = [];
        
        foreach (json_decode($this->menuItem->fields) as $field) {

            if ($field->type == 'password') {
                continue;
            }

            if ($field->type != 'relationship') {

                if ($field->lang) {
                    
                    foreach (Lang::getLangs() as $lang) {
                        $headings[$field->title.' '.Str::upper($lang->tag)] = $field->db_title;
                    }

                } else {

                    $headings[$field->title] = $field->db_title;
                }
            
            } else {

                if ($field->relationship_count == 'single') {
                    $headings[$field->title] = 'id_'.$field->relationship_table_name;
                }
            }
        }

        return $headings;
    }

    protected function getFieldTypesByHeading()
    {
        $types = [];
        
        foreach (json_decode($this->menuItem->fields) as $field) {

            if ($field->lang) {
                    
                foreach (Lang::getLangs() as $lang) {
                    $types[$field->title.' '.Str::upper($lang->tag)] = $field->type;
                }

            } else {
                $types[$field->title] = $field->type;
            }
        }

        return $types;
    }

    protected function getSingleRelations()
    {
        $singles = [];

        $menu = Menu::get()->keyBy('table_name');

        foreach (json_decode($this->menuItem->fields) as $field) {


            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {

                    $relationshipTable = $menu[$field->relationship_table_name]->multilanguage ? $field->relationship_table_name.'_'.Lang::get() : $field->relationship_table_name;

                    $singles['id_'.$field->relationship_table_name] = DB::table($relationshipTable)
                    ->select('id', $field->relationship_view_field)
                    ->get()->keyBy($field->relationship_view_field);
                }
            }
        }

        return $singles;
    }
}