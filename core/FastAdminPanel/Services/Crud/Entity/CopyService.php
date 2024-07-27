<?php

namespace App\FastAdminPanel\Services\Crud\Entity;

use App\FastAdminPanel\Contracts\CrudEntity\Copy;
use App\FastAdminPanel\Models\Crud;
use App\FastAdminPanel\Services\Crud\TableService;
use Illuminate\Support\Facades\DB;

class CopyService implements Copy
{
	public function __construct(
		protected TableService $tableService,
	) { }

	public function copy($crud, $entityId)
	{
		$tables = $this->tableService->getTables($crud->table_name);

		foreach ($tables as $table) {

			$row = DB::table($table)
			->where('id', $entityId)
			->first();

			$insert = [];

			foreach ($row as $key => $value) {
				
				if ($key == 'id' || $key == 'created_at' || $key == 'updated_at')
					continue;

				if ($key == 'slug') {
					preg_match('/-copy-(\d)$/', $value, $matches);
					if (!empty($matches)) {
						$value = str_replace('-copy-'.intval($matches[1]), '-copy-'.(intval($matches[1]) + 1), $value);
					} else {
						$value .= '-copy-1';
					}
				}

				if ($key == 'title') {

					$value .= ' copy';
				}

				$insert[$key] = $value;
			}

			$newId = DB::table($table)->insertGetId($insert);
		}

		$this->copyRelationshipMany($entityId, $crud->table_name, $newId);
		$this->copyEditable($entityId, $crud->table_name, $newId);
	}
	
	protected function copyRelationshipMany($id, $table, $newId)
	{
		$crud = Crud::findOrFail($table);

		foreach ($crud->fields as $field) {

			if ($field->type == 'relationship' && $field->relationship_count == 'many') {
				
				$manyItems = DB::table("{$table}_{$field->relationship_table_name}")
				->where("id_{$table}", $id)
				->get()
				->all();

				foreach ($manyItems as $key => &$manyItem){

					$manyItem = (array)$manyItem;

					unset($manyItems[$key]['id']);
					$manyItem['id_' . $table] = $newId;
				}

				DB::table("{$table}_{$field->relationship_table_name}")
				->insert($manyItems);
			}
		}
	}

	protected function copyEditable($id, $table, $newId)
	{
		$crud = Crud::findOrFail($table);

		$editable = $crud->fields->filter(fn ($f) => $f->type == 'relationship' && $f->relationship_count == 'editable')
		->map(fn ($f) => $f->relationship_table_name);

		foreach ($editable as $tableName) {

			$tables = $this->tableService->getTables($tableName);

			$parents = [];

			foreach ($tables as $tblIndex => $tbl){

				$editableItems = DB::table($tbl)
				->where("id_$table", $id)
				->get()
				->all();

				foreach ($editableItems as $key => &$editableItem) {

					$editableItem = (array)$editableItem;

					$itemId = $editableItem['id'];

					unset($editableItems[$key]['id']);
					unset($editableItems[$key]['created_at']);
					unset($editableItems[$key]['updated_at']);

					foreach ($editableItem as $key_item => &$item){

						if ($key_item == 'slug') {
							preg_match('/-copy-(\d)$/', $item, $matches);
							if (!empty($matches)) {
								$item = str_replace('-copy-'.intval($matches[1]), '-copy-'.(intval($matches[1]) + 1), $item);
							} else {
								$item .= '-copy-1';
							}
						}
		
						if ($key_item == 'title') {
							$item .= ' copy';
						}
					}
					
					$editableItem['id_' . $table] = $newId;

					$newEditableId = DB::table($tbl)
					->insertGetId($editableItem);

					if ($tblIndex == 0) {

						$parents[] = [
							'id'		=> $itemId,
							'table'		=> $tableName,
							'new_id'	=> $newEditableId,
						];
					}
				}
			}

			if ($parents) {

				foreach ($parents as $parent) {

					$this->copyRelationshipMany($parent['id'], $parent['table'], $parent['new_id']);
					$this->copyEditable($parent['id'], $parent['table'], $parent['new_id']);
				}
			}
		}
	}
}