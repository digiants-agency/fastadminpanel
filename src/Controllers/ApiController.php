<?php 

namespace Digiants\FastAdminPanel\Controllers;

use App\User;
use DB;
use Schema;
use Validator;
use Lang;
use Digiants\FastAdminPanel\Helpers\Single;

class ApiController extends \App\Http\Controllers\Controller {

	public function update_dropdown () {

		$dropdown = request()->get('dropdown');

		DB::table('dropdown')->truncate();

		$query = [];

		if (!empty($dropdown)) {
			foreach ($dropdown as $elm) {
				$query[] = [
					'id'	=> $elm['id'],
					'title'	=> $elm['title'],
					'sort'	=> $elm['sort'],
				];
			}
		}

		DB::table('dropdown')->insert($query);
	}

	public function set_single ($id) {

		$blocks = request()->get('blocks');

		foreach ($blocks as $block) {
			foreach ($block as $field) {

				$table_name = Single::$type_table[$field['type']];

				if ($field['is_multilanguage'] == 1)
					$table_name .= '_'.$_COOKIE['lang'];

				Single::prepare_field_to_db($field);

				if ($field['value'] === null) $field['value'] = '';

				DB::statement("INSERT INTO $table_name (field_id, value) 
				VALUES(".$field['id'].", ?) 
				ON DUPLICATE KEY 
				UPDATE value=?", [$field['value'],$field['value']]);
			}
		}
	}

	public function get_single ($id) {
		
		$single_fields = DB::table('single_field')
		->select(
			'id',
			'is_multilanguage',
			'type',
			'title',
			'block_title',
			'single_page_id',
			'sort'
		)->where('single_page_id', $id)
		->orderBy('sort', 'ASC')
		->get();

		$blocks = [];

		foreach ($single_fields as &$field) {

			$table_name = Single::$type_table[$field->type];

			if ($field->is_multilanguage == 1)
				$table_name .= '_'.$_COOKIE['lang'];
			
			$obj = DB::table($table_name)
			->select('value')
			->where('field_id', $field->id)
			->first();

			if (empty($obj)) $field->value = null;
			else Single::prepare_field_to_admin($field, $obj->value);

			if (empty($blocks[$field->block_title]))
				$blocks[$field->block_title] = [];

			$blocks[$field->block_title][$field->title] = $field;
		}

		return $blocks;
	}

	public function get_menu () {

		$menu = DB::table('menu')
		->select(
			'id', 
			'table_name',
			'title',
			'fields',
			'is_dev', 
			'multilanguage',
			'is_soft_delete',
			'sort',
			'parent',
			DB::raw('"multiple" AS type')
		)->get();

		$dropdown = DB::table('dropdown')->get();

		foreach ($menu as &$elm) {
			$elm->fields = json_decode($elm->fields);
		}

		return response()->json(
			[
				'menu'		=> array_values(
					DB::table('single_page')
					->select(
						'id AS table_name',
						'title',
						'sort',
						'parent',
						DB::raw('0 AS is_dev'),
						DB::raw('"single" AS type')
					)->get()
					->merge($menu)
					->sortBy('sort')
					->toArray()
				),
				'dropdown'	=> $dropdown,
			]
		);
	}

	public function db_select () {

		$table = $this->get_val('table');
		$offset = $this->get_val('offset', 0);
		$limit = $this->get_val('limit', 100);
		$order = $this->get_val('order', 'id');
		$sort_order = $this->get_val('sort_order', 'ASC');
		$fields = $this->get_val('fields', '*');
		$where = $this->get_val('where', '');
		$relationships = $this->get_val('relationships', '');   // many
		$editables = $this->get_val('editables', '');   // one to many (editable)
		$join = $this->get_val('join', '');   // one to many (editable)

		$full_table = $this->get_table(
			$this->get_val('table'),
			$this->get_val('language')
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

				$vals = DB::table($this->get_table(
					$editable->table,
					$this->get_val('language')
				))
				->where("id_$table", $editable->id)
				->get();
				
				$values->map(function ($item) use ($tbl, $vals) {

					$item->editable[$tbl] = $vals;
					return $item;
				});
			}
		}

		return $values;
	}

