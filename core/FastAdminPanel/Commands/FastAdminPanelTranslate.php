<?php

namespace App\FastAdminPanel\Commands;

use Illuminate\Console\Command;
use DB;
use Lang;
use App\FastAdminPanel\Helpers\Translater;

class FastAdminPanelTranslate extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'fastadminpanel:translate {argument?}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Translate language of FastAdminPanel.';

	/**
	 * Create a new command instance.
	 */
	public function __construct() {
		parent::__construct();
	}

	/*
	 * FAP Translator
	 */

	private $not_translate_cols = [
		'id',
		'ico',
		'created_at',
		'updated_at',
		'image',
		'facebook',
		'instagram',
		'telegram',
		'slug',
		'banner_image',
		'id_author',
		'views',
		'likes',
		'thumbnail',
		'theme',
		'banner_image_mobile',
		'sort',
		'image_lg',
		'image_mobile',
		'banner_btn_link',
		'left_advantage_title',
		'right_advantage_title',
		'id_directions',
		'link',
		'preview_image',
		'url',
		'image_preview',
		'website_image',
		'tech_image_1',
		'tech_image_2',
		'image_mobile_right',
		'image_mobile_left',
		'desktop_img',
		'mockup_image',
		'font_image',
		'font_color_1',
		'font_color_2',
		'font_color_3',
		'font_color_4',
		'image_mobiles',
		'preview_images',
		'is_active',
		'id_brief',
		'id_type',
		'img',
		'price',
		'sale_price',
		'available',
		'gallery',
		'id_category',
		'sku',
		'id_marks',
		'id_models',
		'id_kuzov',
		'old_price',
		'old_sale_price',
		'sort',
		'id_filters',
		'id_filter_fields',		
		'email',
		'main image',
		'mobile image',
		'preview image',
		'gallery',
		'img_mob',
		'preview',
		'id_device',
		'active',
		'min',
		'max',
		'step',
		'id_blog', 
		'id_blog_other',
		'is_main',
		'is_show',
		'sort',
		'main_image',
		'phone',
		'email',
		'date',
		'link',
		'id_categories',
		'is_menu',
		'id_products',
		'active',
		'id_attributes_counter',
		'id_products_other',
		'is_available',
		'articul',
		'price',
		'icon'
	];

	private $not_translate_fields = [
		'Theme (light,dark)',
		'Button link',
		'Phone placeholder',
		'Call phone',
		'Schedule content',
		'E-mail',
		'Google maps',
		'Google map',
		'Icon',
		'Number',
		'Link',
		'Slug',
		'Show',
		'First Show',
		'Next Show',
		'site1_price',
		'site2_price',
		'site3_price',
		'Изображение',
		'Ссылка',
		'Картинка',
		'Картинка на моб',
		'Фон',
		'Фон моб',
		'Изображение на мобилку',
		'Иконка',
		'Номер телефона 1',
		'Номер телефона 2',
		'email',
		'Ссылка кнопки1',
		'Ссылка кнопки2',
		'Ссылка кнопки',
		'Номер телефону',
		'Номер телефона',
		'(067)-777-77-77',
		'Image mob',
		'Image',
		'Video',
		'Sell link',
		'Buy Link',
		'Buy btn link',
		'Sell btn link',
		'Image link',
		'btn link',
		'User image',
		'icon',
		'link',
		'photo',
		'image',
		'Fair',
		'good',
		'excellent',
		'Instagram',
		'Facebook',
		'Telegram',
		'Viber',
		'WA',
		'viber link',
		'wa link',
		'Telephone',
		'Instagram',
		'Facebook',
		'Telegram',
		'Viber',
		'WA',
		'Link',
		'icon',
		'viber link',
		'wa link',
		'Telephone',
		'Image',
		'Button link',
		'photo',
		'image',
		'User image',
		'Date',
		'contactsvaluelink',
		'contactsvalue',
		'Fair',
		'good',
		'excellent',
		'Image mob 325x401',
		'Image 1128x422',
		'Buy Link',
		'Image link',
		'Image 205x164',
		'Buy btn link',
		'Image mob',
		''
	];

	public function translate_single ($id) {

		set_time_limit(2500);

		$langs = DB::table('languages')
		->where('main_lang', '!=', 1)
		->get();

		$main_tag = DB::table('languages')
		->where('main_lang', 1)
		->first()
		->tag;

		$single_fields = DB::table('single_field')
		->select('id', 'type')
		->where('single_page_id', $id)
		->where('is_multilanguage', 1)
		->whereRaw("(type = 'repeat' OR type = 'text' OR type = 'textarea' OR type = 'ckeditor')")
		->whereNotIn('title', $this->not_translate_fields)
		->get();

		foreach ($langs as $lang) {

			$this->translate_single_lang($single_fields, $main_tag, $lang->tag);
		}
	}

	public function translate_single_lang ($single_fields, $main_tag, $tag) {
			
		foreach ($single_fields as $field) {
			if ($field->type == 'text' || $field->type == 'textarea' || $field->type == 'ckeditor') {
				
				if ($field->type == 'text') $field_type = 'varchar';
				else $field_type = 'text';

				$value = DB::table("single_{$field_type}_{$main_tag}")
				->select('value')
				->where('field_id', $field->id)
				->first();

				if (!empty($value)) {
					
					$cell = DB::table("single_{$field_type}_{$tag}")
					->where('field_id', $field->id)
					->first();

					if (empty($cell)) {

						DB::table("single_{$field_type}_{$tag}")
						->insert([
							'field_id'	=> $field->id,
							'value'		=> Translater::tr($value->value, $main_tag, $tag),
						]);

					} else {

						DB::table("single_{$field_type}_{$tag}")
						->where('field_id', $field->id)
						->update([
							'value'	=> Translater::tr($value->value, $main_tag, $tag),
						]);
					}
				}

			} else if ($field->type == 'repeat') {

				$value = DB::table("single_text_{$main_tag}")
				->select('value')
				->where('field_id', $field->id)
				->first()
				->value;

				$arr = json_decode($value);

				foreach ($arr as &$f) {
					if (!in_array($f->title, $this->not_translate_fields) && 
							($f->type == 'text' || $f->type == 'textarea' || $f->type == 'ckeditor')
						) {
						foreach ($f->values as &$v) {
							$v = Translater::tr($v, $main_tag, $tag);
						}
					}
				}

				DB::table("single_text_{$tag}")
				->where('field_id', $field->id)
				->update([
					'value'	=> json_encode($arr, JSON_UNESCAPED_UNICODE),
				]);
			}
		}
	}

	public function translate_table_row ($table) {

		set_time_limit(2500);

		$langs = DB::table('languages')
		->where('main_lang', '!=', 1)
		->get();

		$main_tag = DB::table('languages')
		->where('main_lang', 1)
		->first()
		->tag;

		foreach ($langs as $lang) {
			
			$menu_row = DB::table('menu')
			->where('table_name', $table)
			->first();

			if ($menu_row->multilanguage == 1) {

				$row = DB::table("{$table}_$main_tag")
				->where('id', request()->get('id'))
				->first();

				$update = [];
				foreach ($row as $coll => $cell) {
					if (!in_array($coll, $this->not_translate_cols) && !empty($cell)) {
						$cell = Translater::tr($cell, $main_tag, $lang->tag);
					}
					if ($coll != 'id')
						$update[$coll] = $cell;
					if ($coll == 'id') {
						continue;
					}
				}
				DB::table("{$table}_{$lang->tag}")
				->where('id', $row->id)
				->update($update);
			}
		}
	}

	public function translate_languages ($lang) {

		if (empty($lang)) {

			$langs = DB::table('languages')
			->where('main_lang', '!=', 1)
			->get();

			foreach ($langs as $lang) {

				echo $this->translate_language($lang->tag), "\n";
				echo $lang->tag, "\n";
			}
		} else {
			echo $this->translate_language($lang), "\n";
			echo $lang, "\n";
		}
	}

	public function translate_language ($tag) {		

		$counter_start = -1;
		$counter = 0;

		$tag = mb_strtolower($tag);

		$lang = DB::table('languages')
		->where('tag', $tag)
		->where('main_lang', '!=', 1)
		->first();

		if (empty($lang))
			return 'Language doesnt exist or you try translate main language';

		$main_tag = DB::table('languages')
		->where('main_lang', 1)
		->first()
		->tag;

		$single_fields = DB::table('single_field')
		->select('id', 'type')
		->where('is_multilanguage', 1)
		->whereRaw("(type = 'repeat' OR type = 'text' OR type = 'textarea' OR type = 'ckeditor')")
		->whereNotIn('title', $this->not_translate_fields)
		->get();

		foreach ($single_fields as $field) {
			if ($field->type == 'text' || $field->type == 'textarea' || $field->type == 'ckeditor') {
				
				if ($field->type == 'text') $field_type = 'varchar';
				else $field_type = 'text';

				$value = DB::table("single_{$field_type}_{$main_tag}")
				->select('value')
				->where('field_id', $field->id)
				->first();

				if ($counter > $counter_start)
				{
					if (!empty($value)) {

						$cell = DB::table("single_{$field_type}_{$tag}")
						->where('field_id', $field->id)
						->first();
	
						$v = Translater::tr($value->value, $main_tag, $tag);

						if (empty($cell)) {
	
							DB::table("single_{$field_type}_{$tag}")
							->insert([
								'field_id'	=> $field->id,
								'value'		=> $v,
							]);
	
						} else {
	
							DB::table("single_{$field_type}_{$tag}")
							->where('field_id', $field->id)
							->update([
								'value'	=> $v,
							]);
						}
					}
				}
				
				echo ++$counter, $v ?? 0, "\n";
				

			} else if ($field->type == 'repeat') {

				$value = DB::table("single_text_{$main_tag}")
				->select('value')
				->where('field_id', $field->id)
				->first()
				->value;
				$arr = json_decode($value);
				print_r($arr);
				if(!empty($arr)){	
					$update = false; 
					foreach ($arr as &$f) {
						if (!in_array($f->title, $this->not_translate_fields) && 
								($f->type == 'text' || $f->type == 'textarea' || $f->type == 'ckeditor')
							) {
							foreach ($f->values as &$v) {
								if ($counter > $counter_start)
								{
									$v = Translater::tr($v, $main_tag, $tag);
									$update = true;
								}
								echo ++$counter, $v, "\n";
							}
						}
					}

					if($update){
						DB::table("single_text_{$tag}")
						->where('field_id', $field->id)
						->update([
							'value'	=> json_encode($arr, JSON_UNESCAPED_UNICODE),
						]);
					}
				}
			}
		}

		$menu = DB::table('menu')->get();

		foreach ($menu as $elm) {
			if ($elm->multilanguage == 1) {
				$table = DB::table("{$elm->table_name}_$main_tag")->get();
				$table_tr = DB::table("{$elm->table_name}_$tag")->get();
				$check = true;
				if(isset($table_tr->title) && (isset($table->title))){
					if($table->title != $table_tr->title) $check = false;
				}
				if(isset($table_tr->name) && (isset($table->name))){
					if($table->name != $table_tr->name) $check = false;
				}
				if(isset($table_tr->content) && (isset($table->content))){
					if($table->content != $table_tr->content) $check = false;
				}
				if($check)
				foreach ($table as &$row) {
					$update = [];
					foreach ($row as $coll => $cell) {
						$update_check = false;
						if (!in_array($coll, $this->not_translate_cols) && !empty($cell)) {
							if ($counter > $counter_start)
							{
								$cell = Translater::tr($cell, $main_tag, $tag);
								$update_check = true;
							}
							echo ++$counter, $cell, "\n";
						}
						if ($update_check && $coll != 'id')
							$update[$coll] = $cell;
					}
					if(!empty($update))
					DB::table("{$elm->table_name}_$tag")
					->where('id', $row->id)
					->update($update);
				}
			}
		}

		return 'Success';
	}

	public function translate_table ($table) {

		$counter = 0;

		set_time_limit(2500);

		$langs = DB::table('languages')
		->where('main_lang', '!=', 1)
		->get();

		$main_tag = DB::table('languages')
		->where('main_lang', 1)
		->first()
		->tag;

		foreach ($langs as $lang) {
							
			$menu_row = DB::table('menu')
			->where('table_name', $table)
			->first();

			if ($menu_row->multilanguage == 1) {

				$table_count_rows = DB::table("{$table}_$main_tag")
				->select('id')
				->get()->pluck('id');

				foreach($table_count_rows as $row_id){
					$row = DB::table("{$table}_$main_tag")
					->where('id', $row_id)
					->first();
	
					$update = [];
					foreach ($row as $coll => $cell) {
						if (!in_array($coll, $this->not_translate_cols) && !empty($cell) && mb_strpos($coll, 'id_') !== 0) {
							$cell = Translater::tr($cell, $main_tag, $lang->tag);

							echo ++$counter, "\n";
							echo $cell, "\n";
						}
						if ($coll != 'id')
							$update[$coll] = $cell;
						if ($coll == 'id') {
							continue;
						}
					}
					DB::table("{$table}_{$lang->tag}")
					->where('id', $row->id)
					->update($update);
				}
				
			}
		}
	}

	public function translate_admin () {

		$lang_from = 'ru';
		$lang_to = 'sv';

		//translate menu

		$menu = DB::table('menu')->get();

		foreach ($menu as $menu_item) {
			if ($menu_item->title != 'Menu' && $menu_item->title != 'Roles') {

				$new_title = Translater::tr($menu_item->title, $lang_from, $lang_to);
				echo $new_title . "\n";

				$fields = json_decode($menu_item->fields);

				foreach ($fields as &$field) {
					$field->title = Translater::tr($field->title, $lang_from, $lang_to);
					echo $field->title . "\n";
				}


				DB::table('menu')
				->where('id', $menu_item->id)
				->update([
					'title'		=> $new_title,
					'fields'	=> json_encode($fields),
				]);
			}
		}


		// translate dropdown

		$dropdown = DB::table('dropdown')->get();

		foreach ($dropdown as $dropdown_item) {
			$new_title = Translater::tr($dropdown_item->title, $lang_from, $lang_to);
			echo $new_title . "\n";

			DB::table('dropdown')
			->where('id', $dropdown_item->id)
			->update([
				'title'		=> $new_title,
			]);

		}

		//translate single page

		$single_page = DB::table('single_page')->get();

		foreach ($single_page as $single_page_item) {

			$new_title = Translater::tr($single_page_item->title, $lang_from, $lang_to);
			echo $new_title . "\n";

			DB::table('single_page')
			->where('id', $single_page_item->id)
			->update([
				'title_sv'		=> $new_title,
			]);
		}

		//translate single fields
		
		$single_field = DB::table('single_field')->get();

		foreach ($single_field as $single_field_item) {

			$new_title = Translater::tr($single_field_item->title, $lang_from, $lang_to);
			echo $new_title . "\n";

			$new_block_title = Translater::tr($single_field_item->block_title, $lang_from, $lang_to);
			echo $new_block_title . "\n";

			DB::table('single_field')
			->where('id', $single_field_item->id)
			->update([
				'title_sv'			=> $new_title,
				'block_title_sv'	=> $new_block_title,
			]);
		}

		//translate single fields repeated

		$single_field_repeated_ids = DB::table('single_field')
		->select('id')
		->where('type', 'repeat')
		->get()->pluck('id');

		$langs = Lang::all();

		foreach ($langs as $lang) {

			$single_repeated = DB::table('single_text_'.$lang->tag)
			->whereIn('field_id', $single_field_repeated_ids)
			->get();

			foreach ($single_repeated as $single_repeated_item) {

				$single_repeated_item_value = json_decode($single_repeated_item->value);

				foreach ($single_repeated_item_value as &$single_repeated_item_keys) {
					
					$new_title = Translater::tr($single_repeated_item_keys->title, $lang_from, $lang_to);
					echo $new_title."\n";

					$single_repeated_item_keys->title = $new_title;
				}

				DB::table('single_text_'.$lang->tag)
				->where('field_id', $single_repeated_item->field_id)
				->update([
					'value'	=> json_encode($single_repeated_item_value),
				]);

			}

		}

		$single_repeated = DB::table('single_text')
		->whereIn('field_id', $single_field_repeated_ids)
		->get();

		foreach ($single_repeated as $single_repeated_item) {

			$single_repeated_item_value = json_decode($single_repeated_item->value);

			foreach ($single_repeated_item_value as &$single_repeated_item_keys) {
				
				$new_title = Translater::tr($single_repeated_item_keys->title, $lang_from, $lang_to);
				echo $new_title."\n";

				$single_repeated_item_keys->title = $new_title;
			}

			DB::table('single_text')
			->where('field_id', $single_repeated_item->field_id)
			->update([
				'value'	=> json_encode($single_repeated_item_value),
			]);

		}

	}

	/*
	 * End FAP Translator
	 */


	/**
	 * Execute the console command.
	 */
	public function handle() {
		
		$this->info('Start translation...');
		
		$langs = Lang::langs()->pluck('tag')->all();

		if ($this->argument('argument') == 'admin'){
			
			$this->translate_admin();

		} elseif (is_numeric($this->argument('argument'))) {

			$this->translate_single($this->argument('argument'));

		} elseif (in_array($this->argument('argument'), $langs) || empty($this->argument('argument'))) {
			
			$this->translate_languages($this->argument('argument'));

		} else {
			
			$this->translate_table($this->argument('argument'));
		}

	}
}


