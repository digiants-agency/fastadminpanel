<?php

namespace App\FastAdminPanel\Commands;

use Illuminate\Console\Command;
use App\FastAdminPanel\Helpers\Translater;
use App\FastAdminPanel\Models\Language;
use App\FastAdminPanel\Models\Menu;
use App\FastAdminPanel\Models\SingleField;
use App\FastAdminPanel\Models\SinglePage;
use App\FastAdminPanel\Services\Single\SingleGetService;
use DB;

class FastAdminPanelTranslate extends Command
{
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

	protected $translater;
	protected $languagesToTranslate;
	protected $mainTag;
	
	/**
	 * Create a new command instance.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->translater = new Translater();

		$languages = Language::get();
		
		$this->languagesToTranslate = $languages->where('main_lang', '!=', 1);
		$this->mainTag = $languages->where('main_lang', 1)->first()->tag;
	}

	/*
	 * FAP Translator
	 */

	private $notTranslateCols = [
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

	private $notTranslateFields = [
		'Theme (light,dark)',
		'Button link',
		'Посилання',
		'Номер',
		'Зображення',
		'Зображення моб',
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

	public function translateSingle($id, $toLang = '')
	{
		$singleGetService = new SingleGetService();

		if (!empty($toLang)) {
			$this->languagesToTranslate = $this->languagesToTranslate->where('tag', $toLang);
		}

		$singlePage = $singleGetService->get($id);

		foreach ($this->languagesToTranslate as $languageTranslate) {

			foreach ($singlePage as $singleBlocks) {
			
				foreach ($singleBlocks as $singleField) {
					$this->translateField($singleField, $this->mainTag, $languageTranslate->tag);
				}
			}
		}
	}

	protected function translateField($field, $mainTag, $tag)
	{
		if ($field['type'] == 'repeat') {
			foreach ($field['value']['fields'] as $repeatedField) {
				$this->translateField($repeatedField, $mainTag, $tag);
			}
			$field['value'] = $field['value']['length'];
		}

		$translatedField = (new SingleField($tag))
		->where('id', $field['id'])
		->first();

		if ($field['is_multilanguage'] && 
			!in_array($field['title'], $this->notTranslateFields) && 
			in_array($field['type'], ['text', 'textarea', 'ckeditor']) && 
			!empty($field['value']) &&
			!is_numeric($field['value'])
		) {

			if (is_array($field['value'])) {
				
				$repeatedValues = [];
				
				foreach ($field['value'] as $value) {
					
					$translatedValue = $this->translater->tr($value, $mainTag, $tag);
					$repeatedValues[] = $translatedValue;

					$this->info($translatedValue);
				}

				$field['value'] = json_encode($repeatedValues, JSON_UNESCAPED_UNICODE);

			} else {
				
				$field['value'] = $this->translater->tr($field['value'], $mainTag, $tag);

				$this->info($field['value']);
			}
		}
		
		if (empty($translatedField)) {
			$translatedField = new SingleField($tag, $field);
		} else {
			$translatedField->value = $field['value'];
		}

		$translatedField->save();
	}

	public function translateTable($table, $toLang = '')
	{
		if (!empty($toLang)) {
			$this->languagesToTranslate = $this->languagesToTranslate->where('tag', $toLang);
		}

		foreach ($this->languagesToTranslate as $lang) {
							
			$menuRow = DB::table('menu')
			->where('table_name', $table)
			->first();

			if (empty($menuRow)) {
				$this->error('Table or language not found');
				return;
			}

			$menuRowFields = json_decode($menuRow->fields);

			if ($menuRow->multilanguage == 1) {

				$tableRowsIds = DB::table("{$table}_{$this->mainTag}")
				->select('id')
				->get()->pluck('id');

				foreach ($tableRowsIds as $rowId) {
					
					$row = DB::table("{$table}_{$this->mainTag}")
					->where('id', $rowId)
					->first();
	
					$update = [];

					foreach ($row as $coll => $cell) {
						
						$isCellMultilanguage = false;

						foreach ($menuRowFields as $menuRowField) {
							if (isset($menuRowField->db_title) && $menuRowField->db_title == $coll) {
								$isCellMultilanguage = $menuRowField->lang == 1;
								break;
							}
						}

						if (!in_array($coll, $this->notTranslateCols) && 
							mb_strpos($coll, 'id_') !== 0 && 
							!empty($cell) && 
							!is_numeric($cell) &&
							$isCellMultilanguage
						) {
							$cell = $this->translater->tr($cell, $this->mainTag, $lang->tag);
							$this->info($cell);
						}

						if ($coll == 'id') {
							continue;
						}

						$update[$coll] = $cell;
					}

					DB::table("{$table}_{$lang->tag}")
					->where('id', $row->id)
					->update($update);
				}
			}
		}
	}

	public function translateTableRow($tableName, $id)
	{
		set_time_limit(2500);

		foreach ($this->languagesToTranslate as $lang) {
			
			$menuRow = DB::table('menu')
			->where('table_name', $tableName)
			->first();

			if ($menuRow->multilanguage == 1) {

				$row = DB::table("{$tableName}_{$this->mainTag}")
				->where('id', $id)
				->first();

				$update = [];

				foreach ($row as $coll => $cell) {

					if (!in_array($coll, $this->notTranslateCols) && !empty($cell)) {
						$cell = $this->translater->tr($cell, $this->mainTag, $lang->tag);
					}

					if ($coll == 'id') {
						continue;
					}

					$update[$coll] = $cell;
				}

				DB::table("{$tableName}_{$lang->tag}")
				->where('id', $row->id)
				->update($update);
			}
		}
	}

	public function translateLanguages($language)
	{
		if (empty($language)) {

			foreach ($this->languagesToTranslate as $language) {

				$this->translateLanguage($language->tag);
				$this->info($language->tag);
			}

		} else {

			$this->translateLanguage($language);
			$this->info($language);
		}
	}

	public function translateLanguage($tag)
	{
		$tag = mb_strtolower($tag);

		$language = $this->languagesToTranslate->where('tag', $tag)
		->first();

		if (empty($language)) {
			$this->error('Language doesnt exist or you try translate main language');
			return;
		}

		$singlePagesIds = SinglePage::get(['id'])
		->pluck('id')
		->all();

		foreach ($singlePagesIds as $singlePageId) {
			$this->translateSingle($singlePageId, $tag);
		}

		$tableNames = Menu::get(['table_name'])
		->pluck('table_name')
		->all();

		foreach ($tableNames as $tableName) {
			$this->translateTable($tableName, $tag);
		}

		$this->info('Success');
	}

	// ** DEPRECATED **
	public function translateAdmin()
	{
		$lang_from = 'ru';
		$lang_to = 'sv';

		//translate menu

		$menu = DB::table('menu')->get();

		foreach ($menu as $menu_item) {
			if ($menu_item->title != 'Menu' && $menu_item->title != 'Roles') {

				$new_title = $this->translater->tr($menu_item->title, $lang_from, $lang_to);
				$this->info($new_title);

				$fields = json_decode($menu_item->fields);

				foreach ($fields as &$field) {
					$field->title = $this->translater->tr($field->title, $lang_from, $lang_to);
					$this->info($field->title);
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
			$new_title = $this->translater->tr($dropdown_item->title, $lang_from, $lang_to);
			$this->info($new_title);

			DB::table('dropdown')
			->where('id', $dropdown_item->id)
			->update([
				'title'		=> $new_title,
			]);

		}

		//translate single page

		$single_page = DB::table('single_page')->get();

		foreach ($single_page as $single_page_item) {

			$new_title = $this->translater->tr($single_page_item->title, $lang_from, $lang_to);
			$this->info($new_title);

			DB::table('single_page')
			->where('id', $single_page_item->id)
			->update([
				'title_sv'		=> $new_title,
			]);
		}

		//translate single fields
		
		$single_field = DB::table('single_field')->get();

		foreach ($single_field as $single_field_item) {

			$new_title = $this->translater->tr($single_field_item->title, $lang_from, $lang_to);
			$this->info($new_title);

			$new_block_title = $this->translater->tr($single_field_item->block_title, $lang_from, $lang_to);
			$this->info($new_block_title);

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

		$langs = Language::get();

		foreach ($langs as $lang) {

			$single_repeated = DB::table('single_text_'.$lang->tag)
			->whereIn('field_id', $single_field_repeated_ids)
			->get();

			foreach ($single_repeated as $single_repeated_item) {

				$single_repeated_item_value = json_decode($single_repeated_item->value);

				foreach ($single_repeated_item_value as &$single_repeated_item_keys) {
					
					$new_title = $this->translater->tr($single_repeated_item_keys->title, $lang_from, $lang_to);
					$this->info($new_title);

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
				
				$new_title = $this->translater->tr($single_repeated_item_keys->title, $lang_from, $lang_to);
				$this->info($new_title);

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
	public function handle()
	{
		$this->info('Start translation...');
		
		$langs = Language::get()->pluck('tag')->all();

		if ($this->argument('argument') == 'admin'){
			
			$this->translateAdmin();

		} elseif (is_numeric($this->argument('argument'))) {

			$this->translateSingle($this->argument('argument'));

		} elseif (in_array($this->argument('argument'), $langs) || empty($this->argument('argument'))) {
			
			$this->translateLanguages($this->argument('argument'));

		} else {
			
			$this->translateTable($this->argument('argument'));
		}

	}
}