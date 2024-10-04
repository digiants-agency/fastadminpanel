<?php

namespace App\FastAdminPanel\Services\Crud\Entity\Custom;

use App\FastAdminPanel\Contracts\CrudEntity\Show;
use App\FastAdminPanel\Facades\Lang;
use App\FastAdminPanel\Models\Crud;
use App\FastAdminPanel\Services\Crud\TableService;
use Illuminate\Support\Facades\DB;

class ShowProductsService implements Show
{
	public function __construct(
		protected TableService $tableService,
	) { }

	public function get($tableName, $entityId)
	{
		return $this->getFields($tableName, $entityId);
	}

	protected function getFields($tableName, $entityId)
	{
		$crud = Crud::findOrFail($tableName);

		$table = $this->tableService->getTable($crud->table_name);
		
		$instance = DB::table($table)
		->where('id', $entityId)
		->first();

		$fields = [];

		foreach ($crud->fields as $field) {

			// TODO: date/datetime?
			if ($field->type == 'relationship') {

				if ($field->relationship_count != 'editable') {

					$field->values = DB::table($this->tableService->getTable(
						$field->relationship_table_name, 
					))
					->select('id', $field->relationship_view_field.' as title')
					->get();

					#region for products table
					if ($field->relationship_table_name == 'filter_fields') {

						$field->values = DB::table($this->tableService->getTable(
							$field->relationship_table_name, 
						))
						->select('id', 'title', 'id_filters')
						->get();
						
						$filters = DB::table('filters_'.Lang::get())
						->select('id', 'title')
						->get();
						
						foreach ($field->values as &$value) {

							$filter = $filters->where('id', $value->id_filters)->first();
							
							if ($filter)
								$value->title = $filter->title.': '.$value->title;	
						}						
					}
					#endregion

					if ($field->relationship_count == 'single') {

						if ($entityId == 0) {

							$field->value = 0;

						} else {

							$field_title = 'id_' . $field->relationship_table_name;
							$field->value = $instance->$field_title;
							
							if ($field->value) {

								$field->value_title = $field->values->where('id', $field->value)->first()->title;
							}
						}

					} else if ($field->relationship_count == 'many') {

						if ($entityId == 0) {

							$field->value = [];

						} else {

							$rel_table = $tableName.'_'.$field->relationship_table_name;
							$rel_connected_table = $field->relationship_table_name;

							if ($rel_table == $tableName.'_'.$tableName)
								$rel_connected_table .= '_other';

							$field->value = DB::table($rel_table)
							->select('id_'.$rel_connected_table.' AS id')
							->where('id_'.$tableName, $entityId)
							->orderBy('id', 'ASC')
							->get()
							->pluck('id');
						}
					}

				} else if ($field->relationship_count == 'editable') {

					$field->value = [];

					if ($entityId != 0) {

						$editable_ids = DB::table($this->tableService->getTable(
							$field->relationship_table_name,
						))
						->select('id')
						->where('id_'.$tableName, $entityId)
						->get()
						->pluck('id');

						foreach ($editable_ids as $editable_id) {
							
							$field->value[] = [
								'fields'	=> $this->getFields(
									$field->relationship_table_name,
									$editable_id,
								),
								'id'		=> $editable_id,
							];
						}
					}

					$field->values = $this->getFields($field->relationship_table_name, 0);
				}

			} else if ($field->type == 'gallery') {

				if ($entityId == 0) {

					$field->value = [];

				} else {

					$field_title = $field->db_title;
					$field->value = json_decode($instance->$field_title);
				}

			} else if ($field->type == 'password') {

				$field->value = '';

			} else if ($field->type == 'checkbox' || $field->type == 'money' || $field->type == 'number') {

				if ($entityId == 0) {

					$field->value = 0;

				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;
				}

			} else if ($field->type == 'date') {

				if ($entityId == 0) {

					$field->value = date('Y-m-d');

				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;
				}
				
			} else if ($field->type == 'datetime') {

				if ($entityId == 0) {

					$field->value = date('Y-m-d H:i');

				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;
				}

			} else {

				if ($entityId == 0) {

					$field->value = '';
					
				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;
				}
			}

			$fields[] = $field;
		}

		return $fields;
	}
}
