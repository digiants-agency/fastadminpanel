<?php 

namespace App\FastAdminPanel\Helpers;

use DB;
use App;
use Schema;
use Illuminate\Database\Schema\Blueprint;
use Lang;
use App\FastAdminPanel\Helpers\SingleRepeatedField;
use App\FastAdminPanel\Helpers\SingleRepeatedFieldResult;

class Single {

	public static $type_table = [
		'text' => 'single_varchar',
		'textarea' => 'single_text',
		'ckeditor' => 'single_text',
		'checkbox' => 'single_tinyint',
		'color' => 'single_varchar',
		'date' => 'single_date',
		'datetime' => 'single_datetime',
		'relationship' => '',
		'file' => 'single_text',
		'photo' => 'single_text',
		'gallery' => 'single_text',
		'password' => 'single_varchar',
		'money' => 'single_money',
		'number' => 'single_int',
		'enum' => 'single_text',
		'repeat' => 'single_text',
	];

	protected $page;
	protected $fields = [];

	protected $sorts = [];

	public function __construct ($title, $sort, $parent = 0) {

		if (isset($_GET['update']) && env('APP_DEBUG')) {

			$this->page = DB::table('single_page')
			->where('title', $title)
			->first();

			if (empty($this->page)) {

				DB::table('single_page')
				->insert([
					'title'				=> $title,
					'sort'				=> $sort,
					'parent'			=> $parent,
				]);

				$this->page = DB::table('single_page')
				->where('title', $title)
				->first();

			} else {

				DB::table('single_page')
				->where('title', $title)
				->update([
					'sort'				=> $sort,
					'parent'			=> $parent,
				]);
			}

		} else {

			$this->page = DB::table('single_page')
			->where('title', $title)
			->first();

			$this->fields = $this->format_fields(
				DB::table('single_field')
				->where('single_page_id', $this->page->id)
				->get()
			);
		}
	}

	// if you want place repeat field:
	// $default_val = [
	// 	[$field_title, $type, $is_multilanguage, $default_val],
	// 	...
	// ]
	public function field ($field_block, $field_title, $type, $is_multilanguage, $default_val = '') {

		if ($type == 'repeat')
			$default_val = [];

		if (isset($_GET['update']) && env('APP_DEBUG')) {

			$field = DB::table('single_field')
			->select('id')
			->where('single_page_id', $this->page->id)
			->where('block_title', $field_block)
			->where('title', $field_title)
			->first();

			if (empty($this->sorts[$field_block]))
				$this->sorts[$field_block] = 0;

			$this->sorts[$field_block]++;

			if (empty($field)) {

				$id_field = DB::table('single_field')
				->insertGetId([
					'is_multilanguage'	=> $is_multilanguage,
					'type'				=> $type,
					'title'				=> $field_title,
					'block_title'		=> $field_block,
					'single_page_id'	=> $this->page->id,
					'sort'				=> $this->sorts[$field_block],
				]);

				if ($type != 'repeat') {
					if ($is_multilanguage) {

						foreach (Lang::get_langs() as $lang) { 

							DB::table(self::$type_table[$type].'_'.$lang->tag)
							->insert([
								'field_id'	=> $id_field,
								'value'		=> $default_val,
							]);
						}
					} else {

						DB::table(self::$type_table[$type])
						->insert([
							'field_id'	=> $id_field,
							'value'		=> $default_val,
						]);
					}
				}

			} else {

				// there will be clear of old data in DB

				DB::table('single_field')
				->where('single_page_id', $this->page->id)
				->where('block_title', $field_block)
				->where('title', $field_title)
				->update([
					'is_multilanguage'	=> $is_multilanguage,
					'type'				=> $type,
					'sort'				=> $this->sorts[$field_block],
				]);
			}

			if ($type == 'repeat') {

				if (empty($field)) {

					$field = DB::table('single_field')
					->select('id')
					->where('single_page_id', $this->page->id)
					->where('block_title', $field_block)
					->where('title', $field_title)
					->first();
				}

				return [new SingleRepeatedField($field->id, $is_multilanguage)];

			} else {
				return 'Saved';
			}

		} else {

			$obj = DB::table(Single::$type_table[$type].Lang::ending($is_multilanguage))
			->select('value')
			->where('field_id', $this->fields[$field_block][$field_title]->id)
			->first();

			if (empty($obj)) $value = null;
			else $value = $obj->value;

			Single::format_value($value, $type, $is_multilanguage, $this->fields[$field_block][$field_title]->id);

			if (empty($value))
				return $default_val;
			return $value;
		}
	}

