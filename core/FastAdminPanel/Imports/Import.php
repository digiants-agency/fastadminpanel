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

HeadingRowFormatter::default('none');

class Import implements OnEachRow, WithHeadingRow
{
    protected $table;
    protected $realTable;
    protected $menuItem;

    public function __construct($table)
    {
        $this->menuItem = Menu::where('table_name', $table)->first();

        $this->table = $table;
        $this->realTable = $this->menuItem->multilanguage ? $table.'_'.Lang::get() : $table;
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

        foreach (array_keys($row) as $rowKey) {
            
            if ($rowKey == 'ID') {
                continue;
            }

            $headingLang = $headingLangs[$rowKey];
            $headingField = $headingFields[$rowKey];
            
            if (!empty($headingLang)) {
                $toUpdate[$headingLang][$headingField] = $row[$rowKey];
            } else {
                foreach (Lang::getLangs() as $lang) {
                    $toUpdate[$lang->tag][$headingField] = $row[$rowKey];
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

            if (!in_array($field->type, ['relationship', 'password'])) {

                if ($field->lang) {
                    foreach (Lang::getLangs() as $lang) {
                        $headings[$field->title.' '.Str::upper($lang->tag)] = $lang->tag;
                    }
                } else {
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

            if (!in_array($field->type, ['relationship', 'password'])) {

                if ($field->lang) {
                    foreach (Lang::getLangs() as $lang) {
                        $headings[$field->title.' '.Str::upper($lang->tag)] = $field->db_title;
                    }
                } else {
                    $headings[$field->title] = $field->db_title;
                }
            }
        }

        return $headings;
    }
}