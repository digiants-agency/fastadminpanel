<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Menu;
use App\FastAdminPanel\Models\SinglePage;
use App\FastAdminPanel\Responses\JsonResponse;
use App\FastAdminPanel\Services\TableService;
use Schema;
use Validator;
use Lang;
use Auth;
use App;
use DB;

class AdminController extends \App\Http\Controllers\Controller
{
	private $tableService;
	
	public function __construct(TableService $tableService)
	{
		$this->tableService = $tableService;
	}

	public function admin()
	{
		$languages = DB::table('languages')->get();
		$custom_components_path = resource_path('views/fastadminpanel/components/custom');
		$custom_components_files = scandir($custom_components_path);
		$custom_components = [];

		foreach ($custom_components_files as $custom_component) {
			$pathinfo = pathinfo($custom_component);
			if ($pathinfo['extension'] == 'php') {
				$custom_components[] = [
					'name'	=>	$pathinfo['filename'],
					'path'	=> 'fastadminpanel/components/custom/'.$pathinfo['filename'],
				];
			}
		}

		App::setLocale(Auth::user()->admin_lang_tag);

		return view('fastadminpanel.pages.admin')->with([
			'languages'			=> $languages,
			'custom_components'	=> $custom_components,
		]);
	}

	public function login()
	{
		return view('fastadminpanel.pages.login')->with([]);
	}

	public function signIn()
	{
		$request = request();

		$email = $request->get('email');
		$password = $request->get('password');

		if (Auth::attempt(['email' => $email, 'password' => $password], $request->get('remember') === 'true')) {

			return redirect('/admin');
		}

		setcookie('password', 'incorrect', time() + 3600 * 5);

		return redirect('/login');
	}

	public function logout()
	{
		Auth::logout();

		return redirect('/login');
	}
	
	public function updateDropdown()
	{
		$dropdown = request()->get('dropdown');

		DB::table('dropdown')->truncate();

		$query = [];

		if (!empty($dropdown)) {
			foreach ($dropdown as $elm) {
				$query[] = [
					'id'	=> $elm['id'],
					'title'	=> $elm['title'],
					'sort'	=> $elm['sort'],
					'icon'	=> $elm['icon'],
				];
			}
		}

		DB::table('dropdown')->insert($query);
	}

	public function getMenu()
	{
		$menu = Menu::select(
			'id', 
			'table_name',
			'title',
			'fields',
			'is_dev', 
			'multilanguage',
			'is_soft_delete',
			'sort',
			'dropdown_id',
			'icon',
			DB::raw('"multiple" AS type')
		)->get();

		$dropdown = DB::table('dropdown')->get();

		foreach ($menu as &$elm) {
			$elm->fields = json_decode($elm->fields);
		}
		
		$tables = ['orders', 'callback_modal', 'callback_contacts', 'callback_horizontal']; //name tables for count in sidebar
		foreach ($tables as $table) {

			if ($menu->where('table_name', $table)->first()){

				$table = $table;
				if ($menu->where('table_name', $table)->first()->multilanguage == 1){
					$table = $table.'_'.Lang::get();
				}

				$count = DB::table($table)
				->count();

				$menu->where('table_name', $table)->first()->count = $count;
			}
		}

		foreach ($dropdown as &$dd){
			$dd->count = $menu->where('dropdown_id', $dd->id)->sum('count');
		}

		$single = SinglePage::select(
			'id',
			'id AS table_name',
			'title',
			'slug',
			'sort',
			'dropdown_id',
			'icon',
			DB::raw('0 AS is_dev'),
			DB::raw('"single" AS type')
		)
		->with(['blocks' => function ($q) {
			$q->with(['fields' => function($q) {
				$q->with(['fields' => function($q) {
					$q->orderBy('sort', 'ASC');
				}])
				->where('parent_id', 0)
				->orderBy('sort', 'ASC');
			}])
			->orderBy('sort', 'ASC');
		}])
		->get();

		return response()->json(
			[
				'menu'		=> array_values(
					$single->concat($menu)
					->sortBy('sort')
					->toArray()
				),
				'dropdown'	=> $dropdown,
			]
		);
	}

