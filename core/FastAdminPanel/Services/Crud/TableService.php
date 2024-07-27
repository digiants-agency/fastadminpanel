<?php 

namespace App\FastAdminPanel\Services\Crud;

use App\FastAdminPanel\Facades\Lang;
use App\FastAdminPanel\Models\Crud;

class TableService
{
	public function getTables($entity, $multilanguage = -1)
	{
		$tables = collect([]);

		if ($multilanguage == -1) {

			$crud = Crud::get()
			->where('table_name', $entity)
			->first();

			$tableName = $crud->table_name;
			$multilanguage = $crud->multilanguage;

		} else {

			$tableName = $entity;
		}

		if ($multilanguage == 1) {

			foreach (Lang::all() as $lang) {
				$tables[] = "{$tableName}_{$lang->tag}";
			}
			
		} else {

			$tables[] = $tableName;
		}

		return $tables;
	}

	public function getTable($table, $lang = null)
	{
		$crud = Crud::get()
		->where('table_name', $table)
		->first();

		if (empty($crud)) {
			return $table;
		}

		$lang = $lang ?? Lang::get();

		if ($crud->multilanguage == 1) {
			return $table.'_'.$lang;
		}

		return $table;
	}
}