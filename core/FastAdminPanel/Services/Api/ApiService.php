<?php 

namespace App\FastAdminPanel\Services\Api;

use App\FastAdminPanel\Facades\Lang;
use App\FastAdminPanel\Models\Crud;

class ApiService
{
	protected Crud $crud;

	public function __construct(
		protected CustomValidation $customValidation,
		protected CustomFilter $customFilter,
	) { }

	public function setCrud(Crud $crud)
	{
		$this->crud = $crud;
	}

	public function index($data, $filters)
	{
		$this->customValidation->validate('index', $this->crud);

		$model = new $this->crud->model;
		
		$query = $model->query();

		$query = $this->scopeSearch($query, $data);
		$query = $this->scopeFields($query, $data);
		$query = $this->scopeRelations($query, $data);
		$query = $filters->buildQuery($query);

		$items = $query->orderBy($data['sort'], $data['order'])
		->paginate($data['perPage'])
		->through(function($item) {
			$this->map($item);
			return $item;
		});

		$this->customFilter->filter($items, 'index', $this->crud);

		return $items;
	}

	public function store($data)
	{
		$this->customValidation->validate('store', $this->crud, true);

		$data = $this->uploadFiles($data);

		$modelClass = $this->crud->model;

		if ($this->crud->multilanguage) {

			foreach (Lang::all() as $lang) {
				
				$model = new $modelClass($lang->tag);
	
				if ($lang->tag == Lang::get()) {
					
					$item = $model->create($data);

				} else {

					$itemOtherLang = $model->create($data);

					$this->customFilter->filter($itemOtherLang, 'store', $this->crud);
				}
			}

		} else {

			$model = new $modelClass;

			$item = $model->create($data);
		}

		$this->map($item);

		$this->customFilter->filter($item, 'store', $this->crud);

		return $item;
	}

	public function show($id, $data)
	{
		$this->customValidation->validate('show', $this->crud);

		$model = new $this->crud->model;

		$slugField = $this->crud->fields->first(fn($f) => ($f->db_title ?? '') == 'slug');

		if ($slugField) {
			$query = $model->where(
				fn($q) =>
					$q->where('id', $id)
					->orWhere('slug', $id)
			);
		} else {
			$query = $model->where('id', $id);
		}

		$query = $this->scopeFields($query, $data);

		$query = $this->scopeRelations($query, $data);

		$item = $query->first();

		if (!$item) {

			return null;
		}

		$this->map($item);

		$this->customFilter->filter($item, 'show', $this->crud);

		return $item;
	}


	public function update($id, $data)
	{
		$this->customValidation->validate('update', $this->crud, true);

		$model = new $this->crud->model;
		
		$model->where('id', $id)
		->update($data);

		$item = $model->where('id', $id)
		->first();

		$this->map($item);

		$this->customFilter->filter($item, 'update', $this->crud);

		return $item;
	}

	public function destroy($id)
	{
		$this->customValidation->validate('destroy', $this->crud);

		$modelClass = $this->crud->model;

		if ($this->crud->multilanguage) {

			foreach (Lang::all() as $lang) {
				
				$model = new $modelClass($lang->tag);

				$model->where('id', $id)
				->delete();
			}

		} else {
			
			$model = new $modelClass;

			$model->where('id', $id)
			->delete();
		}

		return;
	}

	protected function map($item)
	{
		$fields = $this->crud->getFieldsType();

		foreach ($fields as $key => $field) {
			
			if (in_array($field, ['photo', 'file'])) {

				$item->$key = $item->$key ? url($item->$key) : '';
			
			} elseif (in_array($field, ['gallery'])) {

				$gallery = [];

				$images = json_decode($item->$key);
				
				if ($images) {
					foreach ($images as $image) {
						$gallery[] = url($image);
					}
				}
				
				$item->$key = $gallery;
			}
		}

		return $item;
	}

	#TODO: make search for all fields ? or mark field as searchable, now searching by admin visible fields
	protected function scopeSearch($query, $data)
	{	
		$visible = $this->crud->getVisibleFields();

		$query = $query->where(function($query) use ($visible, $data) {

			foreach ($visible as $field) {

				$query->orWhere($field, 'LIKE', "%{$data['search']}%");
			}
		});

		return $query;
	}

	protected function scopeFields($query, $data)
	{
		$select = [];

		foreach ($data['fields'] as $field) {
			$select[] = $field;
		}

		$query = $query->select($select);

		return $query;
	}

	protected function scopeRelations($query, $data)
	{
		$relations = $this->crud->getRelations();
		
		return $query->when($data['relations'], function($q) use ($data, $relations) {
			
			if ($data['relations'] == '*') {
				
				foreach ($relations as $relation) {
					if ($relation == 'user') continue;
					$q->with($relation);
				}

			} else {
				
				foreach ($data['relations'] as $relation) {
					if ($relation == 'user') continue;
					$q->with($relation);
				}
			}

		});
	}

	protected function uploadFiles($data)
	{
		$fieldsTypes = $this->crud->getFieldsType();
		
		foreach ($data as $key => $value) {

			if (!isset($fieldsTypes[$key])) {
				continue;
			}

			$fieldType = $fieldsTypes[$key];
			
			if (!in_array($fieldType, ['photo', 'file', 'gallery'])) {
				continue;
			}

			$uploadPath = $fieldType == 'file' ? "files/1/" : "photos/1/";

			if ($fieldType == 'gallery') {

				$gallery = [];

				foreach ($value as $valueItem) {
					$gallery[] = $this->uploadFile($valueItem, $uploadPath);
				}

				$data[$key] = $gallery;

			} else {
				$data[$key] = $this->uploadFile($value, $uploadPath);
			}
		}

		return $data;
	}

	protected function uploadFile($file, $uploadPath)
	{
		if ($file != null) {

			$fileName = time() . '-' . $file->getClientOriginalName();

			$file->move($uploadPath, $fileName);

			return '/' . $uploadPath . $fileName;
		}

		return '';
	}
}