	public function db_count () {

		$table = $this->get_val('table');
		$language = $this->get_val('language');

		return DB::selectOne("SELECT count(*) AS count FROM $table$language")->count;
	}

	private function get_val ($title, $default = '') {
		
		$r = request();
		$val = $r->get($title);

		if (!empty($val))
			return $val;
		return $default;
	}

	private function get_tables ($entity, $multilanguage = -1) {

		$tables = [];

		if ($multilanguage == -1) {

			$menu = DB::table('menu')
			->select('multilanguage', 'table_name')
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

			$langs = DB::table('languages')->get();
			foreach ($langs as $lang) {
				$tables[] = $title.'_'.$lang->tag;
			}
			
		} else {

			$tables[] = $title;
		}

		return $tables;
	}

	private function get_table ($table, $lang) {

		$element = DB::table('menu')
		->select('multilanguage')
		->where('table_name', $table)
		->first();

		if (empty($element))
			return $table;

		if ($element->multilanguage == 1 && !empty($lang))
			return $table.'_'.$lang;
		return $table;
	}

	public function db_create_table () {

		$r = request();

		$tables = $this->get_tables($r->get('table_name'), $r->get('multilanguage'));

		foreach ($tables as $table) {

			Schema::create($table, function ($table) use ($r) {
				$table->bigIncrements('id');
				
				foreach (json_decode($r->get('fields')) as $field) {
					$this->add_field($table, $field);
				}

				$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

				if ($r->get('is_soft_delete') == 1)
					$table->timestamp('deleted_at')->nullable();
			});
		}


		DB::table('menu')->insert([
			'title'             => $r->get('title'),
			'table_name'        => $r->get('table_name'),
			'fields'            => $r->get('fields'),
			'is_dev'            => $r->get('is_dev'),
			'multilanguage'     => $r->get('multilanguage'),
			'is_soft_delete'    => $r->get('is_soft_delete'),
			'sort'              => $r->get('sort'),
			'parent'            => (empty($r->get('parent'))) ? 0 : $r->get('parent'),
		]);

		return 'Success';
	}

	private function add_field (&$table, $field) {

		if ($field->type == 'enum' || $field->type == 'password' || $field->type == 'text' || $field->type == 'email' || $field->type == 'color' || $field->type == 'file' || $field->type == 'photo') {

			$table->string($field->db_title);

		} else if ($field->type == 'number' || $field->type == 'checkbox') {

			$table->integer($field->db_title);
			
		} else if ($field->type == 'date') {

			$table->date($field->db_title);
			
		} else if ($field->type == 'datetime') {

			$table->dateTime($field->db_title);
			
		} else if ($field->type == 'translater' || $field->type == 'gallery' || $field->type == 'repeat' || $field->type == 'textarea' || $field->type == 'ckeditor') {

			$table->text($field->db_title);
			
		} else if ($field->type == 'money') {

			$table->decimal($field->db_title, 15, 2);
			
		} else if ($field->type == 'relationship') {

			if ($field->relationship_count == 'single') {

				$table->integer('id_'.$field->relationship_table_name);

			} else if ($field->relationship_count == 'many') {

				$r = request();

				$table_name = $r->get('table_name').'_'.$field->relationship_table_name;

				if (!Schema::hasTable($table_name)) {
					Schema::create($table_name, function ($table) use ($r, $field) {
						$table->bigIncrements('id');
						
						$col_first = 'id_'.$r->get('table_name');
						$col_last = 'id_'.$field->relationship_table_name;

						if ($col_first == $col_last)
							$col_last = $col_last.'_other';

						$table->integer($col_first);
						$table->integer($col_last);
					});
				}
			}
			// $field->relationship_view_field
		}
	}

