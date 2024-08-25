<?php 

namespace App\FastAdminPanel\Services\Crud;

use App\FastAdminPanel\Generators\Migrations\MigrationGenerator;
use Artisan;
use Illuminate\Support\Facades\Schema;

class MigrationService
{
	public function __construct(
		protected MigrationGenerator $generator,
		protected MigrationDevService $devService,
	) { }

	public function create($crud, $filename = '')
	{
		$fields = [
			'$table->id();'
		];

		foreach ($crud->fields as $field) {
			
			$fieldSchema = $this->addField($crud->table_name, $field);
			
			if (!empty($fieldSchema)) {
				$fields[] = $fieldSchema;
			}
		}

		$fields[] = '$table->timestamp("created_at")->default(\DB::raw("CURRENT_TIMESTAMP"));';
		$fields[] = '$table->timestamp("updated_at")->default(\DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"));';

		if ($crud->is_soft_delete == 1) {
			$fields[] = '$table->timestamp("deleted_at")->nullable();';
		}

		$this->generator->create($crud->table_name, 'create', implode("\n\t\t\t", $fields), $crud->multilanguage, $filename);

        Artisan::call('migrate');
	}

	public function update($crud)
	{
		$newFields = $crud->fields;
		$currentFields = $crud->getOriginal('fields');

		$toRemoveFieldsIds = $currentFields->map(fn ($f) => $f->id)
		->diff($newFields->map(fn ($f) => $f->id));

		$fields = array_filter(array_merge(
			$this->removeFields($crud->table_name, $toRemoveFieldsIds, $currentFields),
			$this->renameFields($newFields, $currentFields),
			$this->addFields($crud->table_name, $newFields, $currentFields),
		));

		if (empty($fields)) {

			return;
		}

		// TODO: add unfields (down columns)
		$this->generator->create($crud->table_name, 'update', implode("\n\t\t\t", $fields), $crud->multilanguage);

        Artisan::call('migrate');

		if (config('fap.migrations_mode') == 'dev') {

			$this->devService->removeMigrationFiles($crud, ['update']);
			$this->devService->updateOldMigration($crud, $this);
		}
	}

	public function delete($crud)
	{
		$this->generator->create($crud->table_name, 'delete', '', $crud->multilanguage);
        Artisan::call('migrate');

		if (config('fap.migrations_mode') == 'dev') {

			$this->devService->removeMigrationFiles($crud, ['create', 'update', 'delete']);
		}
	}

	protected function removeFields($tableSingular, $toRemoveFieldsIds, $currentFields)
	{
		$fields = [];

		foreach ($toRemoveFieldsIds as $toRemoveFieldsId) {

			foreach ($currentFields as $field) {

				if ($field->id == $toRemoveFieldsId) {

					if ($field->type == 'relationship' && $field->relationship_count == 'single'){

						$fields[] = '$table->dropColumn("id_'.$field->relationship_table_name.'");';

					} else if ($field->type == 'relationship' && $field->relationship_count == 'many'){

						$this->generator->create($tableSingular.'_'.$field->relationship_table_name, 'delete');
						Artisan::call('migrate');

					} else if ($field->type == 'relationship' && $field->relationship_count == 'editable') {

						// TODO: add remove editable ?

					} else {
						$fields[] = '$table->dropColumn("'.$field->db_title.'");';
					}
				}
			}
		}

		return $fields;
	}

	protected function renameFields($newFields, $currentFields)
	{
		$fields = [];

		foreach ($newFields as $newField) {

			foreach ($currentFields as $currentField) {
				
				if ($newField->type == 'relationship' || $currentField->type == 'relationship') {
					continue;
				}

				if ($newField->id == $currentField->id && $newField->db_title != $currentField->db_title) {

					$fields[] = '$table->renameColumn("'.$currentField->db_title.'", "'.$newField->db_title.'");';
				}
			}
		}

		return $fields;
	}

	protected function addFields($tableSingular, $newFields, $currentFields)
	{
		$fields = [];

		foreach ($newFields as $newField) {

			$isNew = true;

			foreach ($currentFields as $currentField) {

				if ($newField->id == $currentField->id) {
					$isNew = false;
					break;
				}
			}

			if ($isNew) {
				$fields[] = $this->addField($tableSingular, $newField);
			}
		}

		return $fields;
	}

	protected function addField($tableSingular, $field)
	{
		if ($field->type == 'enum' || $field->type == 'password' || $field->type == 'text' || $field->type == 'email' || $field->type == 'color' || $field->type == 'file' || $field->type == 'photo') {

			return '$table->string("'.$field->db_title.'");';
			
		} else if ($field->type == 'checkbox') {

			return '$table->tinyInteger("'.$field->db_title.'");';

		} else if ($field->type == 'number') {

			return '$table->integer("'.$field->db_title.'");';
			
		} else if ($field->type == 'date') {

			return '$table->date("'.$field->db_title.'")->default("2000-01-01"); // some DBs have errors with the default 0000-00-00';
			
		} else if ($field->type == 'datetime') {

			return '$table->dateTime("'.$field->db_title.'")->default("2000-01-01 00:00:00"); // some DBs have errors with the default 0000-00-00 00:00:00';
			
		} else if ($field->type == 'gallery' || $field->type == 'textarea' || $field->type == 'ckeditor') {

			return '$table->text("'.$field->db_title.'");';
			
		} else if ($field->type == 'money') {

			return '$table->decimal("'.$field->db_title.'", 15, 2);';
			
		} else if ($field->type == 'relationship') {

			if ($field->relationship_count == 'single') {

				return '$table->unsignedBigInteger("id_'.$field->relationship_table_name.'");';

			} else if ($field->relationship_count == 'many') {

				$tableName = $tableSingular.'_'.$field->relationship_table_name;

				$colFirst = 'id_'.$tableSingular;
				$colLast = 'id_'.$field->relationship_table_name;

				if ($colFirst == $colLast) {
					$colLast = $colLast.'_other';
				}

				$fields = [
					'$table->id();',
					'$table->unsignedBigInteger("'.$colFirst.'");',
					'$table->unsignedBigInteger("'.$colLast.'");',
				];

				if (!Schema::hasTable($tableName)) {

					$this->generator->create($tableName, 'create', implode("\n\t\t\t", $fields));
				}
			}
		}

		return '';
	}
}