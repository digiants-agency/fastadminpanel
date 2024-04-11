<?php 

namespace App\FastAdminPanel\Services;

use App\FastAdminPanel\Generators\Migrations\MigrationGenerator;
use App\FastAdminPanel\Models\Menu;
use Artisan;

class MigrationService
{
	protected $generator;

	public function __construct(MigrationGenerator $generator)
	{
		$this->generator = $generator;
	}

	public function create($table, $data)
	{
		$fields = [
			'$table->bigIncrements("id");'
		];

		foreach (json_decode($data['fields']) as $field) {
			
			$fieldSchema = $this->addField($data['table_name'], $field);
			
			if (!empty($fieldSchema)) {
				$fields[] = $fieldSchema;
			}
		}

		$fields[] = '$table->timestamp("created_at")->default(\DB::raw("CURRENT_TIMESTAMP"));';
		$fields[] = '$table->timestamp("updated_at")->default(\DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"));';

		if ($data['is_soft_delete'] == 1) {
			$fields[] = '$table->timestamp("deleted_at")->nullable();';
		}

		$this->generator->create($table, 'create', implode("\n\t\t\t", $fields));

        Artisan::call('migrate');
	}

	public function update($table, $data)
	{
		$newFields = json_decode($data['fields']);
		
		$currentFields = json_decode(
			Menu::where('id', $data['id'])
			->value('fields')
		);

		$toRemoveFieldsIds = json_decode($data['to_remove']);

		$fields = array_filter(array_merge(
			$this->removeFields($data['table_name'], $toRemoveFieldsIds, $currentFields),
			$this->renameFields($newFields, $currentFields),
			$this->addFields($data['table_name'], $newFields, $currentFields),
		));

		if (!empty($fields)) {
			$this->generator->create($table, 'update', implode("\n\t\t\t", $fields));
		}

        Artisan::call('migrate');
	}

	public function delete($table)
	{
		$this->generator->create($table, 'delete');
        Artisan::call('migrate');
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

						$this->delete($tableSingular.'_'.$field->relationship_table_name);

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

		} else if ($field->type == 'number' || $field->type == 'checkbox') {

			return '$table->integer("'.$field->db_title.'");';
			
		} else if ($field->type == 'date') {

			return '$table->date("'.$field->db_title.'");';
			
		} else if ($field->type == 'datetime') {

			return '$table->dateTime("'.$field->db_title.'");';
			
		} else if ($field->type == 'translater' || $field->type == 'gallery' || $field->type == 'repeat' || $field->type == 'textarea' || $field->type == 'ckeditor') {

			return '$table->text("'.$field->db_title.'");';
			
		} else if ($field->type == 'money') {

			return '$table->decimal("'.$field->db_title.'", 15, 2);';
			
		} else if ($field->type == 'relationship') {

			if ($field->relationship_count == 'single') {

				return '$table->bigInteger("id_'.$field->relationship_table_name.'");';

			} else if ($field->relationship_count == 'many') {

				$tableName = $tableSingular.'_'.$field->relationship_table_name;

				$colFirst = 'id_'.$tableSingular;
				$colLast = 'id_'.$field->relationship_table_name;

				if ($colFirst == $colLast) {
					$colLast = $colLast.'_other';
				}

				$fields = [
					'$table->bigIncrements("id");',
					'$table->bigInteger("'.$colFirst.'");',
					'$table->bigInteger("'.$colLast.'");',
				];

				$this->generator->create($tableName, 'create', implode("\n\t\t\t", $fields));
			}
		}

		return '';
	}
}