	public function db_remove_table () {

		$r = request();

		$tables = $this->get_tables($r->get('id'));

		foreach ($tables as $table)
			Schema::dropIfExists($table);

		DB::table('menu')->where('id', $r->get('id'))->delete();

		return 'Success';
	}

	public function db_update_table () {

		$r = request();

		$fields_new = json_decode($r->get('fields'));

		$fields_curr = json_decode(DB::table('menu')
		->select('fields')
		->where('id', $r->get('id'))
		->first()
		->fields);
		
		$tables = $this->get_tables($r->get('table_name'));

		foreach ($tables as $table) {

			$this->remove_fields($table, json_decode($r->get('to_remove')), $fields_curr);
			$this->rename_fields($table, $fields_new, $fields_curr);
			$this->add_fields($table, $fields_new, $fields_curr);
			
			DB::table('menu')->
			where('table_name', $r->get('table_name'))->
			update([
				'title'             => $r->get('title'),
				'fields'            => $r->get('fields'),
				'is_dev'            => $r->get('is_dev'),
				'is_soft_delete'    => $r->get('is_soft_delete'),
				'sort'              => $r->get('sort'),
				'parent'             => $r->get('parent'),
			]);
		}

		return 'Success';
	}

	private function remove_fields ($table_name, $array_ids_remove, $fields_curr) {
		
		foreach ($array_ids_remove as $id) {
			foreach ($fields_curr as $field) {
				if ($field->id == $id) {
					Schema::table($table_name, function($table) use ($field) {
						if ($field->type == 'relationship' && $field->relationship_count == 'single'){

							$table->dropColumn('id_'.$field->relationship_table_name);

						} else if ($field->type == 'relationship' && $field->relationship_count == 'many'){

							$r = request();
							Schema::dropIfExists($r->get('table_name').'_'.$field->relationship_table_name);

						} else {

							$table->dropColumn($field->db_title);
						}
					});
					continue;
				}
			}
		}
	}

	private function rename_fields ($table_name, $fields_new, $fields_curr) {

		foreach ($fields_new as $new) {
			foreach ($fields_curr as $curr) {
				
				if ($new->type == 'relationship' || $curr->type == 'relationship')
					continue;

				if ($new->id == $curr->id && $new->db_title != $curr->db_title) {
					Schema::table($table_name, function($table) use ($new, $curr) {
						$table->renameColumn($curr->db_title, $new->db_title);
					});
					continue;
				}
			}
		}
	}

	private function add_fields ($table_name, $fields_new, $fields_curr) {

		foreach ($fields_new as $new) {

			$is_new = true;

			foreach ($fields_curr as $curr) {
				if ($new->id == $curr->id) {

					$is_new = false;
					continue;
				}
			}

			if ($is_new) {
				Schema::table($table_name, function($table) use ($new) {
					$this->add_field($table, $new);
				});
			}
		}
	}

	public function db_copy () {

		$input = request()->all();

		if (!empty($input['language'])) {

			$tbl = $input['table'].'_'.$input['language'];

		} else {

			$tbl = $input['table'];
		}

		$row = DB::table($tbl)
		->where('id', $input['id'])
		->first();

		$tables = $this->get_tables($input['table']);

		foreach ($tables as $table) {

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

			DB::table($table)->insert($insert);
		}

		return 'Success';
	}

	public function db_update () {

		$r = request();

		DB::table($r->get('table'))
		->where('id', $r->get('id'))
		->update([
			$r->get('field') => $r->get('value')
		]);
	}

