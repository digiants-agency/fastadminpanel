<?php

namespace App\FastAdminPanel\Exports;

use App\FastAdminPanel\Models\Menu;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;
use Lang;
use Str;

class Export implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $table;
    protected $realTable;
    protected $menuItem;

    public function __construct($table)
    {
        $this->menuItem = Menu::where('table_name', $table)->first();

        $this->table = $table;
        $this->realTable = $this->menuItem->multilanguage ? $table.'_'.Lang::get() : $table;
    }

    public function query()
    {
        $toSelect = [$this->realTable.'.id'];
        
        foreach (json_decode($this->menuItem->fields) as $field) {

            if (!in_array($field->type, ['relationship', 'password'])) {

                if ($field->lang) {
                    foreach (Lang::getLangs() as $lang) {
                        $toSelect[] = $this->table.'_'.$lang->tag.'.'.$field->db_title.' AS '.$field->db_title.'_'.$lang->tag;
                    }
                } else {
                    $toSelect[] = $this->realTable.'.'.$field->db_title;
                }
            }
        }

        return DB::table($this->realTable)
        ->select($toSelect)
        ->when($this->menuItem->multilanguage, function($q) {
            foreach (Lang::getLangs() as $lang) {
                if ($lang->tag != Lang::get()) {
                    $q->join($this->table.'_'.$lang->tag, $this->realTable.'.id', $this->table.'_'.$lang->tag.'.id');
                }
            }
        })
        ->orderBy('id', 'ASC');
    }

    public function headings() : array
    {
        $headings = ['ID'];
        
        foreach (json_decode($this->menuItem->fields) as $field) {

            if (!in_array($field->type, ['relationship', 'password'])) {

                if ($field->lang) {
                    foreach (Lang::getLangs() as $lang) {
                        $headings[] = $field->title.' '.Str::upper($lang->tag);
                    }
                } else {
                    $headings[] = $field->title;
                }
            }
        }

        return $headings;
    }

    public function map($item) : array
    {
        $map = [$item->id];
        
        foreach (json_decode($this->menuItem->fields) as $field) {

            if (!in_array($field->type, ['relationship', 'password'])) {

                if ($field->lang) {
                    foreach (Lang::getLangs() as $lang) {
                        $dbTitle = $field->db_title.'_'.$lang->tag;
                        $map[] = $item->$dbTitle;
                    }
                } else {
                    $dbTitle = $field->db_title;
                    $map[] = $item->$dbTitle;
                }
            }
        }

        return $map;
    }
}