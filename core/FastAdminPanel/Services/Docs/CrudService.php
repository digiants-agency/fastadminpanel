<?php

namespace App\FastAdminPanel\Services\Docs;

use App\FastAdminPanel\Models\Crud;
use Str;

class CrudService
{
	public function get()
	{
		$cruds = Crud::get()
		->where('is_docs', 1);
		
		$docs = collect([]);

		foreach ($cruds as $crud) {

			$fields = $crud->getFields();
			$relations = $crud->getRelations();

			$fieldsRequired = $crud->getFieldsRequired();
			
			$fieldsTypes = $crud->getFieldsType();

			foreach ($fieldsTypes as &$fieldType) {
				$fieldType = str_replace(['textarea', 'ckeditor', 'enum', 'text'], 'String', $fieldType);
				$fieldType = str_replace(['number', 'relationship', 'checkbox'], 'Integer', $fieldType);
				$fieldType = str_replace(['money'], 'Decimal', $fieldType);
				$fieldType = str_replace(['date'], 'Date', $fieldType);
				$fieldType = str_replace(['datetime'], 'DateTime', $fieldType);
				$fieldType = str_replace(['photo', 'file'], 'File', $fieldType);
			}

			$formatedFieldsPost = [];

			foreach ($fields as $field) {
				$formatedFieldsPost[$field] = [
					'title'		=> $field,
					'required'	=> $fieldsRequired[$field] ?? 'nullable',
					'type'		=> $fieldsTypes[$field] ?? '',
				];
			}

			unset($formatedFieldsPost['id']);
			unset($formatedFieldsPost['created_at']);
			unset($formatedFieldsPost['updated_at']);

			$formatedFieldsPut = $formatedFieldsPost;

			foreach ($formatedFieldsPut as $key => $field) {
				$formatedFieldsPut[$key]['required'] = 'nullable';
			}
			
			$docs[$crud->title] = [
				[
					'method'		=> 'GET',
					'endpoint'		=> '/fapi/'.$crud->table_name,
					'description'	=> 'Get all '.Str::replace('_', ' ', Str::plural($crud->table_name)).' with pagination',
					'fields'		=> [
						[
							'title'		=> 'sort',
							'required'	=> 'nullable',
							'type'		=> 'String',
							'desc'		=> 'in: ' . implode(', ', $fields),
						],
						[
							'title'		=> 'order',
							'required'	=> 'nullable',
							'type'		=> 'String',
							'desc'		=> 'asc, desc',
						],
						[
							'title'		=> 'search',
							'required'	=> 'nullable',
							'type'		=> 'String',
							'desc'		=> 'max: 191',
						],
						[
							'title'		=> 'perPage',
							'required'	=> 'nullable',
							'type'		=> 'Integer',
							'desc'		=> 'between:0,10000',
						],
						[
							'title'		=> 'fields',
							'required'	=> 'nullable',
							'type'		=> 'Array',
						],
						[
							'title'		=> 'fields.*',
							'required'	=> 'nullable',
							'type'		=> 'String',
							'desc'		=> 'in: ' . implode(', ', $fields),
						],
						[
							'title'		=> 'relations',
							'required'	=> 'nullable',
							'type'		=> 'Array or *',
						],
						[
							'title'		=> 'relations.*',
							'required'	=> 'nullable',
							'type'		=> 'String',
							'desc'		=> 'in: ' . implode(', ', $relations),
						],
						[
							'title'		=> 'filters',
							'required'	=> 'nullable',
							'type'		=> 'Array',
						],
						[
							'title'		=> 'filters.*',
							'required'	=> 'nullable',
							'type'		=> 'String',
							'desc'		=> 'Filter by fields or relations with =, !=, >, >=, <, <=, ~, ()',
						],
					],
				],
				[
					'method'		=> 'GET',
					'endpoint'		=> '/fapi/'.$crud->table_name.'/{id}',
					'description'	=> 'Get single '.Str::replace('_', ' ', Str::singular($crud->table_name)).' by id',
					'fields'		=> [
						[
							'title'		=> 'fields',
							'required'	=> 'nullable',
							'type'		=> 'Array',
						],
						[
							'title'		=> 'fields.*',
							'required'	=> 'nullable',
							'type'		=> 'String',
							'desc'		=> 'in: ' . implode(', ', $fields),
						],
						[
							'title'		=> 'relations',
							'required'	=> 'nullable',
							'type'		=> 'Array or *',
						],
						[
							'title'		=> 'relations.*',
							'required'	=> 'nullable',
							'type'		=> 'String',
							'desc'		=> 'in: ' . implode(', ', $relations),
						],
					],
				],
				[
					'method'		=> 'POST',
					'endpoint'		=> '/fapi/'.$crud->table_name,
					'description'	=> 'Create '.Str::replace('_', ' ', Str::singular($crud->table_name)),
					'fields'		=> $formatedFieldsPost,
				],
				[
					'method'		=> 'PUT',
					'endpoint'		=> '/fapi/'.$crud->table_name.'/{id}',
					'description'	=> 'Update '.Str::replace('_', ' ', Str::singular($crud->table_name)).' by id',
					'fields'		=> $formatedFieldsPut,
				],
				[
					'method'		=> 'DELETE',
					'endpoint'		=> '/fapi/'.$crud->table_name.'/{id}',
					'description'	=> 'Delete '.Str::replace('_', ' ', Str::singular($crud->table_name)).' by id',
					'fields'		=> [],
				],
			];
		}

		return $docs;
	}
}