	private function db_remove_editable ($id, $table) {

		$editable = [];

		$fields = json_decode(DB::table('menu')
		->select('fields')
		->where('table_name', $table)
		->first()
		->fields);

		foreach ($fields as $field) {
			if ($field->type == 'relationship' && $field->relationship_count == 'editable') {
				$editable[] = $field->relationship_table_name;
			}
		}

		foreach ($editable as $table_name) {

			$tables = $this->get_tables($table_name);

			$parent = DB::table($tables[0])
			->select('id')
			->where("id_$table", $id)
			->first();

			foreach ($tables as $tbl) {

				DB::table($tbl)
				->where("id_$table", $id)
				->delete();
			}

			$this->db_remove_editable($parent->id, $table_name);
		}
	}

	private function db_remove_relationship_many ($id, $table_name) {

		$langs = DB::table('languages')->get();
		$field_properties = json_decode(DB::table('menu')
		->select('fields')
		->where('table_name', $table_name)
		->first()
		->fields);

		foreach ($field_properties as $properties) {
			if ($properties->type == 'relationship' && $properties->relationship_count == 'many') {
				
				DB::table($table_name . '_' . $properties->relationship_table_name)
				->where('id_' . $table_name, $id)
				->delete();
			}
		}
	}

	public function db_remove_row () {

		$r = request();

		$id = $r->get('id');
		$lang = $r->get('language');

		if ($lang != '') {

			foreach ($this->get_tables($r->get('table_name')) as $table) {

				DB::table($table)
				->where('id', $id)
				->delete();
			}

		} else {

			DB::table($r->get('table_name'))
			->where('id', $id)
			->delete();
		}
		
		$this->db_remove_relationship_many($id, $r->get('table_name'));
		$this->db_remove_editable($id, $r->get('table_name'));

		return 'Success';
	}

