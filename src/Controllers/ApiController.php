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
				$q->leftJoin($tbl, "$tbl.id", "$full_table.id_$tbl");
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

	public function db_insert_or_update_row () {

		$r = request();

		$fields = (array)json_decode($r->get('fields'));
		// unset($fields['id']);
		unset($fields['created_at']);
		unset($fields['updated_at']);

		$id = $r->get('id');

		$relationship_many = $this->db_get_and_rm_relationship_many($fields);
		$editable = $this->db_get_and_rm_editable($fields);

		if ($id == 0) {

			$tables = $this->get_tables($r->get('table_name'));

			foreach ($tables as $table) {

				$id = DB::table($table)->insertGetId($fields);
			}

		} else {

			$element = DB::table('menu')
			->select('multilanguage')
			->where('table_name', $r->get('table_name'))
			->first();

			if ($element->multilanguage == 1) {

				$table = $r->get('table_name').'_'.$r->get('language');

				$row = DB::table($table)
				->where('id', $fields['id'])
				->update($fields);

				$this->db_update_languages($id, $r->get('table_name'), $table);

			} else {

				$table = $r->get('table_name');

				$row = DB::table($table)
				->where('id', $fields['id'])
				->update($fields);
			}
		}

		$this->db_add_editable($id, $editable, $r->get('table_name'));
		$this->db_add_relationship_many($id, $relationship_many, $r->get('table_name'));

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

	private function db_update_languages ($id, $table_name, $table_name_curr) {

		$langs = DB::table('languages')->get();

		$field_properties = json_decode(DB::table('menu')
		->select('fields')
		->where('table_name', $table_name)
		->first()
		->fields);

		$row = DB::table($table_name_curr)
		->where('id', $id)
		->first();

		$update = [];

		foreach ($langs as $l) {
			foreach ($field_properties as $properties) {
				if ($properties->lang == 0) {
					if ($properties->type == 'relationship' && $properties->relationship_count == 'single') {

						$title = 'id_' . $properties->relationship_table_name;
						$update[$title] = $row->$title;

					} else if ($properties->type != 'relationship') {

						$title = $properties->db_title;
						$update[$title] = $row->$title;
					} else {
						// TODO: 
					}
				}
			}
		}

		if (count($update) > 0) {
			$tables = $this->get_tables($table_name);

			foreach ($tables as $table) {

				if ($table_name_curr == $table)
					continue;

				DB::table($table)
				->where('id', $row->id)
				->update($update);
			}
		}
	}

	private function db_add_editable ($id, $editable, $table) {

		foreach ($editable as $table_name => $values) {

			$menu = DB::table('menu')
			->select('fields', 'multilanguage')
			->where('table_name', $table_name)
			->first();
			$fields = [];
			foreach (json_decode($menu->fields) as $f) {
				if ($f->type == 'relationship' && $f->relationship_count == 'single') {
					
					$fields['id_' . $f->relationship_table_name] = $f->lang;

				} else if ($f->type == 'relationship') {
					// TODO: handle relations
				} else {

					$fields[$f->db_title] = $f->lang;
				}
			}

			$tables = $this->get_tables($table_name);

			// if ($menu->multilanguage == 0) {

			// 	foreach ($tables as $tbl) {

			// 		DB::table($tbl)
			// 		->where("id_$table", $id)
			// 		->delete();

			// 		foreach ($values as $vals) {

			// 			$insert = [
			// 				"id_$table"	=> $id,
			// 			];

			// 			foreach ($vals as $key => $value) {
			// 				$insert[$key] = $value;
			// 			}

			// 			DB::table($tbl)->insert($insert);
			// 		}
			// 	}

			// } else {

				foreach ($tables as $tbl) {

					$exist_ids = DB::table($tbl)
					->select('id')
					->where("id_$table", $id)
					->get()
					->pluck('id')
					->all();
					$request_ids = [];
					foreach ($values as $vals) {
						if (!empty($vals->id)) {
							$request_ids[] = $vals->id;
						}
					}

					DB::table($tbl)
					->whereIn('id', array_diff($exist_ids, $request_ids))
					->delete();

					foreach ($values as $vals) {

						if (!empty($vals->id)) {
							
							$update = ["id_$table"	=> $id];

							if ($menu->multilanguage == 1) {
								$curr_lang = str_replace($table_name.'_', '', $tbl);
							} else {
								$curr_lang = request()->get('language');
							}

							foreach ($vals as $key => $value) {
								if (request()->get('language') == $curr_lang || 
									(!empty($fields[$key]) && $fields[$key] == 0))
									$update[$key] = $value;
							}

							DB::table($tbl)->where('id', $vals->id)->update($update);

						} else {

							$insert = ["id_$table"	=> $id];

							foreach ($vals as $key => $value) {
								$insert[$key] = $value;
							}

							DB::table($tbl)->insert($insert);
						}
					}
				}
			// }
		}
	}

	private function db_add_relationship_many ($id_first, $relationship_many, $table) {

		$col_first = 'id_' . $table;

		foreach ($relationship_many as $rel) {

			foreach ($rel as $table_name_many => $elm) {
				
				DB::table($table_name_many)
				->where($col_first, $id_first)
				->delete();

				$data = [];

				foreach ($elm as $obj) {
					
					$table_name_last = key((array)$obj);

					$id_last = $obj->$table_name_last;
					$col_last = 'id_' . $table_name_last;

					if ($col_first == $col_last)
						$col_last = $col_last.'_other';

					$data[] = [
						$col_last => $id_last,
						$col_first => $id_first,
					];
				}
				DB::table($table_name_many)->insert($data);
			}
		}
	}

	private function db_get_and_rm_editable (&$fields) {

		$editable = [];

		foreach ($fields as $title => &$f) {
			if ($title == 'editable') {

				$editable = $f;
				unset($fields[$title]);
			}
		}

		return $editable;
	}

	private function db_get_and_rm_relationship_many (&$fields) {

		$data = [];

		foreach ($fields as $table_name => &$f) {
			if ($table_name[0] == '$') {

				$data[] = [substr($table_name, 1) => $f];
				unset($fields[$table_name]);
			}
		}

		return $data;
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

			foreach ($tables as $tbl) {

				DB::table($tbl)
				->where("id_$table", $id)
				->delete();
			}
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

	public function db_relationship () {

		$r = request();

		$field = json_decode($r->get('field'));

		$table = $this->get_table(
			$field->relationship_table_name, 
			$r->get('language')
		);

		return DB::table($table)
		->select('id', $field->relationship_view_field.' as title')
		->get();
	}

	public function db_relationships () {

		$r = request();

		$fields = json_decode($r->get('fields'));

		$results = [];

		foreach ($fields as $field) {

			$table = $this->get_table(
				$field->relationship_table_name, 
				$r->get('language')
			);

			if ($field->relationship_count == 'editable') {

				$editable = json_decode(DB::table('menu')
				->select('fields')
				->where('table_name', $field->relationship_table_name)
				->first()
				->fields);

				$rels = [];

				foreach ($editable as $e) {
					if ($e->type == 'relationship' && $e->relationship_count != 'editable') {

						$rels[$e->relationship_table_name] = DB::table($this->get_table(
							$e->relationship_table_name, 
							$r->get('language')
						))
						->select('id', $e->relationship_view_field.' as title')
						->get();
					}
				}

				$results[$field->relationship_table_name] = [
					'editable'	=> $editable,
					'rels'		=> $rels,
				];

			} else {

				$results[$field->relationship_table_name] = DB::table($table)
				->select('id', $field->relationship_view_field.' as title')
				->get();
			}
		}

		return $results;
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
}