	public static function convert_simple_type ($value, $type) {
		if ($type == 'checkbox') {
			return ($value == 'true' || $value == 1) ? 1 : 0;
		}
		if ($type == 'number' && $value == '') {
			return 0;
		}
		return $value;
	}

	public static function prepare_field_to_db (&$field) {

		if ($field['type'] == 'repeat') {

			if (!empty($field['value'])) {
				for ($j = 0, $c = count($field['value']); $j < $c; $j++) {
					$field['value'][$j]['values'] = [];
				}
			}

			if (!empty($field['repeat'])) {
				for ($i = 0, $count = count($field['repeat']); $i < $count; $i++) {
					for ($j = 0, $c = count($field['repeat'][$i]); $j < $c; $j++) {
						$field['value'][$j]['values'][$i] = Single::convert_simple_type($field['repeat'][$i][$j]['value'], $field['repeat'][$i][$j]['type']);
					}
				}
			}

			$field['value'] = json_encode($field['value'], JSON_UNESCAPED_UNICODE);

		} else {

			if (!array_key_exists('value', $field)) { // hotfix
				$field['value'] = null;
			}
			$field['value'] = Single::convert_simple_type($field['value'], $field['type']);
		}
	}

	public static function prepare_field_to_admin (&$field, $value) {

		if ($field->type == 'repeat') {

			$field->value = json_decode($value);

			$field->repeat = [];

			if (!empty($field->value) && count($field->value) > 0 && !empty($field->value[0]->values)) {
				for ($j = 0, $len = count($field->value[0]->values); $j < $len; $j++) { 
					
					$field->repeat[] = [];

					$last = count($field->repeat) - 1;

					for ($i = 0, $count = count($field->value); $i < $count; $i++) {
						$field->repeat[$last][] = [
							'id'	=> $i,
							'title'	=> $field->value[$i]->title,
							'type'	=> $field->value[$i]->type,
							'value'	=> $field->value[$i]->values[$j],
						];
					}
				}
			}

		} else {
			$field->value = $value;
		}
	}

	public static function format_value (&$value, $type, $is_multilanguage = false, $id = 0) {

		if ($type == 'repeat') {

			$srf = new SingleRepeatedField($id, $is_multilanguage, json_decode($value));
			$value = $srf->get();
		}

		return $value;
	}

	private function format_fields ($fields) {

		$blocks = [];

		foreach ($fields as $field) {

			if (empty($blocks[$field->block_title]))
				$blocks[$field->block_title] = [];

			$blocks[$field->block_title][$field->title] = $field;
		}

		return $blocks;
	}