	public function db_remove_rows () {

		$r = request();

		$ids = json_decode($r->get('ids'));
		$lang = $r->get('language');

		if ($lang != '') {
			foreach ($ids as $id) {

				foreach ($this->get_tables($r->get('table_name')) as $table) {

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
			$this->db_remove_relationship_many($id, $r->get('table_name'));
			$this->db_remove_editable($id, $r->get('table_name'));
		}

		return 'Success';
	}
	
	public function upload_image () {

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

	public function remove_language ($tag) {

		$tag = mb_strtolower($tag);

		$lang = DB::table('languages')
		->where('tag', $tag)
		->where('main_lang', '!=', 1)
		->first();

		if (empty($lang))
			return 'Language doesnt exist or you try delete main language';

		$menu = DB::table('menu')->get();

		foreach ($menu as $elm) {
			if ($elm->multilanguage == 1) {
				Schema::dropIfExists("{$elm->table_name}_$tag");
			}
		}

		DB::table('languages')
		->where('tag', $tag)
		->delete();

		Single::rm_db($tag);

		return 'Success';
	}

	public function add_language ($tag) {

		$tag = mb_strtolower($tag);

		if (empty($tag) || mb_strlen($tag) != 2)
			return 'Invalid tag';

		$lang = DB::table('languages')
		->where('tag', $tag)
		->first();

		if (!empty($lang))
			return 'Language have already exist';

		$main_tag = DB::table('languages')
		->where('main_lang', 1)
		->first()
		->tag;

		DB::table('languages')
		->insert([
			'tag'		=> $tag,
			'main_lang'	=> 0,
		]);

		$menu = DB::table('menu')->get();

		foreach ($menu as $elm) {
			if ($elm->multilanguage == 1) {
				DB::statement("CREATE TABLE {$elm->table_name}_$tag LIKE {$elm->table_name}_$main_tag");
				DB::statement("INSERT {$elm->table_name}_$tag SELECT * FROM {$elm->table_name}_$main_tag");
			}
		}

		Single::add_db($tag, $main_tag);

		return 'Success';
	}

	public function set_dynamic () {

		$input = request()->all();

		$input['fields'] = json_decode($input['fields']);


		$this->set_dynamic_fields($input);

		return $this->response();
	}

	private function set_dynamic_fields ($input, $parent_table = false, $parent_id = false) {

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

				$tables = $this->get_tables($input['table']);

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

				$table_main = $this->get_table(
					$input['table'],
					$input['language']
				);

				DB::table($table_main)
				->where('id', $input['id'])
				->update($update);

				if ($menu->multilanguage == 1 && !empty($update_multilanguage)) {

					foreach ($this->get_tables($input['table']) as $table) {

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

					$editable_ids = DB::table($this->get_table(
						$field->relationship_table_name,
						$input['language']
					))
					->select('id')
					->where('id_'.$input['table'], $input['id'])
					->get()
					->pluck('id');

					foreach ($field->value as $group) {

						foreach ($group->fields as &$f) {
							if ($f->type == 'relationship' && $f->relationship_count == 'single' && $f->relationship_table_name == $input['table']) {

								$field_title = 'id_'.$input['table'];
								$f->$field_title = $input['id'];
							}
						}

						$this->set_dynamic_fields([
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

	public function get_dynamic () {

		$input = request()->all();

		$fields = $this->get_dynamic_fields($input);

		return $this->response($fields);
	}

	public function delete_single () {
		
		$databases = [];
		$input = request()->all();
		$id = $input['id'];
		$langs = Lang::get_langs(); 
		
		$field = DB::table('single_field')
		->where('id', $id)
		->first();

		$type_table = Single::$type_table[$field->type];
		$databases[] = $type_table;
		foreach ($langs as $lang) {
			$databases[] = $type_table.'_'.$lang->tag;
		}
		
		DB::table('single_field')
		->where('id', $id)
		->delete();

		foreach ($databases as $database) {
			
			DB::table($database)
			->where('field_id', $id)
			->delete();	
		}
		
		return $this->response();
	}

	private function get_dynamic_fields ($input) {

		$menu = DB::table('menu')
		->where('table_name', $input['table'])
		->first();

		$instance = DB::table($this->get_table(
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

					$field->values = DB::table($this->get_table(
						$field->relationship_table_name, 
						$input['language']
					))
					->select('id', $field->relationship_view_field.' as title')
					->get();

					if ($field->relationship_count == 'single') {

						if ($input['id'] == 0) {

							$field->value = 0;

						} else {

							$field_title = 'id_' . $field->relationship_table_name;
							$field->value = $instance->$field_title;
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

					$editable_ids = DB::table($this->get_table(
						$field->relationship_table_name,
						$input['language']
					))
					->select('id')
					->where('id_'.$input['table'], $input['id'])
					->get()
					->pluck('id');

					$field->value = [];

					foreach ($editable_ids as $editable_id) {
						
						$field->value[] = [
							'fields'	=> $this->get_dynamic_fields([
								'table'		=> $field->relationship_table_name,
								'language'	=> $input['language'],
								'id'		=> $editable_id,
							]),
							'id'		=> $editable_id,
						];
					}

					$field->values = $this->get_dynamic_fields([
						'table'		=> $field->relationship_table_name,
						'language'	=> $input['language'],
						'id'		=> 0,
					]);
				}

			} else if ($field->type == 'gallery') {

				if ($input['id'] == 0) {

					$field->value = [];

				} else {

					$field_title = $field->db_title;
					$field->value = json_decode($instance->$field_title);
				}

			} else if ($field->type == 'password') {

				$field->value = '';

			} else if ($field->type == 'checkbox' || $field->type == 'money' || $field->type == 'number') {

				if ($input['id'] == 0) {

					$field->value = 0;
				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;
				}

			} else if ($field->type == 'date') {

				if ($input['id'] == 0) {

					$field->value = date('Y-m-d');

				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;
				}
			} else if ($field->type == 'datetime') {

				if ($input['id'] == 0) {

					$field->value = date('Y-m-d H:i');
					
				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;
				}
			} else {

				if ($input['id'] == 0) {

					$field->value = '';
				} else {

					$field_title = $field->db_title;
					$field->value = $instance->$field_title;
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
}