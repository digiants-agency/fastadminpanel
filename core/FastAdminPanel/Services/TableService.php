<?php 

namespace App\FastAdminPanel\Services;

use App\FastAdminPanel\Models\Menu;
use Lang;

class TableService
{
	public function getTables($entity, $multilanguage = -1)
	{
		$tables = [];

		if ($multilanguage == -1) {

			$menu = Menu::select('multilanguage', 'table_name')
			->when(is_numeric($entity), function($q) use ($entity){
				$q->where('id', $entity);
			})
			->when(!is_numeric($entity), function($q) use ($entity){
				$q->where('table_name', $entity);
			})
			->first();

			$title = $menu->table_name;
			$multilanguage = $menu->multilanguage;

		} else {

			$title = $entity;
		}

		if ($multilanguage == 1) {

			foreach (Lang::getLangs() as $lang) {
				$tables[] = $title.'_'.$lang->tag;
			}
			
		} else {

			$tables[] = $title;
		}

		return $tables;
	}

	public function getTable($table, $lang)
	{
		$element = Menu::select('multilanguage')
		->where('table_name', $table)
		->first();

		if (empty($element)) {
			return $table;
		}

		if ($element->multilanguage == 1 && !empty($lang)) {
			return $table.'_'.$lang;
		}
		
		return $table;
	}
}