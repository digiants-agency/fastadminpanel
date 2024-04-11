<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Menu;
use App\FastAdminPanel\Responses\JsonResponse;
use Str;

class DocsController extends \App\Http\Controllers\Controller
{
	public function index()
	{
		$menu = Menu::whereNotIn('table_name', ['roles', 'users'])
		->get();
		
		$docs = [];

		foreach ($menu as $menuItem) {

			$fields = $menuItem->getFields();
			$relations = $menuItem->getRelations();

			$fieldsRequired = $menuItem->getFieldsRequired();
			
			$fieldsTypes = $menuItem->getFieldsType();

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
			
			$docs[$menuItem->title] = [
				[
					'method'		=> 'GET',
					'endpoint'		=> '/api/'.$menuItem->table_name,
					'description'	=> 'Get all '.Str::replace('_', ' ', Str::plural($menuItem->table_name)).' with pagination',
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
					'endpoint'		=> '/api/'.$menuItem->table_name.'/{id}',
					'description'	=> 'Get single '.Str::replace('_', ' ', Str::singular($menuItem->table_name)).' by id',
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
					'endpoint'		=> '/api/'.$menuItem->table_name,
					'description'	=> 'Create '.Str::replace('_', ' ', Str::singular($menuItem->table_name)),
					'fields'		=> $formatedFieldsPost,
				],
				[
					'method'		=> 'PUT',
					'endpoint'		=> '/api/'.$menuItem->table_name.'/{id}',
					'description'	=> 'Update '.Str::replace('_', ' ', Str::singular($menuItem->table_name)).' by id',
					'fields'		=> $formatedFieldsPut,
				],
				[
					'method'		=> 'DELETE',
					'endpoint'		=> '/api/'.$menuItem->table_name.'/{id}',
					'description'	=> 'Delete '.Str::replace('_', ' ', Str::singular($menuItem->table_name)).' by id',
					'fields'		=> [],
				],
			];
		}

		return JsonResponse::response([
			'docs' => $docs,
		]);
	}
}