<?php

namespace App\FastAdminPanel\Services\Crud\Entity;

use App\FastAdminPanel\Contracts\CrudEntity\Destroy;
use App\FastAdminPanel\Models\Crud;
use App\FastAdminPanel\Services\Crud\TableService;
use Illuminate\Support\Facades\DB;

class DestroyService implements Destroy
{
	public function __construct(
		protected TableService $tableService,
	) { }

	public function destroy($crud, $ids)
	{
		$tables = $this->tableService->getTables($crud->table_name);

		foreach ($tables as $table) {

			DB::table($table)
			->whereIn('id', $ids)
			->delete();
		}

		foreach ($ids as $id) {

			$this->removeRelationshipMany($id, $crud->table_name);
			$this->removeEditable($id, $crud->table_name);
		}
	}

	protected function removeRelationshipMany($id, $table)
	{
		$crud = Crud::findOrFail($table);

		foreach ($crud->fields as $field) {

			if ($field->type == 'relationship' && $field->relationship_count == 'many') {
				
				DB::table("{$crud->table_name}_{$field->relationship_table_name}")
				->where("id_{$crud->table_name}", $id)
				->delete();
			}
		}
	}

	protected function removeEditable($id, $table)
	{
		$crud = Crud::findOrFail($table);

		$editable = $crud->fields->filter(fn ($f) => $f->type == 'relationship' && $f->relationship_count == 'editable')
		->map(fn ($f) => $f->relationship_table_name);

		foreach ($editable as $tableName) {

			$tables = $this->tableService->getTables($tableName);

			$parents = []; 

			$parentsTable = explode('_', $tables[0])[0]; 

			foreach ($tables as $table_index => $tbl) {

				$editableItems = DB::table($tbl)
				->where("id_{$crud->table_name}", $id)
				->get()
				->all();
	
				foreach ($editableItems as $editable_item) {
	
					if ($table_index == 0) {

						$parents[] = [
							'id'	=> $editable_item->id,
							'table' => $parentsTable,
						];
					}
	
					DB::table($tbl)
					->where('id', $editable_item->id)
					->delete();
				}
			}

			if ($parents) {

				foreach ($parents as $parent) {

					$this->removeRelationshipMany($parent['id'], $parent['table']);
					$this->removeEditable($parent['id'], $parent['table']);
				}
			}
		}
	}
}