	public function dbSelect()
	{
		$table = $this->getVal('table');
		$offset = $this->getVal('offset', 0);
		$limit = $this->getVal('limit', 100);
		$order = $this->getVal('order', 'id');
		$sort_order = $this->getVal('sort_order', 'ASC');
		$fields = $this->getVal('fields', '*');
		$where = $this->getVal('where', '');
		$relationships = $this->getVal('relationships', '');   // many
		$editables = $this->getVal('editables', '');   // one to many (editable)
		$join = $this->getVal('join', '');   // one to many (editable)

		$full_table = $this->tableService->getTable(
			$this->getVal('table'),
			$this->getVal('language')
		);

		$values = DB::table($full_table)
		->selectRaw($fields)
		->when($where != '', function($q) use ($where){
			$q->whereRaw($where);
		})
		->when(!empty($join), function($q) use ($join, $table, $full_table){
			foreach (json_decode($join) as $tbl) {
				$q->leftJoin($tbl->full, "{$tbl->full}.id", "$full_table.id_{$tbl->short}");
			}
		})
		->offset($offset)
		->limit($limit)
		->orderBy(DB::raw($order), $sort_order)
		->get();

		$count = DB::table($full_table)
		->selectRaw($fields)
		->when($where != '', function($q) use ($where){
			$q->whereRaw($where);
		})
		->when(!empty($join), function($q) use ($join, $table, $full_table){
			foreach (json_decode($join) as $tbl) {
				$q->leftJoin($tbl->full, "{$tbl->full}.id", "$full_table.id_{$tbl->short}");
			}
		})
		->count();
		
		if ($relationships != '') {

			$rels = json_decode($relationships);

			foreach ($rels as $rel) {

				$rel_id = $rel->id;
				$rel_table = $rel->rel;
				$rel_connected_table = $rel->table;

				if ($rel_table == $rel_connected_table.'_'.$rel_connected_table)
					$rel_connected_table_title = $rel_connected_table.'_other';
				else $rel_connected_table_title = $rel_connected_table;
	
				$vals = DB::table($rel_table)
				->select('id_' . $rel_connected_table_title.' as rel_id')
				->where('id_'.$table, $rel_id)
				->orderBy('id', 'ASC')
				->get();

				$field = [];

				foreach ($vals as $v) {
					$field[] = [$rel_connected_table => $v->rel_id];
				}

				$val_title = '$'.$rel_table;

				$values->map(function ($item) use ($val_title, $field) {

					$item->$val_title = $field;
					return $item;
				});
			}
		}

		if ($editables != '') {

			$values->map(function ($item) {

				$item->editable = [];
				return $item;
			});

			$edits = json_decode($editables);

			foreach ($edits as $editable) {

				$tbl = $editable->table;

				$vals = DB::table($this->tableService->getTable(
					$editable->table,
					$this->getVal('language')
				))
				->where("id_$table", $editable->id)
				->get();
				
				$values->map(function ($item) use ($tbl, $vals) {

					$item->editable[$tbl] = $vals;
					return $item;
				});
			}
		}

		return [
			'instances'	=> $values,
			'count'		=> $count,
		];
	}

	public function dbCount()
	{
		$table = $this->getVal('table');
		$language = $this->getVal('language');

		return DB::selectOne("SELECT count(*) AS count FROM $table$language")->count;
	}

	private function getVal($title, $default = '')
	{
		$r = request();
		$val = $r->get($title);

		if (!empty($val))
			return $val;
		return $default;
	}

	public function dbCopy()
	{
		$input = request()->all();

		$this->dbCopyFields($input['id'], $input['table']);

		return 'Success';
	}
	