	public static function create_db ($console) {

		$languages = DB::table('languages')->get();

		if (!Schema::hasTable("single_page")) {
			Schema::create("single_page", function (Blueprint $table) {
				$table->increments("id");
				$table->string("title")->default("");
				$table->integer("sort")->default(0);
				$table->integer('parent')->default(0);

				$table->index("title");
			});
		} else {
			$console->info("single_page table has already exist!");
			die();
		}

		if (!Schema::hasTable("single_field")) {
			Schema::create("single_field", function (Blueprint $table) {
				$table->increments("id");
				$table->tinyInteger("is_multilanguage")->default(0);
				$table->string("type")->default('text');
				$table->string("title");
				$table->string("block_title");
				$table->integer("single_page_id");
				$table->integer("sort")->default(0);

				$table->index("single_page_id");
			});
		} else {
			$console->info("single_field table has already exist!");
			die();
		}

		$prefixes = [''];

		foreach ($languages as $lang) {
			$prefixes[] = '_'.$lang->tag;
		}

		foreach ($prefixes as $prefix) {

			if (!Schema::hasTable("single_int$prefix")) {
				Schema::create("single_int$prefix", function (Blueprint $table) {
					$table->increments("field_id");
					$table->integer("value")->default(0);
				});
			} else {
				$console->info("single_int$prefix table has already exist!");
				die();
			}

			if (!Schema::hasTable("single_varchar$prefix")) {
				Schema::create("single_varchar$prefix", function (Blueprint $table) {
					$table->increments("field_id");
					$table->string("value")->default("");
				});
			} else {
				$console->info("single_varchar$prefix table has already exist!");
				die();
			}

			if (!Schema::hasTable("single_text$prefix")) {
				Schema::create("single_text$prefix", function (Blueprint $table) {
					$table->increments("field_id");
					$table->text("value")->nullable();
				});
			} else {
				$console->info("single_text$prefix table has already exist!");
				die();
			}

			if (!Schema::hasTable("single_money$prefix")) {
				Schema::create("single_money$prefix", function (Blueprint $table) {
					$table->increments("field_id");
					$table->decimal("value", 15, 2)->default(0);
				});
			} else {
				$console->info("single_money$prefix table has already exist!");
				die();
			}

			if (!Schema::hasTable("single_tinyint$prefix")) {
				Schema::create("single_tinyint$prefix", function (Blueprint $table) {
					$table->increments("field_id");
					$table->tinyInteger("value")->default(0);
				});
			} else {
				$console->info("single_tinyint$prefix table has already exist!");
				die();
			}

			if (!Schema::hasTable("single_date$prefix")) {
				Schema::create("single_date$prefix", function (Blueprint $table) {
					$table->increments("field_id");
					$table->date("value")->nullable();
					// $table->date("value")->default(DB::raw("NOW()"));
				});
			} else {
				$console->info("single_date$prefix table has already exist!");
				die();
			}

			if (!Schema::hasTable("single_datetime$prefix")) {
				Schema::create("single_datetime$prefix", function (Blueprint $table) {
					$table->increments("field_id");
					$table->timestamp("value")->default(\DB::raw("CURRENT_TIMESTAMP"));
				});
			} else {
				$console->info("single_datetime$prefix table has already exist!");
				die();
			}
		}

		$console->info("Single tables created");
	}

	public static function rm_db ($tag) {

		Schema::dropIfExists("single_int_$tag");
		Schema::dropIfExists("single_varchar_$tag");
		Schema::dropIfExists("single_text_$tag");
		Schema::dropIfExists("single_money_$tag");
		Schema::dropIfExists("single_tinyint_$tag");
		Schema::dropIfExists("single_date_$tag");
		Schema::dropIfExists("single_datetime_$tag");
	}

	public static function add_db ($tag, $main_tag) {

		DB::statement("CREATE TABLE single_int_$tag LIKE single_int_$main_tag");
		DB::statement("INSERT single_int_$tag SELECT * FROM single_int_$main_tag");

		DB::statement("CREATE TABLE single_varchar_$tag LIKE single_varchar_$main_tag");
		DB::statement("INSERT single_varchar_$tag SELECT * FROM single_varchar_$main_tag");

		DB::statement("CREATE TABLE single_text_$tag LIKE single_text_$main_tag");
		DB::statement("INSERT single_text_$tag SELECT * FROM single_text_$main_tag");

		DB::statement("CREATE TABLE single_money_$tag LIKE single_money_$main_tag");
		DB::statement("INSERT single_money_$tag SELECT * FROM single_money_$main_tag");

		DB::statement("CREATE TABLE single_tinyint_$tag LIKE single_tinyint_$main_tag");
		DB::statement("INSERT single_tinyint_$tag SELECT * FROM single_tinyint_$main_tag");

		DB::statement("CREATE TABLE single_date_$tag LIKE single_date_$main_tag");
		DB::statement("INSERT single_date_$tag SELECT * FROM single_date_$main_tag");

		DB::statement("CREATE TABLE single_datetime_$tag LIKE single_datetime_$main_tag");
		DB::statement("INSERT single_datetime_$tag SELECT * FROM single_datetime_$main_tag");
	}
}