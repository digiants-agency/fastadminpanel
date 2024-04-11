<?php 

namespace App\FastAdminPanel\Services;

use App\FastAdminPanel\Facades\Lang;
use App\FastAdminPanel\Models\Menu;

class ApiService
{
	protected $menuItem;

	public function __construct(Menu $menuItem)
	{
		$this->menuItem = $menuItem;
	}

	public function index($data, $filters)
	{
		$model = new $this->menuItem->model;
		
		$query = $model->query();

		$query = $this->scopeSearch($query, $data);
		$query = $this->scopeFields($query, $data);
		$query = $this->scopeRelations($query, $data);
		$query = $filters->buildQuery($query);

		$items = $query->orderBy($data['sort'], $data['order'])
		->paginate($data['perPage'])
		->through(function($item) {
			return $this->map($item); 
		});

		return $items;
	}

	public function store($data)
	{
		$data = $this->uploadFiles($data);

		$modelClass = $this->menuItem->model;

		if ($this->menuItem->multilanguage) {

			foreach (Lang::getLangs() as $lang) {
				
				$model = new $modelClass($lang->tag);
	
				if ($lang->tag == Lang::get()) {
					
					$item = $model->create($data);

				} else {

					$model->create($data);
				}
			}

		} else {

			$model = new $modelClass;

			$item = $model->create($data);
		}

		return $this->map($item);
	}

	public function show($id, $data)
	{
		$model = new $this->menuItem->model;
		
		$query = $model->where('id', $id);

		$query = $this->scopeFields($query, $data);
		$query = $this->scopeRelations($query, $data);

		$item = $query->first();

		return $this->map($item);
	}


	public function update($id, $data)
	{
		$model = new $this->menuItem->model;
		
		$model->where('id', $id)
		->update($data);

		$item = $model->where('id', $id)
		->first();

		return $this->map($item);
	}

	public function destroy($id)
	{
		$modelClass = $this->menuItem->model;

		if ($this->menuItem->multilanguage) {

			foreach (Lang::getLangs() as $lang) {
				
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
		$fields = $this->menuItem->getFieldsType();

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
		$visible = $this->menuItem->getVisibleFields();

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
		$relations = $this->menuItem->getRelations();
		
		return $query->when($data['relations'], function($q) use ($data, $relations) {
			
			if ($data['relations'] == '*') {
				
				foreach ($relations as $relation) {
					$q->with($relation);
				}

			} else {
				
				foreach ($data['relations'] as $relation) {
					$q->with($relation);
				}
			}

		});
	}

	protected function uploadFiles($data)
	{
		$fieldsTypes = $this->menuItem->getFieldsType();
		
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