	private function dbCopyFields($input_id, $input_table)
	{
		$tables = $this->tableService->getTables($input_table);

		foreach ($tables as $table) {

			$row = DB::table($table)
			->where('id', $input_id)
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

			$new_id = DB::table($table)->insertGetId($insert);
		}

		
		$this->dbCopyMany($input_id, $input_table, $new_id);
		$this->dbCopyEditable($input_id, $input_table, $new_id);
	}

	private function dbCopyMany($id, $table, $new_id)
	{
		$field_properties = DB::table('menu')
		->select('fields')
		->where('table_name', $table)
		->first();

		if (!empty($field_properties)){
			
			$field_properties = json_decode($field_properties->fields);

			foreach ($field_properties as $properties) {
				if ($properties->type == 'relationship' && $properties->relationship_count == 'many') {
					
					$many_items = DB::table($table . '_' . $properties->relationship_table_name)
					->where('id_' . $table, $id)
					->get()->all();

					foreach ($many_items as $key => &$many_item){
						$many_item = (array)$many_item;

						unset($many_items[$key]['id']);
						$many_item['id_' . $table] = $new_id;
					}

					DB::table($table . '_' . $properties->relationship_table_name)
					->insert($many_items);
				}
			}	
		}
		
	}

	private function dbCopyEditable($id, $table, $new_id)
	{
		$editable = [];

		$fields = DB::table('menu')
		->select('fields')
		->where('table_name', $table)
		->first();

		if ($fields){

			$fields = json_decode($fields->fields);

			foreach ($fields as $field) {
				if ($field->type == 'relationship' && $field->relationship_count == 'editable') {
					$editable[] = $field->relationship_table_name;
				}
			}

			foreach ($editable as $table_name) {

				$tables = $this->tableService->getTables($table_name);

				$parents = [];

				foreach ($tables as $tbl_index => $tbl){

					$editable_items = DB::table($tbl)
					->where("id_$table", $id)
					->get()->all();
	
					foreach ($editable_items as $key => &$editable_item){
						$editable_item = (array)$editable_item;
	
						$item_id = $editable_item['id'];
	
						unset($editable_items[$key]['id']);
						unset($editable_items[$key]['created_at']);
						unset($editable_items[$key]['updated_at']);
	
						foreach ($editable_item as $key_item => &$item){
	
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
						
						$editable_item['id_' . $table] = $new_id;
	
						$new_editable_id = DB::table($tbl)
						->insertGetId($editable_item);
	
						if ($tbl_index == 0){
							$parents[] = [
								'id'		=> $item_id,
								'table'		=> $table_name,
								'new_id'	=> $new_editable_id,
							];
						}
					}
				}
				

				if ($parents) {

					foreach ($parents as $parent) {

						$this->dbCopyMany($parent['id'], $parent['table'], $parent['new_id']);
						$this->dbCopyEditable($parent['id'], $parent['table'], $parent['new_id']);
		
					}
				}

			}
		}
	}

	public function saveEditable()
	{
		$input = request()->all();

		$menu = DB::table('menu')
		->select('multilanguage', 'fields')
		->where('table_name', $input['table'])
		->first();

		$fields = collect(json_decode($menu->fields));

		$field = $fields->first(function($v, $k) use($input, $fields){
			return ($v->db_title ?? '') == $input['field'];
		});

		if ($menu->multilanguage == 0) {

			DB::table($input['table'])
			->where('id', $input['id'])
			->update([
				$input['field'] => $input['value'],
			]);

		} else if ($menu->multilanguage == 1 && $field->lang == 0) {

			foreach ($this->tableService->getTables($input['table']) as $tbl) {

				DB::table($tbl)
				->where('id', $input['id'])
				->update([
					$input['field'] => $input['value'],
				]);
			}

		} else if ($menu->multilanguage == 1 && $field->lang == 1) {

			DB::table($input['table'] . '_' . $_COOKIE['lang'])
			->where('id', $input['id'])
			->update([
				$input['field'] => $input['value'],
			]);
		}

		return JsonResponse::response();
	}
	
	private function dbRemoveEditable($id, $table)
	{
		$editable = [];

		$fields = DB::table('menu')
		->select('fields')
		->where('table_name', $table)
		->first();

		if ($fields){
			
			$fields = json_decode($fields->fields);
			
			foreach ($fields as $field) {
				if ($field->type == 'relationship' && $field->relationship_count == 'editable') {
					$editable[] = $field->relationship_table_name;
				}
			}
	
			foreach ($editable as $table_name) {
	
				$tables = $this->tableService->getTables($table_name);
	
				$parents = []; 
	
				$parents_table = explode('_', $tables[0])[0]; 
	
				foreach ($tables as $table_index => $tbl){

					$editable_items = DB::table($tbl)
					->where("id_$table", $id)
					->get()->all();
		
					foreach ($editable_items as $editable_item) {
		
						if ($table_index == 0){

							$parents[] = [
								'id'	=> $editable_item->id,
								'table' => $parents_table,
							];
						}
		
						DB::table($tbl)
						->where('id', $editable_item->id)
						->delete();
					}
				}
				
	
				if ($parents) {
					foreach ($parents as $parent) {
	
						$this->dbRemoveRelationshipMany($parent['id'], $parent['table']);
						$this->dbRemoveEditable($parent['id'], $parent['table']);
					}
				}
	
			}
		}
	}

	private function dbRemoveRelationshipMany($id, $table_name)
	{
		$field_properties = DB::table('menu')
		->select('fields')
		->where('table_name', $table_name)
		->first();

		if ($field_properties) {

			$field_properties = json_decode($field_properties->fields);

			foreach ($field_properties as $properties) {
				if ($properties->type == 'relationship' && $properties->relationship_count == 'many') {
					
					DB::table($table_name . '_' . $properties->relationship_table_name)
					->where('id_' . $table_name, $id)
					->delete();
				}
			}
		}

	}

	public function dbRemoveRow()
	{
		$r = request();

		$id = $r->get('id');
		$lang = $r->get('language');

		if ($lang != '') {

			foreach ($this->tableService->getTables($r->get('table_name')) as $table) {

				DB::table($table)
				->where('id', $id)
				->delete();
			}

		} else {

			DB::table($r->get('table_name'))
			->where('id', $id)
			->delete();
		}
		
		$this->dbRemoveRelationshipMany($id, $r->get('table_name'));
		$this->dbRemoveEditable($id, $r->get('table_name'));

		return 'Success';
	}

	public function dbRemoveRows()
	{
		$r = request();

		$ids = json_decode($r->get('ids'));
		$lang = $r->get('language');

		if ($lang != '') {
			foreach ($ids as $id) {

				foreach ($this->tableService->getTables($r->get('table_name')) as $table) {

					DB::table($table)
					->where('id', $id)
					->delete();
				}
			}
		} else {

			DB::table($r->get('table_name'))
			->whereIn('id', $ids)
			->delete();
		}

		foreach ($ids as $id) {
			$this->dbRemoveRelationshipMany($id, $r->get('table_name'));
			$this->dbRemoveEditable($id, $r->get('table_name'));
		}

		return 'Success';
	}
	
	public function uploadImage()
	{
		$data = request()->all();
		
		$validator = Validator::make($data, [
			'upload'      => 'image|max:10000'
		]);
		if ($validator->fails()) {
			return response()->json($validator->errors());
		};

		$upload_path = "photos/1/";

		$img = request()->file('upload');

		if ($img != null) {
			$img_name = time().'-'.$img->getClientOriginalName();
			$img->move($upload_path, $img_name);

			return response()->json('{"url":"' . $upload_path . $img_name . '"}');
		}

		return response()->json('{"error":"Error, file not found"}');
	}
	
	public function setDynamic()
	{
		$input = request()->all();

		$input['fields'] = json_decode($input['fields']);


		$this->setDynamicFields($input);

		return JsonResponse::response();
	}

	private function setDynamicFields($input, $parent_table = false, $parent_id = false)
	{
		$menu = DB::table('menu')
		->select('multilanguage')
		->where('table_name', $input['table'])
		->first();

		$update = [];
		$update_multilanguage = [];

		foreach ($input['fields'] as $field) {
			
			if ($field->type == 'relationship') {

				if ($field->relationship_count == 'single') {

					if ($menu->multilanguage == 1 && $field->lang == 0) {

						$update_multilanguage['id_'.$field->relationship_table_name] = $field->value;
					}

					$update['id_'.$field->relationship_table_name] = $field->value;
				} // other rels are below

			} else if ($field->type == 'gallery') {

				if ($menu->multilanguage == 1 && $field->lang == 0) {

					$update_multilanguage[$field->db_title] = json_encode($field->value, JSON_UNESCAPED_UNICODE);
				}

				$update[$field->db_title] = json_encode($field->value, JSON_UNESCAPED_UNICODE);


			} else if ($field->type == 'password') {

				if ($input['id'] == 0) {

					if (empty($field->value)) {
					
						$update[$field->db_title] = '';
					
					} else {

						$update[$field->db_title] = bcrypt($field->value);
					}

				} else {

					if (!empty($field->value)) {

						if ($menu->multilanguage == 1 && $field->lang == 0) {

							$update_multilanguage[$field->db_title] = bcrypt($field->value);
						}

						$update[$field->db_title] = bcrypt($field->value);
					}
				}

			} else {

				if ($menu->multilanguage == 1 && $field->lang == 0) {

					$update_multilanguage[$field->db_title] = $field->value;
				}

				$update[$field->db_title] = $field->value;
			}
		}

		if (!empty($update)) {

			if ($input['id'] == 0) {

				$tables = $this->tableService->getTables($input['table']);

				foreach ($tables as $table) {
					
					$update['id'] = DB::table($table)->insertGetId($update);
					$input['id'] = $update['id'];

					if ($parent_table) {
						DB::table($table)
						->where('id', $input['id'])
						->update([
							"id_$parent_table" => $parent_id,
						]);
					}
				}

			} else {

				$table_main = $this->tableService->getTable(
					$input['table'],
					$input['language']
				);

				DB::table($table_main)
				->where('id', $input['id'])
				->update($update);

				if ($menu->multilanguage == 1 && !empty($update_multilanguage)) {

					foreach ($this->tableService->getTables($input['table']) as $table) {

						if ($table_main == $table)
							continue;
						
						DB::table($table)
						->where('id', $input['id'])
						->update($update_multilanguage);
					}
				}
			}
		}

		// editable and many relations START
		foreach ($input['fields'] as $field) {
			
			if ($field->type == 'relationship') {

				if ($field->relationship_count == 'many') {

					$table_relationship = $input['table'].'_'.$field->relationship_table_name;
					$col_first = 'id_'.$input['table'];
					$col_last = 'id_'.$field->relationship_table_name;

					if ($col_first == $col_last)
						$col_last = $col_last.'_other';

					DB::table($table_relationship)
					->where($col_first, $input['id'])
					->delete();

					$many_insert = [];

					foreach ($field->value as $id) {
						$many_insert[] = [
							$col_first	=> $input['id'],
							$col_last	=> $id,
						];
					}

					DB::table($table_relationship)
					->insert($many_insert);

				} else if ($field->relationship_count == 'editable') {

					$editable_ids = DB::table($this->tableService->getTable(
						$field->relationship_table_name,
						$input['language']
					))
					->select('id')
					->where('id_'.$input['table'], $input['id'])
					->get()
					->pluck('id');

					
					$current_ids = array_column($field->value, 'id');
					$diff_ids = array_diff($editable_ids->all(), $current_ids);

					DB::table($this->tableService->getTable(
						$field->relationship_table_name,
						$input['language']
					))
					->whereIn('id', $diff_ids)
					->delete();					

					foreach ($field->value as $group) {

						foreach ($group->fields as &$f) {
							if ($f->type == 'relationship' && $f->relationship_count == 'single' && $f->relationship_table_name == $input['table']) {

								$field_title = 'id_'.$input['table'];
								$f->$field_title = $input['id'];
							}
						}

						$this->setDynamicFields([
							'fields'	=> $group->fields,
							'language'	=> $input['language'],
							'table'		=> $field->relationship_table_name,
							'id'		=> $group->id,
						], $input['table'], $input['id']);
					}
				}
			}
		}
		// editable and many relations END
	}

	public function getDynamic()
	{
		$input = request()->all();

		$fields = $this->getDynamicFields($input);

		return JsonResponse::response($fields);
	}

	private function getDynamicFields($input)
	{
		$menu = DB::table('menu')
		->where('table_name', $input['table'])
		->first();

		$instance = DB::table($this->tableService->getTable(
			$input['table'],
			$input['language']
		))
		->where('id', $input['id'])
		->first();

		$fields = [];

		foreach (json_decode($menu->fields) as $field) {

			// TODO: date/datetime?
			if ($field->type == 'relationship') {

				if ($field->relationship_count != 'editable') {

					$field->values = DB::table($this->tableService->getTable(
						$field->relationship_table_name, 
						$input['language']
					))
					->select('id', $field->relationship_view_field.' as title')
					->get();

					//for filters_fields
					if ($field->relationship_table_name == 'filter_fields'){
						$field->values = DB::table($this->tableService->getTable(
							$field->relationship_table_name, 
							$input['language']
						))
						->select('id', 'title', 'id_filters')
						->get();					
						
						$filters = DB::table('filters_'.$input['language'])
						->select('id', 'title')
						->get();
						
						foreach ($field->values as &$value){
							$filter = $filters->where('id', $value->id_filters)->first();
							
							if ($filter)
								$value->title = $filter->title.': '.$value->title;	
						}						
					}

					if ($field->relationship_count == 'single') {

						if ($input['id'] == 0) {

							$field->value = 0;

						} else {

							$field_title = 'id_' . $field->relationship_table_name;
							$field->value = $instance->$field_title;
							
							if ($field->value)
								$field->value_title = $field->values->where('id', $field->value)->first()->title;
						}

					} else if ($field->relationship_count == 'many') {

						if ($input['id'] == 0) {

							$field->value = [];

						} else {

							$rel_table = $input['table'].'_'.$field->relationship_table_name;
							$rel_connected_table = $field->relationship_table_name;

							if ($rel_table == $input['table'].'_'.$input['table'])
								$rel_connected_table .= '_other';

							$field->value = DB::table($rel_table)
							->select('id_'.$rel_connected_table.' AS id')
							->where('id_'.$input['table'], $input['id'])
							->orderBy('id', 'ASC')
							->get()
							->pluck('id');
						}

					}
				} else if ($field->relationship_count == 'editable') {

					$field->value = [];

					if ($input['id'] != 0) {

						$editable_ids = DB::table($this->tableService->getTable(
							$field->relationship_table_name,
							$input['language']
						))
						->select('id')
						->where('id_'.$input['table'], $input['id'])
						->get()
						->pluck('id');

						foreach ($editable_ids as $editable_id) {
							
							$field->value[] = [
								'fields'	=> $this->getDynamicFields([
									'table'		=> $field->relationship_table_name,
									'language'	=> $input['language'],
									'id'		=> $editable_id,
								]),
								'id'		=> $editable_id,
							];
						}
					}

					$field->values = $this->getDynamicFields([
						'table'		=> $field->relationship_table_name,
						'language'	=> $input['language'],
						'id'		=> 0,
					]);
				}

			} else if ($field->type == 'gallery') {

				if ($input['id'] == 0) {

					$field->value = [];

					preg_match('/{(.*)}/', $field->title, $remark);
					if ($remark){

						$field->title  = str_replace($remark[0], '', $field->title);
						$field->remark = $remark[1];
					}

				} else {

					$field_title = $field->db_title;
					$field->value = json_decode($instance->$field_title);

					preg_match('/{(.*)}/', $field->title, $remark);
					if ($remark){

						$field->title  = str_replace($remark[0], '', $field->title);
						$field->remark = $remark[1];
					}
				}

			} else if ($field->type == 'password') {

				$field->value = '';

			} else if ($field->type == 'checkbox' || $field->type == 'money' || $field->type == 'number') {

				if ($input['id'] == 0) {

					$field->value = 0;

					preg_match('/{(.*)}/', $field->title, $remark);
					if ($remark){

						$field->title  = str_replace($remark[0], '', $field->title);
						$field->remark = $remark[1];
					}

				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;

					preg_match('/{(.*)}/', $field->title, $remark);
					if ($remark){

						$field->title  = str_replace($remark[0], '', $field->title);
						$field->remark = $remark[1];
					}
				}

			} else if ($field->type == 'date') {

				if ($input['id'] == 0) {

					$field->value = date('Y-m-d');

					preg_match('/{(.*)}/', $field->title, $remark);
					if ($remark){

						$field->title  = str_replace($remark[0], '', $field->title);
						$field->remark = $remark[1];
					}

				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;

					preg_match('/{(.*)}/', $field->title, $remark);
					if ($remark){

						$field->title  = str_replace($remark[0], '', $field->title);
						$field->remark = $remark[1];
					}
				}
			} else if ($field->type == 'datetime') {

				if ($input['id'] == 0) {

					$field->value = date('Y-m-d H:i');
					
					preg_match('/{(.*)}/', $field->title, $remark);
					if ($remark){

						$field->title  = str_replace($remark[0], '', $field->title);
						$field->remark = $remark[1];
					}

				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;

					preg_match('/{(.*)}/', $field->title, $remark);
					if ($remark){

						$field->title  = str_replace($remark[0], '', $field->title);
						$field->remark = $remark[1];
					}
				}
			} else {

				if ($input['id'] == 0) {

					$field->value = '';

					preg_match('/{(.*)}/', $field->title, $remark);
					if ($remark){

						$field->title  = str_replace($remark[0], '', $field->title);
						$field->remark = $remark[1];
					}
					
				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;

					$field->instance_id = $instance->id;

					preg_match('/{(.*)}/', $field->title, $remark);
					if ($remark){

						$field->title  = str_replace($remark[0], '', $field->title);
						$field->remark = $remark[1];
					}
				}
			}

			$fields[] = $field;
		}

		return $fields;
	}
	
	protected function response($result = []) {
		
		$response = [
			'success' => true,
			'data'    => $result,
		];
		
		return response()->json($response, 200);
	}

	protected function error($error_messages = [], $code = 418) {

		$response = [
			'success'	=> false,
			'data'		=> $error_messages,
		];

		return response()->json($response, $code);
	}

	public function getMainpage()
	{
		// $popproducts =  DB::select('
		//     SELECT products_'.Lang::get().'.title, products_'.Lang::get().'.slug, products_'.Lang::get().'.image, orders_product.slug, orders_product.title, 
		//     COUNT(*) as countorders FROM orders_product 
		//         INNER JOIN products_'.Lang::get().' ON products_'.Lang::get().'.id = orders_product.id 
		//         GROUP BY orders_product.title
		//         ORDER BY countorders DESC LIMIT 5');

		$sorted_popular_products = null;

		if (Schema::hasTable('orders_product') && Schema::hasTable('products_'.Lang::get())){

			$count_popular = DB::table('orders_product')
			->select(DB::raw("SUM(count) as countorders, slug"))
			->orderBy('countorders', 'DESC')
			->groupBy('slug')
			->get();
	
			$popproducts = DB::table('products_'.Lang::get())
			->whereIn('slug', $count_popular->pluck('slug'))
			->get();
	
			foreach($popproducts as &$popproduct){
				$popproduct->count = $count_popular->where('slug', $popproduct->slug)->first()->countorders;
			}
	
			$popproducts = $popproducts->sortByDesc('count')->slice(0, 4);
			
			$sorted_popular_products = [];
	
			foreach ($popproducts as $key => $popproduct) {
				$sorted_popular_products[] = $popproduct;
			}
		}
		

		$thismonth = date("Y-m-00 00:00:00");
		$today = date("Y-m-d 00:00:00");

		$alldata = [];

		if (Schema::hasTable('orders_product') && 
			Schema::hasTable('products_'.Lang::get()) && 
			Schema::hasTable('callback_horizontal') && 
			Schema::hasTable('orders')){

			$alldata = [   
				'allproducts' 	=> DB::table('products_'.Lang::get())->count(),
				'productsale' 	=> DB::table('orders_product')->sum('count'),
				'callbackall' 	=> DB::table('callback_horizontal')->count() + DB::table('callback_contacts')->count() + DB::table('callback_modal')->count(),
				'allorders' 	=> DB::table('orders')->count(),
				'orderstoday' 	=> DB::table('orders')->where('created_at','>', $today)->count(),
				'ordersmonth' 	=> DB::table('orders')->where('created_at','>', $thismonth)->count()
			];
		}

		$lastweek = date( "Y-m-d", strtotime( "-6 day" ));
		$weekdata = [
			date("Y-m-d") 							=> 0,
			date( "Y-m-d", strtotime( "-1 day" )) 	=> 0,
			date( "Y-m-d", strtotime( "-2 day" )) 	=> 0,
			date( "Y-m-d", strtotime( "-3 day" )) 	=> 0,
			date( "Y-m-d", strtotime( "-4 day" )) 	=> 0,
			date( "Y-m-d", strtotime( "-5 day" )) 	=> 0,
			date( "Y-m-d", strtotime( "-6 day" )) 	=> 0,
		];

		$graph1 = null;

		if (Schema::hasTable('orders')) {

			$orders = DB::table('orders')
			->where('created_at','>', $lastweek)
			->get();

			if ($orders->count()){

				foreach ($orders as &$lw){
					$lw->created_at = explode(' ', $lw->created_at)[0];
				}
		
				foreach ($orders as $lw){
					$weekdata[$lw->created_at]++;
				}

				$graph1 = implode(',', $weekdata);

				foreach ($weekdata as &$w){
					$w = 0;
				}
			}
		}

		$graph2 = null;

		if (Schema::hasTable('callback_horizontal') && 
			Schema::hasTable('callback_modal') && 
			Schema::hasTable('callback_contacts')) {

			$callbacks = DB::table('callback_horizontal')
			->select('created_at')
			->where('created_at','>', $lastweek)
			->get();
	
			$callbacks = $callbacks->merge(
				DB::table('callback_modal')
				->select('created_at')
				->where('created_at','>', $lastweek)
				->get()
			);
	
			$callbacks = $callbacks->merge(
				DB::table('callback_contacts')
				->select('created_at')
				->where('created_at','>', $lastweek)
				->get()
			);

			if ($callbacks->count()){

				foreach ($callbacks as &$lw) {
					$lw->created_at = explode(' ', $lw->created_at)[0];
				}
		
				foreach ($callbacks as $lw) {
					$weekdata[$lw->created_at]++;
				}
		
				$graph2 = implode(',', $weekdata);
			}
		}

		return JsonResponse::response([
			'firstblock' => $alldata,
			'popproducts' => $sorted_popular_products,
			'graph1' => $graph1,
			'graph2' => $graph2
		]);
	}
}