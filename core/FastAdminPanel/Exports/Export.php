<?php

namespace App\FastAdminPanel\Exports;

use App\FastAdminPanel\Facades\Lang;
use App\FastAdminPanel\Models\Crud;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Str;

class Export implements FromQuery, WithHeadings, WithMapping
{
	use Exportable;

	protected $cruds;
	protected $crud;

	public function __construct($table)
	{
		$this->cruds = Crud::get()->keyBy('table_name');
		$this->crud = $this->cruds->where('table_name', $table)->first();
	}

	public function query()
	{
		$toSelect = [$this->crud->table.'.id'];
		$joins = collect([]);
		
		foreach ($this->crud->fields as $field) {

			if ($field->type == 'password') {
				continue;
			}

			if ($field->type != 'relationship') {

				if ($field->lang) {

					foreach (Lang::all() as $lang) {

						$toSelect[] = $this->crud->table.'.'.$field->db_title.' AS '.$field->db_title.'_'.$lang->tag;
					}

				} else {

					$toSelect[] = $this->crud->table.'.'.$field->db_title;
				}
				
			} else {

				if ($field->relationship_count == 'single') {

					$relationshipTable = $this->cruds[$field->relationship_table_name]->multilanguage ? $field->relationship_table_name.'_'.Lang::get() : $field->relationship_table_name;

					$toSelect[] = $relationshipTable.'.'.$field->relationship_view_field.' AS '.$field->relationship_table_name.'_'.$field->relationship_view_field;

					$joins[] = [$relationshipTable, $relationshipTable.'.id', $this->crud->table.'.id_'.$field->relationship_table_name];
				}
			}
		}

		$result = DB::table($this->crud->table)
		->select($toSelect)
		->when($this->crud->multilanguage, function($q) {
			foreach (Lang::all() as $lang) {
				if ($lang->tag != Lang::get()) {
					$q->join($this->crud->table_name . "_" . $lang->tag, $this->crud->table_name . "_" . $lang->tag.'.id', $this->crud->table.'.id');
				}
			}
		})
		->when($joins->count(), function($q) use ($joins) {
			foreach ($joins as $join) {
				if ($join[0] != $this->crud->table) {
					$q->join($join[0], $join[1], $join[2]);
				}
			}
		})
		->orderBy('id', 'ASC');

		return $result;
	}

	public function headings() : array
	{
		$headings = ['ID'];
		
		foreach ($this->crud->fields as $field) {

			if ($field->type == 'password') {
				continue;
			}

			if ($field->type != 'relationship') {

				if ($field->lang) {

					foreach (Lang::all() as $lang) {

						$headings[] = $field->title.' '.Str::upper($lang->tag);
					}

				} else {

					$headings[] = $field->title;
				}

			} else {

				if ($field->relationship_count == 'single') {

					$headings[] = $field->title;
				}
			}
		}

		return $headings;
	}

	public function map($item) : array
	{
		$map = [$item->id];
		
		foreach ($this->crud->fields as $field) {

			if ($field->type == 'password') {
				continue;
			}

			if ($field->type != 'relationship') {

				if ($field->lang) {
					
					foreach (Lang::all() as $lang) {

						$dbTitle = $field->db_title.'_'.$lang->tag;
						$map[] = $item->$dbTitle;
					}

				} else {

					$dbTitle = $field->db_title;
					$map[] = $item->$dbTitle;
				}

			} else {

				if ($field->relationship_count == 'single') {
					
					$dbTitle = $field->relationship_table_name.'_'.$field->relationship_view_field;
					$map[] = $item->$dbTitle;
				}
			}
		}

		return $map;
	}
}